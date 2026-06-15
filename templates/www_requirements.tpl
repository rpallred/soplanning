{* Smarty *}
{include file="www_header.tpl"}

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="soplanning-box">
				<h4><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;Completion Requirements</h4>
				<p class="text-muted">Manage cohorts and the checklist items within each. Items can be added or removed at any time.</p>

				<div class="card" style="margin-bottom:18px;">
					<div class="card-body">
						<h5>Cohorts</h5>
						<table class="table table-sm" style="margin-bottom:10px;">
							<thead><tr><th>Cohort</th><th>Year</th><th>Population</th><th style="width:60px;"></th></tr></thead>
							<tbody>
								{foreach item=co from=$cohorts}
									<tr>
										<td>{$co.libelle|xss_protect}</td>
										<td>{$co.annee}</td>
										<td>{$co.population}</td>
										<td><a href="{$BASE}/process/cohort_save?action=delete&cohort_id={$co.cohort_id}&crsf={$smarty.session.CRSF}" onClick="return confirm('Delete this cohort and all its checklist items and completion records?');" title="Delete cohort"><i class="fa fa-trash-o"></i></a></td>
									</tr>
								{/foreach}
							</tbody>
						</table>
						<form method="POST" action="{$BASE}/process/cohort_save" class="form-inline">
							<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
							<input type="text" name="libelle" class="form-control" placeholder="Cohort name (e.g. Interns 2027-2028)" maxlength="100" required style="min-width:260px;">
							&nbsp;<input type="text" name="annee" class="form-control" placeholder="Year" maxlength="20" style="width:110px;">
							&nbsp;<select name="population" class="form-control">
								<option value="trainee">Trainee</option>
								<option value="supervisor">Supervisor</option>
							</select>
							&nbsp;<button type="submit" class="btn btn-outline-primary">Add cohort</button>
						</form>
					</div>
				</div>

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
						<tr><th>Item</th><th style="width:200px;">Response type</th><th style="width:80px;">Active</th><th style="width:70px;"></th></tr>
					</thead>
					<tbody>
						{foreach item=req from=$requirements}
							<tr>
								<td>{$req.libelle|xss_protect}</td>
								<td>{$req.response_type}{if $req.response_type == 'number' && $req.cible}&nbsp;<span class="text-muted">(target {$req.cible})</span>{/if}</td>
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
						<option value="number">Number (count)</option>
						<option value="link">Link</option>
						<option value="file">File upload</option>
					</select>
					&nbsp;<input type="number" name="cible" class="form-control" placeholder="target #" min="1" style="width:100px;" title="Target count (only used by the Number type, e.g. 6)">
					&nbsp;
					<button type="submit" class="btn btn-primary">Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
