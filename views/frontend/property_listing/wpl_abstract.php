<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

_wpl_import('libraries.pagination');
_wpl_import('libraries.property');
_wpl_import('libraries.render');
_wpl_import('libraries.items');
_wpl_import('libraries.activities');
_wpl_import('libraries.settings');
_wpl_import('libraries.sort_options');

abstract class wpl_property_listing_controller_abstract extends wpl_controller
{
	public $tpl_path = 'views.frontend.property_listing.tmpl';
	public $tpl;
	public $wpl_properties;
	public $model;
	public $kind;
    public $return_listings = false;
	
	public function display($instance = array())
	{
        /** check access **/
		if(!wpl_users::check_access('propertylisting'))
		{
			/** import message tpl **/
			$this->message = sprintf(__("You don't have access to this menu! %s KB article might be helpful.", 'wpl'), '<a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/618/">'.__('this', 'wpl').'</a>');
			return parent::render($this->tpl_path, 'message', false, true);
		}
        
        $this->tpl = wpl_request::getVar('tpl', 'default');
        $this->method = wpl_request::getVar('wplmethod', NULL);
        
        /** global settings **/
		$this->settings = wpl_settings::get_settings();
		
		/** listing settings **/
        $this->page_number = wpl_request::getVar('wplpage', 1, '', true);
		$this->limit = wpl_request::getVar('limit', $this->settings['default_page_size']);
		$this->start = wpl_request::getVar('start', (($this->page_number-1)*$this->limit), '', true);
		$this->orderby = wpl_request::getVar('wplorderby', $this->settings['default_orderby'], '', true);
		$this->order = wpl_request::getVar('wplorder', $this->settings['default_order'], '', true);
        
        /** Set Property CSS class **/
        $this->property_css_class = wpl_request::getVar('wplpcc', NULL);
        if(!$this->property_css_class) $this->property_css_class = wpl_request::getVar('wplpcc', 'grid_box', 'COOKIE');
        
        $this->property_css_class_switcher = wpl_request::getVar('wplpcc_switcher', '1');
        $this->property_listview = wpl_request::getVar('wplplv', '1'); #Show listview or not
        
        // only icon or icon+text
        $this->switcher_type = isset($this->settings['wpl_listing_switcher_type']) ? $this->settings['wpl_listing_switcher_type'] : 'icon';
		
		/** listing Columns Count **/
		$listing_columns = wpl_global::get_setting('wpl_ui_customizer_property_listing_columns');
		$listing_columns_default = trim($listing_columns) ? $listing_columns : '3';
		$this->listing_columns = wpl_request::getVar('wplcolumns', $listing_columns_default); 

		// Disable or Enable Mouseover effect
		$this->listing_picture_mouseover = isset($this->settings['wpl_listing_picture_mouseover']) ? $this->settings['wpl_listing_picture_mouseover'] : 1;
        
        /** RSS Feed Setting **/
        $this->listings_rss_enabled = isset($this->settings['listings_rss_enabled']) ? $this->settings['listings_rss_enabled'] : 0;
        
        /** Print Results Page **/
        $this->print_results_page = isset($this->settings['pdf_results_page_status']) ? $this->settings['pdf_results_page_status'] : 0;

		/** Microdata */
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
		$this->itemtype_SingleFamilyResidence = ($this->microdata) ? 'itemtype="http://schema.org/SingleFamilyResidence"' : '';
		$this->itemtype_Place = ($this->microdata) ? 'itemtype="http://schema.org/Place"' : '';
		$this->itemtype_PostalAddress = ($this->microdata) ? 'itemtype="http://schema.org/PostalAddress"' : '';
		$this->itemtype_offer = ($this->microdata) ? 'itemtype="http://schema.org/offer"' : '';
		$this->itemtype_QuantitativeValue = ($this->microdata) ? 'itemtype="http://schema.org/QuantitativeValue"' : '';

        /** detect kind **/
		$this->kind = wpl_request::getVar('kind', 0);
        if(!$this->kind) $this->kind = wpl_request::getVar('sf_select_kind', 0);
        
		if(!in_array($this->kind, wpl_flex::get_valid_kinds()))
		{
			/** import message tpl **/
			$this->message = __('Invalid Request!', 'wpl');
			return parent::render($this->tpl_path, 'message', false, true);
		}
        
        /** pagination types **/
        $this->wplpagination = wpl_request::getVar('wplpagination', 'normal', '', true);
        wpl_request::setVar('wplpagination', $this->wplpagination);
        
		/** property listing model **/
		$this->model = new wpl_property;
		
		/** set page if start var passed **/
		$this->page_number = ($this->start/$this->limit)+1;
		wpl_request::setVar('wplpage', $this->page_number);
		
		$where = array('sf_select_confirmed'=>1, 'sf_select_finalized'=>1, 'sf_select_deleted'=>0, 'sf_select_expired'=>0, 'sf_select_kind'=>$this->kind);
		
        /** Add search conditions to the where **/
        $vars = array_merge(wpl_request::get('POST'), wpl_request::get('GET'));
		$where = array_merge($vars, $where);

		// View Restrictions
        $current_user = wpl_users::get_wpl_user();
        
		$lrestrict = isset($current_user->maccess_lrestrict_plisting) ? $current_user->maccess_lrestrict_plisting : '';
		$ptrestrict = isset($current_user->maccess_ptrestrict_plisting) ? $current_user->maccess_ptrestrict_plisting : '';

		if($lrestrict)
		{
			$rlistings = trim($current_user->maccess_listings_plisting, ',');
			$where['sf_restrict_listing'] = $rlistings;
		}

		if($ptrestrict)
		{
			$rproperty_types = trim($current_user->maccess_property_types_plisting, ',');
			$where['sf_restrict_property_type'] = $rproperty_types;
		}
        
		/** start search **/
		$this->model->start($this->start, $this->limit, $this->orderby, $this->order, $where, $this->kind);
		
		/** run the search **/
		$query = $this->model->query();
		$properties = $this->model->search();
        
		/** finish search **/
		$this->model->finish();
        
		/** validation for page_number **/
		$this->total_pages = ceil($this->model->total / $this->limit);
		if($this->page_number <= 0 or ($this->page_number > $this->total_pages)) $this->model->start = 0;
		
        // Update WPL Session
        if(!$this->return_listings)
        {
            // Save Search in SESSION
            wpl_session::set('wpl_listing_criteria', $where);
            wpl_session::set('wpl_listing_orderby', $this->orderby);
            wpl_session::set('wpl_listing_order', $this->order);
            wpl_session::set('wpl_listing_total', $this->model->total);
        
            // Search URL
            $search_url = wpl_global::remove_qs_var('wpl_format', wpl_global::get_full_url());
            wpl_session::set('wpl_last_search_url', $search_url);
        }
        
		// We have to disable the cache if some of units changed by unit switcher feature or something else
        $force = false;
        $cookies = wpl_request::get('COOKIE');
        if(isset($cookies['wpl_unit1']) or isset($cookies['wpl_unit2']) or isset($cookies['wpl_unit3']) or isset($cookies['wpl_unit4'])) $force = true;
        
		$wpl_properties = array();
		foreach($properties as $property)
		{
			$wpl_properties[$property->id] = $this->model->full_render($property->id, $this->model->listing_fields, $property, array(), $force);

			//adding in items as including in listing page stat
			wpl_property::add_property_stats_item($property->id, 'inc_in_listings_stat');
		}
		
		/** define current index **/
		$wpl_properties['current'] = array();
		
		/** apply filters (This filter must place after all proccess) **/
		_wpl_import('libraries.filters');
		@extract(wpl_filters::apply('property_listing_after_render', array('wpl_properties'=>$wpl_properties)));
		
		$this->pagination = wpl_pagination::get_pagination($this->model->total, $this->limit, true, $this->wplraw);
		$this->wpl_properties = $wpl_properties;
        
        if($this->wplraw and $this->method == 'get_markers')
        {
            $markers = array('markers'=>$this->model->render_markers($wpl_properties), 'total'=>$this->model->total);
            echo json_encode($markers);
            exit;
        }
        elseif($this->wplraw and $this->method == 'get_listings')
        {
        	if($this->return_listings) return $wpl_properties;
        	else
            {
                echo json_encode($wpl_properties);
                exit;
            }
        }
        
		/** import tpl **/
        $this->tpl = wpl_flex::get_kind_tpl($this->tpl_path, $this->tpl, $this->kind);
		return parent::render($this->tpl_path, $this->tpl, false, true);
	}
}