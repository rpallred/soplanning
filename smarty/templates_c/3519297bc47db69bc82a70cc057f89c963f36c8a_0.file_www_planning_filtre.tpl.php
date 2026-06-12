<?php
/* Smarty version 5.5.1, created on 2026-06-12 04:05:08
  from 'file:www_planning_filtre.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6a2b6954837c42_73893450',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3519297bc47db69bc82a70cc057f89c963f36c8a' => 
    array (
      0 => 'www_planning_filtre.tpl',
      1 => 1772195582,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a2b6954837c42_73893450 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home1/doctora1/public_html/SOPlanning/templates';
?><div class="vw-100 position-fixed" id="firstLayer">
	<div class="soplanning-box form-inline pt-0" id="divPlanningDateSelector">
		<div class="btn-group cursor-pointer pt-2" id="btnDateNow">
			<a class="btn btn-default tooltipster" title="<?php echo $_smarty_tpl->getConfigVariable('aujourdhui');
echo $_smarty_tpl->getValue('dateToday');?>
" onClick="document.location='process/planning?raccourci_date=aujourdhui'" id="buttonDateNowSelector"><i class="fa fa-home fa-lg fa-fw" aria-hidden="true"></i></a>
		</div>

				<div class="btn-group ml-md-2 pt-2" id="dropdownDateSelector">
			<form action="process/planning" method="GET" class="form-inline" id="formChoixDates">
				<a href="#" id="buttonDateSelector" class="btn dropdown-toggle btn-default" data-toggle="dropdown">
					<b>
					<span class="d-none d-sm-inline-block"><?php echo $_smarty_tpl->getValue('dateDebutTexte1');?>
&nbsp;</span><?php echo $_smarty_tpl->getValue('dateDebutTexte2');?>

					<?php if ($_smarty_tpl->getValue('baseLigne') != "heures") {?>
						- <span class="d-none d-sm-inline-block"><?php echo $_smarty_tpl->getValue('dateFinTexte1');?>
&nbsp;</span><?php echo $_smarty_tpl->getValue('dateFinTexte2');?>

					<?php }?>
					</b>&nbsp;&nbsp;&nbsp;<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" id="planningDateSelectorDropdown">
					<li>
						<div style="display:flex; flex-wrap: wrap; width:100%;">
							<div style="display:flex; flex-wrap: wrap; width:200px;">
								<div style="display:flex; width:90px; justify-content: flex-end">
									<?php echo $_smarty_tpl->getConfigVariable('formDebut');?>
 : &nbsp;&nbsp;
								</div>
								<div style="display:flex; flex-wrap: wrap; width:110px">
									<?php if ($_SESSION['isMobileOrTablet'] == 1) {?>
										<input name="date_debut_affiche" id="date_debut_affiche" type="date" value="<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('forceISODateFormat')($_smarty_tpl->getValue('dateDebut'));?>
" class="form-control" onChange="$('date_debut_custom').value= '----------------';" />
									<?php } else { ?>
										<input name="date_debut_affiche" id="date_debut_affiche" type="text" value="<?php echo $_smarty_tpl->getValue('dateDebut');?>
" class="form-control datepicker" onChange="$('date_debut_custom').value= '----------------';" />
									<?php }?>
									<select id="date_debut_custom" class="form-control" name="date_debut_custom" onChange="$('date_debut_affiche').value= '----------------';" style="margin-bottom:5px">
										<option value=""><?php echo $_smarty_tpl->getConfigVariable('raccourci');?>
...</option>
										<option value="aujourdhui"><?php echo $_smarty_tpl->getConfigVariable('raccourci_aujourdhui');?>
</option>
										<option value="semaine_derniere"><?php echo $_smarty_tpl->getConfigVariable('raccourci_semaine_derniere');?>
</option>
										<option value="mois_dernier"><?php echo $_smarty_tpl->getConfigVariable('raccourci_mois_dernier');?>
</option>
										<option value="debut_semaine"><?php echo $_smarty_tpl->getConfigVariable('raccourci_debut_semaine');?>
</option>
										<option value="debut_mois"><?php echo $_smarty_tpl->getConfigVariable('raccourci_debut_mois');?>
</option>
									</select>
								</div>
							</div>
							<?php if ($_smarty_tpl->getValue('baseLigne') != "heures") {?>
								<div style="display:flex; flex-wrap: wrap; width:230px;">
									<div style="display:flex; width:90px; justify-content: flex-end">
										&nbsp;<?php echo $_smarty_tpl->getConfigVariable('formFin');?>
 :&nbsp;
									</div>
									<div style="display:flex; flex-wrap: wrap; width:110px">
										<?php if ($_SESSION['isMobileOrTablet'] == 1) {?>
											<input name="date_fin_affiche" id="date_fin_affiche" type="date" value="<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('forceISODateFormat')($_smarty_tpl->getValue('dateFin'));?>
" class="form-control"  onChange="$('date_fin_custom').value= '----------------';" />
										<?php } else { ?>
											<input name="date_fin_affiche" id="date_fin_affiche" type="text" value="<?php echo $_smarty_tpl->getValue('dateFin');?>
" class="form-control datepicker"   onChange="$('date_fin_custom').value= '----------------';" />
										<?php }?>

										<select id="date_fin_custom" name="date_fin_custom" class="form-control" onChange="$('date_fin_affiche').value= '----------------';" style="margin-bottom:5px">
											<option value=""><?php echo $_smarty_tpl->getConfigVariable('raccourci');?>
...</option>
											<option value="1_semaine"><?php echo $_smarty_tpl->getConfigVariable('raccourci_1_semaine');?>
</option>
											<option value="2_semaines"><?php echo $_smarty_tpl->getConfigVariable('raccourci_2_semaines');?>
</option>
											<option value="3_semaines"><?php echo $_smarty_tpl->getConfigVariable('raccourci_3_semaines');?>
</option>
											<option value="1_mois"><?php echo $_smarty_tpl->getConfigVariable('raccourci_1_mois');?>
</option>
											<option value="2_mois"><?php echo $_smarty_tpl->getConfigVariable('raccourci_2_mois');?>
</option>
											<option value="3_mois"><?php echo $_smarty_tpl->getConfigVariable('raccourci_3_mois');?>
</option>
											<option value="4_mois"><?php echo $_smarty_tpl->getConfigVariable('raccourci_4_mois');?>
</option>
											<option value="5_mois"><?php echo $_smarty_tpl->getConfigVariable('raccourci_5_mois');?>
</option>
											<option value="6_mois"><?php echo $_smarty_tpl->getConfigVariable('raccourci_6_mois');?>
</option>
										</select>
									</div>
								</div>
							<?php }?>
							<div style="display:flex; flex-wrap: wrap; ">
								<button id="dateFilterButton" class="btn btn-sm btn-default" onClick="$('formChoixDates').submit();"><i class="fa fa-search fa-lg fa-fw" aria-hidden="true"></i></button>
							</div>

						</div>
					</li>
				</ul>
			</form>
		</div>

		<div class="btn-group ml-md-2 pt-2 cursor-pointer" id="btnDateSelector">
			<a class="btn btn-default" onClick="document.location='process/planning?raccourci_date=-<?php echo $_smarty_tpl->getValue('nbJours');?>
';" id="buttonDatePrevSelector"><i class="fa fa-angles-left fa-lg fa-fw" aria-hidden="true"></i><span class="d-none d-xl-inline-block"><?php echo $_smarty_tpl->getValue('dateBoutonInferieur');?>
</span></a>
			<a class="btn btn-default" onClick="document.location='process/planning?raccourci_date=+<?php echo $_smarty_tpl->getValue('nbJours');?>
';" id="buttonDateNextSelector"><span class="d-none d-xl-inline-block"><?php echo $_smarty_tpl->getValue('dateBoutonSuperieur');?>
</span> <i class="fa fa-angles-right fa-lg fa-fw" aria-hidden="true"></i></a>
		</div>
		<?php if (!$_smarty_tpl->getSmarty()->getModifierCallback('in_array')("tasks_readonly",$_smarty_tpl->getValue('user')['tabDroits'])) {?>
			<div class="btn-group ml-md-4 pt-2" id="btnAddTask">
				<a class="btn btn-info" href="javascript:Reloader.stopRefresh();xajax_ajoutPeriode();void(0);">
					<i class="fa fa-calendar-plus-o fa-lg fa-fw" aria-hidden="true"></i>
					<span class="d-none d-xl-inline-block" ><?php echo $_smarty_tpl->getConfigVariable('menuAjouterPeriode');?>
</span>
				</a>
			</div>
		<?php }?>
	</div>
</div>
<div class="vw-100 position-fixed" id="secondLayer">
	<div class="soplanning-box form-inline pt-0" id="divPlanningMainFilter">

				<div class="btn-group pt-2" id="dropdownTaskUserFilter">
			<form action="process/planning" method="POST">
			<input type="hidden" name="filtreUser" value="1" />
			<select name="filtreUser" multiple="multiple" id="filtreUser" class="d-none multiselect">
				<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeUsers')) == 0) {?>
					<option>&nbsp;<?php echo $_smarty_tpl->getConfigVariable('formFiltreUserAucunProjet');?>
</option>
				<?php } else { ?>
					<optgroup id="gu0" label="<?php echo $_smarty_tpl->getConfigVariable('cocheUserSansGroupe');?>
">
					<?php $_smarty_tpl->assign('groupeTemp', '', false, NULL);?>
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('listeUsers'), 'userCourant', false, NULL, 'loopUsers', array (
));
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('userCourant')->value) {
$foreach0DoElse = false;
?>
						<?php if ($_smarty_tpl->getValue('userCourant')['user_groupe_id'] != $_smarty_tpl->getValue('groupeTemp')) {?>
							</optgroup><optgroup id="gu<?php echo $_smarty_tpl->getValue('userCourant')['user_groupe_id'];?>
" label="<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('userCourant')['groupe_nom']);?>
">
						<?php }?>
					<option value="<?php echo $_smarty_tpl->getValue('userCourant')['user_id'];?>
" <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('userCourant')['user_id'],$_smarty_tpl->getValue('filtreUser'))) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('userCourant')['nom']);?>
 (<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('userCourant')['user_id']);?>
)</option>
					<?php $_smarty_tpl->assign('groupeTemp', $_smarty_tpl->getValue('userCourant')['user_groupe_id'], false, NULL);?>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				<?php }?>
				</optgroup></select>
			</form>
		</div>
				<div class="btn-group pt-2" id="dropdownTaskProjectFilter">
			<form action="process/planning" method="POST">
			<input type="hidden" name="filtreGroupeProjet" value="1" />
			<select name="filtreGroupeProjet" multiple="multiple" id="filtreGroupeProjet" class="d-none multiselect">
				<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeProjets')) == 0) {?>
					<option>&nbsp;<?php echo $_smarty_tpl->getConfigVariable('formFiltreProjetAucunProjet');?>
</option>
				<?php } else { ?>
					<optgroup id="g0" label="<?php echo $_smarty_tpl->getConfigVariable('projet_liste_sansGroupes');?>
">
					<?php $_smarty_tpl->assign('groupeTemp', '', false, NULL);?>
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('listeProjets'), 'projetCourant', false, NULL, 'loopProjets', array (
));
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('projetCourant')->value) {
$foreach1DoElse = false;
?>
						<?php if ($_smarty_tpl->getValue('projetCourant')['groupe_id'] != $_smarty_tpl->getValue('groupeTemp')) {?>
							</optgroup><optgroup id="g<?php echo $_smarty_tpl->getValue('projetCourant')['groupe_id'];?>
" label="<?php echo $_smarty_tpl->getValue('projetCourant')['groupe_nom'];?>
">
						<?php }?>
					<option value="<?php echo $_smarty_tpl->getValue('projetCourant')['projet_id'];?>
" <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('projetCourant')['projet_id'],$_smarty_tpl->getValue('filtreGroupeProjet'))) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('projetCourant')['nom']);?>
 (<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('projetCourant')['projet_id']);?>
)</option>
					<?php $_smarty_tpl->assign('groupeTemp', $_smarty_tpl->getValue('projetCourant')['groupe_id'], false, NULL);?>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				<?php }?>
				</optgroup></select>
			</form>
		</div>
				<div class="btn-group pt-2" id="dropdownAdvancedFilter">
			<form action="process/planning" method="POST">
			<button class="btn <?php if (($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('filtreGroupeLieu')) > 0) || ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('filtreGroupeRessource')) > 0)) {?>btn-danger<?php } else { ?>btn-default<?php }?> dropdown-toggle" data-toggle="dropdown" onclick="javascript:multiselecthide();" data-display="static"><i class="fa fa-flask fa-lg fa-fw" aria-hidden="true"></i><span class="d-none d-xl-inline-block">&nbsp;<?php echo $_smarty_tpl->getConfigVariable('filtres_avances');?>
&nbsp;</span><span class="caret"></span></button>
			<ul class="dropdown-menu filtrePlanning" style="width:800px;overflow-x:scroll">
				<li>
					<input type="submit" value="<?php echo $_smarty_tpl->getConfigVariable('submit');?>
" class="btn btn-default ml-2" />
					<?php if (($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('filtreGroupeLieu')) > 0) || ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('filtreGroupeRessource')) > 0)) {?><a href="process/planning?desactiverFiltreAvances=1" class="btn btn-danger btn-sm margin-left-10"><?php echo $_smarty_tpl->getConfigVariable('formFiltreAvancesDesactiver');?>
</a><?php }?>
				</li>
				<li class="divider"></li>
				<li>
					<table onClick="event.cancelBubble=true;" class="planning-filter">
						<tr>
							<td class="planningDropdownFilter">
								<input type="hidden" name="filtreStatutTache" value="1">
								<b><?php echo $_smarty_tpl->getConfigVariable('formChoixStatutTache');?>
</b><br />
								<div class="form-horizontal col-md-12">
								<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('listeStatusTaches'), 'statust');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('statust')->value) {
$foreach2DoElse = false;
?>
								<label class="checkbox">
									<input type="checkbox" id="<?php echo $_smarty_tpl->getValue('statust')['status_id'];?>
" name="statutsTache[]" value="<?php echo $_smarty_tpl->getValue('statust')['status_id'];?>
" <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('statust')['status_id'],$_smarty_tpl->getValue('filtreStatutTache')) || $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('filtreStatutTache')) == 0) {?>checked="checked"<?php }?> />&nbsp;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('statust')['nom']);?>

								</label>
								<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
								</div>
							</td>
							<td class="planningDropdownFilter">
								<input type="hidden" name="filtreStatutProjet" value="1">
								<b><?php echo $_smarty_tpl->getConfigVariable('formChoixStatutProjet');?>
</b><br />
								<div class="form-horizontal col-md-12">
								<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('listeStatusProjets'), 'statusp');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('statusp')->value) {
$foreach3DoElse = false;
?>
								<label class="checkbox">
									<input type="checkbox" id="statut_projet_<?php echo $_smarty_tpl->getValue('statusp')['status_id'];?>
" name="statutsProjet[]" value="<?php echo $_smarty_tpl->getValue('statusp')['status_id'];?>
" <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('statusp')['status_id'],$_smarty_tpl->getValue('filtreStatutProjet')) || $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('filtreStatutProjet')) == 0) {?>checked="checked"<?php }?> />&nbsp;<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('statusp')['nom']);?>

								</label>
								<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
								</div>
							</td>

														<?php if ((defined('CONFIG_SOPLANNING_OPTION_LIEUX') ? constant('CONFIG_SOPLANNING_OPTION_LIEUX') : null) == 1 && ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeLieux'))) > 0) {?>
								<td class="planningDropdownFilter">
								<input type="hidden" name="filtreGroupeLieu" value="1">
								<input type="hidden" name="maxGroupeLieu" value="<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeLieux'));?>
">
									<b><?php echo $_smarty_tpl->getConfigVariable('menuLieux');?>
</b>
									<div class="form-horizontal col-md-12">
									<?php $_smarty_tpl->assign('groupeTemp', '', false, NULL);?>
									<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('math')->handle(array('assign'=>'nbColonnes','equation'=>"ceil(nbLieux / nbLieuxParColonnes)",'nbLieux'=>$_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeLieux')),'nbLieuxParColonnes'=>(defined('FILTER_NB_AERA_PER_COLUMN') ? constant('FILTER_NB_AERA_PER_COLUMN') : null)), $_smarty_tpl);?>

									<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('math')->handle(array('assign'=>'maxCol','equation'=>"ceil(nbLieux / nbColonnes)",'nbLieux'=>$_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeLieux')),'nbColonnes'=>$_smarty_tpl->getValue('nbColonnes')), $_smarty_tpl);?>

									<?php $_smarty_tpl->assign('tmpNbDansColCourante', "0", false, NULL);?>
									<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('listeLieux'), 'lieuCourant', false, NULL, 'loopLieux', array (
));
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('lieuCourant')->value) {
$foreach4DoElse = false;
?>
										<?php if ($_smarty_tpl->getValue('tmpNbDansColCourante') > $_smarty_tpl->getValue('maxCol')) {?>
											<?php $_smarty_tpl->assign('tmpNbDansColCourante', "0", false, NULL);?>
											</td>
										<td class="planningDropdownFilter">
										<?php }?>
										<label class="checkbox">
											<input type="checkbox" id="lieu_<?php echo $_smarty_tpl->getValue('lieuCourant')['lieu_id'];?>
" name="lieu[]" value="<?php echo $_smarty_tpl->getValue('lieuCourant')['lieu_id'];?>
" <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('lieuCourant')['lieu_id'],$_smarty_tpl->getValue('filtreGroupeLieu'))) {?>checked="checked"<?php }?> /> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('lieuCourant')['nom']);?>

										</label>
										<?php $_smarty_tpl->assign('tmpNbDansColCourante', $_smarty_tpl->getValue('tmpNbDansColCourante')+1, false, NULL);?>
									<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
									</div>
								</td>
							<?php }?>

														<?php if ((defined('CONFIG_SOPLANNING_OPTION_RESSOURCES') ? constant('CONFIG_SOPLANNING_OPTION_RESSOURCES') : null) == 1 && ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeRessources'))) > 0) {?>
								<td class="planningDropdownFilter">
								<input type="hidden" name="maxGroupeRessource" value="<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeRessources'));?>
">
								<input type="hidden" name="filtreGroupeRessource" value="1">
									<b><?php echo $_smarty_tpl->getConfigVariable('menuRessources');?>
</b>
									<div class="form-horizontal col-md-12">
									<?php $_smarty_tpl->assign('groupeTemp', '', false, NULL);?>
									<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('math')->handle(array('assign'=>'nbColonnes','equation'=>"ceil(nbRessources / nbRessourcesParColonnes)",'nbRessources'=>$_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeRessources')),'nbRessourcesParColonnes'=>(defined('FILTER_NB_RESSOURCES_PER_COLUMN') ? constant('FILTER_NB_RESSOURCES_PER_COLUMN') : null)), $_smarty_tpl);?>

									<?php echo $_smarty_tpl->getSmarty()->getFunctionHandler('math')->handle(array('assign'=>'maxCol','equation'=>"ceil(nbRessources / nbColonnes)",'nbRessources'=>$_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('listeRessources')),'nbColonnes'=>$_smarty_tpl->getValue('nbColonnes')), $_smarty_tpl);?>

									<?php $_smarty_tpl->assign('tmpNbDansColCourante', "0", false, NULL);?>
									<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('listeRessources'), 'ressourceCourant', false, NULL, 'loopRessources', array (
));
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('ressourceCourant')->value) {
$foreach5DoElse = false;
?>
										<?php if ($_smarty_tpl->getValue('tmpNbDansColCourante') > $_smarty_tpl->getValue('maxCol')) {?>
											<?php $_smarty_tpl->assign('tmpNbDansColCourante', "0", false, NULL);?>
											</td>
											<td class="planningDropdownFilter">
										<?php }?>
										<label class="checkbox">
											<input type="checkbox" id="ressource_<?php echo $_smarty_tpl->getValue('ressourceCourant')['ressource_id'];?>
" value="<?php echo $_smarty_tpl->getValue('ressourceCourant')['ressource_id'];?>
" name="ressource[]" <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('ressourceCourant')['ressource_id'],$_smarty_tpl->getValue('filtreGroupeRessource'))) {?>checked="checked"<?php }?> /> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('ressourceCourant')['nom']);?>

										</label>
										<?php $_smarty_tpl->assign('tmpNbDansColCourante', $_smarty_tpl->getValue('tmpNbDansColCourante')+1, false, NULL);?>
									<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
									</div>
								</td>
							<?php }?>
						</tr>
					</table>
				</li>
			</ul>
			</form>
		</div>
				<div class="btn-group pt-2" id="dropdownTri">
			<button class="btn dropdown-toggle btn-default" data-toggle="dropdown" onclick="javascript:multiselecthide();"><i class="fa fa-sort-amount-desc fa-lg fa-fw" aria-hidden="true"></i><span class="d-none d-xl-inline-block">&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('formTrierPar');?>
</span>&nbsp;<span class="caret"></span></button>
			<div class="dropdown-menu">
				<?php if ($_smarty_tpl->getValue('baseLigne') == "projets") {?>
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('triPlanningPossibleProjet'), 'triTemp');
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('triTemp')->value) {
$foreach6DoElse = false;
?>
						<?php $_smarty_tpl->assign('chaineTmp', $_smarty_tpl->getSmarty()->getModifierCallback('replace')($_smarty_tpl->getSmarty()->getModifierCallback('replace')(("triProjet_").($_smarty_tpl->getValue('triTemp')),' ','_'),',','_'), false, NULL);?>
						<a class="dropdown-item" href="process/planning?triPlanning=<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('urlencode')($_smarty_tpl->getValue('triTemp'));?>
"><?php if ($_smarty_tpl->getValue('triTemp') == $_smarty_tpl->getValue('triPlanning')) {?><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;<?php } else { ?><i style="margin-left:19px;">&nbsp;</i><?php }
echo $_smarty_tpl->getConfigVariable($_smarty_tpl->getValue('chaineTmp'));?>
</a>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				<?php } elseif ($_smarty_tpl->getValue('baseLigne') == "users") {?>
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('triPlanningPossibleUser'), 'triTemp');
$foreach7DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('triTemp')->value) {
$foreach7DoElse = false;
?>
						<?php $_smarty_tpl->assign('chaineTmp', $_smarty_tpl->getSmarty()->getModifierCallback('replace')($_smarty_tpl->getSmarty()->getModifierCallback('replace')(("triUser_").($_smarty_tpl->getValue('triTemp')),' ','_'),',','_'), false, NULL);?>
						<a class="dropdown-item" href="process/planning?triPlanning=<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('urlencode')($_smarty_tpl->getValue('triTemp'));?>
"><?php if ($_smarty_tpl->getValue('triTemp') == $_smarty_tpl->getValue('triPlanning')) {?><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;<?php } else { ?><i style="margin-left:19px;">&nbsp;</i><?php }
echo $_smarty_tpl->getConfigVariable($_smarty_tpl->getValue('chaineTmp'));?>
</a>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				<?php } elseif ($_smarty_tpl->getValue('baseLigne') == "lieux" || $_smarty_tpl->getValue('baseLigne') == "ressources" || $_smarty_tpl->getValue('baseLigne') == "heures") {?>
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('triPlanningPossibleAutre'), 'triTemp');
$foreach8DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('triTemp')->value) {
$foreach8DoElse = false;
?>
						<?php $_smarty_tpl->assign('chaineTmp', $_smarty_tpl->getSmarty()->getModifierCallback('replace')($_smarty_tpl->getSmarty()->getModifierCallback('replace')(("triAutre_").($_smarty_tpl->getValue('triTemp')),' ','_'),',','_'), false, NULL);?>
						<a class="dropdown-item" href="process/planning?triPlanning=<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('urlencode')($_smarty_tpl->getValue('triTemp'));?>
"><?php if ($_smarty_tpl->getValue('triTemp') == $_smarty_tpl->getValue('triPlanning')) {?><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;<?php } else { ?><i style="margin-left:19px;">&nbsp;</i><?php }
echo $_smarty_tpl->getConfigVariable($_smarty_tpl->getValue('chaineTmp'));?>
</a>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				<?php }?>
			</div>
		</div>

				<div class="btn-group pt-2" id="btnMoreActionsToggle">
			<a class="btn btn-default" href="javascript:void(0);" onclick="toggleMoreActions(true);" title="<?php echo $_smarty_tpl->getConfigVariable('hide_show_table');?>
">
				<i class="fa fa-chevron-down fa-lg fa-fw" aria-hidden="true"></i>
			</a>
		</div>
		<div id="moreActions">
						<div class="btn-group pt-2" id="dropdownExport">
				<button class="btn dropdown-toggle btn-default" data-toggle="dropdown" onclick="javascript:multiselecthide();"><i class="fa fa-cloud-download fa-lg fa-fw" aria-hidden="true"></i><span class="d-none d-xl-inline-block">&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('choix_export');?>
</span>&nbsp;<span class="caret"></span></button>
				<div class="dropdown-menu" style="">
					<a class="dropdown-item" href="javascript:window.print();"><i class="fa fa-fw fa-print" aria-hidden="true"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('printAll'));?>
</a>
					<a class="dropdown-item" href="export_csv"><i class="fa fa-fw fa-file-text-o" aria-hidden="true"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('CSVExport'));?>
</a>
					<a class="dropdown-item" href="export_csv_raw"><i class="fa fa-fw fa-file-text-o" aria-hidden="true"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('CSVExportRaw'));?>
</a>
					<a class="dropdown-item" href="javascript:xajax_choixPDF();void(0);"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('PDFExport'));?>
</a>
					<a class="dropdown-item" href="export_xls" target="_blank"><i class="fa fa-fw fa-file-excel-o" aria-hidden="true"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('xlsExport'));?>
</a>
					<a class="dropdown-item" href="export_gantt" target="_blank"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('ganttExport'));?>
</a>
					<a class="dropdown-item" href="export_pdf_calendrier" target="_blank"><i class="fa fa-fw fa-calendar-o" aria-hidden="true"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('calendarExport'));?>
</a>
					<a class="dropdown-item" href="javascript:xajax_choixIcal();void(0);"><i class="fa fa-fw fa-envelope-o" aria-hidden="true"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('icalExport'));?>
</a>
				</div>
			</div>

						<div class="btn-group pt-2" id="dropdownLarge">
				<?php if ($_smarty_tpl->getValue('dimensionCase') == "reduit") {?>
					<a class="btn btn-default" title="<?php echo $_smarty_tpl->getConfigVariable('menuPlanningLarge');?>
" href="process/planning?dimensionCase=large"><i class="fa fa-search-plus fa-lg fa-fw" aria-hidden="true"></i></a>
				<?php } else { ?>
					<a class="btn btn-default" title="<?php echo $_smarty_tpl->getConfigVariable('menuPlanningReduit');?>
" href="process/planning?dimensionCase=reduit"><i class="fa fa-search-minus fa-lg fa-fw" aria-hidden="true"></i></a>
				<?php }?>
				<button class="btn dropdown-toggle btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-sort fa-lg fa-fw" aria-hidden="true"></i></button>
				<div class="dropdown-menu">						
					<?php if ($_smarty_tpl->getValue('fleches') == '1') {?>
						<a class="dropdown-item" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/process/planning?fleches=0">
						<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
					<?php } else { ?>
						<a class="dropdown-item" href="<?php echo $_smarty_tpl->getValue('BASE');?>
/process/planning?fleches=1"><i style="margin-left:19px;">&nbsp;</i>
					<?php }?>
					<?php echo $_smarty_tpl->getConfigVariable('scrolls_fleches');?>
</a>
				</div>
			</div>

						<div class="btn-group pt-2" id="dropdownFiltresPerso">
				<button class="btn dropdown-toggle btn-default" data-toggle="dropdown" onclick="javascript:multiselecthide();"><i class="fa fa-filter fa-lg fa-fw" aria-hidden="true"></i><span class="d-none d-xl-inline-block">&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('formFiltresPerso');?>
</span>&nbsp;<span class="caret"></span></button>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="javascript:xajax_filtre_perso_form('');void(0);"><i class="fa fa-plus fa-lg fa-fw" aria-hidden="true"></i> <?php echo $_smarty_tpl->getConfigVariable('creer_filtre_perso');?>
</a>
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('filtres_perso'), 'filtre');
$foreach9DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('filtre')->value) {
$foreach9DoElse = false;
?>
						<a class="dropdown-item" href="javascript:xajax_filtre_perso_form('<?php echo $_smarty_tpl->getValue('filtre')['filtre_perso_id'];?>
');void(0);"><i class="fa fa-caret-right fa-lg fa-fw" aria-hidden="true"></i> <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('filtre')['filtre_perso_nom']);?>
</a>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				</div>
			</div>

						<div class="btn-group pt-2 d-xl-inline-block" id="searchboxPlanning">
				<form action="process/planning" method="POST">
					<div class="input-group" style="width:200px">
						<input type="text" class="tooltipster form-control input-sm" name="filtreTexte" value="<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getValue('filtreTexte'));?>
" maxlength="50" title="<?php echo htmlspecialchars((string)$_smarty_tpl->getConfigVariable('formFiltreTexte'), ENT_QUOTES, 'UTF-8', true);?>
" id="filtreTexte" />
						<div class="input-group-append">
							<button type="submit" class="btn btn-sm <?php if ($_smarty_tpl->getValue('filtreTexte') != '') {?>btn-danger<?php } else { ?>btn-default<?php }?>">
							<i class="fa fa-search fa-lg fa-fw" aria-hidden="true"></i></button>
							<?php if ($_smarty_tpl->getValue('filtreTexte') != '') {?>
								<div class="btn-group">
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">&nbsp;<span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a href="process/planning?desactiverFiltreTexte=1"><?php echo $_smarty_tpl->getConfigVariable('formFiltreUserDesactiver');?>
</a></li>
									</ul>
								</div>
							<?php }?>
						</div>
						<div id="btnLessActionsToggle">
							<a class="btn btn-default" href="javascript:void(0);" onclick="toggleMoreActions(false);" title="<?php echo $_smarty_tpl->getConfigVariable('hide_show_table');?>
">
								<i class="fa fa-chevron-up fa-lg fa-fw" aria-hidden="true"></i>
							</a>
						</div>
					</div>

				</form>
			</div>

		</div>
	</div>
</div>

<div class="d-nonez" id="dropdownDisplayPlanning">
	<button class="dropdown-toggle boutonAffichagePlanning" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" ><i class="fa fa-calendar fa-lg fa-fw" aria-hidden="true"></i><span class="d-none d-md-inline-block">&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('planning_affichage');?>
</span>&nbsp;<span class="caret"></span></button>
	<div class="dropdown-menu">
		<?php if ($_SESSION['baseLigne'] == 'users') {?>
			<a class="dropdown-item" href="process/planning?baseLigne=users">
			<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
		<?php } else { ?>
			<a class="dropdown-item" href="process/planning?baseLigne=users">
			<i style="margin-left:19px;">&nbsp;</i>
		<?php }?>
		<?php echo $_smarty_tpl->getConfigVariable('planningPersonne');?>
</a>
		
		<?php if ($_SESSION['baseLigne'] == 'projets') {?>
			<a class="dropdown-item" href="process/planning?baseLigne=projets">
			<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
		<?php } else { ?>
			<a class="dropdown-item" href="process/planning?baseLigne=projets">
			<i style="margin-left:19px;">&nbsp;</i>
		<?php }?>
		<?php echo $_smarty_tpl->getConfigVariable('planningProjet');?>
</a>
		
		<?php if ((defined('CONFIG_SOPLANNING_OPTION_LIEUX') ? constant('CONFIG_SOPLANNING_OPTION_LIEUX') : null) == 1) {?>
			<?php if ($_SESSION['baseLigne'] == 'lieux') {?>
				<a class="dropdown-item" href="process/planning?baseLigne=lieux">
				<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
			<?php } else { ?>
				<a class="dropdown-item" href="process/planning?baseLigne=lieux">
				<i style="margin-left:19px;">&nbsp;</i>
			<?php }?>
			<?php echo $_smarty_tpl->getConfigVariable('planningLieu');?>
</a>
		<?php }?>
		
		<?php if ((defined('CONFIG_SOPLANNING_OPTION_RESSOURCES') ? constant('CONFIG_SOPLANNING_OPTION_RESSOURCES') : null) == 1) {?>
			<?php if ($_SESSION['baseLigne'] == 'ressources') {?>
				<a class="dropdown-item" href="process/planning?baseLigne=ressources">
				<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
			<?php } else { ?>
				<a class="dropdown-item" href="process/planning?baseLigne=ressources">
				<i style="margin-left:19px;">&nbsp;</i>
			<?php }?>
			<?php echo $_smarty_tpl->getConfigVariable('planningRessource');?>
</a>
		<?php }?>

											
		<div class="dropdown-divider"></div>
		<?php if ($_SESSION['baseColonne'] == 'users' && $_SESSION['baseLigne'] == 'heures') {?>
			<a class="dropdown-item disabled" href="process/planning?baseColonne=heures"><i style="margin-left:19px;">&nbsp;</i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('planningHeures');?>
</a>
			<a class="dropdown-item disabled" href="process/planning?baseColonne=jours"><i style="margin-left:19px;">&nbsp;</i>&nbsp;&nbsp;<?php echo $_smarty_tpl->getConfigVariable('planningJours');?>
</a>
		<?php } else { ?>
			<?php if ($_SESSION['baseColonne'] == 'heures') {?>
				<a class="dropdown-item" href="process/planning?baseColonne=heures">
				<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
			<?php } else { ?>
				<a class="dropdown-item" href="process/planning?baseColonne=heures">
				<i style="margin-left:19px;">&nbsp;</i>
			<?php }?>
			<?php echo $_smarty_tpl->getConfigVariable('planningHeures');?>
</a>
			<?php if ($_SESSION['baseColonne'] == 'jours') {?>
				<a class="dropdown-item" href="process/planning?baseColonne=jours">
				<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
			<?php } else { ?>
				<a class="dropdown-item" href="process/planning?baseColonne=jours">
				<i style="margin-left:19px;">&nbsp;</i>
			<?php }?>
			<?php echo $_smarty_tpl->getConfigVariable('planningJours');?>
</a>
		<?php }?>
		<div class="dropdown-divider"></div>

		<?php if ($_SESSION['masquerLigneVide'] == 0) {?>
			<a class="dropdown-item" href="process/planning?baseLigne=<?php echo $_SESSION['baseLigne'];?>
&baseColonne=<?php echo $_SESSION['baseColonne'];?>
&masquerLigneVide=1">
			<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
		<?php } else { ?>
			<a class="dropdown-item" href="process/planning?baseLigne=<?php echo $_SESSION['baseLigne'];?>
&baseColonne=<?php echo $_SESSION['baseColonne'];?>
&masquerLigneVide=0">
			<i style="margin-left:19px;">&nbsp;</i>
		<?php }?>
		<?php echo $_smarty_tpl->getConfigVariable('planningAfficherLignesVides');?>
</a>
		
		<?php if ($_SESSION['afficherLigneTotal'] == 1) {?>
			<a class="dropdown-item" href="process/planning?baseLigne=<?php echo $_SESSION['baseLigne'];?>
&baseColonne=<?php echo $_SESSION['baseColonne'];?>
&afficherLigneTotal=0">
			<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
		<?php } else { ?>
			<a class="dropdown-item" href="process/planning?baseLigne=<?php echo $_SESSION['baseLigne'];?>
&baseColonne=<?php echo $_SESSION['baseColonne'];?>
&afficherLigneTotal=1">
			<i style="margin-left:19px;">&nbsp;</i>
		<?php }?>
		<?php echo $_smarty_tpl->getConfigVariable('planningAfficherTotal');?>
</a>
		
		<?php if ($_SESSION['afficherLigneTotalTaches'] == 1) {?>
			<a class="dropdown-item" href="process/planning?baseLigne=<?php echo $_SESSION['baseLigne'];?>
&baseColonne=<?php echo $_SESSION['baseColonne'];?>
&afficherLigneTotalTaches=0">
			<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
		<?php } else { ?>
			<a class="dropdown-item" href="process/planning?baseLigne=<?php echo $_SESSION['baseLigne'];?>
&baseColonne=<?php echo $_SESSION['baseColonne'];?>
&afficherLigneTotalTaches=1">
			<i style="margin-left:19px;">&nbsp;</i>
		<?php }?>
		<?php echo $_smarty_tpl->getConfigVariable('planningAfficherTotalTaches');?>
</a>

		<?php if ($_SESSION['afficherTableauRecap'] == 1) {?>
			<a class="dropdown-item" href="process/planning?baseLigne=<?php echo $_SESSION['baseLigne'];?>
&baseColonne=<?php echo $_SESSION['baseColonne'];?>
&afficherTableauRecap=0">
			<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;
		<?php } else { ?>
			<a class="dropdown-item" href="process/planning?baseLigne=<?php echo $_SESSION['baseLigne'];?>
&baseColonne=<?php echo $_SESSION['baseColonne'];?>
&afficherTableauRecap=1">
			<i style="margin-left:19px;">&nbsp;</i>
		<?php }?>
		<?php echo $_smarty_tpl->getConfigVariable('planningAfficherTableauRecap');?>
</a>
	</div>
</div>

<?php }
}
