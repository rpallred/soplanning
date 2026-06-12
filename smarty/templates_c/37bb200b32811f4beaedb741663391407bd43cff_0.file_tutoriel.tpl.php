<?php
/* Smarty version 5.5.1, created on 2026-06-12 04:05:08
  from 'file:tutoriel.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6a2b69548423e6_02234126',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '37bb200b32811f4beaedb741663391407bd43cff' => 
    array (
      0 => 'tutoriel.tpl',
      1 => 1772195582,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a2b69548423e6_02234126 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home1/doctora1/public_html/SOPlanning/templates';
if ((true && ($_smarty_tpl->hasVariable('afficher_tuto') && null !== ($_smarty_tpl->getValue('afficher_tuto') ?? null)))) {?>
	<?php if ($_SESSION['isMobileOrTablet'] == 0) {?>

		<div class="modal fade" tabindex="-1" role="dialog" id="modal-tutoriel">
			<div class="modal-dialog modal-tutoriel" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_titre');?>
</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div id="tutoriel-contenu-1">
							<?php echo $_smarty_tpl->getConfigVariable('tutoriel_contenu_1');?>

							<br><br>
							<div align="center">
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-1').hide();$('#tutoriel-contenu-2').show();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_demarrer');?>
</a>
							</div>
						</div>
						<div id="tutoriel-contenu-2" style="display:none">
							<?php echo $_smarty_tpl->getConfigVariable('tutoriel_contenu_2');?>

							<br><br>
							<div align="center" width="630" style="border:1px solid #000000;">
								<video width="100%" controls autoplay muted loop>
									<source src="assets/videos/creation_tache_<?php if ($_smarty_tpl->getValue('lang') == "fr") {?>fr<?php } else { ?>en<?php }?>.mp4" type="video/mp4">
									Your browser does not support the video tag.
								</video>
							</div>
							<br>
							<div align="center">
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-1').show();$('#tutoriel-contenu-2').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_precedent');?>
</a>
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-3').show();$('#tutoriel-contenu-2').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_suivant');?>
</a>
							</div>
							<br>
						</div>
						<div id="tutoriel-contenu-3" style="display:none">
							<?php echo $_smarty_tpl->getConfigVariable('tutoriel_contenu_3');?>

							<br><br>
							<div align="center" width="630" style="border:1px solid #000000;">
								<video width="100%" controls autoplay muted loop>
									<source src="assets/videos/glisser_copier_<?php if ($_smarty_tpl->getValue('lang') == "fr") {?>fr<?php } else { ?>en<?php }?>.mp4" type="video/mp4">
									Your browser does not support the video tag.
								</video>
							</div>
							<br>
							<div align="center">
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-2').show();$('#tutoriel-contenu-3').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_precedent');?>
</a>
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-4').show();$('#tutoriel-contenu-3').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_suivant');?>
</a>
							</div>
							<br>
						</div>

						<div id="tutoriel-contenu-4" style="display:none">
							<?php echo $_smarty_tpl->getConfigVariable('tutoriel_contenu_4');?>

							<br><br>
							<div align="center" width="630" style="border:1px solid #000000;">
								<video width="100%" controls autoplay muted loop>
									<source src="assets/videos/selection_multiple_<?php if ($_smarty_tpl->getValue('lang') == "fr") {?>fr<?php } else { ?>en<?php }?>.mp4" type="video/mp4">
									Your browser does not support the video tag.
								</video>
							</div>
							<br>
							<div align="center">
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-3').show();$('#tutoriel-contenu-4').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_precedent');?>
</a>
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-5').show();$('#tutoriel-contenu-4').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_suivant');?>
</a>
							</div>
							<br>
						</div>

						<div id="tutoriel-contenu-5" style="display:none">
							<?php echo $_smarty_tpl->getConfigVariable('tutoriel_contenu_5');?>

							<br><br>
							<div align="center" width="630" style="border:1px solid #000000;">
								<video width="100%" controls autoplay muted loop>
									<source src="assets/videos/creation_tache_<?php if ($_smarty_tpl->getValue('lang') == "fr") {?>fr<?php } else { ?>en<?php }?>.mp4" type="video/mp4">
									Your browser does not support the video tag.
								</video>
							</div>
							<br>
							<div align="center">
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-4').show();$('#tutoriel-contenu-5').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_precedent');?>
</a>
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-6').show();$('#tutoriel-contenu-5').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_suivant');?>
</a>
							</div>
							<br>
						</div>

						<div id="tutoriel-contenu-6" style="display:none">
							<?php echo $_smarty_tpl->getConfigVariable('tutoriel_contenu_6');?>

							<br><br>
							<div align="center" width="630" style="border:1px solid #000000;">
								<video width="100%" controls autoplay muted loop>
									<source src="assets/videos/decalage_projet_<?php if ($_smarty_tpl->getValue('lang') == "fr") {?>fr<?php } else { ?>en<?php }?>.mp4" type="video/mp4">
									Your browser does not support the video tag.
								</video>
							</div>
							<br>
							<div align="center">
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-5').show();$('#tutoriel-contenu-6').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_precedent');?>
</a>
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-7').show();$('#tutoriel-contenu-6').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_suivant');?>
</a>
							</div>
							<br>
						</div>

						<div id="tutoriel-contenu-7" style="display:none">
							<?php echo $_smarty_tpl->getConfigVariable('tutoriel_contenu_7');?>

							<br><br>
							<div align="center">
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-6').show();$('#tutoriel-contenu-7').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_precedent');?>
</a>
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-8').show();$('#tutoriel-contenu-7').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_suivant');?>
</a>
							</div>
							<br>
						</div>

						<div id="tutoriel-contenu-8" style="display:none">
														<?php echo $_smarty_tpl->getConfigVariable('tutoriel_contenu_9');?>

							<br><br>
							<div align="center">
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-7').show();$('#tutoriel-contenu-8').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_precedent');?>
</a>
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-9').show();$('#tutoriel-contenu-8').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_suivant');?>
</a>
							</div>
							<br>
						</div>

						<div id="tutoriel-contenu-9" style="display:none">
							<?php echo $_smarty_tpl->getConfigVariable('tutoriel_contenu_8');?>

							<br><br>
							<div align="center">
								<a class="btn btn-default" href="javascript:$('#tutoriel-contenu-8').show();$('#tutoriel-contenu-9').hide();void(0);"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_precedent');?>
</a>
							</div>
							<br>
						</div>

						<br><br>
						<div align="center">
							<a class="btn btn-default" href="javascript:if(confirm('<?php echo strtr((string)$_smarty_tpl->getConfigVariable('tutoriel_ne_plus_afficher_confirm'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", 
						"\n" => "\\n", "</" => "<\/", "<!--" => "<\!--", "<s" => "<\s", "<S" => "<\S",
						"`" => "\\`", "\${" => "\\\$\{"));?>
')){$('#modal-tutoriel').modal('hide');xajax_tutoriel_masquer();}undefined;"><?php echo $_smarty_tpl->getConfigVariable('tutoriel_ne_plus_afficher');?>
</a>
						</div>

					</div>
				</div>
			</div>
		</div>

		<?php echo '<script'; ?>
>
			// Onload
			jQuery(function() {
				<?php if ((true && ($_smarty_tpl->hasVariable('afficher_tuto') && null !== ($_smarty_tpl->getValue('afficher_tuto') ?? null)))) {?>
				
					$("#modal-tutoriel").modal({backdrop: 'static',  keyboard: false});
					// fade in  : https://codepen.io/bootpen/pen/jbbaRa
					$('#modal-tutoriel').on('shown.bs.modal', function (e) {
					  $(".modal-backdrop").css({ opacity: 0.15 });
					})
					$('#modal-tutoriel').on('hidden.bs.modal', function (e) {
					  $(".modal-backdrop").css({ opacity: 0.5 });
					})
				
				<?php }?>
			});
		<?php echo '</script'; ?>
>
	<?php }?>

<?php }
}
}
