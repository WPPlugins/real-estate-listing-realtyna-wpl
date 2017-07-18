<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

if($show == 'multiselect_dropdown' and !$done_this)
{
    $levels = explode(',', $field['extoption']);
    if(count($levels) == 1 and trim($levels[0]) == '') $levels = array(2, 3);
    
    foreach($levels as $level)
    {
        $level = trim($level);
        if(!is_numeric($level)) continue;
        
        /** current values **/
        $current_value = stripslashes(wpl_request::getVar('sf_multiple_location'.$level.'_name', ''));
        $current_values = explode(',', $current_value);

        $locations = wpl_db::select("SELECT `location".$level."_name` FROM `#__wpl_properties` WHERE `location".$level."_name`!='' GROUP BY `location".$level."_name` ORDER BY `location".$level."_name` ASC", 'loadColumn');
        
        $html .= '<label for="sf'.$widget_id.'_multiple_location'.$level.'_name">'.__($location_settings['location'.$level.'_keyword'], 'wpl').'</label>
        <select data-placeholder="'.__('Desired Location(s)', 'wpl').'" multiple name="sf'.$widget_id.'_multiple_location'.$level.'_name" id="sf'.$widget_id.'_multiple_location'.$level.'_name" class="wpl_search_widget_field_'.$field['id'].'_select">';
        
        foreach($locations as $location) $html .= '<option value="'.$location.'" '.(in_array($location, $current_values) ? 'selected="selected"' : '').'>'.__($location, 'wpl').'</option>';
        
        $html .= '</select>';
    }
	
	$done_this = true;
}