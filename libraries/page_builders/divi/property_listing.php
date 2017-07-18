<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/**
 * Property Listing Shortcode for Divi Builder
 * @author Howard <howard@realtyna.com>
 * @package WPL PRO
 */
class wpl_page_builders_divi_property_listing extends ET_Builder_Module
{
    public function init()
    {
        $this->name = __('Property Listing', 'wpl');
        $this->slug = 'et_pb_wpl_property_listing';
        $this->fb_support = false;

        $this->whitelisted_fields = array(
			'wplcolumns',
		);
        
		$this->fields_defaults = array(
			'wplcolumns' => array('3'),
		);
        
        // Global WPL Settings
		$this->settings = wpl_global::get_settings();
	}
    
    public function get_fields()
    {
        // Module Fields
        $fields = array();
        
        $kinds = wpl_flex::get_kinds('wpl_properties');
        
        $kinds_options = array();
        foreach($kinds as $kind) $kinds_options[$kind['id']] = esc_html__($kind['name'], 'wpl');
        
        $fields['kind'] = array(
            'label'           => esc_html__('Kind', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $kinds_options,
            'description'     => esc_html__('Kind/Entity for filtering listings', 'wpl'),
        );
        
        $listings = wpl_global::get_listings();
        
        $listings_options = array();
        $listings_options[''] = '-----';
        
        foreach($listings as $listing) $listings_options[$listing['id']] = esc_html__($listing['name'], 'wpl');
        
        $fields['sf_select_listing'] = array(
            'label'           => esc_html__('Listing Type', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $listings_options,
        );
        
        $property_types = wpl_global::get_property_types();
        
        $property_types_options = array();
        $property_types_options[''] = '-----';
        
        foreach($property_types as $property_type) $property_types_options[$property_type['id']] = esc_html__($property_type['name'], 'wpl');
        
        $fields['sf_select_property_type'] = array(
            'label'           => esc_html__('Property Type', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $property_types_options,
        );
        
        $property_listing_layouts = wpl_global::get_layouts('property_listing', array('message.php'), 'frontend');
        
        $property_listing_layouts_options = array();
        foreach($property_listing_layouts as $property_listing_layout) $property_listing_layouts_options[$property_listing_layout] = esc_html__($property_listing_layout, 'wpl');
        
        $fields['tpl'] = array(
            'label'           => esc_html__('Layout', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $property_listing_layouts_options,
            'description'     => esc_html__('Layout of the page', 'wpl'),
        );
        
        $location_settings = wpl_global::get_settings('3'); # location settings
        
        $fields['sf_locationtextsearch'] = array(
            'label'           => esc_html__('Location', 'wpl'),
            'type'            => 'text',
            'option_category' => 'basic_option',
            'description'     => esc_html__($location_settings['locationzips_keyword'].', '.$location_settings['location3_keyword'].', '.$location_settings['location1_keyword'], 'wpl'),
        );
        
        $units = wpl_units::get_units(4);
        
        $price_unit_options = array();
        foreach($units as $unit) $price_unit_options[$unit['id']] = esc_html__($unit['name'], 'wpl');
        
        $fields['sf_min_price'] = array(
            'label'           => esc_html__('Price (Min)', 'wpl'),
            'type'            => 'number',
            'option_category' => 'basic_option',
            'description'     => esc_html__('Minimum Price of listings', 'wpl'),
        );
        
        $fields['sf_max_price'] = array(
            'label'           => esc_html__('Price (Max)', 'wpl'),
            'type'            => 'number',
            'option_category' => 'basic_option',
            'description'     => esc_html__('Maximum Price of listings', 'wpl'),
        );
        
        $fields['sf_unit_price'] = array(
            'label'           => esc_html__('Price Unit', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $price_unit_options,
            'description'     => esc_html__('Price Unit', 'wpl'),
        );
        
        $tags = wpl_flex::get_tag_fields(0);
        foreach($tags as $tag)
        {
            $fields['sf_select_'.$tag->table_column] = array(
                'label'           => esc_html__($tag->name, 'wpl'),
                'type'            => 'select',
                'option_category' => 'basic_option',
                'options'         => array(
                    '-1' => esc_html__('Any', 'wpl'),
                    '0' => esc_html__('No', 'wpl'),
                    '1' => esc_html__('Yes', 'wpl'),
                ),
            );
        }
        
        $wpl_users = wpl_users::get_wpl_users();
        
        $wpl_users_options = array();
        $wpl_users_options[''] = '-----';
        
        foreach($wpl_users as $wpl_user) $wpl_users_options[$wpl_user->ID] = esc_html__($wpl_user->user_login.((trim($wpl_user->first_name) != '' or trim($wpl_user->last_name) != '') ? ' ('.$wpl_user->first_name.' '.$wpl_user->last_name.')' : ''), 'wpl');
        
        $fields['sf_select_user_id'] = array(
            'label'           => esc_html__('User', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $wpl_users_options,
            'description'     => esc_html__('Filter the listings by a certain agent', 'wpl'),
        );
        
        $pages = wpl_global::get_wp_pages();
        
        $pages_options = array();
        $pages_options[''] = '-----';
        
        foreach($pages as $page) $pages_options[$page->ID] = esc_html__($page->post_title, 'wpl');
        
        $fields['wpltarget'] = array(
            'label'           => esc_html__('Target Page', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $pages_options,
        );
        
        $page_sizes = explode(',', trim($this->settings['page_sizes'], ', '));
        
        $page_sizes_options = array();
        foreach($page_sizes as $page_size) $page_sizes_options[$page_size] = esc_html__($page_size, 'wpl');
        
        $fields['limit'] = array(
            'label'           => esc_html__('Page Size', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $page_sizes_options,
        );
        
        $fields['wplpagination'] = array(
            'label'           => esc_html__('Pagination', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => array(
                '' => '-----',
                'scroll' => esc_html__('Scroll Pagination', 'wpl'),
            ),
        );
        
        $sorts = wpl_sort_options::render(wpl_sort_options::get_sort_options(0, 1));
        
        $sorts_options = array();
        foreach($sorts as $sort) $sorts_options[$sort['field_name']] = esc_html__($sort['name'], 'wpl');
        
        $fields['orderby'] = array(
            'label'           => esc_html__('Order By', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => $sorts_options,
        );
        
        $fields['order'] = array(
            'label'           => esc_html__('Order', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => array(
                'ASC' => esc_html__('Ascending', 'wpl'),
                'DESC' => esc_html__('Descending', 'wpl'),
            ),
        );
        
        $fields['wplcolumns'] = array(
            'label'           => esc_html__('Columns Count', 'wpl'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => array(
                '3' => 3,
                '1' => 1,
                '2' => 2,
                '4' => 4,
                '6' => 6,
            ),
        );

		return $fields;
	}
    
    public function shortcode_callback($atts, $content = NULL, $function_name = NULL)
    {
        $shortcode_atts = '';
        foreach($atts as $key=>$value)
        {
            if(trim($value) == '' or $value == '-1') continue;
            if($key == 'tpl' and $value == 'default') continue;
            
            $shortcode_atts .= $key.'="'.$value.'" ';
        }
        
        return do_shortcode('[WPL'.(trim($shortcode_atts) ? ' '.trim($shortcode_atts) : '').']');
    }
}