{* Smarty *}
{include file="www_header.tpl"}

<div class="container">
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<div class="soplanning-box">
				<h4><i class="fa fa-user-md" aria-hidden="true"></i>&nbsp;Supervision &amp; Coverage Report</h4>

				<form method="GET" action="{$BASE}/supervision_report" class="form-inline" style="margin-bottom:20px;">
					<label>Trainee:&nbsp;</label>
					<select name="trainee_id" class="form-control" onchange="this.form.submit()">
						{foreach item=t from=$trainees}
							<option value="{$t.user_id|escape}" {if $t.user_id == $selectedTrainee}selected{/if}>{$t.nom|xss_protect}</option>
						{/foreach}
					</select>
					&nbsp;on&nbsp;
					<input type="date" name="date" class="form-control" value="{$date}">
					&nbsp;<button type="submit" class="btn btn-primary">Show</button>
					&nbsp;<a href="{$BASE}/supervision?trainee_id={$selectedTrainee|escape}" class="btn btn-outline-secondary btn-sm">Manage assignments</a>
				</form>

				<p>For <strong>{$traineeName|xss_protect}</strong> on <strong>{$date}</strong>:</p>
				<table class="table table-bordered">
					<thead class="thead-light">
						<tr><th>Function</th><th>Assigned supervisor</th><th>Effective (today)</th></tr>
					</thead>
					<tbody>
						{foreach item=r from=$rows}
							<tr {if $r.is_covered}class="table-warning"{/if}>
								<td>{$r.fonction}</td>
								<td>{$r.base|xss_protect}</td>
								<td>
									<strong>{$r.effective|xss_protect}</strong>
									{if $r.is_covered}<br><small class="text-muted"><i class="fa fa-exchange"></i> covering for {$r.base|xss_protect}</small>{/if}
								</td>
							</tr>
						{foreachelse}
							<tr><td colspan="3" class="text-muted">No trainee selected.</td></tr>
						{/foreach}
					</tbody>
				</table>
				<p class="text-muted"><small>A highlighted row means someone is covering that function on this date.</small></p>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
