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
 * Entity academic reference.
 */
abstract class AcademicReference {

    /**
     * @var int Object's unique identification.
     */
    protected $id;

    /**
     * @var int Entity type.
     */
    protected $type;

    /**
     * Mapping for that resolving attributes names from MAG to class.
     *
     * @var array
     */
    protected $mapAttributesNames = array (
        'Id' => 'id',
        'Ty' => 'type'
    );

    /**
     * Constructor class.
     *
     * @param array $academicReferenceAttributes Values to initialize class attributes.
     */
    public function __construct(stdClass $academicReferenceAttributes = null) { 
        foreach($academicReferenceAttributes as $attribute => $value){
            // Check if attribute exist.
            if(property_exists($this, $translatedAttribute = $this->traslateAttribute($attribute))){
                $this->$translatedAttribute = $value;
            }
        }        
    }

    /**
     * Get id object.
     *
     * @return int Returns object id.
     */
    protected function getId(){
        return $this->id;
    }

    /**
     * Get type object.
     *
     * @return int Returns object id.
     */
    protected function getType(){
        return $this->type;
    }

    /**
     * Translate attribute from MAG to correspondent attribute name in class.
     *
     * @param string $attributeName Original attribute name from MAG.
     * 
     * @return string If exists correspondent attribute name in $mapAttributesNames
     * returns translated attribute name, otherwise returns own attribute name.
     */
    public function traslateAttribute(string $attributeName){
       
        // Returns translated attribute name.
        return (array_key_exists($attributeName, $this->mapAttributesNames)) ?
             $this->mapAttributesNames[$attributeName] : $attributeName;

    }

}
