{* Smarty *}
{include file="www_header.tpl"}

<div class="container-fluid" style="margin-top:60px;">
	<div class="row">
		<div class="col-md-11 offset-md-1">
			<div class="soplanning-box">
				<h4><i class="fa fa-tachometer" aria-hidden="true"></i>&nbsp;Program Dashboard</h4>
				<p class="text-muted">Assigned supervision by half (First / Second). For coverage and the
					individual-session / note-signing functions, see <a href="{$BASE}/supervision_report">Supervision Report</a>.</p>

				<div class="row">
					<div class="col-md-6">
						<h5>Trainee &rarr; Supervisor lookup</h5>
						<table class="table table-sm table-striped">
							<thead><tr><th>Trainee</th><th>First Half</th><th>Second Half</th></tr></thead>
							<tbody>
								{foreach item=l from=$lookup}
									<tr>
										<td>{$l.trainee|xss_protect}</td>
										<td>{$l.h1|xss_protect}</td>
										<td>{$l.h2|xss_protect}</td>
									</tr>
								{foreachelse}
									<tr><td colspan="3" class="text-muted">No supervision assignments.</td></tr>
								{/foreach}
							</tbody>
						</table>
					</div>

					<div class="col-md-6">
						<h5>Supervisor load</h5>
						<table class="table table-sm">
							<thead><tr><th>Supervisor</th><th>First Half</th><th>Second Half</th><th>#</th></tr></thead>
							<tbody>
								{foreach item=s from=$loadRows}
									<tr>
										<td>{$s.supervisor|xss_protect}</td>
										<td><small>{$s.h1|xss_protect}</small></td>
										<td><small>{$s.h2|xss_protect}</small></td>
										<td>{$s.total}</td>
									</tr>
								{foreachelse}
									<tr><td colspan="4" class="text-muted">No supervisors assigned.</td></tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
