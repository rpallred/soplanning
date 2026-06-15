{* Smarty *}
{include file="www_header.tpl"}

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="soplanning-box">
				<h4><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;Completion Requirements</h4>
				<p class="text-muted">Manage the checklist items for each cohort. Items can be added or removed at any time.</p>

				<form method="GET" action="{$BASE}/requirements" class="form-inline" style="margin-bottom:15px;">
					<label for="cohort_id">Cohort:&nbsp;</label>
					<select name="cohort_id" id="cohort_id" class="form-control" onchange="this.form.submit()">
						{foreach item=co from=$cohorts}
							<option value="{$co.cohort_id}" {if $co.cohort_id == $selectedCohort}selected{/if}>{$co.libelle|xss_protect} ({$co.population})</option>
						{/foreach}
					</select>
				</form>

				<table class="table table-striped table-sm">
					<thead>
						<tr><th>Item</th><th style="width:160px;">Response type</th><th style="width:80px;">Active</th><th style="width:70px;"></th></tr>
					</thead>
					<tbody>
						{foreach item=req from=$requirements}
							<tr>
								<td>{$req.libelle|xss_protect}</td>
								<td>{$req.response_type}</td>
								<td>{$req.actif}</td>
								<td>
									<a href="{$BASE}/process/requirement_save?action=delete&requirement_id={$req.requirement_id}&cohort_id={$selectedCohort}&crsf={$smarty.session.CRSF}"
									   onClick="return confirm('Remove this requirement and all its completion records?');"
									   title="Remove"><i class="fa fa-trash-o fa-lg"></i></a>
								</td>
							</tr>
						{foreachelse}
							<tr><td colspan="4" class="text-muted">No items yet for this cohort.</td></tr>
						{/foreach}
					</tbody>
				</table>

				<hr>
				<h5>Add an item</h5>
				<form method="POST" action="{$BASE}/process/requirement_save" class="form-inline">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="cohort_id" value="{$selectedCohort}">
					<input type="text" name="libelle" class="form-control" placeholder="Requirement name" maxlength="255" required style="min-width:280px;">
					&nbsp;
					<select name="response_type" class="form-control">
						<option value="bool">Yes / No</option>
						<option value="date">Date</option>
						<option value="link">Link</option>
						<option value="file">File upload</option>
					</select>
					&nbsp;
					<button type="submit" class="btn btn-primary">Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
