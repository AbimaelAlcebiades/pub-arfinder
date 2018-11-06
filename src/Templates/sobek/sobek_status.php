<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

// Check Sobek web service status. ?>
<?php if ($this->sobekIntegrator->getWebServiceStatus()["http_code"] != 200) {?>
	<?php // Display message Sobek out service. ?>
	<div class="alert alert-danger" role="alert">
		<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
		<span class="sr-only">Error:</span>
		O serviço do Sobek está indisponível no momento.
	</div>
<?php } else {?>
	<?php // Sobek service is normal. ?>
	<span>Serviço normal</span>
<?php }?>
