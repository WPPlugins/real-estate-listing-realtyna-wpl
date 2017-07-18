<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

$sort_options = wpl_sort_options::get_sort_options(2, 1);
?>
<div class="wpl_sort_options_container">
    
    <?php if(count($sort_options)): ?>
    <div class="wpl_sort_options_container_title"><?php echo __('Sort Option', 'wpl') ?></div>
    <?php echo $this->model->generate_sorts(); ?>
    <?php endif; ?>
    
    <?php if($this->property_css_class_switcher): ?>
    <div class="wpl_list_grid_switcher <?php if($this->switcher_type == "icon+text") echo 'wpl-list-grid-switcher-icon-text'; ?>">
        <div id="grid_view" class="<?php echo ($this->switcher_type == "icon") ? 'wpl-tooltip-top ' : ''; ?>grid_view <?php if($this->property_css_class == 'grid_box' || $this->property_css_class == 'map_box') echo 'active'; ?>">
            <?php if($this->switcher_type == "icon+text") echo '<span>'.__('Grid', 'wpl').'</span>'; ?>
        </div>
        <?php if ($this->switcher_type == "icon"): ?>
            <div class="wpl-util-hidden"><?php _e('Grid', 'wpl') ?></div>
        <?php endif; ?>
        <div id="list_view" class="<?php echo ($this->switcher_type == "icon") ? 'wpl-tooltip-top ' : ''; ?>list_view <?php if($this->property_css_class == 'row_box') echo 'active'; ?>">
            <?php if($this->switcher_type == "icon+text") echo '<span>'.__('List', 'wpl').'</span>'; ?>
        </div>
        <?php if ($this->switcher_type == "icon"): ?>
            <div class="wpl-util-hidden"><?php _e('List', 'wpl') ?></div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<div class="wpl-row wpl-expanded <?php if($this->property_css_class == "grid_box" || $this->property_css_class == 'map_box') echo "wpl-small-up-1 wpl-medium-up-2 wpl-large-up-".$this->profile_columns; ?>  wpl_profile_listing_profiles_container clearfix">
  <?php echo $this->profiles_str; ?>
</div>

<?php if($this->wplpagination != 'scroll'): ?>
<div class="wpl_pagination_container">
    <?php echo $this->pagination->show(); ?>
</div>
<?php endif;