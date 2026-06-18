{* Smarty *}
{include file="www_header.tpl"}

<div class="container" style="margin-top:60px;">
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="soplanning-box">
				<h4><i class="fa fa-hand-paper-o" aria-hidden="true"></i>&nbsp;Request a Book</h4>
				<p class="text-muted">Ask to borrow a book. A coordinator reviews your request; you'll see the status below.</p>

				<form method="POST" action="{$BASE}/process/booking_request_save" class="form-inline" style="margin-bottom:25px;">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="submit">
					<label>Book:&nbsp;</label>
					<select name="resource_id" class="form-control" required>
						<option value="">-- choose --</option>
						{foreach item=b from=$books}<option value="{$b.ressource_id|escape}">{$b.nom|xss_protect}</option>{/foreach}
					</select>&nbsp;
					needed from <input type="date" name="date_debut" class="form-control" required>&nbsp;
					until <input type="date" name="date_fin" class="form-control">&nbsp;
					<input type="text" name="note" class="form-control" placeholder="note (optional)" maxlength="255">&nbsp;
					<button type="submit" class="btn btn-primary">Submit request</button>
				</form>

				<h5>My requests</h5>
				<table class="table table-sm table-striped">
					<thead><tr><th>Book</th><th>From</th><th>Until</th><th>Status</th><th>Note</th></tr></thead>
					<tbody>
						{foreach item=r from=$mine}
							<tr>
								<td>{$r.resource_name|xss_protect}</td>
								<td>{$r.date_debut}</td>
								<td>{$r.date_fin}</td>
								<td>
									{if $r.statut == 'pending'}<span class="badge badge-warning">Pending</span>
									{elseif $r.statut == 'approved'}<span class="badge badge-success">Approved</span>
									{else}<span class="badge badge-secondary">Denied</span>{/if}
								</td>
								<td><small class="text-muted">{$r.decision_note|xss_protect}</small></td>
							</tr>
						{foreachelse}
							<tr><td colspan="5" class="text-muted">No requests yet.</td></tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
