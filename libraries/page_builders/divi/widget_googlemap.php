<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/**
 * Tags Widget Shortcode for Divi Builder
 * @author Howard <howard@realtyna.com>
 * @package WPL PRO
 */
class wpl_page_builders_divi_widget_googlemap extends ET_Builder_Module
{
    public function init()
    {
        $this->name = __('WPL Google Maps Widget', 'wpl');
        $this->slug = 'et_pb_wpl_widget_googlemap';
        $this->fb_support = false;

        $this->whitelisted_fields = array();
		$this->fields_defaults = array();
        
        // Global WPL Settings
		$this->settings = wpl_global::get_settings();
	}
    
    public function get_fields()
    {
        $googlemap = new wpl_googlemap_widget();
        
        // Module Fields
        $fields = array();
        
        $fields['title'] = array(
            'label'           => esc_html__('Title', 'wpl'),
            'type'            => 'text',
            'option_category' => 'basic_option',
            'description'     => esc_html__('The widget title', 'wpl'),
        );
        
        $widget_layouts = $googlemap->get_layouts('googlemap');
        
        $widget_layouts_options = array();
        foreach($widget_layouts as $widget_layout) $widget_layouts_options[str_replace('.php', '', $widget_layout)] = esc_html__(ucfirst(str_replace('.php', '', $widget_layout)), 'wpl');
        
        $fields['tpl'] = array(
            'label'           => esc_html__('Layout', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $widget_layouts_options,
        );
        
        $fields['css_class'] = array(
            'label'           => esc_html__('CSS Class', 'wpl'),
            'type'            => 'text',
            'option_category' => 'basic_option',
        );

		return $fields;
	}
    
    public function shortcode_callback($atts, $content = NULL, $function_name = NULL)
    {
        ob_start();
        
        $googlemap = new wpl_googlemap_widget();
        $googlemap->widget(array(
            'before_widget'=>'',
            'after_widget'=>'',
            'before_title'=>'',
            'after_title'=>'',
        ),
        array
        (
            'title'=>isset($atts['title']) ? $atts['title'] : '',
            'layout'=>isset($atts['tpl']) ? $atts['tpl'] : '',
            'data'=>array(
                'css_class'=>isset($atts['css_class']) ? $atts['css_class'] : '',
            )
        ));
        
        return ob_get_clean();
    }
}