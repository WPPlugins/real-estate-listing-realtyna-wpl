<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

_wpl_import('libraries.locations');

class wpl_property_listing_controller extends wpl_controller
{
    public function display()
    {
        $function = wpl_request::getVar('wpl_function');

        if($function == 'get_locations')
        {
            $location_level = wpl_request::getVar('location_level');
            $parent = wpl_request::getVar('parent');
            $current_location_id = wpl_request::getVar('current_location_id');
            $widget_id = wpl_request::getVar('widget_id');

            $this->get_locations($location_level, $parent, $current_location_id, $widget_id);
        }
        elseif($function == 'locationtextsearch_autocomplete')
        {
            $term = wpl_request::getVar('term');
            $this->locationtextsearch_autocomplete($term);
        }
        elseif($function == 'advanced_locationtextsearch_autocomplete')
        {
            $term = wpl_request::getVar('term');
            $this->advanced_locationtextsearch_autocomplete($term);
        }
        elseif($function == 'contact_listing_user' or $function == 'contact_agent')
        {
            $this->contact_listing_user();
        }
        elseif($function == 'set_pcc')
        {
            $this->set_pcc();
        }
    }

    private function get_locations($location_level = '', $parent = '', $current_location_id = '', $widget_id)
    {
        $location_settings = wpl_global::get_settings('3'); # location settings

        if($location_settings['zipcode_parent_level'] == $location_level - 1)
        {
            $location_level = 'zips';
        }

        $location_data = wpl_locations::get_locations($location_level, $parent, ($location_level == '1' ? 1 : ''));

        $res = count($location_data) ? 1 : 0;
        $message = $res ? __('Fetched.', 'wpl') : __('Error Occured.', 'wpl');
        $name_id = $location_level != 'zips' ? 'sf' . $widget_id . '_select_location' . $location_level . '_id' : 'sf' . $widget_id . '_select_zip_id';

        $html = '<select name="' . $name_id . '" id="' . $name_id . '"';

        if($location_level != 'zips')
            $html .='onchange="wpl' . $widget_id . '_search_widget_load_location(\'' . $location_level . '\', this.value, \'' . $current_location_id . '\');"';

        $html .= '>';
        $html .= '<option value="-1">' . __((trim($location_settings['location'.$location_level.'_keyword']) != '' ? $location_settings['location'.$location_level.'_keyword'] : 'Select'), 'wpl') . '</option>';

        foreach($location_data as $location)
        {
            $html .= '<option value="' . $location->id . '" ' . ($current_location_id == $location->id ? 'selected="selected"' : '') . '>' . __($location->name, 'wpl') . '</option>';
        }

        $html .= '</select>';

        $response = array('success' => $res, 'message' => $message, 'data' => $location_data, 'html' => $html, 'keyword' => __($location_settings['location' . $location_level . '_keyword'], 'wpl'));
        echo json_encode($response);
        exit;
    }

    private function locationtextsearch_autocomplete($term)
    {
        $limit = 10;
        $query = "SELECT `count`, `location_text` AS name FROM `#__wpl_locationtextsearch` WHERE `location_text` LIKE '" . $term . "%' ORDER BY `count` DESC LIMIT " . $limit;
        $results = wpl_db::select($query, 'loadAssocList');
        
        $output = array();
        foreach($results as $result)
        {
            $name = preg_replace("/\s,/", '', $result['name']);
            $output[] = array('label' => $name, 'value' => $name);
        }

        echo json_encode($output);
        exit;
    }

    private function advanced_locationtextsearch_autocomplete($term)
    {
        $settings = wpl_settings::get_settings(3);
        $street = 'field_42';
        $location2 = 'location2_name';
        $location3 = 'location3_name';
        $location4 = 'location4_name';
        $location5 = 'location5_name';
        
        if(wpl_global::check_multilingual_status())
        {
            $street = wpl_addon_pro::get_column_lang_name($street, wpl_global::get_current_language(), false);
            $location2 = wpl_addon_pro::get_column_lang_name($location2, wpl_global::get_current_language(), false);
            $location3 = wpl_addon_pro::get_column_lang_name($location3, wpl_global::get_current_language(), false);
            $location4 = wpl_addon_pro::get_column_lang_name($location4, wpl_global::get_current_language(), false);
            $location5 = wpl_addon_pro::get_column_lang_name($location5, wpl_global::get_current_language(), false);
        }

        $limit = 5;
        $output = array();
        $condition = "`finalized` = 1 AND `confirmed` = 1 AND `deleted` = 0 AND `expired` = 0";
        $queries = array($street => __('Street', 'wpl'), 
                         $location2 => __($settings['location2_keyword'], 'wpl'),
                         $location3 => __($settings['location3_keyword'], 'wpl'),
                         $location4 => __($settings['location4_keyword'], 'wpl'),
                         $location5 => __($settings['location5_keyword'], 'wpl'),
                         'location_text' => __('Address', 'wpl'),
                         'zip_name' => __($settings['locationzips_keyword'], 'wpl'), 
                         'mls_id' => __('Listing ID', 'wpl'));

        foreach ($queries as $column => $title)
        {
            $query = "SELECT `{$column}` AS `name`, COUNT(`{$column}`) AS `count` FROM `#__wpl_properties` WHERE $condition AND (`{$column}` LIKE '" . $term . "%' OR `{$column}` LIKE '% " . $term . "%') GROUP BY `{$column}` ORDER BY `{$column}` LIMIT " . $limit;
            $results = wpl_db::select($query, 'loadAssocList');

            foreach($results as $result)
            {
                $output[] = array('label' => $result['name'].' ('.$result['count'].')', 'title' => $title, 'column' => $column, 'value' => $result['name']);
            }
        }

        $output[] = array('label' => $term, 'title' => __('Keyword', 'wpl'), 'column' => '', 'value' => $term);

        echo json_encode($output);
        exit;
    }
    
    private function contact_listing_user()
    {
        $fullname = wpl_request::getVar('fullname', '');
        $phone = wpl_request::getVar('phone', '');
        $email = wpl_request::getVar('email', '');
        $message = wpl_request::getVar('message', '');
        $property_id = wpl_request::getVar('pid', '');
        
        $parameters = array(
            'fullname' => $fullname,
            'phone' => $phone,
            'email' => $email,
            'message' => $message,
            'property_id' => $property_id,
            'user_id' => wpl_property::get_property_user($property_id)
        );
        
        // For integrating third party plugins such as captcha plugins
        apply_filters('preprocess_comment', array());
        
        $returnData = array();
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $returnData['success'] = 0;
            $returnData['message'] = __('Your email is not a valid email!', 'wpl');
        }
        elseif(!wpl_security::verify_nonce(wpl_request::getVar('_wpnonce', ''), 'wpl_listing_contact_form'))
        {
            $returnData['success'] = 0;
            $returnData['message'] = __('The security nonce is not valid!', 'wpl');
        }
        else
        {
            wpl_events::trigger('contact_agent', $parameters);
            
            $returnData['success'] = 1;
            $returnData['message'] = __('Information sent to agent.', 'wpl');
        }

        //adding in items with type contact stat
        wpl_property::add_property_stats_item($property_id, 'contact_stat');
        
        echo json_encode($returnData);
        exit;
    }
    
    private function set_pcc()
    {
        $pcc = wpl_request::getVar('pcc', '');
        
        setcookie('wplpcc', $pcc, time()+(86400*30), '/');
        wpl_request::setVar('wplpcc', $pcc, 'COOKIE');
        
        echo json_encode(array('success'=>1));
        exit;
    }
}
