{* Smarty *}
{include file="www_header.tpl"}

<div class="container-fluid" style="margin-top:60px;">
	<div class="row">
		<div class="col-md-12">
			<div class="soplanning-box">
				<h4><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;Completion Tracking</h4>

				<form method="GET" action="{$BASE}/completions" class="form-inline" style="margin-bottom:15px;">
					<label for="cohort_id">Cohort:&nbsp;</label>
					<select name="cohort_id" id="cohort_id" class="form-control" onchange="this.form.submit()">
						{foreach item=co from=$cohorts}
							<option value="{$co.cohort_id}" {if $co.cohort_id == $selectedCohort}selected{/if}>{$co.libelle|xss_protect} ({$co.population})</option>
						{/foreach}
					</select>
					&nbsp;<a href="{$BASE}/requirements?cohort_id={$selectedCohort}" class="btn btn-outline-secondary btn-sm">Manage items</a>
				</form>

				{if $subjectType == 'user'}
					<form method="POST" action="{$BASE}/process/cohort_save" class="form-inline" style="margin-bottom:15px;">
						<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
						<input type="hidden" name="action" value="add_member">
						<input type="hidden" name="cohort_id" value="{$selectedCohort}">
						<label>Add person to this cohort:&nbsp;</label>
						<select name="user_id" class="form-control" required>
							<option value="">-- person --</option>
							{foreach item=p from=$assignable}<option value="{$p.user_id|escape}">{$p.nom|xss_protect}</option>{/foreach}
						</select>
						&nbsp;<button type="submit" class="btn btn-outline-primary btn-sm">Add</button>
						<span class="text-muted">&nbsp;(moves them here if they're in another cohort)</span>
					</form>
				{/if}

				<div style="overflow-x:auto;">
				<table class="table table-bordered table-sm" style="white-space:nowrap;">
					<thead class="thead-light">
						<tr>
							<th style="position:sticky;left:0;background:#fff;">Person</th>
							{foreach item=req from=$reqRows}
								<th style="font-weight:normal;font-size:12px;">{$req.libelle|xss_protect}<br><small class="text-muted">{if $req.response_type == 'bool'}Yes / No{elseif $req.response_type == 'number'}Number{elseif $req.response_type == 'link'}Link{elseif $req.response_type == 'file'}File{elseif $req.response_type == 'date'}Date{else}{$req.response_type}{/if}</small></th>
							{/foreach}
							<th>Progress</th>
						</tr>
					</thead>
					<tbody>
						{foreach item=row from=$matrix}
							<tr>
								<td style="position:sticky;left:0;background:#fff;white-space:nowrap;">
									<a href="{$BASE}/completion_form?subject_type={$subjectType}&subject_id={$row.id|escape:'url'}&cohort_id={$selectedCohort}">{$row.nom|xss_protect}</a>
									{if $subjectType == 'user'}
										<a href="{$BASE}/process/cohort_save?action=remove_member&user_id={$row.id|escape:'url'}&cohort_id={$selectedCohort}&crsf={$smarty.session.CRSF}" onClick="return confirm('Remove this person from the cohort? Their recorded completions are kept.');" title="Remove from cohort" class="text-muted">&nbsp;<i class="fa fa-times-circle"></i></a>
									{/if}
								</td>
								{foreach item=cell from=$row.cells}
									<td class="text-center">
										{if $cell.type == 'number'}
											{if $cell.display != ''}
												<small class="{if $cell.done}text-success font-weight-bold{elseif $cell.partial}text-warning{else}text-muted{/if}">{$cell.display}{if $cell.done}&nbsp;<i class="fa fa-check"></i>{/if}</small>
											{else}<span class="text-muted">&mdash;</span>{/if}
										{elseif $cell.done}
											{if $cell.type == 'date'}<small>{$cell.display}</small>
											{else}<i class="fa fa-check text-success" title="{$cell.display}"></i>{/if}
										{else}
											<span class="text-muted">&mdash;</span>
										{/if}
									</td>
								{/foreach}
								<td class="text-center"><small>{$row.done}/{$row.total}</small></td>
							</tr>
						{foreachelse}
							<tr><td colspan="99" class="text-muted">No people in this cohort.</td></tr>
						{/foreach}
					</tbody>
				</table>
				</div>
				<p class="text-muted"><small>Click a person's name to record or update their completions.</small></p>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
