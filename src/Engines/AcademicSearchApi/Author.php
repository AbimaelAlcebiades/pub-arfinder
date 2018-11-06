<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

use ARFinder\Helper\StringsHelper;
use \stdClass;

/**
 * Author academic reference entity.
 */
class Author extends AcademicReference
{

    /**
     * Academic reference type.
     *
     * @var int
     */
    protected $type = 1;

    /**
     * Normalized name
     *
     * @var string
     */
    protected $normalizedName;

    /**
     * Displayed name
     *
     * @var string
     */
    protected $displayName;

    /**
     * Total citation count.
     *
     * @param stdClass
     */
    protected $totalCitationCount;

    /**
     * Total estimated citation count.
     *
     * @param stdClass
     */
    protected $totalEstimatedCitationCount;

    /**
     * Author affiliation.
     *
     * @var Affiliation
     */
    protected $affiliation;

    /**
     * Constructor class.
     *
     * @param array $authorAcademicReferenceAttributes Values to initialize class.
     */
    public function __construct(stdClass $authorAcademicReferenceAttributes = null)
    {

        if(isset($authorAcademicReferenceAttributes->AfId)){
            // Handle data affiliation and initialize.
            $this->initiateAffiliation(
                $authorAcademicReferenceAttributes->AfId,
                $authorAcademicReferenceAttributes->AfN
            );
        }

        // Set author's attributes;
        $this->mapAttributesNames = array_merge(
            $this->mapAttributesNames,
            array(
                'AuId' => 'id',
                'AuN' => 'normalizedName',
                'DAuN' => 'displayName',
                'CC' => 'totalCitationCount',
                'ECC' => 'totalEstimatedCitationCount'
            )
        );

        parent::__construct($authorAcademicReferenceAttributes);
    }

    public function __toString()
    {
        return $this->displayName;
    }

    /**
     * Process data affiliations from MAG and initialize affiliations to author.
     *
     * @param int       $idAffiliation              Id affiliation data from MAG, handle and configure.
     * @param string    $affiliationNormalizedName  Name affiliation data from MAG, handle and configure.
     *
     * @return void
     */
    public function initiateAffiliation(int &$idAffiliation, string &$affiliationNormalizedName)
    {

        $initializeAffiliation = new StdClass();
        $initializeAffiliation->id = $idAffiliation;
        $initializeAffiliation->AfN = $affiliationNormalizedName;       

        $this->affiliation = new Affiliation($initializeAffiliation);
        
        unset($idAffiliation);
        unset($affiliationName);
    }
    
    /**
     * Get author name.
     *
     * @return string Returns normalized author name.
     */
    public function getName($normalized = false)
    {
        $name = $this->normalizedName;
        if ($normalized) {
            $name = StringsHelper::normalizeString($name);
        }
        return $name;
    }
    
}
