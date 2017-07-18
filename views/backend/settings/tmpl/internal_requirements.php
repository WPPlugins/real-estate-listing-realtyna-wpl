<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
?>
<div class="wpl-requirements-container">
	<ul>
        <!-- Headers -->
        <li class="header">
            <span class="wpl-requirement-name"></span>
            <span class="wpl-requirement-require"><?php echo __('Requirement', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo __('Current', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<?php echo __('Status', 'wpl'); ?>
            </span>
        </li>
        <!-- Web Server -->
        <?php
            $webserver_name = strtolower(wpl_request::getVar('SERVER_SOFTWARE', 'UNKNOWN', 'SERVER'));
            $webserver = (strpos($webserver_name, 'apache') !== false or strpos($webserver_name, 'nginx') !== false) ? true : false;
        ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('Web server', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Standard', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $webserver ? __('Yes', 'wpl') : __('No', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $webserver ? 'confirm' : 'warning'; ?>"></i>
            </span>
		</li>
    	<!-- PHP version -->
        <?php $php_version = wpl_global::php_version(); ?>
    	<li>
        	<span class="wpl-requirement-name"><?php echo __('PHP version', 'wpl'); ?></span>
            <span class="wpl-requirement-require">5.3.1</span>
            <span class="wpl-requirement-current"><?php echo $php_version; ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo (!version_compare($php_version, '5.3.1', '>=') ? 'danger' : 'confirm'); ?>"></i>
            </span>
		</li>
        <!-- WP version -->
        <?php $wp_version = wpl_global::wp_version(); ?>
    	<li>
        	<span class="wpl-requirement-name"><?php echo __('WP version', 'wpl'); ?></span>
            <span class="wpl-requirement-require">3.0.1</span>
            <span class="wpl-requirement-current"><?php echo $wp_version; ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo (!version_compare($wp_version, '3.0.1', '>=') ? 'danger' : 'confirm'); ?>"></i>
            </span>
		</li>
        <!-- WP debug -->
        <?php $wp_debug = WP_DEBUG ? true : false; ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('WP debug', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Off', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $wp_debug ? __('On', 'wpl') : __('Off', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $wp_debug ? 'warning' : 'confirm'; ?>"></i>
            </span>
		</li>
        <!-- Upload directory permission -->
        <?php $wpl_writable = substr(sprintf('%o', fileperms(wpl_global::get_upload_base_path())), -4) >= '0755' ? true : false; ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('Upload dir', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Writable', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $wpl_writable ? __('Yes', 'wpl') : __('No', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $wpl_writable ? 'confirm' : 'danger'; ?>"></i>
            </span>
		</li>
        <!-- WPL temporary directory permission -->
        <?php $wpl_tmp_writable = wpl_folder::exists(wpl_global::init_tmp_folder()) ? true : false; ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('tmp directory', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Writable', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $wpl_tmp_writable ? __('Yes', 'wpl') : __('No', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $wpl_tmp_writable ? 'confirm' : 'danger'; ?>"></i>
            </span>
		</li>
        <!-- GD library -->
        <?php $gd = (extension_loaded('gd') && function_exists('gd_info')) ? true : false; ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('GD library', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Installed', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $gd ? __('Installed', 'wpl') : __('Not Installed', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $gd ? 'confirm' : 'danger'; ?>"></i>
            </span>
		</li>
        <!-- CURL -->
        <?php $curl = function_exists('curl_version') ? true : false; ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('CURL', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Installed', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $curl ? __('Installed', 'wpl') : __('Not Installed', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $curl ? 'confirm' : 'danger'; ?>"></i>
            </span>
		</li>
        <!-- ZipArchive -->
        <?php $zip_extension = class_exists('ZipArchive') ? true : false; ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('ZipArchive', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Installed', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $zip_extension ? __('Installed', 'wpl') : __('Not Installed', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $zip_extension ? 'confirm' : 'warning'; ?>"></i>
            </span>
		</li>
        <!-- Multibyte String -->
        <?php $mb_string = function_exists('mb_get_info') ? true : false; ?>
        <li>
            <span class="wpl-requirement-name"><?php echo __('Multibyte String', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Installed', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $mb_string ? __('Installed', 'wpl') : __('Not Installed', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
                <i class="icon-<?php echo $mb_string ? 'confirm' : 'warning'; ?>"></i>
            </span>
        </li>
        <!-- Safe Mode -->
        <?php $safe = ini_get('safe_mode'); $safe_mode = (!$safe or strtolower($safe) == 'off') ? true : false; ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('Safe Mode', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Off', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $safe_mode ? __('Off', 'wpl') : __('On', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $safe_mode ? 'confirm' : 'warning'; ?>"></i>
            </span>
		</li>
        <!-- Magic Quote -->
        <?php $magic_quote = get_magic_quotes_gpc(); $magic_quote_status = (!$magic_quote) ? true : false; ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('Magic Quote', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Off', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $magic_quote_status ? __('Off', 'wpl') : __('On', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $magic_quote_status ? 'confirm' : 'danger'; ?>"></i>
            </span>
		</li>
        <!-- Memory Limit -->
        <?php $memory_limit = ini_get('memory_limit'); $memory_status = ((int) $memory_limit < 128) ? false : true; ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('Memory Limit', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('128M', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $memory_limit; ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $memory_status ? 'confirm' : 'warning'; ?>"></i>
            </span>
		</li>
        <!-- Write Permission -->
        <?php $writable = (is_writable(WPL_ABSPATH.'libraries'.DS.'services'.DS.'sef.php') and is_writable(WPL_ABSPATH.'widgets'.DS.'search'.DS.'main.php') and is_writable(WPL_ABSPATH.'WPL.php')); ?>
        <li>
        	<span class="wpl-requirement-name"><?php echo __('Write Permission', 'wpl'); ?></span>
            <span class="wpl-requirement-require"><?php echo __('Yes', 'wpl'); ?></span>
            <span class="wpl-requirement-current"><?php echo $writable ? __('Yes', 'wpl') : __('No', 'wpl'); ?></span>
            <span class="wpl-requirement-status p-action-btn">
            	<i class="icon-<?php echo $writable ? 'confirm' : 'danger'; ?>"></i>
            </span>
		</li>
        <!-- Server providers offers -->
        <li class="wpl_server_offers">
        	<a href="http://hosting.realtyna.com/" target="_blank">Cloud real estate web hosting</a><br />
            <a href="http://bluehost.com/track/realtyna" target="_blank">Bluehost WordPress</a>
		</li>
    </ul>
</div>