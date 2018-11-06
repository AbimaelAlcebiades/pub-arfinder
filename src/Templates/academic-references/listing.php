<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */
?>
<?php if(!$loadMore){ ?>
    <!-- <h5 class="text-center text-muted" id='search-label'><?php //echo $searchLegend;?></h5> -->
<?php } ?>
<?php if(false){ ?>
    <h6>CONSULTA : 
    <?php foreach ($academicReferences['queries'] as $value) {
        echo 'QueryString: ' . $value['queryString'] . '<br>';
        echo 'Resultados: ' . $value['numberOfResults'] . '<br>';
    } ?>
    </h6>
<?php } ?>

<div class="card-columns card-deck">
    <?php foreach ($papers as $paper) { ?>
        <div class="card card-academic-reference" style="display:none;">
            <?php if(false){ ?>
                <h6>Analisado com <?php echo $paper->analisadoCom; ?><h6>
                <h6>Similariedade com seu texto: <?php echo $paper->similarity; ?></h6>
                <h6>Similariedade com seu texto (PHP): <?php echo $paper->similarityPHP; ?></h6>
                <h6>Total de similariedade: <?php echo $paper->totalSimilarity; ?></h6>
            <?php } ?>
            <div class="card-body">
                <h4 class="card-title text-center"><?php echo $paper->getDisplayName(true); ?></h4>
                <?php if($abstract = $paper->getAbstract(30)) { ?>
                    <div id='abstract-container'class="text-center">
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=" <?php echo $abstract; ?>...">
                            Resumo
                        </button>
                    </div>
                <?php } else { ?>
                    <p class="card-text text-center">
                        <small class="text-muted">Resumo não disponível</small>
                    </p>
                <?php } ?>

                <?php /* Authors. */ ?>
                <?php if($authors = $paper->getAuthors()) ?>
                <p class="card-text text-muted text-center">
                    <?php $authorsLinks = array(); ?>
                    <?php foreach ($authors as $author) {
                        $authorsLinks[] = '<a href="#" data-author="'.$author->getName(true).'">'.$author.'</a>';
                    } ?>
                    <?php echo 'Por '. implode(', ', $authorsLinks); ?>
                </p>
                <?php if(!empty($paper->getSources())) { ?>
                    <p class="card-text text-center">
                        Conteúdo disponível:
                    </p>
                    <ul class="list-inline text-center list-sources">
                        <!-- <?php /* Language */ ?>
                        <li>
                            Idioma: <?php //echo $paper->getLanguage();?>
                        </li> -->
            
                        <?php /* Sources */ ?>
                        <li class="list-inline-item">
                            <?php foreach ($paper->getSources() as $type => $source) { ?>
                                <?php switch ($type) {
                                    case 'HTML':
                                        $displaySource =
                                            '<a href="'.$source.'" title="Conteúdo em HTML" target="_blank">
                                                <img src="images/icons/link_24px.svg" alt="ícone de link">
                                            </a>';
                                        break;
            
                                    case 'PDF':
                                        $displaySource = 
                                            '<a href="'.$source.'" title="Conteúdo em PDF" target="_blank">
                                                <img src="images/icons/pdf_24px.svg" alt="ícone de pdf">
                                            </a>';
                                        break;

                                    case 'Download':
                                        $displaySource = 
                                            '<a href="'.$source.'" title="Download do conteúdo" target="_blank">
                                                <img src="images/icons/download_24px.svg" alt="ícone de download">
                                            </a>';
                                        break;
                                    
                                    default:
                                        $displaySource = $source;
                                        break;
                                } ?>
                                <?php echo $displaySource; ?>
                            <?php } ?>
                        </li>                     
                        <?php /* Fields of study */ ?>
                        <!-- <li>
                            Campos de estudo:
                            <?php //foreach ($paper->getFieldsOfStudy() as $fieldOfStudy) { ?>
                                <?php //echo $fieldOfStudy->getName(); ?>
                            <?php// } ?>
                        </li> -->
                    </ul>
                <?php } else { ?>
                    <p class="card-text text-center">
                        Não foi encontrado conteúdo associado
                    </p>
                <?php } ?>
                <p class="card-text text-center">
                    <?php /* Date */ ?>
                    <small class="text-muted"> Data de publicação - <?php echo $paper->getDate('d/m/Y');?></small>
                </p>
            </div>        
        </div>
    <?php } ?>
</div>

