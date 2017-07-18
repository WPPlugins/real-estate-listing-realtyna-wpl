<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/** Define Tabs **/
$tabs = array();
$tabs['tabs'] = array();

$content = '<h3>'.__('WPL Data Structure', 'wpl').'</h3><p>'.__("Use this menu to manage property types (i.e. home, villa, etc.), listing types (i.e. for rent, for sale, etc.), room types, sort options, and units of measurement (acre, mile, currency, etc.).", 'wpl').'</p>';
$tabs['tabs'][] = array('id'=>'wpl_contextual_help_tab_int', 'content'=>$content, 'title'=>__('Introduction', 'wpl'));

$articles  = '';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/542/" target="_blank">'.__("How do I enable/disable WPL measuring units such as acre, mile, currency, etc.?", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/583/" target="_blank">'.__("How to manage (Add/Edit/Delete) Listing Types or Property Types", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/687/" target="_blank">'.__("How do I set WPL sort options??", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/532/" target="_blank">'.__("How to translate WPL Data structure (Property Types, Listing Types, Sort Options, Flex fields, etc) texts", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/629/" target="_blank">'.__("How do I set categories for listing and property types??", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/577/" target="_blank">'.__("How do I add a new category for listing and property types?", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/662/" target="_blank">'.__("How do I add new units of measurement (acre, mile, currency, etc.) to WPL??", 'wpl').'</a></li>';

$content = '<h3>'.__('Related KB Articles', 'wpl').'</h3><p>'.__('Here you will find KB articles with information related to this page. You can come back to this section to find an answer to any questions that may come up.', 'wpl').'</p><p><ul>'.$articles.'</ul></p>';
$tabs['tabs'][] = array('id'=>'wpl_contextual_help_tab_kb', 'content'=>$content, 'title'=>__('KB Articles', 'wpl'));

// Hide Tour button
$tabs['sidebar'] = array('content'=>'');

return $tabs;