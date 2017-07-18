<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
?>
<div class="pwizard-panel">
    <div class="pwizard-section noti-wp">
        <div class="prow">
            <label for="wpl_subject"><?php echo __('Subject', 'wpl'); ?>:</label>
            <input type="text" name="info[subject]" id="wpl_subject" value="<?php echo $this->notification->subject; ?>" />
        </div>
        <div class="prow">
            <label for="wpl_description"><?php echo __('Description', 'wpl'); ?>:</label>
            <textarea name="info[description]" id="wpl_description" rows="5"><?php echo $this->notification->description; ?></textarea>
            <input type="hidden" name="info[template_path]" value="<?php echo $this->notification->template;?>" />
        </div>
        <div class="prow">
            <label for="wpl_template"><?php echo __('Email Template', 'wpl'); ?>:</label>
            <?php wp_editor($this->template, 'wpl_template', array('textarea_name'=>'info[template]', 'teeny'=>true)); ?>
        </div>

        <!-- Check SMS add-on -->
        <?php if(wpl_global::check_addon('sms')): ?>
        <div class="prow">
            <label for="wpl_sms_template"><?php echo __('SMS Template', 'wpl'); ?>:</label> <br>
            <textarea name="info[wpl_sms_template]" id="wpl_sms_template" cols="30" rows="10"><?php echo $this->sms_template; ?></textarea>
        </div>
        <?php endif; ?>
    </div>
</div>