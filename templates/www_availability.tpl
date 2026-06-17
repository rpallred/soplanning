{* Smarty *}
{include file="www_header.tpl"}

<div class="container">
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="soplanning-box">
				<h4><i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbsp;Resource Availability</h4>

				<form method="GET" action="{$BASE}/availability" class="form-inline" style="margin-bottom:15px;">
					<label>Resource:&nbsp;</label>
					<select name="resource_id" class="form-control" onchange="this.form.submit()">
						{foreach item=r from=$resources}
							<option value="{$r.ressource_id|escape}" {if $r.ressource_id == $selected}selected{/if}>{$r.nom|xss_protect}{if $r.exclusif} (book){/if}</option>
						{/foreach}
					</select>
				</form>

				<p class="text-muted">
					<strong>{$resourceName|xss_protect}</strong> is bookable
					{if $hasWindows}only within the weekly windows below{else}any day (no windows defined){/if};
					blackout ranges block it entirely.
				</p>

				<h5>Linked login account</h5>
				<form method="POST" action="{$BASE}/process/availability_save" class="form-inline" style="margin-bottom:25px;">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="set_user_link">
					<input type="hidden" name="resource_id" value="{$selected|escape}">
					<label>This resource logs in as:&nbsp;</label>
					<select name="user_id" class="form-control">
						<option value="">-- no account (admin acts for them) --</option>
						{foreach item=p from=$people}<option value="{$p.user_id|escape}" {if $p.user_id == $linkedUser}selected{/if}>{$p.nom|xss_protect}</option>{/foreach}
					</select>
					&nbsp;<button type="submit" class="btn btn-primary">Save link</button>
					<span class="text-muted">&nbsp;(optional; lets a supervisor self-serve &amp; get notices)</span>
				</form>
				{if $linkedUser == ''}
					<form method="POST" action="{$BASE}/process/availability_save" style="margin-bottom:25px;">
						<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
						<input type="hidden" name="action" value="create_login">
						<input type="hidden" name="resource_id" value="{$selected|escape}">
						<button type="submit" class="btn btn-outline-success btn-sm" onClick="return confirm('Create a login account for this resource (self-service right, not shown on the planning)? The password is displayed once.');">
							<i class="fa fa-user-plus"></i>&nbsp;Create a login for this supervisor
						</button>
						<span class="text-muted">&nbsp;(or pick an existing account above)</span>
					</form>
				{/if}

				<h5>Limits</h5>
				<form method="POST" action="{$BASE}/process/availability_save" class="form-inline" style="margin-bottom:25px;">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="set_limits">
					<input type="hidden" name="resource_id" value="{$selected|escape}">
					<label>Max loan duration (days) for this resource:&nbsp;</label>
					<input type="number" name="quota_max_jours" class="form-control" min="0" style="width:90px;" value="{$quotaMaxJours|escape}" placeholder="none">
					&nbsp;&nbsp;<label>Max books out per borrower (all books, 0 = unlimited):&nbsp;</label>
					<input type="number" name="loan_max_per_user" class="form-control" min="0" style="width:90px;" value="{$loanMaxPerUser|escape}">
					&nbsp;<button type="submit" class="btn btn-primary">Save limits</button>
				</form>

				<h5>Weekly windows</h5>
				<table class="table table-sm table-striped">
					<thead><tr><th>Day</th><th>From</th><th>To</th><th style="width:50px;"></th></tr></thead>
					<tbody>
						{foreach item=w from=$windows}
							<tr>
								<td>{$w.jour}</td><td>{$w.heure_debut}</td><td>{$w.heure_fin}</td>
								<td><a href="{$BASE}/process/availability_save?action=delete&avail_id={$w.avail_id}&resource_id={$selected|escape}&crsf={$smarty.session.CRSF}" onClick="return confirm('Remove this window?');"><i class="fa fa-trash-o"></i></a></td>
							</tr>
						{foreachelse}
							<tr><td colspan="4" class="text-muted">No windows &mdash; available any day.</td></tr>
						{/foreach}
					</tbody>
				</table>
				<form method="POST" action="{$BASE}/process/availability_save" class="form-inline" style="margin-bottom:25px;">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="add_window">
					<input type="hidden" name="resource_id" value="{$selected|escape}">
					<select name="jour_semaine" class="form-control" required>
						<option value="1">Mon</option><option value="2">Tue</option><option value="3">Wed</option>
						<option value="4">Thu</option><option value="5">Fri</option><option value="6">Sat</option><option value="7">Sun</option>
					</select>&nbsp;
					from <input type="time" name="heure_debut" class="form-control" value="09:00">&nbsp;
					to <input type="time" name="heure_fin" class="form-control" value="17:00">&nbsp;
					<button type="submit" class="btn btn-primary">Add window</button>
				</form>

				<h5>Blackout periods</h5>
				<table class="table table-sm">
					<thead><tr><th>From</th><th>To</th><th>Note</th><th style="width:50px;"></th></tr></thead>
					<tbody>
						{foreach item=b from=$blackouts}
							<tr class="table-warning">
								<td>{$b.date_debut}</td><td>{$b.date_fin}</td><td>{$b.note|xss_protect}</td>
								<td><a href="{$BASE}/process/availability_save?action=delete&avail_id={$b.avail_id}&resource_id={$selected|escape}&crsf={$smarty.session.CRSF}" onClick="return confirm('Remove this blackout?');"><i class="fa fa-trash-o"></i></a></td>
							</tr>
						{foreachelse}
							<tr><td colspan="4" class="text-muted">No blackout periods.</td></tr>
						{/foreach}
					</tbody>
				</table>
				<form method="POST" action="{$BASE}/process/availability_save" class="form-inline">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="add_blackout">
					<input type="hidden" name="resource_id" value="{$selected|escape}">
					from <input type="date" name="date_debut" class="form-control" required>&nbsp;
					to <input type="date" name="date_fin" class="form-control" required>&nbsp;
					<input type="text" name="note" class="form-control" placeholder="note (e.g. vacation)" maxlength="255">&nbsp;
					<button type="submit" class="btn btn-primary">Add blackout</button>
				</form>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
