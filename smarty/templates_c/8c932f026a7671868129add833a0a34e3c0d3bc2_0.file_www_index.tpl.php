<?php
/* Smarty version 5.5.1, created on 2026-06-12 03:34:20
  from 'file:www_index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6a2b621c3faab1_39105221',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8c932f026a7671868129add833a0a34e3c0d3bc2' => 
    array (
      0 => 'www_index.tpl',
      1 => 1770308776,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:www_header.tpl' => 1,
    'file:www_footer.tpl' => 1,
  ),
))) {
function content_6a2b621c3faab1_39105221 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home1/doctora1/public_html/SOPlanning/templates';
$_smarty_tpl->renderSubTemplate("file:www_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/css/simplePage.css" />	

<div class="container">
	<h3 class="text-center">
		<?php if ((defined('CONFIG_SOPLANNING_LOGO') ? constant('CONFIG_SOPLANNING_LOGO') : null) != '') {?>
				<img src="./upload/logo/<?php echo (defined('CONFIG_SOPLANNING_LOGO') ? constant('CONFIG_SOPLANNING_LOGO') : null);?>
" alt='logo' style='height:40px;' id="logo" /><br />
		<?php }?>
		<?php if ((defined('CONFIG_SOPLANNING_TITLE') ? constant('CONFIG_SOPLANNING_TITLE') : null) != "SOPlanning") {?>
			<span class="soplanning_index_title1"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')((defined('CONFIG_SOPLANNING_TITLE') ? constant('CONFIG_SOPLANNING_TITLE') : null));?>
</span>
		<?php } else { ?>
			<span class="soplanning_index_title2">Simple Online Planning</span>
		<?php }?>
		<?php if ((true && ($_smarty_tpl->hasVariable('infoVersion') && null !== ($_smarty_tpl->getValue('infoVersion') ?? null)))) {?>
			<small>v<?php echo $_smarty_tpl->getValue('infoVersion');?>
</small>
		<?php }?>
	</h3>
	<div class="small-container">
		<?php if ((true && ($_smarty_tpl->hasVariable('alerte') && null !== ($_smarty_tpl->getValue('alerte') ?? null)))) {?>
			<div class="alert alert-danger"><?php echo $_smarty_tpl->getValue('alerte');?>
</div>
		<?php }?>

		<?php if ((true && (true && null !== ($_smarty_tpl->getValue('smartyData')['message'] ?? null)))) {?>
			<?php $_smarty_tpl->assign('messageFinal', $_smarty_tpl->getSmarty()->getModifierCallback('formatMessage')($_smarty_tpl->getValue('smartyData')['message']), false, NULL);?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<i class="fa fa-lg fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getValue('messageFinal');?>

			</div>
		<?php }?>

		<?php if ((true && ($_smarty_tpl->hasVariable('blocked') && null !== ($_smarty_tpl->getValue('blocked') ?? null)))) {?>
			<div class="alert alert-danger"><?php echo $_smarty_tpl->getValue('blocked');?>
</div>
			<br><br><br>
		<?php } else { ?>
			<form action="process/login" method="post" class="form-horizontal box" id="formLogin">
				<input type="hidden" name="crsf" value="<?php echo $_SESSION['CRSF'];?>
">

				<div class="form-group row col-md-12">
					<label for="login" class="col-md-4 col-sm-4 control-label"><?php echo $_smarty_tpl->getConfigVariable('login_login');?>
 :</label>
					<div class="col-md-8 col-sm-8">
						<input type="text" class="form-control" name="login" id="login" />
					</div>
				</div>
				<div class="form-group row col-md-12">
					<label for="password" class="col-md-4 col-sm-4 control-label"><?php echo $_smarty_tpl->getConfigVariable('login_password');?>
 :</label>
					<div class="col-md-8 col-sm-8">
						<input type="password" class="form-control" name="password" id="password" />
					</div>
				</div>
				<div class="form-group row col-md-12">
					<label for="password" class="col-md-4 col-sm-4 control-label">&nbsp;</label>
					<div class="col-md-8 col-sm-8">
						<input class="form-check-input" type="checkbox" name="remember" id="remember" value="remember" style="margin-left:0px">
						<label class="form-check-label" for="remember" style="margin-left:20px"><?php echo $_smarty_tpl->getConfigVariable('remember_checkbox');?>
</label>
					</div>
				</div>
				<div class="form-group">
					<div  class="col-12 text-center">
						<input class="btn btn-primary" type="submit" value="<?php echo $_smarty_tpl->getConfigVariable('loginTxt');?>
" />
					
						<?php if ((true && ($_smarty_tpl->hasVariable('google_auth_url') && null !== ($_smarty_tpl->getValue('google_auth_url') ?? null)))) {?>
							<br><br>
							<?php echo $_smarty_tpl->getConfigVariable('ou');?>
<br><br>
							<a class="btn btn-info" href="<?php echo $_smarty_tpl->getValue('google_auth_url');?>
"><?php echo $_smarty_tpl->getConfigVariable('google_oauth_bouton');?>
</a>
						<?php }?>

					</div >
				</div>

			</form>
			<div class="form-group text-center">
			<?php if ((defined('CONFIG_SOPLANNING_OPTION_ACCES') ? constant('CONFIG_SOPLANNING_OPTION_ACCES') : null) == 1) {?>
				<a href="planning?public=1"><?php echo $_smarty_tpl->getConfigVariable('accesPublic');?>
</a> &middot;
			<?php }?>
			<a href="#pwdReminderModal" role="button" data-toggle="modal"><?php echo $_smarty_tpl->getConfigVariable('rappelPwdTitre');?>
</a><br /><br />
			</div>
			<div id="divTranslation">
				<ul class="list-inline flag text-right">
					<li class="list-inline-item"><a href="?language=en" class="tooltipEvent" data-title="English"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/en.png" alt="English" title="English"/></a></li>
					<li class="list-inline-item"><a href="?language=fr" class="tooltipEvent" data-title="French"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/fr.png" alt="French" title="French"/></a></li>
					<li class="list-inline-item"><a href="?language=nl" class="tooltipEvent" data-title="Dutch"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/nl.png" alt="Dutch" title="Dutch"/></a></li>
					<li class="list-inline-item"><a href="?language=it" class="tooltipEvent" data-title="Italian"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/it.png" alt="Italian" title="Italian"/></a></li>
					<li class="list-inline-item"><a href="?language=pl" class="tooltipEvent" data-title="Polish"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/pl.png" alt="Polish" title="Polish"/></a></li>
					<li class="list-inline-item"><a href="?language=pt" class="tooltipEvent" data-title="Portuguese"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/pt.png" alt="Portuguese" title="Portuguese"/></a></li>
					<li class="list-inline-item"><a href="?language=br" class="tooltipEvent" data-title="English"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/br.png" alt="Brazilian Portuguese" title="Brazilian Portuguese"/></a></li>
					<li class="list-inline-item"><a href="?language=es" class="tooltipEvent" data-title="Spanish"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/es.png" alt="Spanish" title="Spanish" /></a></li>
					<li class="list-inline-item"><a href="?language=de" class="tooltipEvent" data-title="German"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/de.png" alt="German" title="German"/></a></li>
					<li class="list-inline-item"><a href="?language=da" class="tooltipEvent" data-title="Danish"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/da.png" alt="Danish" title="Danish"/></a></li>
					<li class="list-inline-item"><a href="?language=hu" class="tooltipEvent" data-title="Hungarian"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/hu.png" alt="Hungarian" title="Hungarian"/></a></li>
					<li class="list-inline-item"><a href="?language=id" class="tooltipEvent" data-title="Indonesian"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/id.png" alt="Indonesian" title="Indonesian"/></a></li>
					<li class="list-inline-item"><a href="?language=sl" class="tooltipEvent" data-title="Slovenian"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/img/flag/sl.png" alt="Slovenian" title="Slovenian"/></a></li>
				</ul>
				<p class="text-right text-info"><small><a href="mailto:support@soplanning.org"><?php echo $_smarty_tpl->getConfigVariable('proposerTrad');?>
</a></small></p>
			</div>
			<div id="infosVersion" class="alert alert-warning" style="display:none"></div>
		<?php }?>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="pwdReminderModal">
<div class="modal-dialog modal-dialog-normal" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?php echo $_smarty_tpl->getConfigVariable('rappelPwdTitre');?>
</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
		<input type="text" id="rappel_pwd" placeholder="<?php echo $_smarty_tpl->getConfigVariable('rappelPwdVotreEmail');?>
" class="form-control" />
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" id="changePwd"><?php echo $_smarty_tpl->getConfigVariable('submit');?>
</button>
		</div>
	</div>
</div>
</div>

<?php echo '<script'; ?>
>
document.getElementById('login').focus();
setTimeout("xajax_checkAvailableVersion('home');", 3000);

jQuery(document).ready(function() {
	jQuery('#changePwd').click(function(){
		xajax_changerPwd(document.getElementById('rappel_pwd').value);
	});
});

<?php echo '</script'; ?>
>
<?php $_smarty_tpl->renderSubTemplate("file:www_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
