<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

use \DateTime;

/**
 * Paper object reference.
 */
class GraphPaper extends Reference {

    /**
     * @var string Paper original title.
     */
    protected $originalTitle;

    /**
     * @var array Paper list of keywords.
     */
    protected $keywords;

    /**
     * @var array Paper list of authors ids.
     */
    protected $authors;

    /**
     * @var DateTime Paper publish date.
     */
    protected $publishDate;

    /**
     * Set paper original title.
     *
     * @param  string $originalTitle Paper original title.
     *
     * @return void
     */
    public function setOriginalTitle(string $originalTitle){
        $this->originalTitle = $originalTitle;
    }

    /**
     * Get $originalTitle attribute.
     *
     * @return string Returns paper original title.
     */
    public function getOriginalTitle() {
        return $this->originalTitle;
    }

    /**
     * Set paper keywords.
     *
     * @param  array $keywords List of paper keywords.
     *
     * @return void
     */
    public function setkeywords(array $keywords){
        $this->keywords = $keywords;
    }

    /**
     * Set paper authors.
     *
     * @param  array $keywords List of paper authors ids.
     *
     * @return void
     */
    public function setAuthors(array $authors){
        $this->authors = $authors;
    }

    /**
     * Set paper publish date.
     *
     * @param  string $publishDate Data paper publish date.
     *
     * @return void
     */
    public function setPublishDate(string $publishDate){
        $this->publishDate = new DateTime($publishDate);
    }

    public function getPublishDate(string $dateFormat = ''){

        if(empty($dateFormat)){
            return $this->publishDate;
        }

        return $this->publishDate->format($dateFormat);
    }


}

?>
