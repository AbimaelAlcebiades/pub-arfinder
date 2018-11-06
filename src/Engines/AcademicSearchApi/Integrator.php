<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

use ARFinder\Engines\DefaultEngine;
use ARFinder\Helper\StringsHelper;
use ARFinder\Engines\AcademicSearchApi\Paper;
use \Exception;
use \stdClass;

/**
 * Academic Search API intregrator class.
 */
class Integrator implements DefaultEngine
{

    /**
     * @var array Entitities types.
     */
    const ENTITIES_TYPES = array(
        'paper' => 0,
        'author' => 1,
        'journal' => 2,
        'conferenceSeries' => 3,
        'conferenceInstance' => 4,
        'affiliation' => 5,
        'fieldOfStudy' => 6
    );

    /**
     * @var object Academic Search Api integrator configurations.
     */
    private $configs;
    
    /**
     * Constructor class.
     */
    public function __construct()
    {
        // Load configs.
        $this->configs = $this->readConfig();
    }

    /**
     * Read configs from file.
     *
     * @return array Returns list of configuration parameters.
     */
    public function readConfig()
    {
        // Returns list configutarions parameters.
        return json_decode(
            file_get_contents(
                ARFINDER_CONFIG . DIRECTORY_SEPARATOR . 'academic_search_api.json'));
    }
    
    /**
     * Search academic references given an term.
     *
     * @param array $terms          Terms for get academic references.
     * @param int    $offset        Index start retrieve academic reference.
     * @param string $filterAuthor  Filter by paper's author.
     *
     * @return object Data academic references.
     */
    public function getAcademicReferences(
        array $terms,
        string $articleText,
        array $options
        // int $offset,
        // $filterAuthor = '',
        // array  $filterLanguages = array('pt'),
    ) {

        // Checks exists executed queries.
        if(!isset($_SESSION['queriesAlreadyExecuted'])){
            $_SESSION['queriesAlreadyExecuted'] = array();
        }

        // Configure query languages.
        foreach ($options['languages'] as $filterLanguage) {
            $queryLanguage[] = "L='{$filterLanguage}'";
        }
        // Build query language.
        $queryLanguages = 'Or('. implode(',', $queryLanguage) .')';

        //$filterAuthor = StringsHelper::normalizeString($filterAuthor);
        //$filterAuthor = str_replace('_', ' ', $filterAuthor);

        $words = array();
        // Explode term in words.
        foreach ($terms as $word) {
            // Normalize string.
            $word = StringsHelper::normalizeString($word, ' ');
            foreach (explode(' ', $word) as $pieceOfWord) {
                foreach ($options['languages'] as $language) {
                    if ($this->isValidWordEvaluate($pieceOfWord, $language)) {
                        $words[] = "W='{$pieceOfWord}'";
                    }
                }
            }
        }

        $returnAcademicReferences['results'] = array();

        // Remove duplicate values.
        $words = array_unique($words);

        // Limit terms top 5 terms.
        $words = array_slice($words, 0, 5);

        // Query gereric configs.
        $count = $this->configs->evaluate->count;
        $offset = $options['startIndex'];

        switch ($options['orderBy']) {
            case 'date':
                $orderBy = 'D:desc';
                break;
            
            default:
                $orderBy = '';
                break;
        }
        
        $optionsQuery = "count={$count}&offset={$offset}&orderby={$orderBy}";
        $attributesQuery = 'attributes=Id,Ty,Ti,L,Y,D,CC,ECC,AA.AuId,AA.AuN,AA.DAuN,AA.CC,AA.ECC,AA.AfN,AA.AfId,AA.S,
            F.FN,F.FId,J.JN,J.JId,C.CN,C.CId,RId,W,E';

        // Walks and combine terms searching a academic refenreces.
        for ($i = sizeof($words); $i > 0; $i--) { 
           $combinedTerms = $this->getTermsCombined($words, $i);

            // Walks combined terms.
            foreach ($combinedTerms as $query) {

                $queryWords = 'And('. implode(',', $query) .')';
                $filtersQuery = "And({$queryWords},Ty='".self::ENTITIES_TYPES['paper']."',{$queryLanguages})";
                $queryEvaluate = "expr={$filtersQuery}&{$optionsQuery}&$attributesQuery";

                if(!array_key_exists($queryWords, $_SESSION['queriesAlreadyExecuted'])){
                    // Execute query and get academic references from web service.
                    $resultEvaluate = $this->evaluate($queryEvaluate);
                    
                    // Register query like already executed.                    
                    $_SESSION['queriesAlreadyExecuted'][$queryWords] = $resultEvaluate->entities;
                }else{
                    $resultEvaluate = new StdClass();
                    $resultEvaluate->entities = $_SESSION['queriesAlreadyExecuted'][$queryWords];
                }
                
                // ACHO QUE NAO ESTA FUNCIONANDO.    
                $resultEvaluate->entities = 
                    $this->arrayKeysBlacklist(
                        $resultEvaluate->entities, $_SESSION['suggestedAR']);
                
                $returnAcademicReferences['results'] =
                    array_merge($returnAcademicReferences['results'], $resultEvaluate->entities);

                $returnAcademicReferences['queries'][] = array(
                    'queryString' => $queryEvaluate,
                    'numberOfResults' => sizeof($resultEvaluate->entities)
                );

                if (sizeof($returnAcademicReferences['results']) >= 3) {
                    $i = 0;
                    break;
                }
            }
        }

        $papers = $returnAcademicReferences['results'];

        $academicReferences = array();
        
        foreach ($papers as $paper) {
            $paper = new Paper($paper);
            //TODO: AS COMPARAÇÕES CO RESUMOS SÃO MAIS IMPORTANTES QUE AS COMPARAÇÕES COM TÍTULO.
            if ($abstract = $paper->getAbstract()) {
                $paper->similarity = $this->similarity($abstract, $articleText);
                // Percetual de strings semelhantes.
                similar_text($abstract, $articleText, $percentualStringSimilar);
                $paper->similarityPHP = $percentualStringSimilar;
                $paper->analisadoCom = 'resumo';
                $paper->totalSimilarity = $paper->similarity + $paper->similarityPHP;
            } elseif ($title = $paper->getTitle()) {
                $paper->similarity = $this->similarity($title, $articleText);
                $paper->similarity = 0;
                // Percetual de strings semelhantes.
                similar_text($title, $articleText, $percentualStringSimilar);
                $paper->similarityPHP = $percentualStringSimilar;
                $paper->analisadoCom = 'titulo';
                $paper->totalSimilarity = $paper->similarity + $paper->similarityPHP;
            }

            $academicReferences[$paper->getId()] = $paper;
        }

        // Order papers by similarity with article text.
        uasort($academicReferences, array($this, 'sortPapers'));

        $returnAcademicReferences['results'] = $academicReferences;

        return $returnAcademicReferences;
    }

