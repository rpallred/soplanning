{* Smarty *}
{include file="www_header.tpl"}

<div class="container">
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="soplanning-box">
				<h4><i class="fa fa-user" aria-hidden="true"></i>&nbsp;{$subjectName|xss_protect}</h4>
				<p class="text-muted">Record completion of checklist items.</p>

				<form method="POST" action="{$BASE}/process/completion_save" enctype="multipart/form-data" class="form-horizontal">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="subject_type" value="{$subjectType}">
					<input type="hidden" name="subject_id" value="{$subjectId|escape}">
					<input type="hidden" name="cohort_id" value="{$cohortId}">

					<table class="table">
						<tbody>
						{foreach item=it from=$items}
							<tr>
								<td style="width:45%;">{$it.libelle|xss_protect}</td>
								<td>
									{if $it.response_type == 'bool'}
										<select name="value_{$it.requirement_id}" class="form-control">
											<option value="">&mdash;</option>
											<option value="yes" {if $it.valeur == 'yes'}selected{/if}>Yes</option>
											<option value="no" {if $it.valeur == 'no'}selected{/if}>No</option>
										</select>
									{elseif $it.response_type == 'date'}
										<input type="date" name="value_{$it.requirement_id}" class="form-control" value="{$it.valeur|escape}">
									{elseif $it.response_type == 'number'}
										<input type="number" name="value_{$it.requirement_id}" class="form-control" min="0" value="{$it.valeur|escape}" style="width:120px;">
										{if $it.cible}<span class="text-muted">&nbsp;of {$it.cible}</span>{/if}
									{elseif $it.response_type == 'link'}
										<input type="url" name="value_{$it.requirement_id}" class="form-control" placeholder="https://..." value="{$it.valeur|escape}">
									{elseif $it.response_type == 'file'}
										{if $it.fichier != ''}
											<div><i class="fa fa-file-o"></i> <a href="{$BASE}/upload/files/completions/{$it.fichier|escape:'url'}" target="_blank">current file</a></div>
										{/if}
										<input type="file" name="file_{$it.requirement_id}" class="form-control-file">
									{/if}
								</td>
							</tr>
						{/foreach}
						</tbody>
					</table>

					<button type="submit" class="btn btn-primary">Save</button>
					<a href="{$BASE}/completions?cohort_id={$cohortId}" class="btn btn-outline-secondary">Back</a>
				</form>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
