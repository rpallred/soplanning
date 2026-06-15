{* Smarty *}
{include file="www_header.tpl"}

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="soplanning-box">
				<h4><i class="fa fa-book" aria-hidden="true"></i>&nbsp;Book Library</h4>

				<h5>Check out a book</h5>
				<form method="POST" action="{$BASE}/process/loan_save" class="form-inline" style="margin-bottom:20px;">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="checkout">
					<select name="resource_id" class="form-control" required style="min-width:240px;">
						<option value="">-- book --</option>
						{foreach item=b from=$available}
							<option value="{$b.id|escape}">{$b.nom|xss_protect}</option>
						{/foreach}
					</select>
					&nbsp;to&nbsp;
					<select name="user_id" class="form-control" style="min-width:180px;">
						<option value="">-- person --</option>
						{foreach item=p from=$people}
							<option value="{$p.user_id|escape}">{$p.nom|xss_protect}</option>
						{/foreach}
					</select>
					&nbsp;<input type="text" name="borrower_name" class="form-control" placeholder="or type a name" maxlength="100">
					&nbsp;due&nbsp;<input type="date" name="date_due" class="form-control" value="{$defaultDue}">
					&nbsp;<button type="submit" class="btn btn-primary">Check out</button>
				</form>

				<h5>Currently out ({$booksOut|@count})</h5>
				<table class="table table-sm table-striped">
					<thead><tr><th>Book</th><th>Borrower</th><th>Out</th><th>Due</th><th></th></tr></thead>
					<tbody>
						{foreach item=l from=$booksOut}
							<tr {if $l.overdue}class="table-danger"{/if}>
								<td>{$l.book_nom|xss_protect}</td>
								<td>{$l.borrower|xss_protect}</td>
								<td><small>{$l.date_out}</small></td>
								<td><small>{$l.date_due}{if $l.overdue} <span class="badge badge-danger">OVERDUE</span>{/if}</small></td>
								<td>
									<a href="{$BASE}/process/loan_save?action=checkin&loan_id={$l.loan_id}&crsf={$smarty.session.CRSF}" class="btn btn-sm btn-success">Check in</a>
									<a href="{$BASE}/process/loan_save?action=lost&loan_id={$l.loan_id}&crsf={$smarty.session.CRSF}" onClick="return confirm('Mark this book lost?');" class="btn btn-sm btn-outline-danger">Lost</a>
								</td>
							</tr>
						{foreachelse}
							<tr><td colspan="5" class="text-muted">No books are checked out.</td></tr>
						{/foreach}
					</tbody>
				</table>

				{if $holds|@count > 0}
				<h5>Holds</h5>
				<table class="table table-sm">
					<thead><tr><th>Book</th><th>Requested by</th><th>Since</th><th>Status</th><th></th></tr></thead>
					<tbody>
						{foreach item=h from=$holds}
							<tr>
								<td>{$h.book_nom|xss_protect}</td>
								<td>{$h.requester|xss_protect}</td>
								<td><small>{$h.requested_at}</small></td>
								<td>{if $h.statut == 'notified'}<span class="badge badge-info">available</span>{else}waiting{/if}</td>
								<td><a href="{$BASE}/process/loan_save?action=cancelhold&hold_id={$h.hold_id}&crsf={$smarty.session.CRSF}" class="btn btn-sm btn-outline-secondary">Cancel</a></td>
							</tr>
						{/foreach}
					</tbody>
				</table>
				{/if}

				<h5>Recent history</h5>
				<table class="table table-sm">
					<thead><tr><th>Book</th><th>Borrower</th><th>Out</th><th>Returned</th><th>Status</th></tr></thead>
					<tbody>
						{foreach item=l from=$history}
							<tr>
								<td>{$l.book_nom|xss_protect}</td>
								<td>{$l.borrower|xss_protect}</td>
								<td><small>{$l.date_out}</small></td>
								<td><small>{$l.date_in}</small></td>
								<td>{$l.statut}</td>
							</tr>
						{foreachelse}
							<tr><td colspan="5" class="text-muted">No history yet.</td></tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