    public function getTermsCombined($terms, $minActiveTerms, array $results = array())
    {

        if (empty($results)) {
            // Build initial combination list.
            foreach ($terms as $key => $term) {
                // If in range index min terms.
                if ($key < $minActiveTerms) {
                    $base[] = $term;
                } else {
                    $base[] = '';
                }
            }
            //$results[] = array_keys(array_filter($base));
            $results[] = array_filter($base);
        } else {
            // Get last combination.
            end($results);
            $keyLastCombination = key($results);
            // Build combination list with previous combinations.
            foreach ($terms as $key => $term) {
                // If find last combination.
                if (array_search($term, $results[$keyLastCombination]) !== false) {
                    $base[] = $term;
                } else {
                    $base[] = '';
                }
            }
        }

        $totalTerms = sizeof($base);
        if($minActiveTerms > $totalTerms){
            throw new Exception("O número de termos minímos não pode ser maior que o tamnho da list de termos", 500);
        }

        $previousIndex = false;
        $startIndex = $totalTerms - 1;

        // Walks inversely list of terms
        for ($currentIndex = $startIndex; $currentIndex >= 0; $currentIndex --) {           
            // Find fist valid term.
            if (!empty($base[$currentIndex])) {
                // Get next index.
                $nextIndex = $currentIndex + 1;
                // Possui casa na direita?
                // Is there next index ?
                if (array_key_exists($nextIndex, $base)) {
                    // Next index has active term.
                    if (empty($base[$nextIndex])) {
                        // Active next term.
                        $base[$nextIndex] = $terms[$nextIndex];
                        // Disable current index;
                        $base[$currentIndex] = "";

                        // Test if final list.
                        if (sizeof(
                            array_filter(array_slice($base, -$minActiveTerms, $minActiveTerms))) == $minActiveTerms
                        ) {
                            // Get a pattern.
                            //$results[] = array_keys(array_filter($base));
                            $results[] = array_filter($base);
                            return $results;
                        }
                        
                        // If exists previus combination values.
                        if ($previousIndex !== false) {
                            // Reorganize list.
                            $base[$nextIndex + 1] = $terms[$nextIndex + 1];
                            if ($previousIndex != $nextIndex + 1) {
                                $base[$previousIndex] = "";
                            }
                        }

                        // Extrai este padrão.
                        //$results[] = array_keys(array_filter($base));
                        $results[] = array_filter($base);
                        
                        // Call recursive.
                        return $this->getTermsCombined($terms, $minActiveTerms, $results);
                    } 
                } else {
                    // Hold index for next iterantion.
                    $previousIndex = $currentIndex;
                }
            }
        }  
        
        return $results;
    }

