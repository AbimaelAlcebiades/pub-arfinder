<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Helper;

/**
 * Class string helper.
 */
class StringsHelper
{

    const PREPOSITIONS = array(
        'pt' => array(
            'a', 'o', 'os', 'as', 'de', 'em', 'por', 'um', 'uma', 'uns', 'umas', 'ao', 'à', 'aos',
            'às', 'do', 'da', 'dos', 'das', 'dum', 'duma', 'duns', 'dumas', 'no', 'na', 'nos', 'nas', 'num', 'numa',
            'nuns', 'numas', 'pelo', 'pela', 'pelos', 'pelas'
        )
    );

    const ARTICLES = array(
        'pt' => array(
            'a', 'as', 'o', 'os', 'um', 'umas'
        )
    );

    const CONJUCTIONS = array(
        'pt' => array(
            'e', 'mas', 'nem', 'contudo', 'entretanto', 'bastante', 'porém', 'todavia', 'já', 'ou', 'ora', 'quer',
            'assim', 'então', 'logo', 'pois', 'portanto', 'porquanto', 'porque', 'que'
        )
    );
 
    /**
     * Normalize string transforming to lowercase, remove accents and white spaces.
     *
     * @param string $string 	String for apply normalized method.
	 * @param string $replace 	String to replace white spaces.
     *
     * @return string String normalized.
     */
    public static function normalizeString(string $string, $replace = '_')
    {
		$string = strtolower($string);
		$string = preg_replace('/\s/', $replace, $string);
        return preg_replace(
            array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/",
                "/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/", "/ç/", "/Ç/"),
            explode(" ", "a A e E i I o O u U n N c C"),
            $string
        );
    }

    /**
     * Remove prepositions from string.
     *
     * @param string    $string         String to remove prepositions.
     * @param string    $language       String content language.
     * @param boolean   $caseSensitive  (optional) Use case sensitive for search values.  
     * 
     * @return string Returns string without prepositions, if any rules exists returns own string.
     */
    public static function removePreposition(string $string, string $language, $caseSensitive = false)
    {
        if(array_key_exists($language, self::PREPOSITIONS)){
            return self::removeWordsFromString($string, self::PREPOSITIONS[$language]);
        }else{
            return $string;
        }
    }

    public static function removeArticle(string $string, string $language, $caseSensitive = false){
        if(array_key_exists($language, self::ARTICLES)){
            return self::removeWordsFromString($string, self::ARTICLES[$language]);
        } else {
            return $string;
        }
    }

    public static function removeConjunction(string $string, string $language, $caseSensitive = false)
    {
        if(array_key_exists($language, self::CONJUCTIONS)){
            return self::removeWordsFromString($string, self::CONJUCTIONS[$language]);
        } else {
            return $string;
        }
    }

    public static function removeWordsFromString(string $string, array $excludeWords, $caseSensitive = false)
    {
        foreach ($excludeWords as $excludeWord) {
            $patterns[] = '\s'.$excludeWord.'\s|\b'.$excludeWord.'\s|\s'.$excludeWord.'\b|^'.$excludeWord.'$';
        }
        $regex =  implode('|', $patterns);
        $regexOptions = ($caseSensitive) ? '' : 'i' ;

        return preg_replace('/'.$regex.'/'.$regexOptions, ' ', $string);
    }

}
