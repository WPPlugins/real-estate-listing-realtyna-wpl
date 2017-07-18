<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

_wpl_import('libraries.property');
_wpl_import('libraries.render');
_wpl_import('libraries.items');
_wpl_import('libraries.activities');

abstract class wpl_property_show_controller_abstract extends wpl_controller
{
	public $tpl_path = 'views.frontend.property_show.tmpl';
	public $tpl;
	public $wpl_properties;
	public $pid;
	public $kind;
	public $property;
	public $model;
	public $pshow_fields;
	
	public function display($instance = array())
	{
        /** global settings **/
		$this->settings = wpl_settings::get_settings();
        
		/** do cronjobs **/
        if(isset($this->settings['wpl_cronjobs']) and $this->settings['wpl_cronjobs'])
        {
            _wpl_import('libraries.events');
            wpl_events::do_cronjobs();
        }
		
		/** check access **/
		if(!wpl_users::check_access('propertyshow'))
		{
			/** import message tpl **/
            $this->message = sprintf(__("You don't have access to this menu! %s KB article might be helpful.", 'wpl'), '<a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/618/">'.__('this', 'wpl').'</a>');
			return parent::render($this->tpl_path, 'message', false, true);
		}
        
        $tpl = wpl_global::get_setting('wpl_propertyshow_layout');
        if(trim($tpl) == '') $tpl = 'default';
        
        $this->tpl = wpl_request::getVar('tpl', $tpl);
        
		/** property listing model **/
		$this->model = new wpl_property;
		$this->pid = wpl_request::getVar('pid', 0);
		
		$listing_id = wpl_request::getVar('mls_id', 0);
		if(trim($listing_id))
        {
            $this->pid = wpl_property::pid($listing_id);
            wpl_request::setVar('pid', $this->pid);
        }
		
		$property = $this->model->get_property_raw_data($this->pid);
		
		/** no property found **/
		if(!$property or $property['finalized'] == 0 or $property['confirmed'] == 0 or $property['deleted'] == 1 or $property['expired'] >= 1)
		{
			/** import message tpl **/
			if(isset($property['confirmed']) and !$property['confirmed']) $this->message = __("Sorry! The property is not visible until it is confirmed by someone.", 'wpl');
            else $this->message = __("Sorry! Either the url is incorrect or the listing is no longer available.", 'wpl');
            
			return parent::render($this->tpl_path, 'message', false, true);
		}
		
		$current_user = wpl_users::get_wpl_user();
		$lrestrict = $current_user->maccess_lrestrict_pshow;
		$rlistings = explode(',', $current_user->maccess_listings_pshow);
		$ptrestrict = $current_user->maccess_ptrestrict_pshow;
		$rproperty_types = explode(',', $current_user->maccess_property_types_pshow);

		if(($lrestrict and !in_array($property['listing'], $rlistings)) or ($ptrestrict and !in_array($property['property_type'], $rproperty_types)))
		{
			$this->message = __("Sorry! You don't have access to view this property.", 'wpl');
            
			return parent::render($this->tpl_path, 'message', false, true);
		}
        
		$this->pshow_fields = $this->model->get_pshow_fields('', $property['kind']);
		$this->pshow_categories = wpl_flex::get_categories('', '', " AND `enabled`>='1' AND `kind`='".$property['kind']."' AND `pshow`='1'");
		$wpl_properties = array();

		/** Microdata **/
		$this->microdata = isset($this->settings['microdata']) ? $this->settings['microdata'] : 0;
		$this->itemscope = ($this->microdata) ? 'itemscope' : '';

		$this->itemprop_name = ($this->microdata) ? 'itemprop="name"' : '';
		$this->itemprop_value = ($this->microdata) ? 'itemprop="value"' : '';
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
		$this->itemtype_ApartmentComplex = ($this->microdata) ? 'itemtype="http://schema.org/ApartmentComplex"' : '';
		$this->itemtype_SingleFamilyResidence = ($this->microdata) ? 'itemtype="http://schema.org/SingleFamilyResidence"' : '';
		$this->itemtype_Place = ($this->microdata) ? 'itemtype="http://schema.org/Place"' : '';
		$this->itemtype_PostalAddress = ($this->microdata) ? 'itemtype="http://schema.org/PostalAddress"' : '';
		$this->itemtype_offer = ($this->microdata) ? 'itemtype="http://schema.org/offer"' : '';
		$this->itemtype_QuantitativeValue = ($this->microdata) ? 'itemtype="http://schema.org/QuantitativeValue"' : '';

		/** define current index **/
		$wpl_properties['current']['data'] = (array) $property;
		$wpl_properties['current']['raw'] = (array) $property;
        
        $find_files = array();
		$rendered_fields = $this->model->render_property($property, $this->pshow_fields, $find_files, true);
        
		$wpl_properties['current']['rendered_raw'] = $rendered_fields['ids'];
        $wpl_properties['current']['materials'] = $rendered_fields['columns'];
		
		foreach($this->pshow_categories as $pshow_category)
		{
			if(trim($pshow_category->listing_specific) != '')
            {
                if(substr($pshow_category->listing_specific, 0, 5) == 'type=')
                {
                    $specified_listings = wpl_global::get_listing_types_by_parent(substr($pshow_category->listing_specific, 5));

                    $array_specified_listing = array();

                    foreach ($specified_listings as $specified_listing) $array_specified_listing[] = $specified_listing['id'];

                    if(!in_array($wpl_properties['current']['data']['listing'], $array_specified_listing)) continue;
                }
            }
            elseif(trim($pshow_category->property_type_specific) != '')
            {
            	if(substr($pshow_category->property_type_specific, 0, 5) == 'type=')
                {
                    $specified_property_types = wpl_global::get_property_types_by_parent(substr($pshow_category->property_type_specific, 5));

                    $array_specified_property_types = array();

                    foreach ($specified_property_types as $specified_property_type) $array_specified_property_types[] = $specified_property_type['id'];

                    if(!in_array($wpl_properties['current']['data']['property_type'], $array_specified_property_types)) continue;
                }
            }

			$pshow_cat_fields = $this->model->get_pshow_fields($pshow_category->id, $property['kind']);
			$wpl_properties['current']['rendered'][$pshow_category->id]['self'] = (array) $pshow_category;
			$wpl_properties['current']['rendered'][$pshow_category->id]['data'] = $this->model->render_property($property, $pshow_cat_fields);
		}
		
		$wpl_properties['current']['items'] = wpl_items::get_items($this->pid, '', $property['kind'], '', 1);
		/** property location text **/ $wpl_properties['current']['location_text'] = $this->model->generate_location_text((array) $property);
		/** property full link **/ $wpl_properties['current']['property_link'] = $this->model->get_property_link((array) $property);
        /** property page title **/ $wpl_properties['current']['property_page_title'] = $this->model->update_property_page_title($property);
        /** property title **/ $wpl_properties['current']['property_title'] = $this->model->update_property_title($property);
		
		/** apply filters (This filter must place after all proccess) **/
		_wpl_import('libraries.filters');
		@extract(wpl_filters::apply('property_listing_after_render', array('wpl_properties'=>$wpl_properties)));
		
		$this->wpl_properties = $wpl_properties;
		$this->kind = $property['kind'];
		$this->property = $wpl_properties['current'];
		
		/** updating the visited times and etc **/
		wpl_property::property_visited($this->pid);

		//adding in items with type 'view_parent_stat' for child listings
		if($property['kind'] == 1)
		{
			$child_listings = wpl_property::select_active_properties(" AND `parent`='".$this->pid."'", 'id');
			foreach($child_listings as $listing) wpl_property::add_property_stats_item($listing['id'], 'view_parent_stat');
		}
		
        // Location visibility
        $this->location_visibility = wpl_property::location_visibility($this->pid, $this->kind, wpl_users::get_user_membership());
        
        /** trigger event **/
		wpl_global::event_handler('property_show', array('id'=>$this->pid));
        
		/** Property Show fields Columns Count **/
		$fields_columns = wpl_global::get_setting('wpl_ui_customizer_property_show_fields_columns');
		$this->fields_columns = trim($fields_columns) ? $fields_columns : '3';
        
		/** import tpl **/
        $this->tpl = wpl_flex::get_kind_tpl($this->tpl_path, $this->tpl, $this->kind);
		$output = parent::render($this->tpl_path, $this->tpl, false, true);
        
        if($this->wplraw)
        {
            echo $output;
            exit;
        }
        else return $output;
	}
}