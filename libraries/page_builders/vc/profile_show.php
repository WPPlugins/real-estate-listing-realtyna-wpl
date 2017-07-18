<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/**
 * Profile Show Shortcode for VC
 * @author Howard <howard@realtyna.com>
 * @package WPL PRO
 */
class wpl_page_builders_vc_profile_show
{
    public function __construct()
    {
        // Global WPL Settings
		$this->settings = wpl_global::get_settings();
        
        vc_map(array
        (
            'name' => __('Profile/Agent Show', 'wpl'),
            //'custom_markup' => '<strong>'.__('WPL Profile/Agent Show', 'wpl').'</strong>',
            'description' => __('Profile/Agent Show Pages.', 'wpl'),
            'base' => "wpl_profile_show",
            'class' => '',
            'controls' => 'full',
            'icon' => 'wpb-wpl-icon',
            'category' => __('WPL', 'wpl'),
            'params' => $this->get_fields()
        ));
	}
    
    public function get_fields()
    {
        // Module Fields
        $fields = array();
        
        $layouts = wpl_global::get_layouts('profile_show', array('message.php'), 'frontend');
        
        $layouts_options = array();
        foreach($layouts as $layout) $layouts_options[esc_html__($layout, 'wpl')] = $layout;
        
        $fields[] = array(
            'heading'         => esc_html__('Layout', 'wpl'),
            'type'            => 'dropdown',
            'holder'          => 'div',
            'class'           => '',
            'param_name'      => 'tpl',
            'value'           => $layouts_options,
            'std'             => '',
            'description'     => esc_html__('Layout of the page', 'wpl'),
        );
        
        $wpl_users = wpl_users::get_wpl_users();
        
        $wpl_users_options = array();
        foreach($wpl_users as $wpl_user) $wpl_users_options[esc_html__($wpl_user->user_login.((trim($wpl_user->first_name) != '' or trim($wpl_user->last_name) != '') ? ' ('.$wpl_user->first_name.' '.$wpl_user->last_name.')' : ''), 'wpl')] = $wpl_user->ID;
        
        $fields[] = array(
            'heading'         => esc_html__('User', 'wpl'),
            'type'            => 'dropdown',
            'holder'          => 'div',
            'class'           => '',
            'param_name'      => 'uid',
            'value'           => $wpl_users_options,
            'std'             => '',
            'admin_label'     => true,
            'description'     => esc_html__('The agent to show', 'wpl'),
        );
        
        $pages = wpl_global::get_wp_pages();
        
        $pages_options = array();
        $pages_options['-----'] = '';
        
        foreach($pages as $page) $pages_options[esc_html__($page->post_title, 'wpl')] = $page->ID;
        
        $fields[] = array(
            'heading'         => esc_html__('Target Page', 'wpl'),
            'type'            => 'dropdown',
            'value'           => $pages_options,
            'holder'          => 'div',
            'class'           => '',
            'param_name'      => 'wpltarget',
            'std'             => '',
        );
        
        $fields[] = array(
            'heading'         => esc_html__('Pagination', 'wpl'),
            'type'            => 'dropdown',
            'holder'          => 'div',
            'class'           => '',
            'param_name'      => 'wplpagination',
            'value'           => array(
                '-----' => '',
                esc_html__('Scroll Pagination', 'wpl') => 'scroll',
            ),
            'std'             => '',
        );

		return $fields;
	}
}