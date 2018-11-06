<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

/**
 * Query expression to academic search api evaluate.
 */
class QueryExpression {

    /**
     * @var string A query expression that specifies which entities should be returned.
     */
    protected $expr;

    /**
     * @var string Name of the model that you wish to query.
     */
    protected $model = 'latest';

    /**
     * @var int Number of results to return.
     */
    protected $count;

    /**
     * @var int Index of the first result to return.
     */
    protected $offset;

    /**
     * @var string Name of an attribute that is used for sorting the entities.
     * Optionally, ascending/descending can be specified. The format is: name:asc or name:desc.
     */
    protected $orderBy;
    
    /**
     * @var array A comma delimited list that specifies the attribute values that are included in the response.
     * Attribute names are case-sensitive.
     */
    protected $attributes;


    //(Composite(AA.AuN=='jaime teevan'),Y>2012)

    /**
     * Set name to query object.
     *
     * @param string $expr Query object name.
     *
     * @return void
     */
    public function setName(string $expr) {
        $this->name = $expr;
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
     * @param string $count Query object type value.
     *
     * @return void
     */
    public function setType(string $count) {
        $this->type = $count;
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
     * @param array $offset Query object list of matchs values.
     *
     * @return void
     */
    public function setMatch(array $offset){
        $this->match = $offset;
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
     * @param array $orderBy Query object list of selects values.
     *
     * @return void
     */
    public function setSelect(array $orderBy){
        $this->select = $orderBy;
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
     * @param string $model Query object edge value.
     *
     * @return void
     */
    public function setEdge(string $model){
        $this->edge = $model;
    }

}
?>
