<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\Sobek;

use ARFinder\Exceptions\SobekBadXMLReturnException;
use SimpleXMLElement;
use \stdClass;

/**
 * Sobek's integrator class.
 */
class Integrator
{

    /**
     * @var object Sobek integrator configurations.
     */
    private $configs;
    
    /**
     * Constructor class.
     */
    public function __construct()
    {
        // Load configs.
        $this->configs = $this->readConfig();
    }
    
    /**
     * Read configs from file.
     *
     * @return array Returns list of configuration parameters.
     */
    public function readConfig()
    {
        // Returns list configutarions parameters.
        return json_decode(
            file_get_contents(
                ARFINDER_CONFIG . DIRECTORY_SEPARATOR . 'sobek.json'));
    }

    /**
     * Checks Sobek web service is online.
     *
     * @return boolean Returns true if service is online(http code 200), othewise returns false if offline.
     */
    public function serviceIsOnline()
    {
        // Get service status.
        $webServiceStatus = $this->getWebServiceStatus();
        // Test if http code is OK.
        return ($webServiceStatus['http_code'] == 200);
    }

    /**
     * Checks Sobek web service status.
     *
     * @return array Returns Sobek web service data.
     */
    public function getWebServiceStatus()
    {
        // Open curl with Sobek web service address.
        $cUrl = curl_init($this->getConfigs()->urlSobekWebService);
        // Set 10s timeout for response Sobek web service.
        curl_setopt($cUrl, CURLOPT_TIMEOUT, 10);
        // Execute.
        curl_exec($cUrl);
        // Get data returned.
        $webServiceData = curl_getinfo($cUrl);
        // Close curl resource.
        curl_close($cUrl);

        return $webServiceData;
    }

    /**
     * Get graph of frequency terms from text.
     *
     * @param string $text User text for get graph.
     * @return SimpleXML Returns XML with frequency terms of text sends.
     */
    public function getGraph($text)
    {

        $text = preg_replace('/\s\s+/', ' ', $text);

        // Get params configured.
        $sobekParams = $this->configParams($text);

        try {

            if($this->serviceIsOnline()){
                // Send user text to Sobek and create object with return.'
                $xml = $this->sendToSobek($sobekParams);
            }else{
                $xml = $this->sendToSobekLocaly($sobekParams);
            }

            return new SimpleXMLElement($xml);
        } catch (SobekBadXMLReturnException $error) {
            return false;
        }
    }

    /**
     * Configure input Sobek params.
     *
     * @param array $inputConfigs
     * 
     * @return string Returns input params configured to Sobek web service.
     */
    public function setupInputParams(stdClass $inputConfigs)
    {
        // Params result.
        $inputParams = '';

        // Go through params.
        foreach ($inputConfigs as $config => $value) {
            if ($config == "averageNumbersTerms") {
                $inputParams .= (is_int($value)) ? "-c $value " : "";
                continue;
            }
            if ($config == "minFrequencyTerms") {
                $inputParams .= (is_int($value)) ? "-m $value " : "";
                continue;
            }
            if ($config == "minNumberOccurrenceValidTerm") {
                $inputParams .= (is_int($value)) ? "-o $value " : "";
                continue;
            }
            if ($config == "language") {
                $inputParams .= (is_int($value)) ? "-l $value" : "";
                continue;
            }
        }

        return $inputParams;
    }

    /**
     * Configure output Sobek params.
	 * 
     * @param array $inputConfigs
     * @return string Returns output params configured to Sobek web service.
     */
    public function setupOutputParams(stdClass $outputConfigs)
    {

        // Params result.
        $outputParams = '';

        // Go through params.
        foreach ($outputConfigs as $config => $value) {
            if ($value) {
                $output = $config;
            }
        }

        switch ($output) {
            case 'justTerms':
                $outputParams = '-b';
                break;
            case 'xml':
                $outputParams = "-x";
                break;
            case 'termFrequency':
                $outputParams = "-n";
                break;
            default:
                $outputParams = "-x";
                break;
        }

        return $outputParams;
    }

    /**
     * Configure params to send Sobe web service.
     *
     * @param string $textContent Text content from user.
     * @return array Returns array configured for send Sobek.
     */
    public function configParams($textContent)
    {

        $configs = $this->getConfigs();

        // Get I/O params.
        $configInputParams = $this->setupInputParams(  $configs->input);
        $configOutputParams = $this->setupOutputParams(  $configs->output);

        // Create array to Sobek web service requisition.
        return array(
            "entrada" => "$configInputParams $configOutputParams -t $textContent",
        );
    }

    /**
     * Send text for analysis by Sobek.
	 * 
     * @param string $sobekParams Params to sobek.
     * @return string Returns xml string with terms.
     * @throws SobekBadXMLReturnException Error to receive bad XML from Sobek.
     */
    public function sendToSobek($sobekParams)
    {

        // Open cURL resource.
        $cURL = curl_init();

        // cURL configuration.
        $configCURL = array(
            CURLOPT_URL => $this->getConfigs()->urlSobekWebService,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $sobekParams,
            CURLOPT_RETURNTRANSFER => true,
        );

        // Set configuration to cURL.
        curl_setopt_array($cURL, $configCURL);

        // Get Sobek returns.
        $sobekReturn = curl_exec($cURL);

        // Close cURL resource.
        curl_close($cURL);

        // Enable user error handling for avoid load XML error.
        libxml_use_internal_errors(true);

        // Test create XML with Sobek return.
        if (!simplexml_load_string($sobekReturn)) {
            // Get errors
            if (libxml_get_errors()) {
                // PEGAR O ERRO E RETORNAR NA EXCEÇÃO.
                libxml_clear_errors();
            }
            // Throws exception bad XML.
            throw new SobekBadXMLReturnException("XML devolvido pelo serviço do Sobek não é válido");
        }

        return $sobekReturn;
    }

    /**
     * Send text for analysis by Sobek in alternative version (localy).
	 * 
     * @param string $sobekParams Params to sobek.
     * @return string Returns xml string with terms.
     * @throws SobekBadXMLReturnException Error to receive bad XML from Sobek.
     */
    public function sendToSobekLocaly($sobekParams)
    {

        $sobekReturn = utf8_encode(shell_exec('java -jar WebServiceSobek.jar ' . $sobekParams['entrada']));

        // Enable user error handling for avoid load XML error.
        libxml_use_internal_errors(true);

        // Test create XML with Sobek return.
        if (!simplexml_load_string($sobekReturn)) {
            // Get errors
            if (libxml_get_errors()) {
                // PEGAR O ERRO E RETORNAR NA EXCEÇÃO.
                libxml_clear_errors();
            }
            // Throws exception bad XML.
            throw new SobekBadXMLReturnException("XML devolvido pelo serviço do Sobek não é válido");
        }

        return $sobekReturn;
    }


    /**
     * Get configs property.
     *
     * @return array Returns list of configs.
     */
    public function getConfigs()
    {
        return $this->configs;
    }
}
