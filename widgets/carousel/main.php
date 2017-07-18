<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

_wpl_import('libraries.widgets');
_wpl_import('libraries.flex');
_wpl_import('libraries.property');
_wpl_import('libraries.images');
_wpl_import('libraries.sort_options');

/**
 * WPL Carousel Widget
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update
 */
class wpl_carousel_widget extends wpl_widget
{
	public $wpl_tpl_path = 'widgets.carousel.tmpl';
	public $wpl_backend_form = 'widgets.carousel.form';
	public $listing_specific_array = array();
	public $property_type_specific_array = array();
	public $widget_id;
	public $widget_uq_name; # widget unique name
	
	public function __construct()
	{
		parent::__construct('wpl_carousel_widget', __('(WPL) Carousel', 'wpl'), array('description'=>__('Showing specific properties.', 'wpl')));
	}

	/**
	 * How to display the widget on the screen.
	 */
	public function widget($args, $instance)
	{
		$this->instance = $instance;
        
        $this->widget_id = $this->number;
        if($this->widget_id < 0) $this->widget_id = abs($this->widget_id)+1000;
        
		$this->widget_uq_name = 'wplc'.$this->widget_id;
		$widget_id = $this->widget_id;
        
        $this->css_class = isset($instance['data']['css_class']) ? $instance['data']['css_class'] : '';
        
		/** add main scripts **/
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-slider');
			
		/** render properties **/
		$query = self::query($instance);
        $model = new wpl_property();
		$properties = $model->search($query);
		
        /** return if no property found **/
        if(!count($properties)) return;
        
		$plisting_fields = $model->get_plisting_fields();
		$wpl_properties = array();
        $render_params['wpltarget'] = isset($instance['wpltarget']) ? $instance['wpltarget'] : 0;
        
		foreach($properties as $property)
		{
			$wpl_properties[$property->id] = $model->full_render($property->id, $plisting_fields, $property, $render_params);
		}
		
		echo isset($args['before_widget']) ? $args['before_widget'] : '';
        
        /** apply filters (This filter must place after all proccess) **/
		_wpl_import('libraries.filters');
		@extract(wpl_filters::apply('property_listing_after_render', array('wpl_properties'=>$wpl_properties)));

		$title = apply_filters('widget_title', $instance['title']);
        if(trim($title) != '') echo (isset($args['before_title']) ? $args['before_title'] : '') .$title. (isset($args['after_title']) ? $args['after_title'] : '');
		
		$layout = 'widgets.carousel.tmpl.'.$instance['layout'];
		$layout = _wpl_import($layout, true, true);

        /** Microdata */
        $this->settings = wpl_settings::get_settings();
        $this->microdata = isset($this->settings['microdata']) ? $this->settings['microdata'] : 0;
        $this->itemscope = ($this->microdata) ? 'itemscope' : '';

        $this->itemprop_name = ($this->microdata) ? 'itemprop="name"' : '';
        $this->itemprop_value = ($this->microdata) ? 'itemprop="value"' : '';
        $this->itemprop_image = ($this->microdata) ? 'itemprop="image"' : '';
        $this->itemprop_floorSize = ($this->microdata) ? 'itemprop="floorSize"' : '';
        $this->itemprop_price = ($this->microdata) ? 'itemprop="price"' : '';
        $this->itemprop_url = ($this->microdata) ? 'itemprop="url"' : '';
        $this->itemprop_address = ($this->microdata) ? 'itemprop="address"' : '';
        $this->itemprop_description = ($this->microdata) ? 'itemprop="description"' : '';
        $this->itemprop_additionalProperty = ($this->microdata) ? 'itemprop="additionalProperty"' : '';
        $this->itemprop_addressLocality = ($this->microdata) ? 'itemprop="addressLocality"' : '';
        $this->itemprop_numberOfRooms = ($this->microdata) ? 'itemprop="numberOfRooms"' : '';

        $this->itemtype_PropertyValue = ($this->microdata) ? 'itemtype="http://schema.org/PropertyValue"' : '';
        $this->itemtype_Apartment = ($this->microdata) ? 'itemtype="http://schema.org/Apartment"' : '';
        $this->itemtype_SingleFamilyResidence = ($this->microdata) ? 'itemtype="http://schema.org/SingleFamilyResidence"' : '';
        $this->itemtype_Place = ($this->microdata) ? 'itemtype="http://schema.org/Place"' : '';
        $this->itemtype_PostalAddress = ($this->microdata) ? 'itemtype="http://schema.org/PostalAddress"' : '';
        $this->itemtype_offer = ($this->microdata) ? 'itemtype="http://schema.org/offer"' : '';
        $this->itemtype_QuantitativeValue = ($this->microdata) ? 'itemtype="http://schema.org/QuantitativeValue"' : '';
		
		if(!wpl_file::exists($layout)) $layout = _wpl_import('widgets.carousel.tmpl.default', true, true);
		elseif(wpl_file::exists($layout)) require $layout;
		else echo __('Widget Layout Not Found!', 'wpl');
		
		echo isset($args['after_widget']) ? $args['after_widget'] : '';

	}

