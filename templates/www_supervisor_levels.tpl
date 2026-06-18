{* Smarty *}
{include file="www_header.tpl"}

<div class="container" style="margin-top:60px;">
	<div class="row">
		<div class="col-md-11 offset-md-1">
			<div class="soplanning-box">
				<h4><i class="fa fa-tags" aria-hidden="true"></i>&nbsp;Supervisor Levels</h4>
				<p class="text-muted">Define the supervisor levels your site uses and what each can do:
					<strong>Lead group</strong> (lead a group-supervision session),
					<strong>Cover</strong> (provide/cover individual supervision),
					<strong>Assignable</strong> (be assigned as a trainee's principal supervisor).
					Supervisors with no level set are unrestricted.</p>

				<form method="POST" action="{$BASE}/process/supervisor_levels_save">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="save_all">
					<table class="table table-sm">
						<thead class="thead-light">
							<tr><th style="width:90px;">Order</th><th>Label</th><th class="text-center">Lead group</th><th class="text-center">Cover</th><th class="text-center">Assignable</th><th>In use</th><th></th></tr>
						</thead>
						<tbody>
							{foreach item=l from=$levels}
								<tr>
									<td><input type="number" name="ordre[{$l.level_id}]" value="{$l.ordre}" class="form-control form-control-sm" style="width:75px;"></td>
									<td><input type="text" name="label[{$l.level_id}]" value="{$l.label|escape}" class="form-control form-control-sm" maxlength="60" required>
										<small class="text-muted">code: {$l.code|escape}</small></td>
									<td class="text-center"><input type="checkbox" name="lead_group[{$l.level_id}]" {if $l.lead_group == 'oui'}checked{/if}></td>
									<td class="text-center"><input type="checkbox" name="cover[{$l.level_id}]" {if $l.cover == 'oui'}checked{/if}></td>
									<td class="text-center"><input type="checkbox" name="assignable[{$l.level_id}]" {if $l.assignable == 'oui'}checked{/if}></td>
									<td><small class="text-muted">{$l.in_use}</small></td>
									<td><a href="{$BASE}/process/supervisor_levels_save?action=delete&level_id={$l.level_id}&crsf={$smarty.session.CRSF}" onClick="return confirm('Delete this level? Any supervisors at this level will be set to no level.');" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
								</tr>
							{foreachelse}
								<tr><td colspan="7" class="text-muted">No levels defined.</td></tr>
							{/foreach}
						</tbody>
					</table>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</form>

				<hr>
				<h5>Add a level</h5>
				<form method="POST" action="{$BASE}/process/supervisor_levels_save" class="form-inline">
					<input type="hidden" name="crsf" value="{$smarty.session.CRSF}">
					<input type="hidden" name="action" value="add">
					<input type="text" name="label" class="form-control" placeholder="Level name" maxlength="60" required>&nbsp;
					<label class="ml-2">&nbsp;<input type="checkbox" name="lead_group" checked> Lead group</label>&nbsp;
					<label class="ml-2">&nbsp;<input type="checkbox" name="cover"> Cover</label>&nbsp;
					<label class="ml-2">&nbsp;<input type="checkbox" name="assignable"> Assignable</label>&nbsp;
					<button type="submit" class="btn btn-outline-primary">Add level</button>
				</form>
			</div>
		</div>
	</div>
</div>

{include file="www_footer.tpl"}
