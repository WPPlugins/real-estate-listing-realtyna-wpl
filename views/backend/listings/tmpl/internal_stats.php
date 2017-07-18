<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
?>
<div class="panel-wp lm-search-form-wp">
    <h3><?php echo __('Stats', 'wpl'); ?></h3>

    <div id="wpl_listing_manager_stats_cnt" class="panel-body">
        <div class="pwizard-panel">
            <div class="pwizard-section">
                <div class="wpl-backend-table">
                    <div class="tr th table-header">
                        <div class="td"><?php echo __('Blog Name', 'wpl'); ?></div>
                        <div class="td"><?php echo __('Property Visits', 'wpl'); ?></div>
                        <?php if(wpl_global::check_addon('crm')): ?>
                            <div class="td"><?php echo __('CRM Requests', 'wpl'); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php foreach ($this->stats as $stat): ?>
                        <div class="tr">
                        <div class="td">
                            <span><?php echo $stat['blog_name']; ?></span>
                        </div>
                        <div class="td">
                            <span><?php echo $stat['property_visits'] ? $stat['property_visits'] : 0; ?></span>
                        </div>
                        <?php if(wpl_global::check_addon('crm')): ?>
                        <div class="td">
                            <span><?php echo $stat['crm_requests']; ?></span>
                        </div>
                        <?php endif; ?>

                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>