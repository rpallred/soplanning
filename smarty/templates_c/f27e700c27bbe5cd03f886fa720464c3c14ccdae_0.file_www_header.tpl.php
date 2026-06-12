<?php
/* Smarty version 5.5.1, created on 2026-06-12 03:34:20
  from 'file:www_header.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6a2b621c412df1_40121194',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f27e700c27bbe5cd03f886fa720464c3c14ccdae' => 
    array (
      0 => 'www_header.tpl',
      1 => 1772195582,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a2b621c412df1_40121194 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home1/doctora1/public_html/SOPlanning/templates';
?><!DOCTYPE html>
<html lang="fr">
<head>
	<?php if (!(true && ($_smarty_tpl->hasVariable('infoVersion') && null !== ($_smarty_tpl->getValue('infoVersion') ?? null)))) {?>
		<?php $_smarty_tpl->assign('infoVersion', "temp", false, NULL);?>
	<?php }?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no" />
	<meta name="reply-to" content="support@soplanning.org" />
	<meta name="email" content="support@soplanning.org" />
	<meta name="Identifier-URL" content="http://www.soplanning.org" />
	<meta name="robots" content="noindex,follow" />
	<title>
		<?php if ((true && (true && null !== ((defined('CONFIG_SOPLANNING_TITLE') ? constant('CONFIG_SOPLANNING_TITLE') : null) ?? null))) && (defined('CONFIG_SOPLANNING_TITLE') ? constant('CONFIG_SOPLANNING_TITLE') : null) != "SOPlanning") {?>
			<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')((defined('CONFIG_SOPLANNING_TITLE') ? constant('CONFIG_SOPLANNING_TITLE') : null));?>

		<?php } else { ?>
			SOPlanning - Simple Online Planning
		<?php }?>
	</title>
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/favicon-16x16.png" />
	<link rel="manifest" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/manifest" />
	<link rel="mask-icon" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/safari-pinned-tab.svg" color="#5bbad5" />
	<meta name="msapplication-TileColor" content="#da532c" />
	<meta name="theme-color" content="#ffffff" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/bootstrap-4.6.2/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/jquery-ui-1.13.2.custom/jquery-ui.min.css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/css/themes/<?php echo (defined('CONFIG_SOPLANNING_THEME') ? constant('CONFIG_SOPLANNING_THEME') : null);?>
?<?php echo $_smarty_tpl->getValue('infoVersion');?>
" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/jquery-multiselect-2.4.1/jquery.multiselect.css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/css/styles.css?<?php echo $_smarty_tpl->getValue('infoVersion');?>
" type="text/css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/css/mobile.css?<?php echo $_smarty_tpl->getValue('infoVersion');?>
" media="screen and (max-width: 1165px)" type="text/css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/css/print.css?<?php echo $_smarty_tpl->getValue('infoVersion');?>
" media="print">
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/select2-4.0.13/dist/css/select2.min.css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/css/select2-bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/spectrum-1.8.1/spectrum.css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/timepicker/jquery.ui.timepicker.css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/bootstrap-datepicker-1.10.0/css/bootstrap-datepicker3.css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/jquery-timepicker-1.14.0/jquery.timepicker.min.css" />
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/fontawesome-6.4.0/css/all.min.css" />
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/js/fonctions.js?<?php echo $_smarty_tpl->getValue('infoVersion');?>
"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/js/jquery-3.7.0.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/jquery-ui-1.13.2.custom/jquery-ui.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/jquery-multiselect-2.4.1/jquery.multiselect.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/select2-4.0.13/dist/js/select2.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/select2-4.0.13/dist/js/i18n/fr.js" charset="UTF-8"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/spectrum-1.8.1/spectrum.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/jquery-timepicker-1.14.0/jquery.timepicker.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/textarea-autosize/autosize.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/timepicker/jquery.ui.timepicker.js"><?php echo '</script'; ?>
>	
	<?php echo '<script'; ?>
 defer src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/fontawesome-6.4.0/js/all.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 defer src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/fontawesome-6.4.0/js/v4-shims.min.js"><?php echo '</script'; ?>
>
	<style>
	<?php if ((defined('CONFIG_SOPLANNING_LOGO') ? constant('CONFIG_SOPLANNING_LOGO') : null) != '') {?>
		
		.week td {min-width:30px;}
		
	<?php }?>
	<?php if ((defined('CONFIG_PLANNING_LINE_HEIGHT') ? constant('CONFIG_PLANNING_LINE_HEIGHT') : null) > 0 || (defined('CONFIG_PLANNING_COL_WIDTH') ? constant('CONFIG_PLANNING_COL_WIDTH') : null) > 0 || (defined('CONFIG_PLANNING_COL_WIDTH_LARGE') ? constant('CONFIG_PLANNING_COL_WIDTH_LARGE') : null) > 0) {?>
		td.week, td.weekend, td.sumcell, #tdtotal, #total2 {
		<?php if ((defined('CONFIG_PLANNING_LINE_HEIGHT') ? constant('CONFIG_PLANNING_LINE_HEIGHT') : null) > 0) {?>
			height:<?php echo (defined('CONFIG_PLANNING_LINE_HEIGHT') ? constant('CONFIG_PLANNING_LINE_HEIGHT') : null);?>
px;
		<?php }?>
		<?php if ((true && (true && null !== ($_SESSION['dimensionCase'] ?? null))) && $_SESSION['dimensionCase'] == "reduit") {?>
			<?php if ((defined('CONFIG_PLANNING_COL_WIDTH') ? constant('CONFIG_PLANNING_COL_WIDTH') : null) > 0) {?>
				min-width:<?php echo (defined('CONFIG_PLANNING_COL_WIDTH') ? constant('CONFIG_PLANNING_COL_WIDTH') : null);?>
px;
			<?php }?>
		<?php } else { ?>
			<?php if ((defined('CONFIG_PLANNING_COL_WIDTH_LARGE') ? constant('CONFIG_PLANNING_COL_WIDTH_LARGE') : null) > 0) {?>
				min-width:<?php echo (defined('CONFIG_PLANNING_COL_WIDTH_LARGE') ? constant('CONFIG_PLANNING_COL_WIDTH_LARGE') : null);?>
px;
			<?php }?>
		<?php }?>
		}
	<?php }?>
	<?php if ((defined('CONFIG_PLANNING_CELL_FONTSIZE') ? constant('CONFIG_PLANNING_CELL_FONTSIZE') : null) > 0) {?>.cellHolidays,.cellProjectBiseau1,.cellProjectBiseau2,.cellProject{font-size:<?php echo (defined('CONFIG_PLANNING_CELL_FONTSIZE') ? constant('CONFIG_PLANNING_CELL_FONTSIZE') : null);?>
px;}
	<?php }?>
	

	
	</style>
</head>
<body>
<?php if ((true && ($_smarty_tpl->hasVariable('user') && null !== ($_smarty_tpl->getValue('user') ?? null)))) {?>
	<nav class="navbar navbar-expand-lg navbar-dark fixed-top flex-lg-nowrap bg-dark">
		<?php if ((defined('CONFIG_SOPLANNING_LOGO') ? constant('CONFIG_SOPLANNING_LOGO') : null) != '') {?>
			<a class="navbar-brand navbar-brand-logo mr-auto d-inline-block align-items-center" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/"><img src="<?php echo $_smarty_tpl->getValue('BASE');?>
/upload/logo/<?php echo (defined('CONFIG_SOPLANNING_LOGO') ? constant('CONFIG_SOPLANNING_LOGO') : null);?>
" alt='logo' class="mr-3 logo" style="max-height:23px" />
		<?php } else { ?>
			<a class="navbar-brand mr-auto" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/">
		<?php }?>
		<span id="soplanning_title"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')((defined('CONFIG_SOPLANNING_TITLE') ? constant('CONFIG_SOPLANNING_TITLE') : null));?>
&nbsp;<span class="versionNumber">v<?php echo $_smarty_tpl->getValue('infoVersion');?>
</span></span>
		</a>

		<div id="divWarningSpace" style="width:15px">
			<div id="divWarningVersion" style="display:none">
				<a style="margin-left:5px" href="javascript:jQuery('#myModal .modal-header h5').html('<?php echo $_smarty_tpl->getConfigVariable('version_version_dispo');?>
');jQuery('#myModal .modal-body').html(jQuery('#divContenuVersion').html());jQuery('#myModal').modal();void(0);"  title="<?php echo $_smarty_tpl->getConfigVariable('warning_version');?>
" class="tooltipster">
					<i class="fa fa-warning fa-lg" aria-hidden="true" style="color:orange;font-size:1em"></i>
				</a>
			</div>
		</div>
		<div id="divContenuVersion" style="display:none;">
		</div>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-3 mr-auto">
			<li class="nav-item dropdown">
				<a class="nav-link" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/planning" id="menuPlanning" role="button" <?php if ($_SESSION['isMobileOrTablet'] == 1) {?>data-toggle="dropdown"<?php }?> >
					<i class="fa fa-calendar fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuPlanning');?>

				</a>
				<div class="dropdown-menu mt-0" aria-labelledby="menuPlanning">
				<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/planning" class="dropdown-item">
					<i class="fa fa-calendar fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuAfficherPlanning');?>

				</a>
				<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/taches" class="dropdown-item">
					<i class="fa fa-list fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuAfficherTaches');?>

				</a>
				<div class="dropdown-divider"></div>
				<?php if (!$_smarty_tpl->getSmarty()->getModifierCallback('in_array')("tasks_readonly",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
				<a href="javascript:Reloader.stopRefresh();xajax_ajoutPeriode();void(0);" class="dropdown-item">
					<i class="fa fa-calendar-plus-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuAjouterPeriode');?>

				</a>
				<?php }?>
			</div>
			</li>	
			<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("projects_manage_all",$_smarty_tpl->getValue('user')['tabDroits']) || $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("projects_manage_own",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
				<li class="nav-item dropdown">
					<a class="nav-link" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/projets" id="menuProjet" <?php if ($_SESSION['isMobileOrTablet'] == 1) {?>data-toggle="dropdown"<?php }?> role="button">
						<i class="fa fa-book fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuProjets');?>

					</a>
					<div class="dropdown-menu mt-0" aria-labelledby="menuProjet">
						<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/projets" class="dropdown-item">
							<i class="fa fa-book fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuListeProjets');?>

						</a>
						<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("projectgroups_manage_all",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
						<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/groupe_list" class="dropdown-item">
							<i class="fa fa-folder-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuListeGroupes');?>

						</a>
						<?php }?>
						<div class="dropdown-divider"></div>
						<a href="javascript:Reloader.stopRefresh();xajax_ajoutProjet();void(0);" class="dropdown-item">
							<i class="fa fa-bookmark fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuAjouterProjet');?>

						</a>
					</div>
				 </li>
			<?php }?>
			<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("users_manage_all",$_smarty_tpl->getValue('user')['tabDroits']) || $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("users_manage_team",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
				<li class="divider-vertical"></li>
				<li class="nav-item dropdown">
					<a class="nav-link" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/user_list" id="menuUser" <?php if ($_SESSION['isMobileOrTablet'] == 1) {?>data-toggle="dropdown"<?php }?> role="button">
						<i class="fa fa-users fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuUsers');?>

					</a>
					<div class="dropdown-menu mt-0" aria-labelledby="menuUser">
						<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/user_list" class="dropdown-item">
							<i class="fa fa-address-card-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuGestionUsers');?>

						</a>
						<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/user_groupes" class="dropdown-item">
							<i class="fa fa-users fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuGroupesUsers');?>

						</a>
						<div class="dropdown-divider"></div>
						<a href="javascript:xajax_modifUser();void(0);" class="dropdown-item">
							<i class="fa fa-user-plus fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuCreerUser');?>

						</a>
					</div>
				</li>
			<?php }?>
			<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("stats_users",$_smarty_tpl->getValue('user')['tabDroits']) || $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("stats_projects",$_smarty_tpl->getValue('user')['tabDroits']) || $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("audit_restore_own",$_smarty_tpl->getValue('user')['tabDroits']) || $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("stats_roi_projects",$_smarty_tpl->getValue('user')['tabDroits']) || $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("audit_restore",$_smarty_tpl->getValue('user')['tabDroits'])) {?>	
				<li class="divider-vertical"></li>
				<li class="nav-item dropdown">
					<a class="nav-link" href="#" id="menuStats" role="button" <?php if ($_SESSION['isMobileOrTablet'] == 1) {?>data-toggle="dropdown"<?php }?> aria-haspopup="true" data-target="#menuStatsToggle" aria-expanded="true">
						<i class="fa fa-bar-chart fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('droits_stats');?>

					</a>
					<div class="dropdown-menu mt-0" id="menuStatsToggle" aria-labelledby="menuStats">
						<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("stats_users",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/stats_users" class="dropdown-item">
								<i class="fa fa-bar-chart fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('droits_stats_users');?>

							</a>
						<?php }?>
						<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("stats_projects",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/stats_projects" class="dropdown-item">
								<i class="fa fa-bar-chart fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('droits_stats_projects');?>

							</a>
						<?php }?>
						<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("stats_roi_projects",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/stats_roi_projects" class="dropdown-item">
								<i class="fa fa-coins fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('droits_stats_roi_projects');?>

							</a>
						<?php }?>
						<?php if ((defined('CONFIG_SOPLANNING_OPTION_AUDIT') ? constant('CONFIG_SOPLANNING_OPTION_AUDIT') : null) == 1 && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("audit_restore",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
							<div class="dropdown-divider"></div>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/audit"  class="dropdown-item">
								<i class="fa fa-user-secret fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuAudit');?>

							</a>
						<?php }?>
					</div>
				</li>	
			<?php }?>
			<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("parameters_all",$_smarty_tpl->getValue('user')['tabDroits']) || $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("lieux_all",$_smarty_tpl->getValue('user')['tabDroits']) || $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("ressources_all",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
				<li class="divider-vertical"></li>
				<li class="nav-item dropdown">
					<a class="nav-link" href="<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("parameters_all",$_smarty_tpl->getValue('user')['tabDroits'])) {
echo $_smarty_tpl->getValue('BASE');?>
/options<?php } else { ?>#<?php }?>" data-target="#menuOptionsToggle" id="menuOptions" <?php if ($_SESSION['isMobileOrTablet'] == 1) {?>data-toggle="dropdown"<?php }?> role="button">
						<i class="fa fa-cogs fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuOptions');?>

					</a>
					<div class="dropdown-menu mt-0" id="menuOptionsToggle" aria-labelledby="menuOptions">
						<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("parameters_all",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/options" class="dropdown-item">
								<i class="fa fa-cogs fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuOptions');?>

							</a>
							<div class="dropdown-divider"></div>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/feries" class="dropdown-item">
								<i class="fa fa-plane fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuFeries');?>

							</a>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/status" class="dropdown-item">
								<i class="fa fa-tags fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuStatus');?>

							</a>
						<?php }?>
						<?php if ((defined('CONFIG_SOPLANNING_OPTION_LIEUX') ? constant('CONFIG_SOPLANNING_OPTION_LIEUX') : null) == 1 && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("lieux_all",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/lieux" class="dropdown-item">
								<i class="fa fa-map-marker fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuLieux');?>

							</a>			
						<?php }?>
						<?php if ((defined('CONFIG_SOPLANNING_OPTION_RESSOURCES') ? constant('CONFIG_SOPLANNING_OPTION_RESSOURCES') : null) == 1 && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')("ressources_all",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/ressources" class="dropdown-item">
								<i class="fa fa-plug fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuRessources');?>

							</a>				
						<?php }?>
						<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')("parameters_all",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
							<div class="dropdown-divider"></div>
							<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/backup" class="dropdown-item">
								<i class="fa fa-exchange fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('menuImportExport');?>

							</a>
						<?php }?>
					</div>
				 </li>	
			<?php }?>
			<li class="nav-item">
				<a class="nav-link tooltipster" title="<?php echo $_smarty_tpl->getConfigVariable('menu_aide');?>
" href="<?php echo $_smarty_tpl->getValue('lienAide');?>
" data-target="#"><i class="fa fa-question-circle fa-lg fa-fw" aria-hidden="true"></i></a>
			</li>
		</ul> 
		<ul class="navbar-nav ml-auto">
			<?php if ((true && ($_smarty_tpl->hasVariable('dateAbo') && null !== ($_smarty_tpl->getValue('dateAbo') ?? null))) && $_SESSION['isMobileOrTablet'] == 0) {?>
				<li class="nav-item" style="margin-right:50px;">
					<a class="nav-link navbar-right tooltipster" target="_blank" href="<?php echo $_smarty_tpl->getConfigVariable('texte_abo_lien');?>
" title="<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('str_replace')("%1%",$_smarty_tpl->getValue('dateAbo'),$_smarty_tpl->getConfigVariable('texte_abo2'));?>
">
						<i class="fa fa-warning fa-lg fa-fw" aria-hidden="true" style="color:orange"></i>&nbsp;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('str_replace')("%1%",$_smarty_tpl->getValue('dateAbo'),$_smarty_tpl->getConfigVariable('texte_abo'));?>

					</a>
				</li>
			<?php }?>
			<?php if ((defined('CONFIG_SOPLANNING_URL') ? constant('CONFIG_SOPLANNING_URL') : null) != '') {?>
				<li class="nav-item" style="margin-right:10px;">
					<a class="nav-link navbar-right tooltipster" href="javascript:xajax_qrcode();void(0);" title="<?php echo $_smarty_tpl->getConfigVariable('acces_mobile');?>
">
						<i class="fa fa-qrcode fa-lg fa-fw" aria-hidden="true"></i>
					</a>
				</li>
			<?php }?>
			<?php if ($_smarty_tpl->getValue('user')['user_id'] == 'publicspl') {?>
				<li class="nav-item">
					<a class="nav-link" href="#" data-target="#" style="color:white">
						<i class="fa fa-user-o fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('accesPublicUsername');?>

					</a>
				</li>
			<?php } else { ?>
				<li class="nav-item">
					<a class="nav-link navbar-right tooltipster" href="javascript:xajax_modifProfil();void(0);" title="<?php echo $_smarty_tpl->getConfigVariable('menu_modifier_profil');?>
" data-target="#">
						<i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getValue('user')['nom'];?>
 (<?php echo $_smarty_tpl->getValue('user')['user_id'];?>
)
					</a>
				</li>
			<?php }?>
			<li class="nav-item">
				<a href="<?php echo $_smarty_tpl->getValue('BASE');?>
/process/login?action=logout&language=<?php echo $_smarty_tpl->getValue('lang');?>
" class="nav-link tooltipster navbar-right" title="<?php echo $_smarty_tpl->getConfigVariable('menu_deconnecter');?>
">
					<i class="fa fa-lg fa-sign-out" aria-hidden="true" style="color:red"></i>
				</a>
			</li>
		</ul>
		</div>
	</nav>
<?php }
if ((true && (true && null !== ($_SESSION['message'] ?? null)))) {?>
	<?php $_smarty_tpl->assign('messageFinal', $_smarty_tpl->getSmarty()->getModifierCallback('formatMessage')($_SESSION['message']), false, NULL);?>
	<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('delete_session_value')("message");?>


	<div id="divMessageInfoGlobal" class="container-fluid" style="<?php if ((true && ($_smarty_tpl->hasVariable('htmlTableau') && null !== ($_smarty_tpl->getValue('htmlTableau') ?? null)))) {?>cursor:pointer;position:fixed;top:10px;z-index:1000<?php } else { ?>margin-bottom:60px;<?php }?>" onClick="this.style.display='none'">
		<div id="divMessage" class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="fa fa-lg fa-info-circle" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getValue('messageFinal');?>

		</div>
	</div>
	<?php echo '<script'; ?>
 language="javascript">$('#divMessageInfoGlobal').delay(5000).fadeOut('slow');<?php echo '</script'; ?>
>
<?php }
if ((true && (true && null !== ($_SESSION['erreur'] ?? null)))) {?>
	<?php $_smarty_tpl->assign('messageFinal', $_smarty_tpl->getSmarty()->getModifierCallback('formatMessage')($_SESSION['erreur']), false, NULL);?>
	<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('delete_session_value')("erreur");?>


	<div id="divMessageErreurGlobal" class="container-fluid" style="<?php if ((true && ($_smarty_tpl->hasVariable('htmlTableau') && null !== ($_smarty_tpl->getValue('htmlTableau') ?? null)))) {?>cursor:pointer;position:fixed;top:10px;z-index:1000<?php } else { ?>margin-bottom:60px;<?php }?>" onClick="this.style.display='none'">
		<div id="divMessage" class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="fa fa-lg fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getValue('messageFinal');?>

		</div>
	</div>
	<?php echo '<script'; ?>
 language="javascript">$('#divMessageErreurGlobal').delay(5000).fadeOut('slow');<?php echo '</script'; ?>
>
<?php }?>

<?php }
}
