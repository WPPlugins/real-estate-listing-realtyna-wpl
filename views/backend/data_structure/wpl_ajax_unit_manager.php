<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

class wpl_data_structure_controller extends wpl_controller
{
	public $tpl_path = 'views.backend.data_structure.tmpl';
	public $tpl;
	
	public function display()
	{
		/** check permission **/
		wpl_global::min_access('administrator');
		
		$function = wpl_request::getVar('wpl_function');
		
        // Check Nonce
        if(!wpl_security::verify_nonce(wpl_request::getVar('_wpnonce', ''), 'wpl_data_structure')) $this->response(array('success'=>0, 'message'=>__('The security nonce is not valid!', 'wpl')));
        
        // Create Nonce
        $this->nonce = wpl_security::create_nonce('wpl_data_structure');
        
		if($function == 'generate_new_page')
		{
			$type = wpl_request::getVar('type');
			$this->generate_new_page($type);
		}
		elseif($function == 'sort_units')
		{
			$sort_ids = wpl_request::getVar('sort_ids');
			$this->sort_units($sort_ids);
		}
		elseif($function == 'unit_enabled_state_change')
		{
			$unit_id = wpl_request::getVar('unit_id');
			$enabled_status = wpl_request::getVar('enabled_status');
			$this->update($unit_id, 'enabled', $enabled_status);
		}
		elseif($function == 'update_exchange_rates')
		{			
			$this->update_exchange_rates();
		}
		elseif($function == 'update_a_exchange_rate')
		{			
			$unit_id = wpl_request::getVar('unit_id');			
			$currency_code = wpl_request::getVar('currency_code');			
			$this->update_a_exchange_rate($unit_id, $currency_code);
		}
		elseif($function == 'modify_unit')
		{
			$id = wpl_request::getVar('id');
			$field = wpl_request::getVar('field');
			$value = wpl_request::getVar('value');
			$this->update($id, $field, $value);
		}		
	}

	/**
	*	{$type} 
	*	$type is a unit type for filtering
	**/
	private function generate_new_page($type)
	{		
		$this->units = wpl_units::get_units($type,"","");	
		
		if($type == 4) parent::render($this->tpl_path, 'internal_unit_manager_currency');
		else parent::render($this->tpl_path, 'internal_unit_manager_general');
		
		exit;
	}
	
	/**
	*{tablename,unit_id,key,value of key}
	* this function call update function in units library and change value of a field
	**/
	private function update($unit_id, $key, $value = '')
	{
		$res = wpl_units::update($unit_id, $key, sanitize_text_field($value));
		
		$res = (int) $res;
		$message = $res !== false ? __('Operation was successful.', 'wpl') : __('Error Occured.', 'wpl');
		$data = NULL;
		
		$response = array('success'=>$res, 'message'=>$message, 'data'=>$data);		
		echo json_encode($response);
		exit;
	}
	
	private function sort_units($sort_ids)
	{
		if(trim($sort_ids) == '') $sort_ids = wpl_request::getVar('sort_ids');
		wpl_units::sort_units($sort_ids);		
		exit;
	}	
	
	/**
	*	call wpl_units::update_exchange_rates for connect to yahoo
	*	server and exchange currency rates
	**/
	private function update_exchange_rates()
	{
		wpl_units::update_exchange_rates();			
	}
	
	/**
	*	get a currency id and exchange rate it by unit library
	**/
	private function update_a_exchange_rate($unit_id, $currency_code)
	{
		$res = wpl_units::update_a_exchange_rate($unit_id, $currency_code);
		
		$success = $res ? true : false;
		$response = array('success'=>$success, 'res'=>$res);
		
		echo json_encode($response);
		exit;
	}
}