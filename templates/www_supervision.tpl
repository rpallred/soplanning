{* Smarty *}
{include file="www_header.tpl"}

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="soplanning-box">
				<h4><i class="fa fa-sitemap" aria-hidden="true"></i>&nbsp;Manage Supervision</h4>

				<form method="GET" action="{$BASE}/supervision" class="form-inline" style="margin-bottom:15px;">
					<label>Trainee:&nbsp;</label>
					<select name="trainee_id" class="form-control" onchange="this.form.submit()">
						{foreach item=t from=$trainees}
							<option value="{$t.user_id|escape}" {if $t.user_id == $selectedTrainee}selected{/if}>{$t.nom|xss_protect}</option>
						{/foreach}
					</select>
					&nbsp;<a href="{$BASE}/supervision_report?trainee_id={$selectedTrainee|escape}" class="btn btn-outline-secondary btn-sm">View report</a>
				</form>

				<h5>Assignments</h5>
				<table class="table table-sm table-striped">
					<thead><tr><th>Function</th><th>Supervisor</th><th>From</th><th>To</th><th>Session</th><th></th></tr></thead>
					<tbody>
						{foreach item=r from=$supRows}
							<tr>
								<td>{$r.fonction}</td><td>{$r.supervisor|xss_protect}</td>
								<td><small>{$r.date_debut}</small></td><td><small>{$r.date_fin}</small></td>
								<td><small>{$r.slot}</small></td>
								<td><a href="{$BASE}/process/supervision_save?action=del_sup&sup_id={$r.sup_id}&trainee_id={$selectedTrainee|escape}&crsf={$smarty.session.CRSF}" onClick="return confirm('Remove this assignment?');"><i class="fa fa-trash-o"></i></a></td>
							</tr>
						{foreachelse}
							<tr><td colspan="6" class="text-muted">No assignments yet.</td></tr>
						{/foreach}
					</tbody>
				</table>
				<form method="POST" action="{$BASE}/process/supervision_save" class="form-inline" style="margin-bottom:25px;">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="add_sup">
					<input type="hidden" name="trainee_id" value="{$selectedTrainee|escape}">
					<select name="fonction" class="form-control">
						<option value="assigned">Assigned (primary)</option>
						<option value="individual">Individual supervision</option>
						<option value="notes">Note signing</option>
					</select>&nbsp;
					<select name="supervisor_ref" class="form-control" required>
						<option value="">-- supervisor --</option>
						{foreach item=s from=$supervisors}<option value="{$s.ressource_id|escape}">{$s.nom|xss_protect}</option>{/foreach}
					</select>&nbsp;
					from <input type="date" name="date_debut" class="form-control" required>&nbsp;
					to <input type="date" name="date_fin" class="form-control">&nbsp;
					<span class="text-muted">| individual only:</span>
					<select name="jour_semaine" class="form-control">
						<option value="">day</option>
						<option value="1">Mon</option><option value="2">Tue</option><option value="3">Wed</option>
						<option value="4">Thu</option><option value="5">Fri</option><option value="6">Sat</option><option value="7">Sun</option>
					</select>
					<input type="time" name="heure_debut" class="form-control">
					<input type="time" name="heure_fin" class="form-control">&nbsp;
					<button type="submit" class="btn btn-primary">Add</button>
				</form>

				<h5>Coverage</h5>
				<table class="table table-sm">
					<thead><tr><th>Function</th><th>Covered by</th><th>From</th><th>To</th><th>Note</th><th></th></tr></thead>
					<tbody>
						{foreach item=r from=$covRows}
							<tr class="table-warning">
								<td>{$r.fonction}</td><td>{$r.covering|xss_protect}</td>
								<td><small>{$r.date_debut}</small></td><td><small>{$r.date_fin}</small></td>
								<td><small>{$r.note|xss_protect}</small></td>
								<td><a href="{$BASE}/process/supervision_save?action=del_cov&cov_id={$r.cov_id}&trainee_id={$selectedTrainee|escape}&crsf={$smarty.session.CRSF}" onClick="return confirm('Remove this coverage?');"><i class="fa fa-trash-o"></i></a></td>
							</tr>
						{foreachelse}
							<tr><td colspan="6" class="text-muted">No coverage entries.</td></tr>
						{/foreach}
					</tbody>
				</table>
				<form method="POST" action="{$BASE}/process/supervision_save" class="form-inline">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="add_cov">
					<input type="hidden" name="trainee_id" value="{$selectedTrainee|escape}">
					<select name="fonction" class="form-control">
						<option value="all">All functions (e.g. FMLA)</option>
						<option value="assigned">Assigned (primary)</option>
						<option value="individual">Individual supervision</option>
						<option value="notes">Note signing</option>
					</select>&nbsp;
					<select name="covering_ref" class="form-control" required>
						<option value="">-- covering supervisor --</option>
						{foreach item=s from=$supervisors}<option value="{$s.ressource_id|escape}">{$s.nom|xss_protect}</option>{/foreach}
					</select>&nbsp;
					from <input type="date" name="date_debut" class="form-control" required>&nbsp;
					to <input type="date" name="date_fin" class="form-control" required>&nbsp;
					<input type="text" name="note" class="form-control" placeholder="note" maxlength="255">&nbsp;
					<button type="submit" class="btn btn-primary">Add coverage</button>
				</form>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
