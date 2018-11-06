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

<?php foreach ($references as $reference): ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <?php echo $reference['Title'] ?>
        </div>
        <div class="panel-body">
            <ul class="list-inline">
                <?php /* Link */ ?>
                <li class="reference-item">
                    <a href="<?php echo $reference['URL']?>"><span class="glyphicon glyphicon-link reference-icon" aria-hidden="true"></span>Link</a>
                </li>
                <?php /* Year */ ?>
                <li>
                    <?php echo $reference['Year'];?>
                </li>
                <?php /* Number of citations */ ?>
                <li>
                    <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                    <br>Citações<span class="badge"><?php echo $reference['Citations'] ?></span>
                </li>
                <?php /* Number of versions */ ?>
                <li>
                    Versões <span class="badge"><?php echo $reference['Versions'] ?></span>
                </li>
                <?php /* Cluster ID */ ?>
                <li>
                    Cluster ID <?php echo $reference['Cluster_ID']; ?>
                </li>
                <?php /* Citations list */ ?>
                <li>
                    Lista de Citações <?php echo $reference['Citations_list']; ?>
                </li>
                <?php /* Versions list */ ?>
                <li>
                    Lista de versões <?php echo $reference['Versions_list']; ?>
                </li>
                <?php /* Excerpt */ ?>
                <li>
                    Resumo <?php echo $reference['Excerpt']; ?>
                </li>
            </ul>
        </div>
    </div>
<?php endforeach; ?>
