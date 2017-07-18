<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/**
 * Search Widget Shortcode for Divi Builder
 * @author Howard <howard@realtyna.com>
 * @package WPL PRO
 */
class wpl_page_builders_divi_widget_search extends ET_Builder_Module
{
    public function init()
    {
        $this->name = __('WPL Search Widget', 'wpl');
        $this->slug = 'et_pb_wpl_widget_search';
        $this->fb_support = false;

        $this->whitelisted_fields = array();
		$this->fields_defaults = array();
        
        // Global WPL Settings
		$this->settings = wpl_global::get_settings();
	}
    
    public function get_fields()
    {
        // Module Fields
        $fields = array();
        
        $widgets_list = wpl_widget::get_existing_widgets();
        
        $widgets_list_options = array();
        foreach($widgets_list as $sidebar=>$widgets)
        {
            if($sidebar == 'wp_inactive_widgets') continue;
            
            foreach($widgets as $widget)
            {
                if(strpos($widget['id'], 'wpl_search_widget') === false) continue;
                $widgets_list_options[$widget['id']] = esc_html__(ucwords(str_replace('_', ' ', $widget['id'])), 'wpl');
            }
        }
        
        $fields['id'] = array(
            'label'           => esc_html__('Widget', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $widgets_list_options,
            'description'     => esc_html__('Select your desired search widget to show. if there is no widget in the list, Please configure some in Appearance->Widgets menu. You can put them inside of WPL Hidden sidebar.', 'wpl'),
        );

		return $fields;
	}
    
    public function shortcode_callback($atts, $content = NULL, $function_name = NULL)
    {
        $shortcode_atts = '';
        foreach($atts as $key=>$value)
        {
            if(trim($value) == '' or $value == '-1') continue;
            
            $shortcode_atts .= $key.'="'.$value.'" ';
        }
        
        return do_shortcode('[wpl_widget_instance'.(trim($shortcode_atts) ? ' '.trim($shortcode_atts) : '').']');
    }
}