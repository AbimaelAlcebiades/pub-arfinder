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
 * FieldOfStudy academic reference entity.
 */
class FieldOfStudy extends AcademicReference
{

    /**
     * Academic reference type.
     *
     * @var int
     */
    protected $type = 6;

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
     * Hierarchy level in field study.
     *
     * @var Affiliation
     */
    protected $hierarchyLevel;

    /**
     * Constructor class.
     *
     * @param array $fieldOfStudyAcademicReferenceAttributes Values to initialize class.
     */
    public function __construct(stdClass $fieldOfStudyAcademicReferenceAttributes = null)
    {

        // Set author's attributes;
        $this->mapAttributesNames = array_merge(
            $this->mapAttributesNames,
            array(
                'FN' => 'normalizedName',
                'DFN' => 'displayName',
                'CC' => 'totalCitationCount',
                'ECC' => 'totalEstimatedCitationCount',
                'FL' => 'hierarchyLevel'
                //'FP.FN' => '',
                //'FP.FId' => '',
                //'FC.FN' => '',
                //'FC.FId'  => ''
            )
        );

        parent::__construct($fieldOfStudyAcademicReferenceAttributes);
    }    

    /**
     * Get name field of study.
     *
     * @return string Returns name field of study.
     */
    public function getName()
    {
        return $this->normalizedName;
    }
}