	/**
	 * Update the widget settings.
	 */
	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['layout'] = $new_instance['layout'];
        $instance['wpltarget'] = $new_instance['wpltarget'];
		$instance['data'] = (array) $new_instance['data'];
		
        /** random option **/
        if(isset($instance['data']['random']) and $instance['data']['random']) $instance['data']['listing_ids'] = '';
        
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	public function form($instance)
	{
        $this->widget_id = $this->number;
        
		/* Set up some default widget settings. */
		if(!isset($instance['layout']))
		{
			$instance = array('title'=>__('Featured Properties', 'wpl'), 'layout'=>'default.php', 'data'=>array('kind'=>'0', 'limit'=>'8', 'orderby'=>'p.add_date', 'order'=>'DESC', 'image_width'=>'1920', 'image_height'=>'558', 'thumbnail_width'=>'150', 'thumbnail_height'=>'60'));
			$instance = wp_parse_args((array) $instance, NULL);
		}
        
		$path = _wpl_import($this->wpl_backend_form, true, true);
		
		ob_start();
		include $path;
		echo $output = ob_get_clean();
	}
    
    private function query($instance)
	{
        /** property listing model **/
		$model = new wpl_property;
		$data = $instance['data'];
        
		$this->start = 0;
		$this->limit = $data['limit'];
		$this->orderby = urldecode($data['orderby']);
        $this->order = $data['order'];
        
		/** detect kind **/
        if(isset($data['kind']) and (trim($data['kind']) != '' or trim($data['kind']) != '-1')) $kind = $data['kind'];
        else $kind = 0;
		
        $where = array('sf_select_confirmed'=>1, 'sf_select_finalized'=>1, 'sf_select_deleted'=>0, 'sf_select_expired'=>0, 'sf_select_kind'=>$kind);
        
        if(trim($data['listing']) and $data['listing'] != '-1') $where['sf_select_listing'] = $data['listing'];
		if(trim($data['property_type']) and $data['property_type'] != '-1') $where['sf_select_property_type'] = $data['property_type'];
		if(isset($data['listing_ids']) and trim($data['listing_ids'])) $where['sf_multiple_mls_id'] = trim($data['listing_ids'], ', ');
        
        /** Location **/
        for ($i = 2; $i < 8; $i++)
        {
        	if(isset($data["location{$i}_name"]) and trim($data["location{$i}_name"])) $where["sf_select_location{$i}_name"] = $data["location{$i}_name"];
        }

        /** Tags **/
        $tags = wpl_flex::get_fields(NULL, NULL, NULL, NULL, NULL, "AND `type`='tag' AND `enabled`>='1' GROUP BY `table_column`");
        $tag_type = (!isset($data['tag_group_join_type']) OR empty($data['tag_group_join_type'])) ? 'and' : $data['tag_group_join_type'];

        foreach($tags as $tag)
        {
            $tagkey = 'only_'.ltrim($tag->table_column, 'sp_');

            if(isset($data[$tagkey]) and trim($data[$tagkey]))
            {
                if($tag_type == 'and') $where['sf_select_'.$tag->table_column] = 1;
                else $where['sf_groupor_'.$tag->table_column] = 1;
            }
        }
        
        /** Parent **/
        if(isset($data['parent']) and trim($data['parent'])) $where['sf_parent'] = $data['parent'];
        if(isset($data['auto_parent']) and trim($data['auto_parent']))
        {
            /** current proeprty id - This features works only in single property page **/
            $property_data = NULL;
            $pid = wpl_request::getVar('pid', 0);
            if($pid) $property_data = $model->get_property_raw_data($pid);
            
            if(isset($property_data['mls_id'])) $where['sf_parent'] = $property_data['mls_id'];
        }
        
        /** Similar properties **/
        if(isset($data['sml_only_similars']) and $data['sml_only_similars']) # sml = similar
        {
            $sml_where = array('sf_select_confirmed'=>1, 'sf_select_finalized'=>1, 'sf_select_deleted'=>0, 'sf_select_expired'=>0);
            
            /** current proeprty id - This features works only in single property page **/
            $pid = wpl_request::getVar('pid', 0);
            $property_data = wpl_property::get_property_raw_data($pid);
            
            if($property_data)
            {
                $sml_where['sf_notselect_id'] = $pid;
                $sml_where['sf_select_kind'] = $property_data['kind'];
            
                if(isset($data['sml_inc_listing']) and $data['sml_inc_listing']) $sml_where['sf_select_listing'] = $property_data['listing'];
                if(isset($data['sml_inc_property_type']) and $data['sml_inc_property_type']) $sml_where['sf_select_property_type'] = $property_data['property_type'];

                if(isset($data['sml_inc_price']) and $data['sml_inc_price'])
                {
                    $down_rate = $data['sml_price_down_rate'] ? $data['sml_price_down_rate'] : 0.8;
                    $up_rate = $data['sml_price_up_rate'] ? $data['sml_price_up_rate'] : 1.2;

                    $price_down_range = $property_data['price_si']*$down_rate;
                    $price_up_range = $property_data['price_si']*$up_rate;
                    
                    $sml_where['sf_tmin_price_si'] = $price_down_range;
                    $sml_where['sf_tmax_price_si'] = $price_up_range;
                }

                if(isset($data['sml_inc_radius']) and $data['sml_inc_radius'])
                {
                    $latitude = $property_data['googlemap_lt'];
                    $longitude = $property_data['googlemap_ln'];
                    $radius = $data['sml_radius'];
                    $unit_id = $data['sml_radius_unit'];
                    
                    if($latitude and $longitude and $radius and $unit_id)
                    {
                        $sml_where['sf_radiussearchunit'] = $unit_id;
                        $sml_where['sf_radiussearch_lat'] = $latitude;
                        $sml_where['sf_radiussearch_lng'] = $longitude;
                        $sml_where['sf_radiussearchradius'] = $radius;
                    }
                }
                
                if(isset($data['data_sml_zip_code']) and $data['data_sml_zip_code'])
                {
                    if(!empty($property_data['zip_name']) and $property_data['zip_name'] != 0)
                    {
                        $zip_code = $property_data['zip_name'];
                        $zip_code_field_type = 'zip_name';
                    }
                    else
                    {
                        $zip_code = $property_data['post_code'];
                        $zip_code_field_type = 'post_code';
                    }
                    
                    $sml_where['sf_select_'.$zip_code_field_type] = $zip_code;
                }
            }
            
            /** overwrite $where if similar where is correct **/
            if(count($sml_where) > 3) $where = $sml_where;
        }
        
        /** apply filters **/
		_wpl_import('libraries.filters');
		@extract(wpl_filters::apply('carousel_where', array('where'=>$where, 'widget_id'=>$this->widget_id, 'instance'=>$instance)));
		
		if(isset($data['random']) and trim($data['random']) and trim($data['listing_ids']) == '')
		{
			$query_rand = "SELECT p.`id` FROM `#__wpl_properties` AS p WHERE 1 ".wpl_db::create_query($where)." ORDER BY RAND() LIMIT ".$this->limit;
			$results = wpl_db::select($query_rand);
			
			$rand_ids = array();
			foreach($results as $result) $rand_ids[] = $result->id;
			
            $where['sf_multiple_id'] = implode(',', $rand_ids);
		}
        
		/** Start Search **/
		$model->start($this->start, $this->limit, $this->orderby, $this->order, $where);

		/** Return the search **/
		return $model->query(false);
	}
    
