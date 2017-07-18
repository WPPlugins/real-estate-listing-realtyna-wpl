<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/** Define Tabs **/
$tabs = array();
$tabs['tabs'] = array();

$content = '<h3>'.__('WPL Activity Manager', 'wpl').'</h3><p>'.__('WPL is a modular system that runs certain activities to generate page outputs. You can change options on this page for the gallery, Google Maps, and other activities. ', 'wpl').'</p>';
$tabs['tabs'][] = array('id'=>'wpl_contextual_help_tab_int', 'content'=>$content, 'title'=>__('Introduction', 'wpl'));

$articles  = '';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/651/" target="_blank">'.__("How do you modify and change settings for items in the WPL Activity Manager?", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/611/" target="_blank">'.__("How do I link images using the mailto option??", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/584/" target="_blank">'.__("How do I disable Google Maps in the listing pages?", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/594/" target="_blank">'.__("How to enable the Mortgage Calculator feature?", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/598/" target="_blank">'.__("How do I enable WPL contact forms/activites?", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/688/" target="_blank">'.__("How do I make the Walk Score responsive??", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/547/" target="_blank">'.__("Enabling/Disabling/Sorting WPL Activities.", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/567/" target="_blank">'.__("How do I manage social media icons on the WPL front-end??", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/571/" target="_blank">'.__("How do I enable the Google Places feature?", 'wpl').'</a></li>';
$articles .= '<li><a href="https://support.realtyna.com/index.php?/Default/Knowledgebase/Article/View/611/" target="_blank">'.__("How do I link images using the mailto option??", 'wpl').'</a></li>';

$content = '<h3>'.__('Related KB Articles', 'wpl').'</h3><p>'.__('Here you will find KB articles with information related to this page. You can come back to this section to find an answer to any questions that may come up.', 'wpl').'</p><p><ul>'.$articles.'</ul></p>';
$tabs['tabs'][] = array('id'=>'wpl_contextual_help_tab_kb', 'content'=>$content, 'title'=>__('KB Articles', 'wpl'));

return $tabs;