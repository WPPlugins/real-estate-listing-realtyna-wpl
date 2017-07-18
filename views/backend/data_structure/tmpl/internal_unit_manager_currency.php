<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
$this->_wpl_import($this->tpl_path.'.scripts.internal_unit_manager_js');
?>
<table class="widefat page" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th scope="col" class="manage-column" width="50"><?php echo __('Enabled', 'wpl'); ?></th>
			<th scope="col" class="manage-column" width="50"><?php echo __('Name', 'wpl'); ?></th>
			<th scope="col" class="manage-column"><?php echo __('3digit sep', 'wpl'); ?></th>
			<th scope="col" class="manage-column"><?php echo __('Desimal sep', 'wpl'); ?></th>
			<th scope="col" class="manage-column"><?php echo __('Cur. after/before', 'wpl'); ?></th>
			<th scope="col" class="manage-column">
				<?php echo __('Exchange rate', 'wpl'); ?>
				<button type="button" class="wpl-btn-overlay" onclick="wpl_update_exchange_rates(this);">
					<span class="action-btn icon-recycle-2"></span>
				</button>
				<span class="wpl-loader"></span>
			</th>
			<th scope="col" class="manage-column"><?php echo __('Move', 'wpl'); ?></th>
		</tr>
	</thead>
	<tbody class="sortable_unit">
		<?php foreach($this->units as $id => $unit): ?>
			<tr id="item_row_<?php echo $unit['id']; ?>">
				<td>
					<span class="action-btn enabled_check <?php echo $unit['enabled'] == 1 ? "icon-enabled" : "icon-disabled"; ?>" onclick="wpl_unit_enabled_change(<?php echo $unit['id']; ?>);" id="wpl_ajax_flag_<?php echo $unit['id']; ?>"></span>
					<span class="wpl_ajax_loader" id="wpl_ajax_loader_<?php echo $unit['id']; ?>"></span>
				</td>
				<td>
					<input type="text" value="<?php echo __($unit['name'], 'wpl'); ?>" data-wpl-id="<?php echo $unit['id']; ?>" onchange="wpl_change_unit_name(this);" />
					<span class="wpl-loader"></span>
					<span><?php echo __($unit['extra3'], 'wpl'); ?> ( <?php echo __($unit['extra'], 'wpl'); ?> ) </span>
				</td>
				<td>
					<select class="selectbox" data-wpl-id="<?php echo $unit['id']; ?>" data-wpl-option="seperator" onchange="wpl_change_unit_option(this);">
						<option value=""><?php echo __('No separator', 'wpl'); ?></option>
						<option value="," <?php if($unit['seperator'] == ',') echo 'selected="selected"'; ?>>, (<?php echo __('Comma', 'wpl'); ?>)</option>
						<option value="." <?php if($unit['seperator'] == '.') echo 'selected="selected"'; ?>>. (<?php echo __('Point', 'wpl'); ?>)</option>
					</select>
					<span class="wpl-loader"></span>
				</td>
				<td>
					<select class="selectbox" data-wpl-id="<?php echo $unit['id']; ?>" data-wpl-option="d_seperator" onchange="wpl_change_unit_option(this);">
						<option value=""><?php echo __('No decimal', 'wpl'); ?></option>
						<option value="," <?php if($unit['d_seperator'] == ',') echo 'selected="selected"'; ?>>, (<?php echo __('Comma', 'wpl'); ?>)</option>
						<option value="." <?php if($unit['d_seperator'] == '.') echo 'selected="selected"'; ?>>. (<?php echo __('Point', 'wpl'); ?>)</option>
					</select>
					<span class="wpl-loader"></span>
				</td>
				<td>
					<select class="selectboxmini" data-wpl-id="<?php echo $unit['id']; ?>" data-wpl-option="after_before" onchange="wpl_change_unit_option(this);">
						<option value="0"><?php echo __('Before', 'wpl'); ?></option>
						<option value="1" <?php if($unit['after_before'] == 1) echo 'selected="selected"'; ?>><?php echo __('After', 'wpl'); ?></option>
					</select>
					<span class="wpl-loader"></span>
				</td>
				<td>
					<input type="text" value="<?php echo $unit['tosi']; ?>" data-wpl-id="<?php echo $unit['id']; ?>" data-wpl-role="tosi-input" onchange="wpl_change_unit_tosi(this);" />
					<button type="button" class="wpl-btn-overlay" data-wpl-id="<?php echo $unit['id']; ?>" data-wpl-currency-code="<?php echo $unit['extra'] ?>" onclick="wpl_update_a_exchange_rate(this);">
						<span class="action-btn icon-recycle-2"></span>
					</button>
					<span class="wpl-loader"></span>
				</td>
				<td class="wpl_manager_td">
					<span class="action-btn icon-move" id="extension_move_1"></span>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>