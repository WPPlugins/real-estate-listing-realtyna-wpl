<?php
/** no direct access * */
defined('_WPLEXEC') or die('Restricted access');
?>
<div class="wpl_links_widget_backend_form wpl-widget-form-wp" id="<?php echo $this->get_field_id('wpl_links_widget_container'); ?>">
    
    <div class="wpl-widget-row">
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title', 'wpl'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
    </div>

    <div class="wpl-widget-row">
        <label for="<?php echo $this->get_field_id('layout'); ?>"><?php echo __('Layout', 'wpl'); ?></label>
        <select id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>" class="widefat">
            <?php echo $this->generate_layouts_selectbox('links', $instance); ?>
        </select>
    </div>
    <div class="wpl-widget-row">
        <label for="<?php echo $this->get_field_id('data_css_class'); ?>"><?php echo __('CSS Class', 'wpl'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('data_css_class'); ?>" name="<?php echo $this->get_field_name('data'); ?>[css_class]" value="<?php echo isset($instance['data']['css_class']) ? $instance['data']['css_class'] : ''; ?>" />
    </div>
    <div class="wpl-widget-row">
        <label for="<?php echo $this->get_field_id('register_link'); ?>"><?php echo __('Register Link', 'wpl'); ?></label>
        <select id="<?php echo $this->get_field_id('register_link'); ?>" name="<?php echo $this->get_field_name('register_link'); ?>">
            <option value="1" <?php if(isset($instance['register_link']) and $instance['register_link'] == 1) echo 'selected="selected"'; ?>><?php echo __('Show', 'wpl'); ?></option>
            <option value="0" <?php if(isset($instance['register_link']) and $instance['register_link'] == 0) echo 'selected="selected"'; ?>><?php echo __('Hide', 'wpl'); ?></option>
        </select>
    </div>
    <div class="wpl-widget-row">
        <label for="<?php echo $this->get_field_id('login_link'); ?>"><?php echo __('Login Link', 'wpl'); ?></label>
        <select id="<?php echo $this->get_field_id('login_link'); ?>" name="<?php echo $this->get_field_name('login_link'); ?>">
            <option value="1" <?php if(isset($instance['login_link']) and $instance['login_link'] == 1) echo 'selected="selected"'; ?>><?php echo __('Show', 'wpl'); ?></option>
            <option value="0" <?php if(isset($instance['login_link']) and $instance['login_link'] == 0) echo 'selected="selected"'; ?>><?php echo __('Hide', 'wpl'); ?></option>
        </select>
    </div>
    <div class="wpl-widget-row">
        <label for="<?php echo $this->get_field_id('forget_password_link'); ?>"><?php echo __('Forget Password Link', 'wpl'); ?></label>
        <select id="<?php echo $this->get_field_id('forget_password_link'); ?>" name="<?php echo $this->get_field_name('register_link'); ?>">
            <option value="1" <?php if(isset($instance['forget_password_link']) and $instance['forget_password_link'] == 1) echo 'selected="selected"'; ?>><?php echo __('Show', 'wpl'); ?></option>
            <option value="0" <?php if(isset($instance['forget_password_link']) and $instance['forget_password_link'] == 0) echo 'selected="selected"'; ?>><?php echo __('Hide', 'wpl'); ?></option>
        </select>
    </div>
    <?php if(class_exists('wpl_global') and wpl_global::check_addon('membership')): ?>
    <div class="wpl-widget-row">
        <label for="<?php echo $this->get_field_id('dashboard_link'); ?>"><?php echo __('Dashboard Link', 'wpl'); ?></label>
        <select id="<?php echo $this->get_field_id('dashboard_link'); ?>" name="<?php echo $this->get_field_name('dashboard_link'); ?>">
            <option value="1" <?php if(isset($instance['dashboard_link']) and $instance['dashboard_link'] == 1) echo 'selected="selected"'; ?>><?php echo __('Show', 'wpl'); ?></option>
            <option value="0" <?php if(isset($instance['dashboard_link']) and $instance['dashboard_link'] == 0) echo 'selected="selected"'; ?>><?php echo __('Hide', 'wpl'); ?></option>
        </select>
    </div>
    <?php endif; ?>
    <?php if(class_exists('wpl_global') and wpl_global::check_addon('pro')): ?>
    <div class="wpl-widget-row">
        <label for="<?php echo $this->get_field_id('compare_link'); ?>"><?php echo __('Property Compare Link', 'wpl'); ?></label>
        <select id="<?php echo $this->get_field_id('compare_link'); ?>" name="<?php echo $this->get_field_name('compare_link'); ?>">
            <option value="1" <?php if(isset($instance['compare_link']) and $instance['compare_link'] == 1) echo 'selected="selected"'; ?>><?php echo __('Show', 'wpl'); ?></option>
            <option value="0" <?php if(isset($instance['compare_link']) and $instance['compare_link'] == 0) echo 'selected="selected"'; ?>><?php echo __('Hide', 'wpl'); ?></option>
        </select>
    </div>
    <?php endif; ?>
</div>