<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */
?>

<?php // TODO: PRECISO VER COMO FICO LISTA DE CITAÇÕES. ?>

<style media="screen">
    .reference-item {
        height: 60px;
        width: 60px;
        font-size: 15px;
        /*background-color: green;*/
        text-align: center;
    }
    .reference-item span.glyphicon{
        padding: 1px;
        /*background-color: red;*/
        display: block;
        font-size: 30px;
    }
    .reference-item a{
        text-decoration: none;
    }
</style>

<?php foreach ($papers as $paper) { ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <?php echo $paper->getTitle(); ?>
        </div>
        <div class="panel-body">
            <ul class="list-inline">
                <?php /* Date */ ?>
                <li>
                    Data de publicação: <?php echo $paper->getDate('d/m/Y');?>
                </li>
                <?php /* Language */ ?>
                <li>
                    Idioma: <?php echo $paper->getLanguage();?>
                </li>

                <?php /* Authors */ ?>
                <li>
                    Autores:
                    <?php foreach ($paper->getAuthors() as $author) { ?>
                        <?php echo $author->getName(); ?>
                    <?php } ?>
                </li>

                <?php /* Sources */ ?>
                <li>
                    Conteúdo:
                    <?php foreach ($paper->getSources() as $type => $source) { ?>
                        <?php switch ($type) {
                            case 'HTML':
                                $displaySource = "<a href='{$source}'>Counteúdo página</a>";
                                break;

                            case 'PDF':
                                $displaySource = "<a href='{$source}'>Conteúdo PDF</a>";
                                break;
                            
                            default:
                                $displaySource = $source;
                                break;
                        } ?>
                        <?php echo $type . ' : ' . $displaySource; ?>
                    <?php } ?>
                </li>

                <?php /* Fields of study */ ?>
                <li>
                    Campos de estudo:
                    <?php foreach ($paper->getFieldsOfStudy() as $fieldOfStudy) { ?>
                        <?php echo $fieldOfStudy->getName(); ?>
                    <?php } ?>
                </li>
                
                <?php /* Number of citations */ ?>
                <!-- <li>
                    <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                    <br>Citações<span class="badge"><?php //echo $paper['Citations'] ?></span>
                </li> -->
                <?php /* Number of versions */ ?>
                <!-- <li>
                    Versões <span class="badge"><?php //echo $paper['Versions'] ?></span>
                </li> -->
                <?php /* Cluster ID */ ?>
                <!-- <li>
                    Cluster ID <?php //echo $paper['Cluster_ID']; ?>
                </li> -->
                <?php /* Citations list */ ?>
                <!-- <li>
                    Lista de Citações <?php //echo $paper['Citations_list']; ?>
                </li> -->
                <?php /* Versions list */ ?>
                <!-- <li>
                    Lista de versões <?php //echo $paper['Versions_list']; ?>
                </li> -->
                <?php /* Excerpt */ ?>
                <!-- <li>
                    Resumo <?php //echo $paper['Excerpt']; ?>
                </li> -->
            </ul>
        </div>
    </div> 
<?php } ?>
