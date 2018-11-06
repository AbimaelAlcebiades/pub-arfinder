<?php
/**
 * @author      Abimael Alcebíades - abimaelafsilva@gmail.com
 * @version     1.0
 * @copyright   Copyright (C) 2017 Abimael Alcebíades. All rights reserved.
 * @license     See LICENSE file.
 */

?>
<div>
	<ul class="nav nav-tabs" id="myTabs" role="tablist">
		<?php foreach ($listOfterms as $term) {?>
			<li role="presentation">
				<a href="#<?php echo $term->getName(true); ?>" id="<?php echo $term->getName(true); ?>-tab" role="tab" data-toggle="tab" aria-controls="<?php echo $term->getName(true); ?>" aria-expanded="true">
					<?php echo $term->getName(); ?>
				</a>
			</li>
		<?php }?>
	</ul>

	<div class="tab-content" id="myTabContent">
		<?php foreach ($listOfterms as $term) {?>
			<div style="margin-top: 5px;" class="tab-pane fade" role="tabpanel" id="<?php echo $term->getName(true); ?>" aria-labelledby="<?php echo $term->getName(true); ?>-tab">
				<h4>Dados do termo</h4>
				<div class="well well-sm">
					<form class="form-horizontal">
					  <div class="form-group form-group-sm">
							<?php /* Id */ ?>
							<label class="col-sm-1 control-label" for="term-id-<?php echo $term->getId();?>">ID</label>
					    <div class="col-sm-2	">
					      <input class="form-control" type="text" id="term-id-<?php echo $term->getId();?>" value="<?php echo $term->getId();?>">
					    </div>
							<?php /* Nome */ ?>
							<label class="col-sm-1 control-label" for="term-name-<?php echo $term->getId();?>">Nome</label>
							<div class="col-sm-2	">
								<input class="form-control" type="text" id="term-name-<?php echo $term->getId();?>" value="<?php echo $term->getName();?>">
							</div>
							<?php /* Ocorrência */ ?>
							<label class="col-sm-1 control-label" for="term-occurrence-<?php echo $term->getId();?>">Ocorrência</label>
							<div class="col-sm-2	">
								<input class="form-control" type="text" id="term-occurrence-<?php echo $term->getId();?>" value="<?php echo $term->getOccurrence();?>">
							</div>
							<?php /* Frequência */ ?>
							<label class="col-sm-1 control-label" for="term-frequency-<?php echo $term->getId();?>">Frequência</label>
							<div class="col-sm-2	">
								<input class="form-control" type="text" id="term-frequency-<?php echo $term->getId();?>" value="<?php echo $term->getFrequency();?>">
							</div>
					  </div>

						<div class="form-group form-group-sm">
							<?php /* Relações */ ?>
							<label class="col-sm-1 control-label" for="term-relations-<?php echo $term->getId();?>">Conexões</label>
					    <div class="col-sm-2	">
					      <input class="form-control" type="text" id="term-relations-<?php echo $term->getId();?>" value="<?php echo $term->getNumberOfRelations();?>">
					  	</div>
					  </div>

						<?php foreach ($term->getText(true) as $index => $citationText) { ?>
							<div class="form-group form-group-sm">
								<?php /* Texto */ ?>
								<label class="col-sm-1 control-label" for="term-text-<?php echo $term->getId() . '-' . $index;?>">Citacão <?php echo $index+1; ?></label>
								<div class="col-sm-11	">
									<textarea class="form-control" id="term-text-<?php echo $term->getId() . '-' . $index;?>" rows="1"><?php echo $citationText;?></textarea>
								</div>
							</div>
						<?php } ?>
						<button data-id="search-references">Buscar referências</button>
                        <button data-id="search-references-mag">Buscar referências - MAG</button>
					</form>
				</div>

				<h4>Termos linkados</h4>
				<?php foreach ($term->getRelations() as $relationedTerm) {?>
					<div class="well well-sm">
						<p><strong>Id</strong>: <?php echo $relationedTerm->getId(); ?></p>
						<p><strong>Nome</strong>: <?php echo $relationedTerm->getName(); ?></p>
						<p><strong>Conexões</strong>: <?php echo $relationedTerm->getConnections(); ?></p>
					</div>
				<?php }?>

				<h4>Referencias para o termo</h4>
				<div class="well well-sm" data-reference="references-result">
				</div>

			</div>
		<?php }?>
	</div>
</div>
