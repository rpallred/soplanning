<?php
/* Smarty version 5.5.1, created on 2026-06-12 04:05:08
  from 'file:www_planning.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6a2b695480bd95_74897312',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4e749f33c97da071b075b81ccaec71e05791fee3' => 
    array (
      0 => 'www_planning.tpl',
      1 => 1772195582,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:www_header.tpl' => 1,
    'file:www_planning_filtre.tpl' => 1,
    'file:tutoriel.tpl' => 1,
    'file:www_footer.tpl' => 1,
  ),
))) {
function content_6a2b695480bd95_74897312 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home1/doctora1/public_html/SOPlanning/templates';
$_smarty_tpl->renderSubTemplate("file:www_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
$_smarty_tpl->renderSubTemplate("file:www_planning_filtre.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
			<div class="position-relative" id="thirdLayer">
			<?php if ($_smarty_tpl->getValue('fleches') == 1) {?>
				<div id="left-scroll">					
					<span class="fa-stack">
						<i class="fa fa-chevron-left fa-2x" id="left-button" aria-hidden="true"></i>				
					</span>
				</div>
			<?php }?>
			<div id="divConteneurPlanning" style="width:99vw;">
				<?php echo $_smarty_tpl->getValue('htmlTableau');?>

			</div>
			<?php if ($_smarty_tpl->getValue('fleches') == 1) {?>
				<div id="right-scroll">						
					<span class="fa-stack">
						<i class="fa fa-chevron-right fa-2x" id="right-button" aria-hidden="true"></i>				
					</span>
				</div>
			<?php }?>
			<br><br>
		 </div> 
	<?php if ((true && ($_smarty_tpl->hasVariable('htmlRecap') && null !== ($_smarty_tpl->getValue('htmlRecap') ?? null))) && $_smarty_tpl->getValue('htmlRecap') != '') {?>
	<div class="vw-100 noprint" id="divRecap">
		<div >
			<div id="divPlanningRecap" class="soplanning-box pt-0" >
				<?php echo $_smarty_tpl->getValue('htmlRecap');?>

			</div>
		</div>
	</div>
	
	<?php echo '<script'; ?>
>
	$(window).scroll(function(){
    $('#divRecap').css({
        'left': $(this).scrollLeft() + 0 
		});
	});
	<?php echo '</script'; ?>
>
	
	<?php }?>
<div id="divChoixDragNDrop" onMouseOut="masquerSousMenuDelai('divChoixDragNDrop');" onMouseOver="AnnuleMasquerSousMenu('divChoixDragNDrop');" onfocus="AnnuleMasquerSousMenu('divChoixDragNDrop')">
	<a href="javascript:windowPatienter();xajax_moveCasePeriode(idCaseEnCoursDeplacement, idCaseDestination, false, 'seule');void(0);"><?php echo $_smarty_tpl->getConfigVariable('planning_deplacer');?>
<div title="<?php echo $_smarty_tpl->getConfigVariable('action_aide_deplacer_seule');?>
" class="align-self-center cursor-help tooltipster" style="display:block;float:right;margin-left:0px;"><i class="fa fa-question-circle" aria-hidden="true"></i></div></a>
	<a href="javascript:windowPatienter();xajax_moveCasePeriode(idCaseEnCoursDeplacement, idCaseDestination, false, 'toutes');void(0);"><?php echo $_smarty_tpl->getConfigVariable('planning_deplacer_toutestaches');?>
<div title="<?php echo $_smarty_tpl->getConfigVariable('action_aide_deplacer_toutestaches');?>
" class="align-self-center cursor-help tooltipster" style="display:block;float:right;margin-left:0px;"><i class="fa fa-question-circle" aria-hidden="true"></i></div></a>
	<a href="javascript:windowPatienter();xajax_moveCasePeriode(idCaseEnCoursDeplacement, idCaseDestination, true);void(0);"><?php echo $_smarty_tpl->getConfigVariable('planning_copier');?>
</a>
	<a href="javascript:masquerSousMenu('divChoixDragNDrop');document.location.reload();"><?php echo $_smarty_tpl->getConfigVariable('planning_annuler');?>
</a>
</div>
<?php echo '<script'; ?>
>

Reloader.init(<?php echo (defined('CONFIG_REFRESH_TIMER') ? constant('CONFIG_REFRESH_TIMER') : null);?>
);

<?php if ((true && ($_smarty_tpl->hasVariable('direct_periode_id') && null !== ($_smarty_tpl->getValue('direct_periode_id') ?? null)))) {?>
	addEvent(window, 'load', function(){xajax_modifPeriode(<?php echo $_smarty_tpl->getValue('direct_periode_id');?>
)});
<?php }?>

var js_choisirProjet = '<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('js_choisirProjet'));?>
';
var js_choisirUtilisateur = '<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('js_choisirUtilisateur'));?>
';
var js_choisirDateDebut = '<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('js_choisirDateDebut'));?>
';
var js_saisirFormatDate = '<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('js_saisirFormatDate'));?>
';
var js_dateFinInferieure = '<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('js_dateFinInferieure'));?>
';
var js_deposerCaseSurDate = '<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('js_deposerCaseSurDate'));?>
';
var js_deplacementOk = '<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('js_deplacementOk'));?>
';
var js_patienter = '<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('xss_protect')($_smarty_tpl->getConfigVariable('js_patienter'));?>
';
var idDrag;
var dragElementParent;
var oldDragBorder;
var displayMode = <?php echo json_encode($_smarty_tpl->getValue('modeAffichage'));?>
;
var dateDebut = <?php echo json_encode($_smarty_tpl->getValue('dateDebut'));?>
;
var dateFin = <?php echo json_encode($_smarty_tpl->getValue('dateFin'));?>
;

	// Gestion du filtre Projet
		$("#filtreGroupeProjet").multiselect({
			selectAll:true,
			selectGroup:true,
			noUpdatePlaceholderText:true,
			search   : true,
			nameSuffix: 'projet',
			desactivateUrl: 'process/planning?desactiverFiltreGroupeProjet=1',
			placeholder: '<i class="fa fa-book fa-lg fa-fw" aria-hidden="true"></i><span class="d-none d-md-inline-block">&nbsp;<?php echo $_smarty_tpl->getConfigVariable('taches_filtreProjets');?>
</span>',
			texts: {
				selectAll    : '<?php echo $_smarty_tpl->getConfigVariable('formFiltreProjetCocherTous');?>
',
				unselectAll    : '<?php echo $_smarty_tpl->getConfigVariable('formFiltreProjetDecocherTous');?>
',
				disableFilter : '<?php echo $_smarty_tpl->getConfigVariable('formFiltreProjetDesactiver');?>
',
				validateFilter : '<?php echo $_smarty_tpl->getConfigVariable('submit');?>
',
				search : '<?php echo $_smarty_tpl->getConfigVariable('search');?>
'
			},
		});
		$("#filtreGroupeProjet").show();
	// Gestion du filtre User
		$("#filtreUser").multiselect({
			selectAll:true,
			selectGroup:true,
			showAllPlaceholderOpts:false,
			search   : true,
			nameSuffix: 'user',
			desactivateUrl: 'process/planning?desactiverFiltreUser=1',
			placeholder: '<i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i><span class="d-none d-md-inline-block">&nbsp;<?php echo $_smarty_tpl->getConfigVariable('formChoixUser');?>
</span>',
			texts: {
				selectAll    : '<?php echo $_smarty_tpl->getConfigVariable('formFiltreUserCocherTous');?>
',
				unselectAll    : '<?php echo $_smarty_tpl->getConfigVariable('formFiltreUserDecocherTous');?>
',
				disableFilter : '<?php echo $_smarty_tpl->getConfigVariable('formFiltreUserDesactiver');?>
',
				validateFilter : '<?php echo $_smarty_tpl->getConfigVariable('submit');?>
',
				search : '<?php echo $_smarty_tpl->getConfigVariable('search');?>
',
				selectedOptions : '<?php echo $_smarty_tpl->getConfigVariable('selectionnes');?>
'
			},
		});
		//$("#filtreUser").class("");

	// Ajout des boutons de scroll de planning
	var e = $("#divConteneurPlanning").get(0);
	if (e.scrollWidth > e.clientWidth)
	{
		
		<?php if ($_smarty_tpl->getValue('fleches') == 1) {?>
		
			$('#left-scroll').show();
			$('#right-scroll').show();
			$('#right-scroll').click(function() {
				window.scrollBy({
				    top: 0,
					left: 800,
					behavior : "smooth"
				});
			});
			$('#left-scroll').click(function() {
				window.scrollBy({
				    top: 0,
					left: -800,
					behavior : "smooth"
				});
			});
		
		<?php }?>
		
	}
		
		<?php if ($_smarty_tpl->getValue('baseligne') == "heures") {?>
			
				$('#divConteneurPlanning').attr('style','overflow:visible');
			
		<?php }?>		
	
	
	var tabCellsSelected = new Array();

	// Affichage du formulaire periode si clic sur case vide
	$('#tabContenuPlanning td.week,#tabContenuPlanning td.weekend,#tabContenuPlanning .cellProject,#tabContenuPlanning .cellProjectBiseau1, #tabContenuPlanning .cellProjectBiseau2').click(function(ev){
		ev.preventDefault();
		ev.stopPropagation();
		if ((ev.ctrlKey || ev.metaKey) && !$(this).hasClass("read-only")) {
			if ($(this).hasClass("cellProject") || $(this).hasClass("cellProjectBiseau1")  || $(this).hasClass("cellProjectBiseau2")) {
				checkPos = tabCellsSelected.indexOf(this.id);
				if (checkPos >= 0) {
					tabCellsSelected.splice(checkPos, 1);
					$(this).removeClass("bordureSelectionne");
				} else {
					tabCellsSelected.push(this.id);
					$(this).addClass("bordureSelectionne");
				}
			}
		} else {
			if (!$(this).hasClass("read-only")){
				if ($(this).hasClass("cellProject") || $(this).hasClass("cellProjectBiseau1")  || $(this).hasClass("cellProjectBiseau2")) {
					cellClic(this.id,0);
				} else {
					<?php if ((true && ($_smarty_tpl->hasVariable('droitAjoutPeriode') && null !== ($_smarty_tpl->getValue('droitAjoutPeriode') ?? null))) && $_smarty_tpl->getValue('droitAjoutPeriode') == true) {?>
					cellClic(this.id,1);
					<?php }?>

				}
				return false;
			}
		}
	});
	
		
	function resizeDivConteneur()
	{

	}

	// Gestion du cookie de positionnement
	function writeCookie(displayMode){
		if (displayMode == 'mois'){
			document.cookie='yposMoisWin=' + window.pageYOffset;
			document.cookie='xposMoisWin=' + window.pageXOffset;
		}else if (displayMode == 'jour'){
			document.cookie='yposJoursWin=' + window.pageYOffset;
			document.cookie='xposJoursWin=' + window.pageXOffset;
		}
	}
	
	// Memorisation scrolling
	<?php if ((true && (true && null !== ($_COOKIE['dateDebut'] ?? null)))) {?>
		var cookieDateDebut = '<?php echo strtr((string)$_COOKIE['dateDebut'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", 
						"\n" => "\\n", "</" => "<\/", "<!--" => "<\!--", "<s" => "<\s", "<S" => "<\S",
						"`" => "\\`", "\${" => "\\\$\{"));?>
';
	<?php } else { ?>
		var cookieDateDebut = 0;
	<?php }?>
	<?php if ((true && (true && null !== ($_COOKIE['dateFin'] ?? null)))) {?>
		var cookieDateFin = '<?php echo strtr((string)$_COOKIE['dateFin'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", 
						"\n" => "\\n", "</" => "<\/", "<!--" => "<\!--", "<s" => "<\s", "<S" => "<\S",
						"`" => "\\`", "\${" => "\\\$\{"));?>
';
	<?php } else { ?>
		var cookieDateFin = 0;
	<?php }?>
	
	if (dateDebut != cookieDateDebut || dateFin != cookieDateFin)  
	{
		document.cookie='dateDebut=' + dateDebut ;
		document.cookie='dateFin=' + dateFin ;
		document.cookie='xposMoisWin=0';
		document.cookie='xposJoursWin=0';
		document.cookie='yposMoisWin=0';
		document.cookie='yposJoursWin=0';
	}
	// Recuperation
	if (displayMode == 'mois')
	{
		
		<?php if ((true && (true && null !== ($_COOKIE['xposMoisWin'] ?? null)))) {?>
			var xscrollWin = <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('intval')($_COOKIE['xposMoisWin']);?>
;
		<?php } else { ?>
			var xscrollWin = 0;
		<?php }?>
		<?php if ((true && (true && null !== ($_COOKIE['yposMoisWin'] ?? null)))) {?>
			var yscrollWin = <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('intval')($_COOKIE['yposMoisWin']);?>
;
		<?php } else { ?>
			var yscrollWin = 0;
		<?php }?>
		
	}else if (displayMode == 'jour'){
		
		<?php if ((true && (true && null !== ($_COOKIE['xposJoursWin'] ?? null)))) {?>
			var xscrollWin = <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('intval')($_COOKIE['xposJoursWin']);?>
;
		<?php } else { ?>
			var xscrollWin = 0;
		<?php }?>
		<?php if ((true && (true && null !== ($_COOKIE['yposJoursWin'] ?? null)))) {?>
			var yscrollWin = <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('intval')($_COOKIE['yposJoursWin']);?>
;
		<?php } else { ?>
			var yscrollWin = 0;
		<?php }?>
		
	}
	window.scroll(xscrollWin,yscrollWin);
	window.onscroll = function() {writeCookie(displayMode)};
	
	
		resizeDivConteneur();
	


	// Fonction pour ajuster la position du thirdLayer en fonction de la hauteur du secondLayer
	function adjustThirdLayer() {
		var secondLayer = document.getElementById('secondLayer');
		var thirdLayer = document.getElementById('thirdLayer');
		if (secondLayer && thirdLayer) {
			var secondLayerHeight = secondLayer.offsetHeight;
			var secondLayerTop = 105; // position top du secondLayer
			var newTop = secondLayerTop + secondLayerHeight - 4; // align thirdLayer border with secondLayer bottom
			thirdLayer.style.top = newTop + 'px';

			// Ajuster aussi les positions sticky des headers du planning
			var baseTop = newTop + 4; // Position de base pour les headers (= secondLayerBottom)

			// Headers pour affichage par jours (4 lignes)
			var headerMonth = document.querySelectorAll('#planning_header_month th');
			var headerWeek = document.querySelectorAll('#planning_header_week th');
			var headerDayname = document.querySelectorAll('#planning_header_dayname th');
			var headerDay = document.querySelectorAll('#planning_header_day th');

			if (headerMonth.length > 0) {
				headerMonth.forEach(function(th) { th.style.top = baseTop + 'px'; });
			}
			if (headerWeek.length > 0) {
				headerWeek.forEach(function(th) { th.style.top = (baseTop + 24) + 'px'; });
			}
			if (headerDayname.length > 0) {
				headerDayname.forEach(function(th) { th.style.top = (baseTop + 49) + 'px'; });
			}
			if (headerDay.length > 0) {
				headerDay.forEach(function(th) { th.style.top = (baseTop + 72) + 'px'; });
			}

			// Headers pour affichage par heures (2 lignes)
			var headerWeekHour = document.querySelectorAll('#planning_header_week_hour th');
			var headerHour = document.querySelectorAll('#planning_header_hour th');

			if (headerWeekHour.length > 0) {
				headerWeekHour.forEach(function(th) { th.style.top = baseTop + 'px'; });
			}
			if (headerHour.length > 0) {
				headerHour.forEach(function(th) { th.style.top = (baseTop + 25) + 'px'; });
			}

			// Separation des equipes - mode jours
			var teamDivJours = document.querySelectorAll('td.planning_team_div, th.planning_team_div');
			if (teamDivJours.length > 0) {
				teamDivJours.forEach(function(el) { el.style.setProperty('top', (baseTop + 86) + 'px', 'important'); });
			}
			// Separation des equipes - mode heures
			var teamDivHour = document.querySelectorAll('.planning_team_div_hour');
			if (teamDivHour.length > 0) {
				teamDivHour.forEach(function(el) { el.style.setProperty('top', (baseTop + 47) + 'px', 'important'); });
			}
		}
	}

	// Onload
	jQuery(function() {
		<?php if ($_SESSION['isMobileOrTablet'] == 0) {?>
			
			// hack pour empecher fermeture du layer au click sur les boutons du calendrier1
			$("#ui-datepicker-div").click( function(event) {
				event.stopPropagation();
			});
			jQuery('#dropdownDateSelector .dropdown-menu').on({
			"click":function(e){
					e.stopPropagation();
				}
			});

			$(document).on('keyup', function(e) {
				if (e.which == 17 && tabCellsSelected.length > 0){
					xajax_selection_multi_tache_form(tabCellsSelected);
				}
			});

			
		<?php }?>

		// Ajuster thirdLayer au chargement
		adjustThirdLayer();

		// Ajuster thirdLayer lors du resize (zoom, redimensionnement fenêtre)
		window.addEventListener('resize', adjustThirdLayer);

		$('#tdUser_0').empty();
		$('#dropdownDisplayPlanning').appendTo('#tdUser_0');
	});

<?php echo '</script'; ?>
>

<?php $_smarty_tpl->renderSubTemplate("file:tutoriel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<?php $_smarty_tpl->renderSubTemplate("file:www_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
}
}
