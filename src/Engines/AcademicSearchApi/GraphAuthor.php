<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\AcademicSearchApi;

/**
 * Author object reference.
 */
class GraphAuthor extends Reference {

    /**
     * @var string Author name;
     */
    protected $name;

    /**
     * Set author name
     *
     * @param  string $name Author name.
     *
     * @return void
     */
    public function setName(string $name){
        $this->originalTitle = $name;
    }

}

?>
