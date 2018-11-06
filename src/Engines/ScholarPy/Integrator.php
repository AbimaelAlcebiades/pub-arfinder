<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Engines\ScholarPy;

/**
 * Scholar.py's integrator class.
 */
class Integrator implements DefaultEngine{

	/**
	 * @var Python file executable to Scholar.py.
	 */
	private static $scholarPy = 'scholar.py';

	/**
	 * Get attribute $scholarPy.
	 *
	 * @param boolean $fullPath Flag to return full path, true is default value.
	 *
	 * @return string Returns scholar.py file name.
	 */
	public function getScholarPy($fullPath = true) {
		return ($fullPath) ? __DIR__ . DIRECTORY_SEPARATOR . self::$scholarPy : $scholarPy;
	}

	/**
	 * Get references.
	 *
	 * @param  string $term Base term to find references.
	 *
	 * @return array List of references.
	 */
	public function getReferences(string $term, int $numberReferences) {

        //$locale='en_US.UTF-8';
        //setlocale(LC_ALL,$locale);
        //putenv('LC_ALL='.$locale);
        //putenv('LANG=en_US.UTF-8');
        //
        //header('Content-Type: text/html; charset=utf-8');
        //ini_set('zlib.output_compression', 'On');
        //$locale='de_DE.UTF-8';
        //setlocale(LC_ALL,$locale);
        //putenv('LC_ALL='.$locale);
        //
        //
        putenv('LANG=en_US.UTF-8');
        //shell_exec('locale charmap');
        $content = shell_exec('echo "emoções"');
        var_dump("teste");
        var_dump(utf8_decode($content));
        var_dump(utf8_encode($content));
        var_dump($content);

		//$content  = shell_exec('"'.self::getScholarPy().'" -c 5 --phrase "sobek ufrgs" >> saida_em_texto4.txt');

        ###### CÓDIGO DE TESTE, ESPERO QUE SEJA TEMPORÁRIO #######
		//$content = file_get_contents("saida_em_texto.php");

        return self::formatScholarPyResults($content);
	}

    /**
     * Handle results from ScholarPy and convert to list of references.
     *
     * @param string $resultsScholarPy Results query from ScholarPy.
     *
     * @return array Returns list of references in organized array.
     */
    public function formatScholarPyResults($resultsScholarPy) {
        $formatedResults = array();
        // Split data using "break line" with delimiter character.
        $resultsLines = preg_split("/\R/", $resultsScholarPy);
        // Aux index results.
        $indexResult = 0;
        // Go through all lines results.
        foreach ($resultsLines as $line) {
            // Check theres content in line.
            if(!empty($line)){
                // Mount data from line.
                $key = str_replace(' ', '_', trim(substr($line, 0, 15)));
                $content = trim(substr($line, 15));
                $formatedResults[$indexResult][$key] = $content;
            }else{
                // New reference.
                $indexResult++;
            }
        }
        return $formatedResults;
     }
}

?>
