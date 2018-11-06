<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

use \stdClass;
use \DateTime;

/**
 * Paper academic reference entity.
 */
class Paper extends AcademicReference
{

    /**
     * Academic reference type.
     *
     * @var int
     */
    protected $type = 0;

    /**
     * @var string Paper title.
     */
    protected $title;

    /**
     * @var string Paper abstract.
     */
    protected $abstract;

    /**
     * @var string Paper language.
     */
    protected $language;

    // /**
    //  * @var int Paper year.
    //  */
    // protected $year;

    /**
     * @var Date Paper date.
     */
    protected $date;

    // /**
    //  * @var int Citation count.
    //  */
    // protected $citationCount;

    // /**
    //  * @var int Estimated citation Count.
    //  */
    // protected $estimatedCitationCount;

    /**
     * @var array List of paper's authors.
     */
    protected $authors = array();

    /**
     * @var FieldsOfStudy Fields of study.
     */
    protected $fieldsOfStudy = array();

    // // TODO: VAI SER UMA CLASSE.
    // /**
    //  * @var ????? Journal.
    //  */
    // protected $journal;

    // // TODO: VAI SER UMA CLASSE.
    // /**
    //  * @var ?????? Conference series.
    //  */
    // protected $conferenceSeries;

    // /**
    //  * @var array Referenced papers' ids.
    //  */
    // protected $referencedPapersIds;

    // /**
    //  * @var array Words from paper title and abstract.
    //  */
    // protected $words;

    /**
      * @var string Display name of the paper.
      */
    protected $displayName;

    /**
     * @var array Sources list of web sources of the paper, sorted by static rank.
     */
    protected $sources = array();

    /**
     * @var int Sources types
     */
    const SOURCE_TYPE = array(
        '1'=>'HTML',
        '2'=>'Text',
        '3'=>'PDF',
        '4'=>'DOC',
        '5'=>'PPT',
        '6'=>'XLS',
        '7'=>'PS',
        '8'=> 'Download'
    );

    /**
     * @var string URL Source.
     */
    protected $sourceUrl;

    /**
     * @var string Venue Full Name - full name of the Journal or Conference.
     */
    protected $fullNameVenue;

    /**
     * @var string Venue Short Name - short name of the Journal or Conference.
     */
    protected $shortNameVenue;

    /**
     * @var string Volume - journal volume.
     */
    protected $volume;

    /**
     * @var string Issue - journal volume.
     */
    protected $issue;

    /**
     * @var string FirstPage - first page of paper
     */
    protected $firstPage;

    /**
     * @var string LastPage - last page of paper
     */
    protected $lastPage;

    // TODO: DESCREVER O TIPO.
    /**
     * @var ????  Digital Object Identifier
     */
    protected $digitalObjectIdentifier;

    // TODO: DESCREVER O TIPO.
    /**
     * @var ???? Citation Contexts – List of referenced paper ID’s and the corresponding context in the paper.
     */
    protected $citationContexts;

    /**
     * @var string Abstract Inverted
     */
    protected $invertedAbstract;

    /**
     * Constructor class.
     *
     * @param array $paperAcademicReferenceAttributes Values to initialize class.
     */
    public function __construct(stdClass $paperAcademicReferenceAttributes = null)
    {

        if (isset($paperAcademicReferenceAttributes->AA)) {
            // Handle data authors and initialize.
            $this->initiateAuthors($paperAcademicReferenceAttributes->AA);
        }

        if (isset($paperAcademicReferenceAttributes->F)) {
            // Handle data field of study and initialize.
            $this->initiateFieldOfStudy($paperAcademicReferenceAttributes->F);
        }

        if (isset($paperAcademicReferenceAttributes->E)) {
            // Handle data extended metadata.
            $paperAcademicReferenceAttributes =
                (object) array_merge(
                    (array) $this->extractMetadata($paperAcademicReferenceAttributes->E),
                    (array) $paperAcademicReferenceAttributes
                );
        }

        // Set paper's attributes;
        $this->mapAttributesNames = array_merge(
            $this->mapAttributesNames,
            array(
                'Ti' => 'title',
                'L' => 'language',
                //'Y' => 'year',
                'D' => 'date',
                //'CC' => 'citationCount'
                //'ECC' => 'estimatedCitationCount'
                //'AA_AuN' => ''
                //'AA_AuId' =>
                //'AA_AfN' =>
                //'AA_AfId' =>
                //'AA_S' =>
                //'F_FN' =>
                //'F_FId' =>
                //'J_JN' =>
                //'J_JId' =>
                //'C_CN' =>
                //'C_CId' =>
                //'RId' =>
                //'W' =>
                //'E' =>
                'DN' => 'displayName'
            )
        );
        parent::__construct($paperAcademicReferenceAttributes);
    }

