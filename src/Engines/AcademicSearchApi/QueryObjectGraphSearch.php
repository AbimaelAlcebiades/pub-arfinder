<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

/**
 * Query object to navigate in MAG graph search.
 */
class QueryObjectGraphSearch {

    /**
     * @var string Query object name.
     */
    protected $name;

    /**
     * @var string Query object edge.
     */
    protected $edge;

    /**
     * @var string Query object type.
     */
    protected $type;

    /**
     * @var array Query object match.
     */
    protected $match;

    /**
     * @var array Query object select.
     */
    protected $select;

    /**
     * Constructor class.
     *
     * @param string $name Value to attribute $name.
     * @param string $type Value to attribute $type.
     */
    function __construct(string $name, string $type){
        $this->setName($name);
        $this->setType($type);
    }

    /**
     * Set name to query object.
     *
     * @param string $name Query object name.
     *
     * @return void
     */
    public function setName(string $name) {
        $this->name = $name;
    }

    /**
     * Get query object name.
     *
     * @return string Returns value of name attribute.
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set type to query object.
     *
     * @param string $type Query object type value.
     *
     * @return void
     */
    public function setType(string $type) {
        $this->type = $type;
    }

    /**
     * Get query object type.
     *
     * @return string Returns value of type attribute.
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set match to query object.
     *
     * @param array $match Query object list of matchs values.
     *
     * @return void
     */
    public function setMatch(array $match){
        $this->match = $match;
    }

    /**
     * Get query object match.
     *
     * @return string Returns value of match attribute.
     */
    public function getMatch() {
        return $this->match;
    }


    /**
     * Set select to query object.
     *
     * @param array $select Query object list of selects values.
     *
     * @return void
     */
    public function setSelect(array $select){
        $this->select = $select;
    }

    /**
     * Get query object select.
     *
     * @return string Returns value of select attribute.
     */
    public function getSelect() {
        return $this->select;
    }

    /**
     * Get query object edge.
     *
     * @return string Returns value of edge attribute.
     */
    public function getEdge() {
        return $this->edge;
    }

    /**
     * Set edge to query object.
     *
     * @param string $edge Query object edge value.
     *
     * @return void
     */
    public function setEdge(string $edge){
        $this->edge = $edge;
    }

}
?>
