<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Controller;

use ARFinder\Engines\DefaultEngine;
use ARFinder\App\CacheSystem;
use ARFinder\Helper\RequestHelper;
use ARFinder\Engines\AcademicSearchApi\Paper;
use Exception;

/**
 * Controller class reference finder.
 */
class ReferenceFinderController extends DefaultController {

	/**
	 * Academic references finder engine.
	 * 
	 * @var ARFinder\Engines\DefaultEngine 
	 */
	private $engineReferenceFinder;

	/**
	 * Cache system.
	 * 
	 * @var ARFinder\App\CacheSystem 
	 */
 	private $cacheSystem;

	/**
	 * Academic references finder configurations.
	 * 
	 * @var object 
	 */	
	private $ARFinderConfig;

	/**
	 * Constructor class.
	 */
	function __construct() {

		// Load configurations.
		$this->ARFinderConfig = $this->readConfig();
		
		// Instanciate engine.
		$this->engineReferenceFinder = new $this->ARFinderConfig->engineReferenceFinder();

		// Configure cache system.
		$this->configCacheSystem(
			empty($this->ARFinderConfig->cacheDirectory) ?
			sys_get_temp_dir() : $this->ARFinderConfig->cacheDirectory
		);

		// Set path to cache system.
		$this->cacheSystem = new CacheSystem($this->ARFinderConfig->cacheDirectory);
	}

	/**
	 * Get configs from file.
	 *
	 * @return array Returns list of configuration parameters.
	 */
	public function readConfig() {
		// Returns list configutarions parameters.
		return json_decode(
			file_get_contents(
				ARFINDER_CONFIG . DIRECTORY_SEPARATOR . 'arfinder.json'));
	}

