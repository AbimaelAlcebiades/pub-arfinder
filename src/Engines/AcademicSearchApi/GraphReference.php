<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

/**
 * Reference object.
 */
abstract class GraphReference {

    /**
     * @var int Unique identification reference object.
     */
    protected $id;

    /**
     * Constructor class.
     * @param int $id Id Object reference.
     */
    public function __construct(int $id) { 
        $this->id = $id;
    }

    /**
     * Get value id object attribute.
     *
     * @return int Returns reference object id.
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set id to reference object.
     *
     * @param int $id Id to set for object.
     *
     * @return void
     */
    public function setId($id){
        $this->id = $id;
    }

}

?>
