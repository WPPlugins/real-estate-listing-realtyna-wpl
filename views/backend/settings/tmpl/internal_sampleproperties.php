<?php defined('_WPLEXEC') or die('Restricted access'); /** no direct access **/ ?>

<div class="wpl-sample-properties">
    <div class="wpl_show_message"></div>

	<label class="wpl-gen-panel-label"><?php echo __('Add Samples', 'wpl'); ?>: </label>
    <input type="button" id="wpl_add_sample_properties_btn" class="wpl-button button-1" onclick="wpl_add_sample_properties();" value="<?php echo __('Add Sample Properties', 'wpl'); ?>"/>
			
    <span id="wpl_add_sample_properties_ajax_loader"></span>
	<div class="wpl-util-panel-note wpl-sample-properties-note"><?php echo __('Click here to add up to six sample properties.', 'wpl'); ?></div>
</div>