			<div class="col-sm-offset-<?= $com->get_com_level(); ?> col-sm-7" id="com<?= $com->get_id(); ?>">
				<div class="panel panel-default">
					<div class="panel-body">
						<p><?= $com->get_contenu(); ?></p>
					</div>				

					<div class="panel-footer">
						<span class="pull-right">
							<div class="btn-toolbar" role="toolbar" aria-label="com-toolbar">
								<div class="btn-group btn-group-xs" role="group" aria-label="com-toolbar-btn">
									<?php if (isset($membre) AND $membre->is_admin()) : ?>
										<a href="?module=commentaires&page=effacer&action=submit&id=<?= $com->get_id(); ?>" type="button" class="btn btn-danger" aria-label="effacer" alt="Effacer"><i class="fa fa-eraser" aria-hidden="true"></i></a>
									<?php endif; ?>
									<a href="?module=commentaires&page=signaler&action=submit&id=<?= $com->get_id(); ?>" type="button" class="btn btn-danger" aria-label="signaler"><i class="fa fa-bullhorn" aria-hidden="true"></i>
										<?= ($com->get_signalement() > 0) ? ' ' . $com->get_signalement() : ''; ?></a>
									<?php if ($com->get_com_level() < Commentaire::COM_LEVEL_MAX) : ?>
									<a href="?module=commentaires&page=repondre&id=<?= $com->get_id(); ?>" type="button" class="btn btn-info" aria-label="repondre"><i class="fa fa-comments" aria-hidden="true"></i> Rép.</a>
									<?php endif; ?>
								</div>
							</div>	
						</span>	
						<?= $com->getAuteur(); ?> le <?= $com->get_date_publie(); ?>
					</div>
				</div>
			</div>

			<?php if (isset($comFormId) AND $comFormId == $com->get_id()) : ?>
				<div class="col-sm-offset-<?= $com->get_com_level() + 1; ?> col-sm-7">
					<?php require (SITE_ROOT . 'modules/commentaires/views/formulaire.view.php'); ?>
				</div>
				<p class="col-xs-12">&nbsp;</p>
			<?php endif; ?>

			<?php foreach ($com->_enfants as $com) : ?>

				<?php include(__FILE__); ?>	

			<?php endforeach; ?>
