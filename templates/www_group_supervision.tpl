{* Smarty *}
{include file="www_header.tpl"}

<div class="container-fluid" style="margin-top:60px;">
	<div class="row">
		<div class="col-md-11 offset-md-1">
			<div class="soplanning-box">
				<h4><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Group Supervision</h4>
				<p class="text-muted">Recurring group sessions led by a supervisor (BHC I and up). Add trainees as members.</p>

				<h5>Create a group</h5>
				<form method="POST" action="{$BASE}/process/group_supervision_save" class="form-inline" style="margin-bottom:25px;">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="add_group">
					<input type="text" name="libelle" class="form-control" placeholder="group name" maxlength="100" required>&nbsp;
					<label>&nbsp;led by&nbsp;</label>
					<select name="lead_ref" class="form-control" required>
						<option value="">-- leader --</option>
						{foreach item=s from=$supervisors}<option value="{$s.ressource_id|escape}">{$s.nom|xss_protect}{if $s.level_label} &mdash; {$s.level_label}{/if}</option>{/foreach}
					</select>&nbsp;
					<select name="jour_semaine" class="form-control">
						<option value="">day…</option>
						<option value="1">Mon</option><option value="2">Tue</option><option value="3">Wed</option>
						<option value="4">Thu</option><option value="5">Fri</option><option value="6">Sat</option><option value="7">Sun</option>
					</select>&nbsp;
					from <input type="time" name="heure_debut" class="form-control" value="12:00">&nbsp;
					to <input type="time" name="heure_fin" class="form-control" value="13:00">&nbsp;
					<button type="submit" class="btn btn-primary">Add group</button>
				</form>

				{foreach item=g from=$groups}
					<div class="soplanning-box" style="background:#f8f9fa;margin-bottom:15px;">
						<h5>
							{$g.libelle|xss_protect}
							<small class="text-muted">&mdash; led by {$g.lead|xss_protect}{if $g.schedule} &middot; {$g.schedule}{/if}</small>
							<a href="{$BASE}/process/group_supervision_save?action=del_group&group_id={$g.group_id}&crsf={$smarty.session.CRSF}" onClick="return confirm('Delete this group and its membership?');" class="text-danger" style="font-size:14px;">&nbsp;<i class="fa fa-trash-o"></i></a>
						</h5>
						<table class="table table-sm" style="max-width:500px;">
							<tbody>
								{foreach item=m from=$g.members}
									<tr>
										<td>{$m.nom|xss_protect}</td>
										<td style="width:40px;"><a href="{$BASE}/process/group_supervision_save?action=del_member&group_id={$g.group_id}&trainee_id={$m.user_id|escape:'url'}&crsf={$smarty.session.CRSF}" title="Remove" class="text-muted"><i class="fa fa-times-circle"></i></a></td>
									</tr>
								{foreachelse}
									<tr><td class="text-muted">No members yet.</td></tr>
								{/foreach}
							</tbody>
						</table>
						<form method="POST" action="{$BASE}/process/group_supervision_save" class="form-inline">
							<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
							<input type="hidden" name="action" value="add_member">
							<input type="hidden" name="group_id" value="{$g.group_id}">
							<select name="trainee_id" class="form-control" required>
								<option value="">-- add trainee --</option>
								{foreach item=t from=$trainees}<option value="{$t.user_id|escape}">{$t.nom|xss_protect}</option>{/foreach}
							</select>&nbsp;
							<button type="submit" class="btn btn-outline-primary btn-sm">Add member</button>
						</form>
					</div>
				{foreachelse}
					<p class="text-muted">No groups yet.</p>
				{/foreach}
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