	/**
	 * Configure cache system.
	 *
	 * @param string $directoryCacheSystem Directory to cache system.
	 * 
	 * @return void
	 * 
	 * @throws Exception Throws an exception if the cache system was not configured correctly.
	 */
	public function configCacheSystem($directoryCacheSystem){
		// Create directory cache data if is not exists.
		if(!is_dir($directoryCacheSystem)){
			// Try create directory and check if has been created.
			if(!mkdir($directoryCacheSystem, '775')){
				// Permission create folder denied.
				throw Exception("Não foi possível criar o diretório {$directoryCacheSystem}. Verifique
				se o sistema tem permisão para criar a pasta.");
			}
		}
	}

	// /**
	//  * Execute controller.
	//  *
	//  *
	//  * @return void
	//  */
	// public function executeFromApi() {

	// 	$requestMethod = "{$request['task']}ApiRequest";
	
	// 	// Checks if task is an class method existing.
	// 	if(method_exists($this, $requestMethod)){
	// 		$this->$requestMethod();
	// 	}else{
	// 		exit("A task {$request['task']} não existe na api");
	// 	}
	// }

	public function clearHistoryApiRequest()
	{
		session_destroy();
		exit();
	}

	/**
	 * Get academic references from MAG givens an term.
	 *
	 * @return void
	 */
	public function getAcademicReferencesApiRequest(){
		
		$results= array();
		
		try {
			$this->checkMandatoryDataAcademicReferencesRequest();

			if(!isset($_SESSION['suggestedAR'])){
				$_SESSION['suggestedAR'] = array();
			}

			$loadMore = ($_POST['loadMore'] ?? false);
			$displayTryAgain = true;

			$optionsAcademicReferences = array(
				'languages' => $_POST['options']['languages'],
				'startIndex' => $_POST['options']['startIndex'],
				'orderBy' => $_POST['options']['orderBy'],
				'autoAcademicReferences' => $_POST['options']['autoAcademicReferences'] ?? '',
				'displaySuggestionsTerms' => $_POST['options']['displaySuggestionsTerms'] ?? '',
				'checkArticle' => $_POST['options']['checkArticle'] ?? '',
			);

			/* Get references, for start index trying value from request, if not exists
			set value to 0.*/
			$academicReferences = $this->getAcademicReferences(
				$_POST['terms'],
				$_POST['articleText'],
				$optionsAcademicReferences
				//$_POST['options']['startIndex'],
				//$filterAuthor, '',
				//$_POST['options']['languages'], 
			);
			
			if(empty($academicReferences['results'])){
				$displayTryAgain = false;
				throw new Exception('Não temos novas referências para o seu texto. Dê uma olhada no seu histório talvez encontre referências legais lá', 404);
			}
	
			$papers = array_slice($academicReferences['results'], 0, $this->ARFinderConfig->numberReferencesDisplayed, true);
			
			$_SESSION['suggestedAR'] = $_SESSION['suggestedAR'] + $papers;
			//$_SESSION['suggestedAR'] = array_unique($_SESSION['suggestedAR']);

			// Avoid for that include don't display content in script.
			ob_start();	
			include '../src/Templates/academic-references/listing.php';
			// Get content inclue and clear content.
			$results['html'] = ob_get_clean();
			$results['removeButtonMore'] = (
				sizeof($academicReferences['results']) <= $this->ARFinderConfig->numberReferencesDisplayed) 
				? true : false;
		} catch (Exception $e) {
			$errorMessage = $e->getMessage();
			ob_start();	
			include '../src/Templates/academic-references/error.php';
			$results['html'] = ob_get_clean();
			$results['removeButtonMore'] = true;
		}
		
		exit(json_encode($results));
	}

	/**
	 * Check mandatory data to execute get academic references method.
	 *
	 * @return void
	 * 
	 * @throws Exception Throws exception if mandatory variables not found in request;
	 */
	public function checkMandatoryDataAcademicReferencesRequest()
	{
		$terms = RequestHelper::getVariable('terms');
		// $filterAuthor =  RequestHelper::getVariable('filterAuthor');
		if($terms === false || empty($terms)){
			throw new Exception("Não foram informados 'termos' para a busca de referências acadêmicas", 500);
		}		
	}

	/* TODO: DESCREVER CABEÇALHO DA FUNÇÃO. */
	public function getAcademicReferences(
		array $terms,
		string $articleText,
		array $options
		//int $startIndex = 0,
		//$filterAuthor = '', 
		//array $languages = array('pt')
	){

		$academicReferences = false;

		// TODO: FAZER O BOTÃO LOAD MORE CARREGAR DADOS COM FILTRO, MESMA LÓGICA DO ACTIVE.
		// TODO: LIMITAR SUGESTÕES DO SOFTWARE.
		// TODO:: TENHO QUE VER COMO OS SISTEMA DE CACHE FICARÁ COM A CONFIGURAÇÃO 
		// QUE LIMITA OS RESULTADOS RETORNADOS.
		
		if($this->ARFinderConfig->enableSystemCache){
			// Try recovers references from cache.
			$academicReferences = $this->cacheSystem->read($terms);
		}

		// If not exists references results to term.
		if (!$academicReferences) {
			// Get references with engine search.
			$academicReferences = $this->engineReferenceFinder->getAcademicReferences(
				$terms, $articleText, $options/*$startIndex, $filterAuthor, $languages*/ 
			);
			
			// System cache enabled.
			if($this->ARFinderConfig->enableSystemCache){
				// Save results in cache.
				$this->cacheSystem->save($terms, $academicReferences, $this->ARFinderConfig->cacheTime);
			}
		}

		// Returns limited results.
		//return array_slice($academicReferences, $startIndex, $this->ARFinderConfig->numberReferencesDisplayed);

		return $academicReferences;

		//return array_slice($academicReferences, $startIndex, $this->ARFinderConfig->numberReferencesDisplayed);

		//$ARFinderConfig = $this->readConfig();

		//$startIndex = ($request['startIndex'] ?? 0);
		//$numberReferencesDisplayed = $this->ARFinderConfig->numberReferencesDisplayed;

		//$startIndex = 0;
		//$numberReferencesDisplayed = $this->ARFinderConfig->numberReferencesDisplayed;

		//return $academicReferences;
	}

	// /**
	//  * Get academic references information.
	//  *
	//  * @param  string $term Base term to find references.
	//  *
	//  * @return array Returns list of referential data.
	//  */
	// public function findReferences(string $term) {

		
	
		
    //     include '../src/Templates/console/mag-references.php';
	// }

}

?>
