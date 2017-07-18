<?php   
defined('_WPLEXEC') or die('Restricted access');

echo $args['before_title'].__($this->title, 'wpl').$args['after_title'];
?>

<div class="wpl_links_widget_container <?php echo $this->css_class; ?>">
    <?php
        extract(shortcode_atts(array(
            'registericon'=>'wpl-font-user',
            'loginicon'=>'wpl-font-login',
            'forgeticon'=>'wpl-font-forget-password',
            'dashboardicon'=>'wpl-font-dashboard',
            'logouticon'=>'wpl-font-logout',
            'compareicon' => 'wpl-font-compare2'
        ), $instance));

        $loginstr = '<div class="wpl-login-box"><ul>';
        if(!is_user_logged_in())
        {
            if($this->login_link)
                $loginstr .= '<li><a href="'.wp_login_url().'"><i class="'.$loginicon.'" aria-hidden="true"></i> '.__('Login to Account', 'wpl').'</a></li>';
            if($this->forget_password_link)
                $loginstr .= '<li><a href="'.wp_lostpassword_url().'"><i class="'.$forgeticon.'" aria-hidden="true"></i> '.__('Forget Password', 'wpl').'</a></li>';

            if(get_option('users_can_register') && $this->register_link)
                $loginstr .= '<li><a href="'.wp_registration_url().'"><i class="'.$registericon.'" aria-hidden="true"></i> '.__('Register', 'wpl').'</a></li>';
        }
        else
        {
            if(class_exists('wpl_global') and wpl_global::check_addon('membership') and wpl_global::get_setting('membership_user_action_urls') == '1' and $this->dashboard_link )
            {
                $membership = new wpl_addon_membership();
                $loginstr .= '<li><a href="'.$membership->URL('dashboard').'"><i class="'.$dashboardicon.'" aria-hidden="true"></i> '.__('Dashboard', 'wpl').'</a></li>';
            }

            if($this->login_link)
                $loginstr .= '<li><a href="'.wp_logout_url().'"><i class="'.$logouticon.'" aria-hidden="true"></i> '.__('Logout', 'wpl').'</a></li>';
        }

        if(class_exists('wpl_global') and wpl_global::check_addon('pro') and $this->compare_link)
        {
            $loginstr .= '<li><a href="'.$this->compare_url.'"><i class="'.$compareicon.'" aria-hidden="true"></i> '.__('Compare', 'wpl').'</a></li>';
        }

        $loginstr .= '</ul></div>';

        echo $loginstr;
    ?>
</div>
