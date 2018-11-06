<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Engines'.DIRECTORY_SEPARATOR.'AcademicSearchApi'.DIRECTORY_SEPARATOR.'AcademicReference.php';
require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Engines'.DIRECTORY_SEPARATOR.'AcademicSearchApi'.DIRECTORY_SEPARATOR.'Paper.php';
require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'Engines'.DIRECTORY_SEPARATOR.'AcademicSearchApi'.DIRECTORY_SEPARATOR.'Author.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="./images/srfinder-logo.png">
  <title>AR Finder</title>
  <meta charset="utf-8">

  <?php /* Load javascript. */ ?>
  <script src="assets/js/tinymce/tinymce.min.js"></script>
  <script src="assets/js/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" 
    integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" 
    crossorigin="anonymous">
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" 
    integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" 
    crossorigin="anonymous">
  </script>
  <script src="assets/js/arfinder.js"></script>

  <?php /* Load CSS */ ?>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
    integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" 
    crossorigin="anonymous">

  <?php /* Init tinymce editor. */ ?>
  <script>
    tinymce.init({ selector:"textarea[name='tinymce']", height : 300 });
  </script>
</head>

<body>
  <?php /* Navbar */?>
  <nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="#">
    <img src="/images/srfinder-logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Finder
    </a>
    <?php /* Config button. */  ?>

    <ul id="menu-options" class="nav nav-pills float-right">
      <li class="nav-item">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#arfinder-history">
          <img src="images/icons/history_24px.svg" alt="Ícone de histórico">
        </button>
      </li>
      <li class="nav-item">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#arfinder-settings">
          <img src="images/icons/settings_24px.svg" alt="Ícone de configurações">
        </button>
      </li> 
    </ul> 
  </nav>

  <?php /* Modal settings */ ?>
  <div class="modal fade" id="arfinder-settings" tabindex="-1" role="dialog" aria-labelledby="arfinder-settingsLabel" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="arfinder-settingsLabel">Configurações AR Finder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <label><strong>Idioma</strong></label>
                <div class="input-group">
                  <div class="form-check form-check-inline">
                    <label class="custom-control custom-checkbox">
                      <input name="language[]" value='pt' type="checkbox" checked class="custom-control-input">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Português</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input name="language[]" value='en' type="checkbox" class="custom-control-input">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Inglês</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label><strong>Ordenação dos resultados</strong></label>
                <div class="custom-controls-stacked d-block my-3">
                  <label class="custom-control custom-radio">
                    <input name="orderby" type="radio" checked class="custom-control-input" value="prob">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Relevância</span>
                  </label>
                  <label class="custom-control custom-radio">
                    <input name="orderby" type="radio" class="custom-control-input" value="date">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Mais recentes</span>
                  </label>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-12">
                <label><strong>Busca automática</strong></label>
                <div class="input-group">
                  <div class="form-check form-check-inline">
                    <label class="custom-control custom-checkbox">
                      <input name="automatic-search-ar" id="automatic-search-ar" type="checkbox" 
                        checked class="custom-control-input">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Sugerir referências acadêmicas automaticamente</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                      <input name="display-suggestions-list" id="display-suggestions-list"
                        type="checkbox" checked class="custom-control-input">
                      <span class="custom-control-indicator"></span>
                      <span class="custom-control-description">Exibir sugestões de termos para busca</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="check-one-each" class="col-sm-5 col-form-label">Verificar o texto a cada</label>
              <div class="col-sm-5">
                <input type="number" class="form-control" id="check-one-each" min="15" value="15">
                <small class="form-text text-muted">
                 Valor minímo é 15s.
                </small>
              </div>
            </div> -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary">Salvar alterações</button>
        </div>
      </div>
    </div>
  </div>

  <?php /* Modal history */ ?>
  <div class="modal fade" id="arfinder-history" tabindex="-1" role="dialog" aria-labelledby="arfinder-historyLabel" 
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="arfinder-historyLabel">Histórico de referências sugeridas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <?php if(isset($_SESSION['suggestedAR']) && !empty($_SESSION['suggestedAR'])){ ?>
              <ul id="list-history">
                <?php 
                  foreach($_SESSION['suggestedAR'] as $academicReferece){
                    echo "<li>";
                      echo $academicReferece->getDisplayName();
                      echo " - Autores ";
                      $authors = array();
                      foreach($academicReferece->getAuthors() as $author){
                        $authors[] = '<i>'.ucwords($author->getName()).'</i>';
                      }
                      echo implode(', ', $authors);
                      $count = 1;
                      $links = array();
                      foreach ($academicReferece->getSources() as $source) { 
                        $links[] =
                          '<a href="'.$source.'" title="Conteúdo em HTML" target="_blank">
                            link'.$count.'
                          </a>';
                        $count++;
                      }
                      if(!empty($links)){
                        echo "<br><strong>Links</strong> :";
                        echo implode('-', $links);
                      }
                    echo "</li>";
                  }
                ?>
              </ul>
            <?php } else { ?>
              <p class="text-center">Não existem registros!</p>
            <?php } ?>
          </div>
        </div>
        <div class="modal-footer">
          <button id="clear-history" type="button" class="btn btn-primary">Apagar histórico</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    
    <div id="input-article-text" class="form-group">
      <textarea name="tinymce" class="form-control" rows="8" id="texto-original" onfocus="this.select();"
        onmouseup="return false;" style="text-align: justify;">
      </textarea>
    </div> 

    <div id="tools-search" class="row align-items-center">
      <!-- <div class="col-lg-8">
        <div class="input-group">
          <input id="search-bar-ar" type="text" class="form-control" 
            placeholder="Buscar artigos científicos por..." aria-label="Buscar artigos científicos por...">
          <span class="input-group-btn">
            <button id="search-academic-references" class="btn btn-primary" type="button">
              <img src="images/icons/search_24px.svg" alt="Ícone de lupa">
            </button>
          </span>
        </div>
      </div>
      <div id="search-filters" class="col-lg-2">
        <label class="custom-control custom-radio">
          <input id="search-filter-articles" checked="checked" name="radio" type="radio" class="custom-control-input">
          <span class="custom-control-indicator"></span>
          <span class="custom-control-description">Artigos</span>
        </label>
        <label class="custom-control custom-radio">
          <input id="search-filter-authors" name="radio" type="radio" class="custom-control-input">
          <span class="custom-control-indicator"></span>
          <span class="custom-control-description">Autores</span>
        </label>
      </div> -->
      <div class="col-lg-12">
        <button id="analyze-text" type="submit" class="btn btn-primary">
          Analise meu texto
        </button>
      </div>

      <input type="hidden" id="academic-reference-term" value="">
      <input type="hidden" id="academic-reference-author" value="">
    </div>
    
    <div id='container-progress-bar' class='d-none'>
      <h3 class='text-center'>Analisando o seu texto...</h3>
      <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 0%; height: 20px;"
         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        </div>
      </div>
    </div>

    <div id="container-suggestions-terms" class="card d-none">
      <h4 class="card-header text-center">Sugestões de busca</h4>
      <div id="list-suggestions-terms" class="card-body text-center">
      </div>
    </div>

    <div id="container-academic-references" class="card d-none">
      <h4 class="card-header text-center">Referências Acadêmicas</h4>
      <div id="list-academic-references" class="card-body">
      </div>
      <div id='container-load-more-ar' class="d-block text-center">
        <button id='load-more-ar' type="button" class="btn btn-primary">
          + Referências Acadêmicas
        </button>
      </div>
    </div>
  </div>
  
</body>
</html>
