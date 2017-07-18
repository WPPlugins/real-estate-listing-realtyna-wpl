<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/**
 * Property Show Shortcode for VC
 * @author Howard <howard@realtyna.com>
 * @package WPL PRO
 */
class wpl_page_builders_vc_property_show
{
    public function __construct()
    {
        // Global WPL Settings
		$this->settings = wpl_global::get_settings();
        
        vc_map(array
        (
            'name' => __('Property Show', 'wpl'),
            //'custom_markup' => '<strong>'.__('WPL Property Show', 'wpl').'</strong>',
            'description' => __('Property Details Pages.', 'wpl'),
            'base' => "wpl_property_show",
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
        
        $layouts = wpl_global::get_layouts('property_show', array('message.php'), 'frontend');
        
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
        
        $fields[] = array(
            'heading'         => esc_html__('Listing ID', 'wpl'),
            'type'            => 'textfield',
            'holder'          => 'div',
            'class'           => '',
            'param_name'      => 'mls_id',
            'value'           => '',
            'admin_label'     => true,
            'description'     => esc_html__('Insert the Listing ID that you want to show', 'wpl'),
        );

		return $fields;
	}
}