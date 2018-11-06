<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

use \stdClass;
use \Exception;

/**
 * Class graph search for use in Academic Search Api.
 */
class GraphSearch {

    /**
     * @var array Query objects .
     */
    protected $queryObjects = array();

    /**
     * @var string Path attribute query graph search.
     */
    protected $path;

    /**
     * Constructor class.
     */
    public function __construct(){
        foreach (func_get_args() as $queryObject) {
            $this->addQueryObject($queryObject);
        }
    }

    public function addQueryObject(QueryObjectGraphSearch $queryObject) {

        //var_dump(empty($this->queryObjects));
        // Verifica se a lista de objetos não é vazia.
        if(!empty($this->queryObjects)){
            // Final do array.
            $previousObject = end($this->queryObjects);

            // Verifica se o objeto anterior tem limitador.
            if(empty($previousObject->getEdge())){
                throw new Exception("O objeto '".$previousObject->getName()."' não possui 'edge'.");
            }
        }

        $this->queryObjects[] = $queryObject;
        //var_dump($this->queryObjects);
    }

    public function getQueryObjects() {
        return $this->queryObjects;
    }

    /**
     * Get query string to use in graph search in academic search api.
     *
     * @param $returnJson (optional) If true returns json's query string, outherwise returns object.
     *
     * @return string String path graph search.
     */
    public function getQueryString($returnJson = true) {

        $queryString = new stdClass();

        $queryString->path = '';

        foreach ($this->getQueryObjects() as $key => $queryObject) {

            $objectName = $queryObject->getName();

            $queryString->path .= '/'.$objectName;

            if(!empty($edge = $queryObject->getEdge())){
                $queryString->path .= '/'.$edge;
            }

            $queryString->$objectName = new stdClass();
            $queryString->$objectName->type = $queryObject->getType();

            if(!empty($match = $queryObject->getMatch())){
                $queryString->$objectName->match = $match;
            }

            if(!empty($select = $queryObject->getSelect())){
                $queryString->$objectName->select = $select;
            }

        }

        if($returnJson){
            return json_encode($queryString);
        }else{
            return $queryString;
        }

    }
}
?>
