<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\App;

use ARFinder\Helper\StringsHelper;

/**
 * Class term.
 */
class Term
{

    protected $id;
    protected $name;
    protected $occurrence;
    protected $frequency;
    protected $relations;
    protected $connections;
    protected $text;

    /**
     * Constructor class.
     */
    function __construct()
    {
        // Initiate empty array to relarions terms.
        $this->relations = array();
    }

    /**
     * Set id to term.
     *
     * @param int $id Id to set.
     *
     * @return void.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id term.
     *
     * @return int Id term.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name to term.
     *
     * @param string $name Name to set.
     *
     * @return void.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get term name.
     *
     * @param boolean $normalized Normalized name, filtering accents and spaces.
     *
     * @return string Name term.
     */
    public function getName($normalized = false)
    {
        $name = $this->name;
        if ($normalized) {
            $name = StringsHelper::normalizeString($name);
        }
        return $name;
    }

    /**
     * Set occurrence to term.
     *
     * @param string $occurrence Ocurrence to set.
     *
     * @return void.
     */
    public function setOccurrence($occurrence)
    {
        $this->occurrence = $occurrence;
    }

    /**
     * Get term occurrence.
     *
     * @return float Ocurrence term.
     */
    public function getOccurrence()
    {
        return $this->occurrence;
    }

    /**
     * Set frequency to term.
     *
     * @param string $frequency Frequency to set.
     *
     * @return void.
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * Get term frequency.
     *
     * @return int Frequency term.
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Add relationed terms to term.
     *
     * @param Term $term Relationed term to add.
     *
     * @return void
     */
    public function addRelationedTerm(Term $term)
    {
        array_push($this->relations, $term);
    }

    /**
     * Get relationed terms.
     *
     * @return array Returns list of relationed terms.
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * Get number of relationed terms.
     *
     * @return int Returns number of relationed terms.
     */
    public function getNumberOfRelations()
    {
        return count($this->relations);
    }

    /**
     * Set connections to term.
     *
     * @param int $numberConnections Number to set.
     *
     * @return void
     */
    public function setConnections(int $numberConnections)
    {
        $this->connections = $numberConnections;
    }

    /**
     * Get number connections term.
     * @return int Returns number of terms connections.
     */
    public function getConnections()
    {
        return $this->connections;
    }

    /**
     * Set text to term.
     *
     * @param string $text Text to term.
     *
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text term.
     *
     * @param $splitted Optional flag for split text information in organized array.
     *
     * @return string Returns text term.
     */
    public function getText($splited = false)
    {

        $text = $this->text;

        // Splited text returns.
        if ($splited) {
            // Split strings by comma.
            $text = explode(',', $text);
            // List character to remove.
            $charactersRemove = array("[", "...", "]");
            // Go through relations.
            foreach ($text as &$splitedText) {
                // Remove characters and white spaces.
                $splitedText = trim(str_replace($charactersRemove, '', $splitedText));
            }
        }

        return $text;
    }
}
