<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */
?>
<div id='container-mag-error-message'class="alert alert-secondary text-center" role="alert">
  <p class="alert-heading"><img src="images/icons/mood_bad_24px.svg" alt="ícone mood bad"></p>
  <p><?php echo $errorMessage; ?></p>
  <?php if($displayTryAgain){ ?>
    <button id="search-references-try-again" class='btn btn-primary' data-results-for-ta="<?php echo $_POST['term']; ?>"
    data-author-ta="<?php echo $filterAuthor;?>">
      Tentar novamente
    </button>
  <?php } ?>
</div>

