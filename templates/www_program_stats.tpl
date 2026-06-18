{* Smarty *}
{include file="www_header.tpl"}

<div class="container-fluid" style="margin-top:60px;">
	<div class="row">
		<div class="col-md-11 offset-md-1">
			<div class="soplanning-box">
				<h4><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;Program Stats</h4>

				<h5 class="mt-3">Completion by cohort</h5>
				<table class="table table-sm table-striped" style="max-width:900px;">
					<thead class="thead-light"><tr><th>Cohort</th><th>People</th><th>Items</th><th>Overall %</th><th>Fully done</th><th>Behind</th></tr></thead>
					<tbody>
						{foreach item=c from=$completionRows}
							<tr>
								<td>{$c.cohort|xss_protect}</td>
								<td>{$c.members}</td>
								<td>{$c.reqs}</td>
								<td><strong>{$c.pct}%</strong></td>
								<td>{$c.fully}/{$c.members}</td>
								<td><small class="text-muted">{$c.behind|xss_protect}{if $c.behind_more} &hellip; +{$c.behind_more} more{/if}</small></td>
							</tr>
						{foreachelse}
							<tr><td colspan="6" class="text-muted">No trainee cohorts.</td></tr>
						{/foreach}
					</tbody>
				</table>

				<h5 class="mt-4">Supervision load</h5>
				<table class="table table-sm" style="max-width:760px;">
					<thead class="thead-light"><tr><th>Supervisor</th><th>Level</th><th>Trainees (principal)</th><th>Functions held</th><th>Active coverages</th></tr></thead>
					<tbody>
						{foreach item=s from=$loadRows}
							<tr>
								<td>{$s.supervisor|xss_protect}</td>
								<td><small class="text-muted">{$s.level|xss_protect}</small></td>
								<td>{$s.principals}</td>
								<td>{$s.functions}</td>
								<td>{if $s.covers}<span class="badge badge-info">{$s.covers}</span>{else}0{/if}</td>
							</tr>
						{foreachelse}
							<tr><td colspan="5" class="text-muted">No supervision assignments.</td></tr>
						{/foreach}
					</tbody>
				</table>

				<h5 class="mt-4">Book circulation</h5>
				<p>
					<span class="badge badge-secondary">Books: {$circ.total}</span>
					<span class="badge badge-primary">Out: {$circ.out}</span>
					<span class="badge {if $circ.overdue}badge-danger{else}badge-success{/if}">Overdue: {$circ.overdue}</span>
					<span class="badge badge-warning">Holds waiting: {$circ.holds}</span>
				</p>
				{if $overdueList}
					<table class="table table-sm" style="max-width:600px;">
						<thead class="thead-light"><tr><th>Book</th><th>Borrower</th><th>Due</th></tr></thead>
						<tbody>
							{foreach item=o from=$overdueList}
								<tr class="table-warning"><td>{$o.book|xss_protect}</td><td>{$o.borrower|xss_protect}</td><td>{$o.date_due}</td></tr>
							{/foreach}
						</tbody>
					</table>
				{/if}

				<h5 class="mt-4">Group supervision</h5>
				<table class="table table-sm" style="max-width:600px;">
					<thead class="thead-light"><tr><th>Group</th><th>Lead</th><th>Members</th></tr></thead>
					<tbody>
						{foreach item=gr from=$groupRows}
							<tr><td>{$gr.group|xss_protect}</td><td>{$gr.lead|xss_protect}</td><td>{$gr.members}</td></tr>
						{foreachelse}
							<tr><td colspan="3" class="text-muted">No groups.</td></tr>
						{/foreach}
					</tbody>
				</table>
				<p class="text-muted"><small>Trainees in no group: {$ungrouped}</small></p>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