    /**
     * The evaluate REST API is used to return a set of academic entities based on a query expression.
     *
     * @param string $queryExpression Query expression for evaluate method.
     *
     * @see https://westus.dev.cognitive.microsoft.com/docs/services/56332331778daf02acc0a50b/operations/5951f78363b4fb31286b8ef4/console
     *
     * @return object Returns data with academics entities founded.
     */
    public function evaluate($queryExpression)
    {
        // Open cUrl resource.
        $cUrl = curl_init();

        // curl configuration.
        $configsCurl = array(
            CURLOPT_URL => $this->configs->evaluate->apiUrl,
            CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // Set timeout for response evaluate web service.
            CURLOPT_TIMEOUT => $this->configs->evaluate->miliSecondstimeout,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $queryExpression,
            CURLOPT_SSL_VERIFYPEER => false,
            // Set headers.
            CURLOPT_HTTPHEADER => array(
                'Content-Type: '. $this->configs->evaluate->contentType,
                'Ocp-Apim-Subscription-Key: ' .  $this->configs->cognitiveServices->apiKey
            )
        );
        // Set configuration to cUrl.
        curl_setopt_array($cUrl, $configsCurl);
        // Entities returned from MAG.
        $resultJsonMagEntities = curl_exec($cUrl);

        if (($erroNumber = curl_errno($cUrl)) != 0) {
            // Exist error.
            throw new Exception(curl_error($cUrl), $erroNumber);
        }

        // Close cUrl resource.
        curl_close($cUrl);

        $resultMagEntities = json_decode($resultJsonMagEntities);

        // Check if exists error
        if (property_exists($resultMagEntities, 'error')) {
            throw new Exception("Ocorreu um erro no retorno da api evaluate. Código:"
            .$resultMagEntities->error->code . ' .Mensagem: '.$resultMagEntities->error->message, 500);
        }

        return $resultMagEntities;
    }

    public function similarity($string1, $string2)
    {
        // Open cUrl resource.
        $cUrl = curl_init();

        $query = "s1='".$string1."'&s2='".$string2."'";

        // curl configuration.
        $configsCurl = array(
            CURLOPT_URL => $this->configs->similarity->apiUrl,
            CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // Set timeout for response similarity web service.
            CURLOPT_TIMEOUT => $this->configs->similarity->miliSecondstimeout,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $query,
            CURLOPT_SSL_VERIFYPEER => false,
            // Set headers.
            CURLOPT_HTTPHEADER => array(
                'Content-Type: '. $this->configs->similarity->contentType,
                'Ocp-Apim-Subscription-Key: ' .  $this->configs->cognitiveServices->apiKey
            )
        );
        // Set configuration to cUrl.
        curl_setopt_array($cUrl, $configsCurl);
        // Entities returned from MAG.
        $resultSimilarity = curl_exec($cUrl);

        if (($erroNumber = curl_errno($cUrl)) != 0) {
            // Exist error.
            throw new Exception(curl_error($cUrl), $erroNumber);
        }

        // Close cUrl resource.
        curl_close($cUrl);

        return $resultSimilarity;
    }

