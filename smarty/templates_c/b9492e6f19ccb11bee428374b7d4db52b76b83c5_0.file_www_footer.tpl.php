<?php
/* Smarty version 5.5.1, created on 2026-06-12 03:34:20
  from 'file:www_footer.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_6a2b621c418ae0_16898821',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b9492e6f19ccb11bee428374b7d4db52b76b83c5' => 
    array (
      0 => 'www_footer.tpl',
      1 => 1775128434,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:ai_chat_widget.tpl' => 1,
  ),
))) {
function content_6a2b621c418ae0_16898821 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home1/doctora1/public_html/SOPlanning/templates';
?>		 		<div class="navbar fixed-bottom navbar-light bg-white footer justify-content-center" id="footerbar">
			<a target="_blank" href="https://www.soplanning.org">www.soplanning.org</a>
			<span class="noprint">&nbsp;-&nbsp;</span>
			<a href="mailto:support@soplanning.org" class="noprint"><?php echo $_smarty_tpl->getConfigVariable('soplanning_support');?>
</a>
			<span class="noprint">&nbsp;-&nbsp;</span>
			<a href="mailto:support@soplanning.org" class="noprint"><?php echo $_smarty_tpl->getConfigVariable('soplanning_proposer');?>
</a>
		</div>
		<div class="modal" tabindex="-1" role="dialog" id="myModal">
			<div class="modal-dialog modal-dialog-normal" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">...</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="alertModal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>
		<div class="modal" tabindex="-1" role="dialog" id="myBigModal">
			<div class="modal-dialog modalBig" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">...</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>
		<div class="modal" tabindex="-1" role="dialog" id="xajaxErrorModal">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content border-danger">
					<div class="modal-header bg-danger text-white">
						<h5 class="modal-title">&#9888; Server Error - Please report to support</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<textarea id="xajaxErrorContent" class="form-control" rows="20" style="font-family:monospace;font-size:12px;" readonly></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/jquery-ui-1.13.2.custom/i18n/datepicker-<?php echo $_smarty_tpl->getValue('lang');?>
.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/bootstrap-4.6.2/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/bootstrap-datepicker-1.10.0/js/bootstrap-datepicker.min.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('BASE');?>
/assets/plugins/bootstrap-datepicker-1.10.0/locales/bootstrap-datepicker.<?php if ($_smarty_tpl->getValue('lang') == "en") {?>en-GB<?php } else {
echo $_smarty_tpl->getValue('lang');
}?>.min.js" charset="UTF-8"><?php echo '</script'; ?>
>

		<?php echo $_smarty_tpl->getValue('xajax');?>

		<?php echo '<script'; ?>
>
		
		$(".modal").draggable({
			handle: ".modal-header"
		});

		function xajaxShowError(msg) {
			var el = document.getElementById('xajaxErrorContent');
			if (el && typeof $ !== 'undefined' && $.fn.modal) {
				el.value = msg;
				$('#xajaxErrorModal').modal('show');
			} else {
				alert(msg);
			}
		}

		// datepicker activation
		$('.datepicker').datepicker({ 			
			calendarWeeks: true,
			language: "<?php echo $_smarty_tpl->getValue('lang');?>
",
			format: "<?php echo (defined('CONFIG_DATE_DATEPICKER') ? constant('CONFIG_DATE_DATEPICKER') : null);?>
",
			autoclose: true,
			todayHighlight: true,
			orientation: "bottom left"
		});

		// tooltip activation
		$('.tooltipster').tooltip({
			html: true,
			placement: 'auto',
			boundary: 'window'
		});

		
		
		<?php if ((true && ($_smarty_tpl->hasVariable('user') && null !== ($_smarty_tpl->getValue('user') ?? null)))) {?>
			setTimeout("xajax_checkAvailableVersion('header');", 10000);
		<?php }?>
		
		var showFooter = false;
		$('#footerbar').mouseenter(function(){showFooter=true;});
		$('#footerbar').mouseleave(function(){showFooter=false;});

		$(function(){
			$(window).scroll(function() {	
			$('#footerbar').show();
			setTimeout(() => {  
					if (showFooter===false)
					{
						$('#footerbar').fadeOut(); 
					}
				}, 2500);

		});
		
		})

		

		/*
		function registerServiceWorker() {
		  if ('serviceWorker' in navigator) {
			 navigator.serviceWorker.register('<?php echo $_smarty_tpl->getValue('BASE');?>
/serviceWorker.js') //
				.then(function(reg){
					console.log("service worker registered");
				}).catch(function(err) {
					console.log(err)
				});
		  }
		  else {
			console.log("Could not find serviceWorker in navigator");
		  }
		}
		registerServiceWorker();
		*/

		<?php echo '</script'; ?>
>
	<?php if ((true && ($_smarty_tpl->hasVariable('user') && null !== ($_smarty_tpl->getValue('user') ?? null))) && $_smarty_tpl->getValue('user')['user_id'] != 'publicspl' && (true && (true && null !== ((defined('CONFIG_AI_OLLAMA_URL') ? constant('CONFIG_AI_OLLAMA_URL') : null) ?? null))) && (defined('CONFIG_AI_OLLAMA_URL') ? constant('CONFIG_AI_OLLAMA_URL') : null) != '' && (true && (true && null !== ((defined('CONFIG_AI_OLLAMA_MODEL') ? constant('CONFIG_AI_OLLAMA_MODEL') : null) ?? null))) && (defined('CONFIG_AI_OLLAMA_MODEL') ? constant('CONFIG_AI_OLLAMA_MODEL') : null) != '') {?>
		<?php $_smarty_tpl->renderSubTemplate("file:ai_chat_widget.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
	<?php }?>
	</body>
</html><?php }
}
