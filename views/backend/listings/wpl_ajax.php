<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

_wpl_import('libraries.property');

class wpl_listings_controller extends wpl_controller
{
    public function display()
    {
        $function = wpl_request::getVar('wpl_function');
        $pid = wpl_request::getVar('pid');
        
        // Check Nonce
        if(!wpl_security::verify_nonce(wpl_request::getVar('_wpnonce', ''), 'wpl_listings')) $this->response(array('success'=>0, 'message'=>__('The security nonce is not valid!', 'wpl')));
        
        if($function == 'purge_property')
		{
            $this->purge_property($pid);
		}
        elseif($function == 'update_property')
        {
            $action = wpl_request::getVar('action');
            $value = wpl_request::getVar('value');
            
            $this->update_property($pid, $action, $value);
        }
        elseif($function == 'change_user')
        {
            $this->change_user();
        }
        elseif($function == 'additional_agents')
        {
            $this->additional_agents();
        }
        elseif($function == 'clone_property')
		{
            $this->clone_property();
		}
		elseif($function == 'generate_listing_stats')
		{
            $this->generate_listing_stats();
		}
    }
    
    /**
     * author Francis
     * @param int $pid
     * desctiption: purge one property with the condition of property id
     */
    private function purge_property($pid)
    {
		/** property data **/
		$property_data = wpl_property::get_property_raw_data($pid);
		
		/** purge property **/
		if(wpl_users::check_access('delete', $property_data['user_id']))
		{
			$res = (int) wpl_property::purge($pid, true);
			$message = __("Property purged.", 'wpl');
		}
		else
		{
			$res = 0;
			$message = __("You don't have access to this action.", 'wpl');
		}
		
		/** echo response **/
		echo json_encode(array('success'=>$res, 'message'=>$message, 'data'=>NULL));
		exit;
    }
    
    /**
     * author Francis
     * @param int $pid
     * @param string $action
     * @param int $value
     * description: update 'confirmed' and 'deleted' fields of one property
     */
    private function update_property($pid, $action, $value)
    {
		/** property data **/
		$property_data = wpl_property::get_property_raw_data($pid);
		
        if($action == 'confirm')
		{
			if(wpl_users::check_access('confirm', $property_data['user_id']))
			{
				/** confirm property **/
		        $res = wpl_property::confirm($pid, $value, true);
				$message = __("Operation was successful.", 'wpl');
			}
			else
			{
				$res = 0;
				$message = __("You don't have access to this action.", 'wpl');
			}
		}
        elseif($action == 'trash')
        {
			if(wpl_users::check_access('delete', $property_data['user_id']))
			{
				/** delete property **/
		        $res = wpl_property::delete($pid, $value, true);
				$message = __("Operation was successful.", 'wpl');
			}
			else
			{
				$res = 0;
				$message = __("You don't have access to this action.", 'wpl');
			}
		}
		
		/** echo response **/
		$res = (int) $res;
		$data = NULL;
		
		echo json_encode(array('success'=>$res, 'message'=>$message, 'data'=>$data));
        exit;
    }
    
    /**
     * author Howard
     * desctiption: change user of a property
     */
    private function change_user()
    {
        $pid = wpl_request::getVar('pid');
        $uid = wpl_request::getVar('uid');
		
		/** purge property **/
		if(wpl_users::check_access('change_user'))
		{
			$res = (int) wpl_property::change_user($pid, $uid);
			$message = __("User changed.", 'wpl');
		}
		else
		{
			$res = 0;
			$message = __("You don't have access to this action.", 'wpl');
		}
		
		/** echo response **/
		echo json_encode(array('success'=>$res, 'message'=>$message, 'data'=>NULL));
		exit;
    }
    
