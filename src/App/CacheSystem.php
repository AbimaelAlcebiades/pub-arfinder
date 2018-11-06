<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\App;

use Exception;


/**
 * Class cache system
 */
class CacheSystem {

	/**
	 * @var string Time for cache data.
	 */
	private static $cacheTime = '5 minutes';

	/**
	 * @var string Folder name where data cache are will saved.
	 */
	private $folder;

	/**
	 * Constructor class, optionally can be receive folder where cache data are will saved, 
	 * if this folder were omitted default temp system directory is used.
	 *
	 * @param string $folder Folder name where cache is saved.
	 */
	public function __construct(string $folder = '') {
		$this->setFolder(empty($folder) ? sys_get_temp_dir() : $folder );
	}

	/**
	 * Set value for $this->folder attribute.
	 *
	 * @param string Value to set folder name where data cache are will saved.
	 * 
	 * @return void
	 */
	protected function setFolder(string $folder){
		// Check if is valid folder.
		if(file_exists($folder) && is_dir($folder) && is_writable($folder)){
			$this->folder = $folder;
		}else{
			throw new Exception("O caminho $folder não é um diretório válido", E_USER_ERROR);
		}
	}

	/**
	 * Generate cache file location.
	 *
	 * @param string $key Key to identify file.
	 * 
	 * @return string Local file cache.
	 */
	public function generateFileLocation(string $key){
		return $this->folder . DIRECTORY_SEPARATOR . sha1($key) . '.tmp';
	}

	/**
	 * Create file cache.
	 * 
	 * @uses CacheSystem::generateFileLocation() for generate location file cache.
	 * 
	 * @param string $key Key to identify file cache.
	 * @param string $content Content file cache. 
	 * 
	 * @return void
	 */
	public function createCacheFile(string $key, string $content){
		$fileName = $this->generateFileLocation($key);

		if($file = file_put_contents($fileName, $content)){
			return $file;
		}else{
			throw new Exception('Não foi possível criar o arquivo de cache', E_USER_ERROR);
		}
	}

	/**
	 * Salve cache value.
	 * 
	 * @uses CacheSystem::createCacheFile() for create file cache.
	 *
	 * @param string $key Key to identify file cache.
	 * @param mixed $content Variable content will be save in cache.
	 * @param string $time Time that this data are valid.
	 * 
	 * @return boolean True if cache is saved, false otherwise.
	 */
	public function save(string $key, $content, string $time = ''){
		$time = strtotime(empty($time) ? self::$time : $time);

		$content = serialize(
			array(
				'expires' => $time,
				'content' => $content	
			)
		);

		return $this->createCacheFile($key, $content);
	}


	/**
   * Read cache value.
   *
   * @uses Cache::generateFileLocation() to generate file cache location.
   *
   * @param string $key Key to identify file cache.
   *
   * @return mixed If file cache is find returns your value, otherwise returns null.
   */
  public function read($key) {
	$filename = $this->generateFileLocation($key);
	// Check if file is valid.
	if (file_exists($filename) && is_readable($filename)) {
		// Read cache file content.
		$cache = unserialize(file_get_contents($filename));
		if ($cache['expires'] > time()) {
			// Return content cache file.
    		return $cache['content'];
    	} else {
			// Delete file.
        	unlink($filename);
    	}
	}	
	// Is not valid file cache.
    return null;
	}
}
?>
