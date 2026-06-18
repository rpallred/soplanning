{* Smarty *}
{include file="www_header.tpl"}

<div class="container-fluid" style="margin-top:60px;">
	<div class="row">
		<div class="col-md-11 offset-md-1">
			<div class="soplanning-box">
				<h4><i class="fa fa-inbox" aria-hidden="true"></i>&nbsp;Booking Requests</h4>
				<p class="text-muted">Approving a request checks the book out to the requester (today). It is blocked while the book is already out.</p>

				<table class="table table-sm">
					<thead class="thead-light">
						<tr><th>Requester</th><th>Book</th><th>From</th><th>Until</th><th>Note</th><th>Status</th><th></th></tr>
					</thead>
					<tbody>
						{foreach item=r from=$rows}
							<tr {if $r.statut == 'pending'}class="table-warning"{/if}>
								<td>{$r.requester_name|xss_protect}</td>
								<td>{$r.resource_name|xss_protect}{if $r.book_out && $r.statut == 'pending'}<br><small class="text-danger">currently out</small>{/if}</td>
								<td>{$r.date_debut}</td>
								<td>{$r.date_fin}</td>
								<td><small>{$r.note|xss_protect}</small></td>
								<td>
									{if $r.statut == 'pending'}<span class="badge badge-warning">Pending</span>
									{elseif $r.statut == 'approved'}<span class="badge badge-success">Approved</span>
									{else}<span class="badge badge-secondary">Denied</span>{/if}
								</td>
								<td style="white-space:nowrap;">
									{if $r.statut == 'pending'}
										<a href="{$BASE}/process/booking_request_save?action=approve&request_id={$r.request_id}&crsf={$smarty.session.CRSF}" class="btn btn-success btn-sm" onClick="return confirm('Approve and check this book out to the requester?');">Approve</a>
										<a href="{$BASE}/process/booking_request_save?action=deny&request_id={$r.request_id}&crsf={$smarty.session.CRSF}" class="btn btn-outline-danger btn-sm" onClick="return confirm('Deny this request?');">Deny</a>
									{else}
										<small class="text-muted">{$r.decided_at}</small>
									{/if}
								</td>
							</tr>
						{foreachelse}
							<tr><td colspan="7" class="text-muted">No requests.</td></tr>
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
