<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

namespace ARFinder\App;

// TODO:: acho que essa é uma responsabiliade do integrado do sobek... deveria avaliar mudar de local.

use ARFinder\App\Term;
use \SimpleXMLElement;

/**
 * Text handler.
 */
class TextHandler {

	/**
	 * Handle Sobek XML and return list of terms.
	 * 
	 * @param SimpleXMLElement $sobekXML XML returned from Sobek Web Service.
	 * @return array Return list of terms.
	 */
	public function handleXMLSobek(SimpleXMLElement $sobekXML) {

		// List of terms.
		$listOfTerms = array();

		// Go through XML.
		foreach ($sobekXML as $key => $nodo) {

			// Ignore node information.
			if ($key == 'informacoes') {
				// Next iteration.
				continue;
			}

			// Create object.
			$term = new Term();

			$term->setName((string) $nodo["name"]);
			$term->setId((int) $nodo->id);
			$term->setOccurrence((float) $nodo->ocorrencia);
			$term->setFrequency((int) $nodo->frequencia);

			// Go through relations.
			foreach ($nodo->relacoes as $relatedNode) {

				// Create object.
				$linkedTerm = new Term();

				$linkedTerm->setName((string) $relatedNode["name"]);
				$linkedTerm->setId((int) $relatedNode->name_ID);
				$linkedTerm->setConnections((int) $relatedNode->conexoes);

				// Add relationed term.
				$term->addRelationedTerm($linkedTerm);
			}

			$term->setText((string) $nodo->texto);

			// Add term to array.
			$listOfTerms[$term->getName(true)] = $term;
		}

		return $listOfTerms;
	}
}

?>