    /**
     * Process data authors from MAG and initialize authors to paper.
     *
     * @param array $authors Data from MAG, handle and configure
     *
     * @return void
     */
    public function initiateAuthors(array &$authors)
    {
        // Walks through authors.
        foreach ($authors as $author) {
            array_push($this->authors, new Author($author));
        }
        unset($authors);
    }

    /**
     * Process data field of study from MAG and initialize field of study to paper.
     *
     * @param array $fieldsOfStudy Data from MAG, handle and configure
     *
     * @return void
     */
    public function initiateFieldOfStudy(array &$fieldsOfStudy)
    {
        // Walks through fieldsOfStudy.
        foreach ($fieldsOfStudy as $fieldOfStudy) {
            array_push($this->fieldsOfStudy, new FieldOfStudy($fieldOfStudy));
        }
        unset($fieldsOfStudy);
    }

    /**
     * Extract information of metadata from MAG and initialize data.
     *
     * @param string $metaData Json with extended data.
     *
     * @return array Returns list data translated.
     */
    public function extractMetadata(string &$metaData)
    {
        $extendedData = json_decode($metaData);

        // Check if exists sources data.
        if (isset($extendedData->S)) {
            foreach ($extendedData->S as $source) {
                $this->sources[$this->getSourceType($source->Ty, $source->U)] = $source->U;
            }
        }

        // Check if exists inverted abstract.
        if (isset($extendedData->IA)) {
            $this->setAbstract(implode(" ", array_keys((array)$extendedData->IA->InvertedIndex)));
        }

        unset($metaData);
        return $extendedData;
    }

    /**
     * Get source type.
     *
     * @param int       $codeType       Code type from MAG.
     * @param string    $sourceContent  Content source, use this value for try retrieve right type.
     *
     * @return string Returns type to source, if $codeType don't exist returns 'Text' by default.
     */
    public function getSourceType($codeType, $sourceContent)
    {
        // Checks if exists type, if not exists returns 'Text' by default.
        if(array_key_exists($codeType, self::SOURCE_TYPE)){
            $key = $codeType;
        } else {
            // Checks valid URL.
            if (filter_var($sourceContent, FILTER_VALIDATE_URL) === false) {
                // Set type as text
                $key = 2;
            } else {
                // Set type as HTML (valid URL), probaly is downlod.
                $key = 8;
            }
        }

        return self::SOURCE_TYPE[$key];
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Get paper title.
     *
     * @return void
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get paper display name.
     * 
     * @param bool $normalizedName Transform name to lowercase and first letter in caps.
     *
     * @return void
     */
    public function getDisplayName(bool $normalizedName = false)
    {
        return ($normalizedName) 
            ? ucfirst(mb_convert_case($this->displayName, MB_CASE_LOWER, "UTF-8"))
            : $this->displayName;
    }

    /**
     * Get paper date.
     *
     * @param string $format Format output date.
     *
     * @return string Returns formated date.
     */
    public function getDate($format = 'Y-m-d')
    {
        $date = new DateTime($this->date);
        return $date->format($format);
    }

    /**
     * Get language paper.
     *
     * @return string Returns language paper.
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Get paper's authors
     *
     * @return array Returns list paper's authors.
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Get paper's sources.
     *
     * @return array Returns list of sources.
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Get paper's fields of study,
     *
     * @return array Returns list of sources.
     */
    public function getFieldsOfStudy()
    {
        return $this->fieldsOfStudy;
    }

    /**
     * Set paper abstract.
     *
     * @param string $abstract Abstract value to set.
     *
     * @return void
     */
    public function setAbstract(string $abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Get paper abstract.
     *
     * @return string Returns abstract value.
     */
    public function getAbstract($limitWords = false)
    {
        //return $this->abstract;

        return ($limitWords) ? $this->limitWords($this->abstract, $limitWords) : $this->abstract;
    }

    /**
     * Get new string with limited words.
     *
     * @param string $string Text to limits words.
     * @param int $wordsLimit Number of words limits.
     * 
     * @return string New string limited with number of words in $wordsLimits
     */
    public function limitWords($string, $wordsLimit)
    {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $wordsLimit));
    }
}