    public function tags($tags, $property_data = array())
	{
        $tags_str = '';
        
        foreach($tags as $tag)
        {
            if(!$property_data[$tag->table_column]) continue;
            
            $options = json_decode($tag->options, true);
            if(!$options['ribbon']) continue;
            
            $tags_str .= '<div class="wpl-listing-tag '.$tag->table_column.'">'.__($tag->name, 'wpl').'</div>';
        }
        
        /** Load Tag Styles **/
        $this->tags_styles($tags);
        
        return $tags_str;
	}
    
    public function tags_styles($tags = array())
    {
        // No tag!
        if(!count($tags)) return;
        
        static $loaded = array();
        
        if(isset($loaded[$this->widget_id])) return;
        if(!isset($loaded[$this->widget_id])) $loaded[$this->widget_id] = true;
        
        /** Initialize WPL color library **/
        $color = new wpl_color();
        
        $styles_str = '';
        foreach($tags as $tag)
        {
            $options = json_decode($tag->options, true);
            if(!$options['ribbon']) continue;
            
            $darken = $color->convert(trim($options['color'], '# '), 130, true);
            $styles_str .= '.wpl-listing-tag.'.$tag->table_column.'{background-color: #'.trim($options['color'], '# ').'; color: #'.trim($options['text_color'], '# ').'} .wpl-listing-tag.'.$tag->table_column.'::after{border-color: #'.$darken.' transparent transparent #'.$darken.';}';
        }
        
        _wpl_import('libraries.html');
        
        $wplhtml = wpl_html::getInstance();
        $wplhtml->set_footer('<style type="text/css">'.$styles_str.'</style>');
    }
}