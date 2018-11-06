<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

// Load application paths.
// require_once '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'application_paths.php';

// // Load the Composer autoloader
// require ROOT_SITE_PATH . '/vendor/autoload.php';

// // Instantiate the application.
// $application = new ARFinder\App\Application();
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="./images/lapis.png">
	<title>Project TCC - Abimael</title>
	<meta charset="utf-8">

    <?php /* Load javascript. */ ?>
	<script src="assets/js/tinymce/tinymce.min.js"></script>
    <script src="assets/js/jquery/jquery.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="assets/js/arfinder.js"></script>

    <?php /* Load CSS */ ?>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/bootstrap.min.css">

    <?php /* Init tinymce editor. */ ?>
    <script>tinymce.init({ selector:"textarea[name='tinymce']" });</script>

  <style> 
input[type=text] {
    width: 130px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('searchicon.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text]:focus {
    width: 100%;
}
</style>

</head>

<body>
  <br />
<font size='1'><table class='xdebug-error xe-notice' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Notice: Undefined property: stdClass::$limitMaxResults in C:\wamp64\www\project-tcc\src\Engines\AcademicSearchApi\Integrator.php on line <i>83</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.2031</td><td bgcolor='#eeeeec' align='right'>366352</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp64\www\project-tcc\www\arfinder.php' bgcolor='#eeeeec'>...\arfinder.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.2087</td><td bgcolor='#eeeeec' align='right'>590424</td><td bgcolor='#eeeeec'>ARFinder\App\Application->__construct(  )</td><td title='C:\wamp64\www\project-tcc\www\arfinder.php' bgcolor='#eeeeec'>...\arfinder.php<b>:</b>16</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.2087</td><td bgcolor='#eeeeec' align='right'>590424</td><td bgcolor='#eeeeec'>ARFinder\App\Application->executeRequest(  )</td><td title='C:\wamp64\www\project-tcc\src\App\Application.php' bgcolor='#eeeeec'>...\Application.php<b>:</b>40</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.2094</td><td bgcolor='#eeeeec' align='right'>598808</td><td bgcolor='#eeeeec'>ARFinder\App\RestFullApi->executeRequest(  )</td><td title='C:\wamp64\www\project-tcc\src\App\Application.php' bgcolor='#eeeeec'>...\Application.php<b>:</b>83</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.2176</td><td bgcolor='#eeeeec' align='right'>679608</td><td bgcolor='#eeeeec'>ARFinder\Controller\DefaultController->executeFromApi(  )</td><td title='C:\wamp64\www\project-tcc\src\App\RestFullApi.php' bgcolor='#eeeeec'>...\RestFullApi.php<b>:</b>31</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.2176</td><td bgcolor='#eeeeec' align='right'>680040</td><td bgcolor='#eeeeec'>ARFinder\Controller\ReferenceFinderController->getAcademicReferencesApiRequest(  )</td><td title='C:\wamp64\www\project-tcc\src\Controller\DefaultController.php' bgcolor='#eeeeec'>...\DefaultController.php<b>:</b>29</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.2176</td><td bgcolor='#eeeeec' align='right'>680040</td><td bgcolor='#eeeeec'>ARFinder\Controller\ReferenceFinderController->getAcademicReferences(  )</td><td title='C:\wamp64\www\project-tcc\src\Controller\ReferenceFinderController.php' bgcolor='#eeeeec'>...\ReferenceFinderController.php<b>:</b>120</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.2177</td><td bgcolor='#eeeeec' align='right'>680040</td><td bgcolor='#eeeeec'>ARFinder\Engines\AcademicSearchApi\Integrator->getAcademicReferences(  )</td><td title='C:\wamp64\www\project-tcc\src\Controller\ReferenceFinderController.php' bgcolor='#eeeeec'>...\ReferenceFinderController.php<b>:</b>153</td></tr>
</table></font>
<br />
<font size='1'><table class='xdebug-error xe-uncaught-exception' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Fatal error: Uncaught Error: Class 'ARFinder\Engines\AcademicSearchApi\Exception' not found in C:\wamp64\www\project-tcc\src\Engines\AcademicSearchApi\Integrator.php on line <i>143</i></th></tr>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Error: Class 'ARFinder\Engines\AcademicSearchApi\Exception' not found in C:\wamp64\www\project-tcc\src\Engines\AcademicSearchApi\Integrator.php on line <i>143</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.2031</td><td bgcolor='#eeeeec' align='right'>366352</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='C:\wamp64\www\project-tcc\www\arfinder.php' bgcolor='#eeeeec'>...\arfinder.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.2087</td><td bgcolor='#eeeeec' align='right'>590424</td><td bgcolor='#eeeeec'>ARFinder\App\Application->__construct(  )</td><td title='C:\wamp64\www\project-tcc\www\arfinder.php' bgcolor='#eeeeec'>...\arfinder.php<b>:</b>16</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.2087</td><td bgcolor='#eeeeec' align='right'>590424</td><td bgcolor='#eeeeec'>ARFinder\App\Application->executeRequest(  )</td><td title='C:\wamp64\www\project-tcc\src\App\Application.php' bgcolor='#eeeeec'>...\Application.php<b>:</b>40</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.2094</td><td bgcolor='#eeeeec' align='right'>598808</td><td bgcolor='#eeeeec'>ARFinder\App\RestFullApi->executeRequest(  )</td><td title='C:\wamp64\www\project-tcc\src\App\Application.php' bgcolor='#eeeeec'>...\Application.php<b>:</b>83</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.2176</td><td bgcolor='#eeeeec' align='right'>679608</td><td bgcolor='#eeeeec'>ARFinder\Controller\DefaultController->executeFromApi(  )</td><td title='C:\wamp64\www\project-tcc\src\App\RestFullApi.php' bgcolor='#eeeeec'>...\RestFullApi.php<b>:</b>31</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>6</td><td bgcolor='#eeeeec' align='center'>0.2176</td><td bgcolor='#eeeeec' align='right'>680040</td><td bgcolor='#eeeeec'>ARFinder\Controller\ReferenceFinderController->getAcademicReferencesApiRequest(  )</td><td title='C:\wamp64\www\project-tcc\src\Controller\DefaultController.php' bgcolor='#eeeeec'>...\DefaultController.php<b>:</b>29</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>7</td><td bgcolor='#eeeeec' align='center'>0.2176</td><td bgcolor='#eeeeec' align='right'>680040</td><td bgcolor='#eeeeec'>ARFinder\Controller\ReferenceFinderController->getAcademicReferences(  )</td><td title='C:\wamp64\www\project-tcc\src\Controller\ReferenceFinderController.php' bgcolor='#eeeeec'>...\ReferenceFinderController.php<b>:</b>120</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>8</td><td bgcolor='#eeeeec' align='center'>0.2177</td><td bgcolor='#eeeeec' align='right'>680040</td><td bgcolor='#eeeeec'>ARFinder\Engines\AcademicSearchApi\Integrator->getAcademicReferences(  )</td><td title='C:\wamp64\www\project-tcc\src\Controller\ReferenceFinderController.php' bgcolor='#eeeeec'>...\ReferenceFinderController.php<b>:</b>153</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>9</td><td bgcolor='#eeeeec' align='center'>7.5085</td><td bgcolor='#eeeeec' align='right'>686328</td><td bgcolor='#eeeeec'>ARFinder\Engines\AcademicSearchApi\Integrator->evaluate(  )</td><td title='C:\wamp64\www\project-tcc\src\Engines\AcademicSearchApi\Integrator.php' bgcolor='#eeeeec'>...\Integrator.php<b>:</b>90</td></tr>
</table></font>

	<?php /* Navbar */?>
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<?php /* Mobile menu */?>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Project TCC</a>
			</div>
			<?php /* Desktop menu */?>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="">Home</a></li>
					<li><a href="#about">About</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container" data-id="cp">
        <h2>
        	<img src="./images/lapis.png" width="60px" height="50px" style="margin-right: 5px;">
        	Project TCC - Abimael
        </h2>
        <p>Cole o texto aqui e aguarde a análise dos nossos agentes inteligentes. Eles irão sugerir sinônimos nas palavras mais repetidas pro teu texto ficar com mais moral.</p>
        <form>
          <div class="form-group">
            <label for="comment">Texto original:</label>
            <textarea name="tinymce" class="form-control" rows="8" id="texto-original" onfocus="this.select();" onmouseup="return false;" style="text-align: justify;">
            </textarea>
           <!--  <button name="send_sobek">Enviar para o Sobek</button> -->
    		<!-- <div class="parametros-utilizados"><div>
    		<div class="retorno-sobek"><div> -->
          </div>
          <div class="form-group" align="right">
            <button data-id='analyze-text' type="submit" class="btn btn-primary">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true">&nbsp;</span>Processar texto
            </button>
            <a href="" name="limpa_campo" class="btn btn-danger btn-cancel" role="button">
              <span class="glyphicon glyphicon-trash cancelar" aria-hidden="true">&nbsp;</span>Limpar
            </a>
          </div>
          <div class="form-group" align="left">
            <input type="text" name="search" placeholder="Search.."> 
          </div>

        </form>
        <div id="analyzeResult">
          <label for="comment">Resultado:</label>
          <div class="well" id="resultado" style="text-align: justify;">
          </div>
        </div>
    </div>

</body>
</html>
