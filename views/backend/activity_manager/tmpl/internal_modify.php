<?php
/** no direct access * */
defined('_WPLEXEC') or die('Restricted access');
$this->_wpl_import($this->tpl_path . '.scripts.modify_js');
?>
<div class="fanc-content size-width-2" id="wpl_activity_modify_container">
    <h2><?php echo ((!$this->activity_id) ? 'Add Activity' : 'Modify Activity => ' . ((trim($this->activity_data->title) == '') ? $this->activity_data->activity : $this->activity_data->title)); ?></h2>
    <div class="fanc-body">
        <div class="fanc-row fanc-button-row-2">
            <span class="ajax-inline-save" id="wpl_activity_modify_ajax_loader"></span>
            <input class="wpl-button button-1" type="button" value="<?php echo __('Save', 'wpl'); ?>" id="wpl_activity_submit_button" onclick="wpl_save_activity();" />
        </div>
        <div class="col-wp">
            <div class="col-fanc-left">
                <div class="fanc-row fanc-inline-title">
                    <?php echo __('Activity Information', 'wpl'); ?>
                </div>
                <div class="fanc-row">
                    <label for="wpl_title"><?php echo __('Title', 'wpl'); ?>: </label>
                    <input class="text_box" name="info[title]" type="text" id="wpl_title" value="<?php echo isset($this->activity_data->title) ? $this->activity_data->title : ''; ?>" />
                </div>
                <div class="fanc-row">
                    <label id="layout_select_label" for="wpl_layout"><?php echo __('Layout', 'wpl'); ?></label>
                    <select id="wpl_layout" class="text_box" name="info[layout]">
                        <option value="">-----</option>
                        <?php foreach($this->activity_layouts as $activity_layout): ?>
                        <option <?php if(isset($this->activity_raw_name[1]) and $this->activity_raw_name[1] == $activity_layout) echo 'selected="selected"'; ?> value="<?php echo $activity_layout; ?>"><?php echo $activity_layout; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="fanc-row">
                    <label for="wpl_position"><?php echo __('Position', 'wpl'); ?></label>
                    <input class="text_box" name="info[position]" type="text" id="wpl_position" value="<?php echo isset($this->activity_data->position) ? $this->activity_data->position : ''; ?>" />
                </div>
                <div class="fanc-row">
                    <label for="wpl_show_title<?php echo $this->activity_id; ?>"><?php echo __('Show Title', 'wpl'); ?></label>
                    <select class="text_box" id="wpl_show_title<?php echo $this->activity_id; ?>" name="info[show_title]">
                        <option value="1" <?php if(isset($this->activity_data->show_title) and $this->activity_data->show_title == '1') echo 'selected="selected"'; ?>><?php echo __('Yes', 'wpl'); ?></option>
                        <option value="0" <?php if(isset($this->activity_data->show_title) and $this->activity_data->show_title == '0') echo 'selected="selected"'; ?>><?php echo __('No', 'wpl'); ?></option>
                    </select>
                </div>
                <div class="fanc-row">
                    <label for="wpl_enabled<?php echo $this->activity_id; ?>"><?php echo __('Status', 'wpl'); ?></label>
                    <select class="text_box" id="wpl_enabled<?php echo $this->activity_id; ?>" name="info[enabled]">
                        <option value="1" <?php if(isset($this->activity_data->enabled) and $this->activity_data->enabled == '1') echo 'selected="selected"'; ?>><?php echo __('Enabled', 'wpl'); ?></option>
                        <option value="0" <?php if(isset($this->activity_data->enabled) and $this->activity_data->enabled == '0') echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                    </select>
                </div>
                <div class="fanc-row">
                    <label for="wpl_client<?php echo $this->activity_id; ?>"><?php echo __('Site Section', 'wpl'); ?></label>
                    <select class="text_box" id="wpl_client<?php echo $this->activity_id; ?>" name="info[client]">
                        <option value="2" <?php if(isset($this->activity_data->client) and $this->activity_data->client == '2') echo 'selected="selected"'; ?>><?php echo __('Both', 'wpl'); ?></option>
                        <option value="1" <?php if(isset($this->activity_data->client) and $this->activity_data->client == '1') echo 'selected="selected"'; ?>><?php echo __('Backend', 'wpl'); ?></option>
                        <option value="0" <?php if(isset($this->activity_data->client) and $this->activity_data->client == '0') echo 'selected="selected"'; ?>><?php echo __('Frontend', 'wpl'); ?></option>
                    </select>
                </div>
                <div class="fanc-row">
                    <label for="wpl_index"><?php echo __('Index', 'wpl'); ?></label>
                    <input class="text_box" name="info[index]" type="text" id="wpl_index" value="<?php echo isset($this->activity_data->index) ? (float) $this->activity_data->index : '99.00'; ?>" />
                </div>
                <div class="wpl_show_message<?php echo $this->activity_id; ?>"></div>
            </div>
            <div class="col-fanc-right">
                <div class="fanc-row fanc-inline-title">
                    <?php echo __('Options', 'wpl'); ?>
                </div>
                <div id="options_section">
                <?php
                    /** including activity option form **/
                    $options_form = wpl_activity::get_activity_option_form($this->activity_raw_name[0]);
                    if($options_form) include($options_form);
                ?>
                </div>
            </div>
        </div>
        <div class="col-wp">
            <div class="col-fanc-bottom wpl-fanc-full-row">
                <div class="fanc-row fanc-inline-title">
                    <?php echo __('Page Association', 'wpl'); ?>
                </div>
                <div class="fanc-row">
                    <?php if(!wpl_global::check_addon('pro')): ?>
                    <p><?php echo __('The PRO Add-on must be installed for this feature.', 'wpl'); ?></p>
                    <?php else: ?>
                    <label for="wpl_page_association<?php echo $this->activity_id; ?>"><?php echo __('Association', 'wpl'); ?></label>
                    <select class="select_box" id="wpl_page_association<?php echo $this->activity_id; ?>" name="info[association_type]" onchange="wpl_page_association_selected('<?php echo $this->activity_id; ?>');">
                        <option value="1" <?php if(isset($this->activity_data->association_type) and $this->activity_data->association_type == 1) echo 'selected="selected"'; ?>><?php echo __('Show on all pages', 'wpl'); ?></option>
                        <option value="2" <?php if(isset($this->activity_data->association_type) and $this->activity_data->association_type == 2) echo 'selected="selected"'; ?>><?php echo __('Show on selected pages', 'wpl'); ?></option>
                        <option value="3" <?php if(isset($this->activity_data->association_type) and $this->activity_data->association_type == 3) echo 'selected="selected"'; ?>><?php echo __('Hide on selected pages', 'wpl'); ?></option>
                        <option value="0" <?php if(isset($this->activity_data->association_type) and $this->activity_data->association_type == 0) echo 'selected="selected"'; ?>><?php echo __('Hide on all pages', 'wpl'); ?></option>
                    </select>
                    <div class="wpl-page-list wpl_activity_pages_container" style="<?php if(!isset($this->activity_data->association_type) or (isset($this->activity_data->association_type) and in_array($this->activity_data->association_type, array(0,1)))) echo 'display: none;'; ?>">
                        <?php
                            $pages = wpl_global::get_wp_pages();
                            if(count($pages))
                            {
                                foreach($pages as $page)
                                {
                                    echo '<div class="wpl-page wpl_activity_page_container" id="wpl_activity_page_container'.$page->ID.'">'
                                            . '<input type="checkbox" class="wpl_activity_page_selectbox" name="associations['.$page->ID.']" id="wpl_activity_page_checkbox'.$page->ID.'" '.((isset($this->activity_data->associations) and strpos($this->activity_data->associations, '['.$page->ID.']') !== false) ? 'checked="checked"' : '').' />'
                                            . '<label for="wpl_activity_page_checkbox'.$page->ID.'">'.$page->post_title.'</label>'
                                            . '</div>';
                                }
                            }
                            else
                            {
                                echo __('No pages', 'wpl');
                            }
                        ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-wp">
            <div class="col-fanc-bottom wpl-fanc-full-row">
                <div class="fanc-row fanc-inline-title">
                    <?php echo __('Accesses', 'wpl'); ?>
                </div>
                <div class="fanc-row">
                    <?php if(!wpl_global::check_addon('membership')): ?>
                    <p><?php echo __('Membership Add-on must be installed for this!', 'wpl'); ?></p>
                    <?php else: ?>
                    <label for="accesses<?php echo $this->activity_id; ?>"><?php echo __('Viewable by', 'wpl'); ?></label>
                    <select id="accesses<?php echo $this->activity_id; ?>" name="info[access_type]" onchange="wpl_activity_change_accesses(this.value, <?php echo $this->activity_id; ?>);">
                        <option value="2"><?php echo __('All Users', 'wpl'); ?></option>
                        <option value="1" <?php if(isset($this->activity_data->access_type) and trim($this->activity_data->access_type) == 1) echo 'selected="selected"'; ?>><?php echo __('Selected Users', 'wpl'); ?></option>
                    </select>
                    <?php endif; ?>
                    <div class="wpl_flex_accesses_cnt" id="accesses_cnt<?php echo $this->activity_id; ?>" style="<?php if(!isset($this->activity_data->accesses) or (isset($this->activity_data->accesses) and trim($this->activity_data->accesses) == '')) echo 'display: none;'; ?>">
                        <ul id="accesses_ul<?php echo $this->activity_id; ?>" class="wpl_accesses_ul">
                            <?php
                            $accesses = (isset($this->activity_data->accesses) and trim($this->activity_data->accesses)) ? explode(',', $this->activity_data->accesses) : array();
                            foreach($this->memberships as $membership)
                            {
                                ?>
                                <li><input name="accesses[<?php echo $membership->id; ?>]" id="wpl_activity_membership_checkbox<?php echo $membership->id; ?>" type="checkbox" value="1" <?php if(!isset($this->activity_data->accesses) or (isset($this->activity_data->accesses) and trim($this->activity_data->accesses) == '') or in_array($membership->id, $accesses)) echo 'checked="checked"'; ?> /><label class="wpl_specific_label" for="wpl_activity_membership_checkbox<?php echo $membership->id; ?>">&nbsp;<?php echo __($membership->membership_name, 'wpl'); ?></label></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="info[activity]" value="<?php echo $this->activity_raw_name[0]; ?>" />
        <?php if($this->activity_id): ?>
        <input type="hidden" name="info[activity_id]" value="<?php echo $this->activity_id; ?>" />
        <?php endif; ?>
    </div>
</div>