<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

use \stdClass;

/**
 * Affiliation academic reference entity.
 */
class Affiliation extends AcademicReference
{

    /**
     * Academic reference type.
     *
     * @var int
     */
    protected $type = 5;
    
    /**
     * Normalized name.
     *
     * @var string
     */
    protected $normalizedName;

    /**
     * Name displayed.
     *
     * @var string
     */
    protected $displayName;

    /**
     * Total citation count.
     *
     * @var int
     */
    protected $totalCitationCount;

    /**
     * Tottal estimated citation count.
     *
     * @var int
     */
    protected $totalEstimatedCitationCount;

    /**
     * Affiliation's paper count.
     *
     * @var int
     */
    protected $paperCount;
    
    /**
     * Constructor class.
     *
     * @param array $affiliationAcademicReferenceAttributes Values to initialize class.
     */
    public function __construct(stdClass $affiliationAcademicReferenceAttributes = null)
    {
        if($affiliationAcademicReferenceAttributes){    
            // Set affiliation's attributes;
            $this->mapAttributesNames = array_merge(
                $this->mapAttributesNames,
                array(
                    'AfN' => 'normalizedName',
                    'DAfN' => 'displayName',
                    'CC' => 'totalCitationCount',
                    'ECC' => 'totalEstimatedCitationCount',
                    'PC' => 'paperCount'
                )
            );
            parent::__construct($affiliationAcademicReferenceAttributes);
        }
    }    
}
