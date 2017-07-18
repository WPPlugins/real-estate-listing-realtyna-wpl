<?php
/** no direct access * */
defined('_WPLEXEC') or die('Restricted access');

_wpl_import('libraries.widgets');
_wpl_import('libraries.activities');

class wpl_links_widget extends wpl_widget
{
    public $wpl_tpl_path = 'widgets.links.tmpl';
    public $wpl_backend_form = 'widgets.links.form';
    public $widget_id;
    public $widget_uq_name; # widget unique name
    public $data;

    public function __construct()
    {
        parent::__construct('wpl_links_widget', __('(WPL) Links', 'wpl'), array('description'=>__('Let you to show Register/Login/Forgot Password Links.', 'wpl')));
    }

    /**
     * How to display the widget on the screen.
     */
    public function widget($args, $instance)
    {
        $this->widget_id = $this->number;
        if($this->widget_id < 0) $this->widget_id = abs($this->widget_id)+1000;
        
        $this->widget_uq_name = 'wplus'.$this->widget_id;
        
        echo $args['before_widget'];

        $this->title = apply_filters('widget_title', $instance['title']);
        $this->data = $instance['data'];
        if(class_exists('wpl_global') and wpl_global::check_addon('pro')) $this->compare_url = wpl_addon_pro::compare_get_url();

        $this->css_class = isset($this->data['css_class']) ? $this->data['css_class'] : '';
        $this->layout = isset($instance['layout']) ? $instance['layout'] : 'default';
        $this->register_link = isset($instance['register_link']) ? $instance['register_link'] : '1';
        $this->login_link = isset($instance['login_link']) ? $instance['login_link'] : '1';
        $this->forget_password_link = isset($instance['forget_password_link']) ? $instance['forget_password_link'] : '1';
        $this->dashboard_link = isset($instance['dashboard_link']) ? $instance['dashboard_link'] : '1';
        $this->compare_link = isset($instance['compare_link']) ? $instance['compare_link'] : '1';

        $layout = 'widgets.links.tmpl.default';
        $layout = _wpl_import($layout, true, true);
        
        if(wpl_file::exists($layout)) require $layout;
        else echo __('Widget Layout Not Found!', 'wpl');

        echo $args['after_widget'];
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    public function form($instance)
    {
        $this->widget_id = $this->number;
        
        /** Set up some default widget settings. **/
        if(!isset($instance['layout']))
        {
            $instance = array('title'=>__('Links', 'wpl'), 'layout'=>'default',
                'data'=>array(
                    'css_class'=>'',
            ));
			
			$defaults = array();
            $instance = wp_parse_args((array) $instance, $defaults);
        }
        
        $path = _wpl_import($this->wpl_backend_form, true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Update the widget settings.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['layout'] = $new_instance['layout'];
        $instance['register_link'] = $new_instance['register_link'];
        $instance['login_link'] = $new_instance['login_link'];
        $instance['forget_password_link'] = $new_instance['forget_password_link'];
        $instance['dashboard_link'] = $new_instance['dashboard_link'];
        $instance['compare_link'] = $new_instance['compare_link'];
        $instance['data'] = (array) $new_instance['data'];

        
        return $instance;
    }
}