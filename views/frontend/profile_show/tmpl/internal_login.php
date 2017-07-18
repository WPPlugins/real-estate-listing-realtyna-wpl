<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

$this->_wpl_import($this->tpl_path.'.scripts.login', true, ($this->wplraw ? false : true));
?>
<div class="wpl-user-login-register" id="wpl_user_login_register_container">
    <div id="wpl_user_login_register_form_container">

        <form id="wpl_user_login_register_form" class="wpl-gen-form-wp wpl-login-register-form-wp" method="POST" onsubmit="wpl_user_logreg(); return false;">

            <div class="wpl-util-hidden" id="wpl_user_login_register_form_register">

                <div class="wpl-gen-form-row">
                    <label for="wpl_lr_email"><?php echo __('Email', 'wpl'); ?>: </label>
                    <input type="email" name="email" id="wpl_lr_email" autocomplete="off" />
                </div>
                
                <div class="wpl-gen-form-row">
                    <label for="wpl_lr_first_name"><?php echo __('First Name', 'wpl'); ?>: </label>
                    <input type="text" name="first_name" id="wpl_lr_first_name" autocomplete="off" />
                </div>
                
                <div class="wpl-gen-form-row">
                    <label for="wpl_lr_last_name"><?php echo __('Last Name', 'wpl'); ?>: </label>
                    <input type="text" name="last_name" id="wpl_lr_last_name" autocomplete="off" />
                </div>
                
                <div class="wpl-gen-form-row">
                    <label for="wpl_lr_tel"><?php echo __('Tel', 'wpl'); ?>: </label>
                    <input type="text" name="tel" id="wpl_lr_tel" autocomplete="off" />
                </div>

            </div>

            <div id="wpl_user_login_register_form_login" class="wpl-gen-form-wp">

                <div class="wpl-gen-form-row">
                    <label for="wpl_lr_username"><?php echo __('Username', 'wpl'); ?>: </label>
                    <input type="text" name="username" id="wpl_lr_username" autocomplete="off" />
                </div>

                <div class="wpl-gen-form-row">
                    <label for="wpl_lr_password"><?php echo __('Password', 'wpl'); ?>: </label>
                    <input type="password" name="password" id="wpl_lr_password" autocomplete="off" />
                </div>

            </div>
            <div class="wpl-gen-form-row last wpl-row wpl-expanded clearfix">
                <div id="wpl_user_login_register_toggle" class="wpl-toggle-btns wpl-small-6 wpl-medium-6 wpl-large-6 wpl-column">
                    <div class="wpl-util-hidden" id="wpl_user_login_register_toggle_register">
                        <?php echo sprintf(__('Already a member? %s', 'wpl'), '<a href="#" class="wpl-gen-link" onclick="wpl_user_logreg_toggle(\'login\');return false;">'.__('Login', 'wpl').'</a>'); ?>
                    </div>
                    <div id="wpl_user_login_register_toggle_login">
                        <?php echo sprintf(__('Not a member? %s', 'wpl'), '<a href="#" class="wpl-gen-link" onclick="wpl_user_logreg_toggle(\'register\');return false;">'.__('Register', 'wpl').'</a>'); ?>
                    </div>
                </div>
                <div class="wpl-util-right wpl-small-6 wpl-medium-6 wpl-large-6 wpl-column">
                    <button type="submit" class="wpl-gen-btn-1 wpl-util-hidden" id="wpl_user_login_register_register_submit"><?php echo __('Register & Continue', 'wpl'); ?></button>
                    <button type="submit" class="wpl-gen-btn-1" id="wpl_user_login_register_login_submit"><?php echo __('Login & Continue', 'wpl'); ?></button>
                </div>
            </div>

            <input type="hidden" name="wpl_function" value="login" id="wpl_user_logreg_guest_method" />
            <input type="hidden" name="token" id="wpl_user_login_register_token" value="<?php echo $this->wpl_security->token(); ?>" />

        </form>

        <div id="wpl_user_login_register_form_show_messages"></div>

    </div>
</div>