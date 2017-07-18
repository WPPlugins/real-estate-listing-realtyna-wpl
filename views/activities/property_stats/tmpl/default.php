<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/** set params **/
$wpl_properties = isset($params['property_data']) ? $params['property_data'] : array();
$property_id = isset($wpl_properties['data']['id']) ? $wpl_properties['data']['id'] : NULL;

$show_contacts = (isset($params['contacts']) and $params['contacts']) ? 1 : 0;
$show_including_in_listing = (isset($params['including_in_listing']) and $params['including_in_listing']) ? 1 : 0;
$show_view_parent = (isset($params['view_parent']) and $params['view_parent']) ? 1 : 0;
$show_visit = (isset($params['visit']) and $params['visit']) ? 1 : 0;
?>
<div class="wpl_property_stats_container" id="wpl_property_stats_container<?php echo $property_id; ?>">

    <div class="wpl_property_stats_title">
        <span><?php echo __('Property Statistics', 'wpl'); ?></span>
    </div>

    <div class="wpl_property_stats_inner">
        <?php if($show_contacts):
        $contacts = wpl_items::get_items($property_id, 'contact_stat');
    ?>
    <div class="property_stats_contacts">
        <div>
            <span><?php echo __('Contacts', 'wpl') ?></span>: <b><?php if(!empty($contacts)) foreach($contacts as $contact) echo $contact->item_name; else echo 0; ?></b>
        </div>
    </div>
    <?php endif; ?>

        <?php if($show_including_in_listing):
        $inc_in_listings_stat = wpl_items::get_items($property_id, 'inc_in_listings_stat');
        ?>
        <div class="property_stats_contacts">
            <div>
                <span><?php echo __('Including in listings', 'wpl') ?>:</span> <b><?php if(!empty($inc_in_listings_stat)) foreach($inc_in_listings_stat as $inc_in_listings) echo $inc_in_listings->item_name; else echo 0; ?></b>
            </div>
        </div>
    <?php endif; ?>

        <?php if($show_view_parent):
        $view_parent = wpl_items::get_items($property_id, 'view_parent_stat');
        ?>
        <div class="property_stats_contacts">
            <div>
                <span><?php echo __('Show parent', 'wpl') ?>:</span> <b><?php if(!empty($view_parent)) foreach($view_parent as $view) echo $view->item_name; else echo 0; ?></b>
            </div>
        </div>
    <?php endif; ?>

        <?php if($show_visit):
            $visit_count = wpl_db::select("SELECT `visit_time` FROM `#__wpl_properties` WHERE `id`='{$property_id}'", 'loadResult');
            ?>
            <div class="property_stats_contacts">
                <div>
                    <span><?php echo __('Visits', 'wpl') ?></span>: <b><?php echo $visit_count; ?></b>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>