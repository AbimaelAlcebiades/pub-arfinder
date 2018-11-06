<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Controller;

use ARFinder\App\TextHandler;
use ARFinder\Sobek\Integrator;
use Exception;

/**
 * Controller class text analyzer.
 */
class TextAnalyzerController extends DefaultController
{

    /**
     * @var ARFinder\Sobek\Integrator Sobek integrator.
     */
    private $sobek;

    function __construct()
    {
        $this->sobek = new Integrator();
    }

    /**
     * Execute controller.
     *
     * @return void
     */
    public function executeFromApi()
    {
        parent::executeFromApi();
    }

    /**
     * Analize text api request method.
     *
     * @return void
     */
    public function analyzeTextApiRequest()
    {

        $results = array();
        $results['terms'] = null;
        try {
            $suggestTerms = $this->getSuggestTerms($_POST['textToSobek']);
            // Avoid for that include don't display content in script.
            //ob_start();
            //include '../src/Templates/sobek/suggestions-terms.php';
            // Get content inclue and clear content.
            //$results['html'] = ob_get_clean();

            foreach ($suggestTerms as $normalizedName => $suggestTerm) { 
               $results['terms'][] = $suggestTerm->getName();
            }

            $results['status'] = 'success';
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            // Avoid for that include don't display content in script.
            //ob_start();
            //include '../src/Templates/sobek/error.php';
            // Get content inclue and clear content.
            //$results['html'] = ob_get_clean();
            $results['message'] = $errorMessage;
            $results['status'] = 'error';
        }
        exit(json_encode($results));
    }

    /**
     * Analyze text and get suggest terms.
     *
     * @param string $text Text to extract terms.
     *
     * @return array Returns list of suggestions terms.
     * 
     * @throws Exception Throw exception if text is smaller to generate terms.
     */
    public function getSuggestTerms($text)
    {
        // Send text to Sobek an get xml graph.
        $textGraph = $this->sobek->getGraph($text);

        // Create sobek graph text handler.
        $textHandler = new TextHandler();
        // Get list suggested of terms.
        $suggestTerms = $textHandler->handleXMLSobek($textGraph);

        if(empty($suggestTerms)){
            throw new Exception('O texto é curto de mais para sugerir termos', 500);
        }

        // Order suggestions terms.
        uasort($suggestTerms, array($this, 'sortSuggestTerms'));
        return $suggestTerms;
    }

    /**
     * Sort terms by frequency, in case terms with same frequency capitalized string is considered smaller.
     *
     * @param Term $term1
     * @param Term $term2
     * 
     * @return boolean Returns true if $term1 is smaller(more important) than $term2, otherwise returns false.
     */
    public function sortSuggestTerms($term1, $term2)
    {

        $occurenceTerm1 = $term1->getOccurrence();
        $occurenceTerm2 = $term2->getOccurrence();

        if($occurenceTerm1 == $occurenceTerm2){
            // Evaluate capitalize string like smaller value (more importante than $term2).
            return $term1->getName()[0] > $term2->getName()[0] ;
        }

        // Evaluate frequency.
        return $occurenceTerm1 < $occurenceTerm2;
    }
}