    /**
     * Get references in Graph Academic Search.
     *
     * @param  string $term Term to get data.
     *
     * @return array List of references.
     */
    public function getReferences(string $term)
    {

        ################ ESTÁ FIXO.
        $term = 'sobek';

        ############ REMOVIDO "EDGE AUTHOR".
        // Configure start query object.
        $queryObjectPaper = new QueryObjectGraphSearch('paper', 'Paper');
        $queryObjectPaper->setMatch(
            array("NormalizedTitle" => "sobek")
        );
        // Set edge to only returns references with authors.
        $queryObjectPaper->setEdge('AuthorIDs');
        $queryObjectPaper->setSelect(array(
            "OriginalTitle",
            "NormalizedTitle",
            "CitationIDs",
            "ReferenceIDs",
            "FieldOfStudyIDs",
            "Keywords",
            "AffiliationIDs",
            "AuthorIDs",
            "JournalID",
            "PublishDate",
            "PublishYear"
        ));

        //$queryObjectAuthor = new QueryObjectGraphSearch('author', 'Author');
        //$queryObjectAuthor->setSelect(array("Name"));

        // Configure graph search.
        $graphSearch = new GraphSearch($queryObjectPaper /*, $queryObjectAuthor*/);

        // Get data from MAG.
        $resultJsonMagEntities = $this->searchReferencesInMAG($graphSearch->getQueryString());

        $magDataReferences = json_decode($resultJsonMagEntities);

        $references = array();
        //ini_set('xdebug.var_display_max_depth', 99999);
        //ini_set('xdebug.var_display_max_children', 99999);
        //ini_set('xdebug.var_display_max_data', 99999);
        //var_dump($magDataReferences->Results);
        // exit();

        foreach ($magDataReferences->Results as $result) {
            // /$reference = array();

            $paperData  = $result[0];
            //$authorData = $result[1];

            $paper = new Paper($paperData->CellID);
            $paper->setOriginalTitle($paperData->OriginalTitle);
            $paper->setkeywords($paperData->Keywords);
            $paper->setAuthors($paperData->AuthorIDs);
            $paper->setPublishDate($paperData->PublishDate);

            //$author = new Author($authorData->CellID);
            //$author->setName($authorData->Name);

            //var_dump($paper,/*$author,*/ $result);

            //$reference['Title'] = $result[0]->OriginalTitle;
            $references['papers'][] = $paper;
        }

        return $references;
    }

    /**
     * Search data references in MAG data base.
     *
     * @param string $graphQueryString Graph query string to search in MAG.
     *
     * @return array Returns list of references found in MAG.
     */
    public function searchReferencesInMAG(string $graphQueryString)
    {

        // Get API configuration.
        //$apiConfig = $this->getConfig();

        // Open cUrl resource.
        $cUrl = curl_init();

        // curl configuration.
        $configCURL = array(
            CURLOPT_URL => $this->getGraphSearchUrl(),
            CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $graphQueryString,
            CURLOPT_SSL_VERIFYPEER => false,
            // Set headers.
            CURLOPT_HTTPHEADER => array(
                'Content-Type: ' . (!empty($apiConfig->graphSearch->contentType) ? $apiConfig->graphSearch->contentType : 'application/json'),
                'Ocp-Apim-Subscription-Key: ' . $apiConfig->graphSearch->apiKey
            )
        );

        // Set configuration to cUrl.
        curl_setopt_array($cUrl, $configCURL);

        // Data returned from MAG.
        $resultJsonMagEntities = curl_exec($cUrl);

        //curl_getinfo($cUrl);
        //curl_error($cUrl);

        // Close cUrl resource.
        curl_close($cUrl);

        return $resultJsonMagEntities;
    }

    /**
     * Get url for performs search in graph search MAG.
     *
     * @return string Configured url to graph search.
     */
    public function getGraphSearchUrl()
    {

        // API configuration.
        //$apiConfig = $this->getConfig();

        // Get mode.
        //$mode = (!empty($apiConfig->mode)) ? $apiConfig->graphSearch->mode : 'json';
        $mode = $apiConfig->mode ?? "json";

        // Return
        return $apiConfig->graphSearch->apiUrl.'?'.$mode;
    }

    /**
     * Check if word is valid to evaluate method.
     *
     * @param string $word      Word for check.
     * @param string $language  Word language to check.
     *
     * @return boolean Returns true if word is valid, otherwise returns false.
     */
    public function isValidWordEvaluate(string $word, string $language)
    {

        // Filter word.
        $result = $word;
        $result = StringsHelper::removePreposition($result, $language);
        $result = StringsHelper::removeArticle($result, $language);
        $result = StringsHelper::removeConjunction($result, $language);

        return !empty(trim($result));
    }

     /**
     * Callback method for sort papers academic references.
     *
     * @param Paper $paper1
     * @param Paper $paper2
     *
     * @return boolean Returns true if $paper1 is smaller than $paper2, otherwise returns false.
     */
    public function sortPapers($paper1, $paper2)
    {
        return $paper1->totalSimilarity < $paper2->totalSimilarity ;
    }

    /**
	 * Filter an array based on a black list of keys
	 *
	 * @param array $array
	 * @param array $keys
	 *
	 * @return array
	 */
	public function arrayKeysBlacklist( array $academicReferences, array $academicReferencesAlreadyDisplayed ) {
        $results = $academicReferences;
        
        foreach ( $academicReferences as $key => $academicReference ) {
            if(isset($academicReferencesAlreadyDisplayed[$academicReference->Id])){
                unset($results[$key]);
            }
		}
	
	    return $results;
	}
}
