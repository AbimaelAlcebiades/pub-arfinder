<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */
?>

<?php /* Walks terms. */ ?>
<?php foreach ($suggestTerms as $normalizedName => $suggestTerm) { ?>
    <a class="btn btn-primary suggestion-term" data-term-value="<?php echo $normalizedName; ?>" href="#" 
    role="button">
        <?php echo $suggestTerm->getName(); ?>
    </a>
<?php } ?>
