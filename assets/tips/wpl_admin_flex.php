<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/** define tips **/
$tips = array();

$content = '<h3>'.__('WPL Fle', 'wpl').'</h3><p>'.__('WPL is Flexibile, it means you can add your desired data fields into data categories simply or manage existing fields. Enjoy WPL Fle!', 'wpl').'</p>';
$tips[] = array('id'=>1, 'selector'=>'.wrap.wpl-wp h2', 'content'=>$content, 'position'=>array('edge'=>'top', 'align'=>'left'), 'buttons'=>array(2=>array('label'=>__('Next', 'wpl'))));

$content = '<h3>'.__('WPL Kind/Entities', 'wpl').'</h3><p>'.__('Switch between WPL kind/entities to manage kind fields.', 'wpl').'</p>';
$tips[] = array('id'=>2, 'selector'=>'.wpl-tabs .wpl-selected-tab', 'content'=>$content, 'position'=>array('edge'=>'top', 'align'=>'left'), 'buttons'=>array(2=>array('label'=>__('Next', 'wpl'), 'code'=>''), 3=>array('label'=>__('Previous', 'wpl'))));

$content = '<h3>'.__('Data Categories', 'wpl').'</h3><p>'.__('Each field in WPL has a data category. Choose a category to manage the related fields. ', 'wpl').'</p>';
$tips[] = array('id'=>3, 'selector'=>'.side-tabs-wp .active', 'content'=>$content, 'position'=>array('edge'=>'left', 'align'=>'center'), 'buttons'=>array(2=>array('label'=>__('Next', 'wpl')), 3=>array('label'=>__('Previous', 'wpl'), 'code'=>'')));

$content = '<h3>'.__('Mandatory/Optional fields', 'wpl').'</h3><p>'.__('Select or deselect the star icon to make a field mandatory or option.', 'wpl').'</p>';
$tips[] = array('id'=>4, 'selector'=>'table.widefat.page tr:nth-child(1) td:nth-child(7)', 'content'=>$content, 'position'=>array('edge'=>'bottom', 'align'=>'center'), 'buttons'=>array(2=>array('label'=>__('Next', 'wpl')), 3=>array('label'=>__('Previous', 'wpl'))));

$content = '<h3>'.__('Edit fields', 'wpl').'</h3><p>'.__('Use the edit icon to modify field details.', 'wpl').'</p>';
$tips[] = array('id'=>5, 'selector'=>'table.widefat.page tr:nth-child(1) td:nth-child(8)', 'content'=>$content, 'position'=>array('edge'=>'bottom', 'align'=>'center'), 'buttons'=>array(2=>array('label'=>__('Next', 'wpl')), 3=>array('label'=>__('Previous', 'wpl'))));

$content = '<h3>'.__('Disable/Enable fields', 'wpl').'</h3><p>'.__("If you don't need a field, disable it. You can enable it again, if needed.", 'wpl').'</p>';
$tips[] = array('id'=>6, 'selector'=>'table.widefat.page tr:nth-child(1) td:nth-child(10)', 'content'=>$content, 'position'=>array('edge'=>'bottom', 'align'=>'center'), 'buttons'=>array(2=>array('label'=>__('Next', 'wpl')), 3=>array('label'=>__('Previous', 'wpl'))));

$content = '<h3>'.__('Add new fields', 'wpl').'</h3><p>'.__("Any field missed? Don't worry. You can add your desired fields in less than 1 minute.", 'wpl').'</p>';
$tips[] = array('id'=>7, 'selector'=>'.flex-right-panel h3', 'content'=>$content, 'position'=>array('edge'=>'right', 'align'=>'top'), 'buttons'=>array(3=>array('label'=>__('Previous', 'wpl'))));

return $tips;