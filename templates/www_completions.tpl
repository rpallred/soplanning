{* Smarty *}
{include file="www_header.tpl"}

<div class="container-fluid">
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

				<div style="overflow-x:auto;">
				<table class="table table-bordered table-sm" style="white-space:nowrap;">
					<thead class="thead-light">
						<tr>
							<th style="position:sticky;left:0;background:#fff;">Person</th>
							{foreach item=req from=$reqRows}
								<th style="font-weight:normal;font-size:12px;">{$req.libelle|xss_protect}<br><small class="text-muted">{$req.response_type}</small></th>
							{/foreach}
							<th>Progress</th>
						</tr>
					</thead>
					<tbody>
						{foreach item=row from=$matrix}
							<tr>
								<td style="position:sticky;left:0;background:#fff;">
									<a href="{$BASE}/completion_form?subject_type={$subjectType}&subject_id={$row.id|escape:'url'}&cohort_id={$selectedCohort}">{$row.nom|xss_protect}</a>
								</td>
								{foreach item=cell from=$row.cells}
									<td class="text-center">
										{if $cell.done}
											{if $cell.type == 'date' || $cell.type == 'number'}<small>{$cell.display}</small>
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