    /**
     * Save additional agents
     * @author Howard R. <howard@realtyna.com>
     */
    private function additional_agents()
    {
        $pid = wpl_request::getVar('pid');
        $uids = explode(',', wpl_request::getVar('uids', ''));
		
        // Validation
        if(count($uids) == 1 and trim($uids[0]) == '') $uids = array();
        
		// Multi agents addon
		if(!wpl_global::check_addon('multi_agents'))
		{
			$res = 0;
			$message = __("Multi Agents Add-on is not installed.", 'wpl');
		}
        elseif(wpl_users::check_access('multi_agents'))
		{
            _wpl_import('libraries.addon_multi_agents');
            
            $multi = new wpl_addon_multi_agents($pid);
            $multi->set_agents($uids);
            
			$res = 1;
			$message = __("Additional agents added.", 'wpl');
		}
		else
		{
			$res = 0;
			$message = __("You don't have access to this action.", 'wpl');
		}
		
		/** Response **/
		$this->response(array('success'=>$res, 'message'=>$message, 'data'=>NULL));
    }
    
    private function clone_property()
    {
        $pid = wpl_request::getVar('pid');
        $clone_id = 0;
        
		// PRO addon
		if(!wpl_global::check_addon('pro'))
		{
			$res = 0;
			$message = __("PRO Add-on is not installed.", 'wpl');
		}
        elseif(wpl_users::check_access('clone'))
		{
            $clone_id = wpl_property::clone_listing($pid);
            
			$res = 1;
			$message = __("Listing cloned.", 'wpl');
		}
		else
		{
			$res = 0;
			$message = __("You don't have access to this action.", 'wpl');
		}
		
		/** Response **/
		$this->response(array('success'=>$res, 'message'=>$message, 'data'=>array('id'=>$clone_id, 'edit_link'=>wpl_property::get_property_edit_link($clone_id))));
    }

    private function generate_listing_stats()
    {
    	$this->stats = array();
        $current_user_id = wpl_users::get_cur_user_id();
        $where_crm_requests = '';

        if(wpl_global::check_addon('crm'))
        {
            _wpl_import('libraries.addon_crm');

            $crm = new wpl_addon_crm();
            $requests_self = $crm->check_access('requests', 'view', 'self');
            $requests_other = $crm->check_access('requests', 'view', 'other');

            if($requests_self and $requests_other)
            {
                $where_crm_requests = '';
            }
            elseif($requests_self and !$requests_other)
            {
                $where_crm_requests = "AND `owner` = '{$current_user_id}'";
            }
            elseif(!$requests_self and $requests_other)
            {
                $where_crm_requests = "AND `owner` <> '{$current_user_id}'";
            }
            else
            {
                $where_crm_requests = 'AND 1 = 2';
            }
        }

        if (is_multisite() and wpl_global::check_addon('franchise'))
        {
            $total_stats = array();
            $blogs = get_sites();
            
            foreach ($blogs as $blog) 
            {
                $blog_info = get_blog_details($blog->blog_id);
                $blog_name = $blog_info->blogname;
                $property_visits = wpl_property::get_all_visits($blog->blog_id);
                $crm_requests = wpl_global::check_addon('crm') ? wpl_db::select("SELECT COUNT(`id`) FROM `#__wpl_addon_crm_requests` WHERE `blog_id` = {$blog->blog_id} {$where_crm_requests}", 'loadResult') : 0;

                $this->stats[$blog->blog_id] = array('blog_name' => $blog_name, 'property_visits' => $property_visits, 'crm_requests' => $crm_requests);
                
                $total_stats['property_visits'] += $property_visits;
                $total_stats['crm_requests'] += $crm_requests;
            }

            $this->stats[0] = array('blog_name' => __('Total', 'wpl'), 'property_visits' => $total_stats['property_visits'], 'crm_requests' => $total_stats['crm_requests']);
        }
        else
        {
            $blog_name = get_bloginfo('name');
            $property_visits = wpl_property::get_all_visits();
            $crm_requests = wpl_global::check_addon('crm') ? wpl_db::select("SELECT COUNT(`id`) FROM `#__wpl_addon_crm_requests` WHERE 1 {$where_crm_requests}", 'loadResult') : 0;

            $this->stats[0] = array('blog_name' => 'Total', 'property_visits' => $property_visits, 'crm_requests' => $crm_requests);
        }

        parent::render('views.backend.listings.tmpl', 'internal_stats');
    }
    
    private function response($response)
    {
        echo json_encode($response);
        exit;
    }
}