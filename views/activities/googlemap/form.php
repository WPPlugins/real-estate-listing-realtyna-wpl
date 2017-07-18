<?php
/** no direct access * */
defined('_WPLEXEC') or die('Restricted access');
?>
<div class="wpl-gen-accordion wpl-gen-accordion-active">
    <h4 class="wpl-gen-accordion-title" id="wpl_accordion1"><?php echo __('Basic Options', 'wpl'); ?></h4>
    <div class="wpl-gen-accordion-cnt" id="wpl_accordion1_cnt">
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_googlemap_type"><?php echo __('Map Type', 'wpl'); ?></label>
            <select class="text_box" name="option[googlemap_type]" id="wpl_o_googlemap_type">
                <option value="0" <?php if(isset($this->options->googlemap_type) and $this->options->googlemap_type == 0) echo 'selected="selected"'; ?>><?php echo __('Typical', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->googlemap_type) and $this->options->googlemap_type == 1) echo 'selected="selected"'; ?>><?php echo __('Street View', 'wpl'); ?></option>
            </select>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_googlemap_view"><?php echo __('Map View', 'wpl'); ?></label>
            <select class="text_box" name="option[googlemap_view]" id="wpl_o_googlemap_view">
                <option value="ROADMAP" <?php if(isset($this->options->googlemap_view) and $this->options->googlemap_view == 'ROADMAP') echo 'selected="selected"'; ?>><?php echo __('Roadmap', 'wpl'); ?></option>
                <option value="SATELLITE" <?php if(isset($this->options->googlemap_view) and $this->options->googlemap_view == 'SATELLITE') echo 'selected="selected"'; ?>><?php echo __('Satellite', 'wpl'); ?></option>
                <option value="HYBRID" <?php if(isset($this->options->googlemap_view) and $this->options->googlemap_view == 'HYBRID') echo 'selected="selected"'; ?>><?php echo __('Hybrid', 'wpl'); ?></option>
                <option value="TERRAIN" <?php if(isset($this->options->googlemap_view) and $this->options->googlemap_view == 'TERRAIN') echo 'selected="selected"'; ?>><?php echo __('Terrain', 'wpl'); ?></option>
                <option value="WPL" <?php if(isset($this->options->googlemap_view) and $this->options->googlemap_view == 'WPL') echo 'selected="selected"'; ?>><?php echo __('WPL Style', 'wpl'); ?></option>
            </select>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_default_lt"><?php echo __('Default latitude', 'wpl'); ?></label>
            <input class="text_box" name="option[default_lt]" type="text" id="wpl_o_default_lt" value="<?php echo isset($this->options->default_lt) ? $this->options->default_lt : '38.685516'; ?>" />
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_default_ln"><?php echo __('Default longitude', 'wpl'); ?></label>
            <input class="text_box" name="option[default_ln]" type="text" id="wpl_o_default_ln" value="<?php echo isset($this->options->default_ln) ? $this->options->default_ln : '-101.073324'; ?>" />
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_default_zoom"><?php echo __('Default zoom level', 'wpl'); ?></label>
            <input class="text_box" name="option[default_zoom]" type="text" id="wpl_o_default_zoom" value="<?php echo isset($this->options->default_zoom) ? $this->options->default_zoom : '4'; ?>" />
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_scroll_wheel"><?php echo __('Scroll wheel zoom', 'wpl'); ?></label>
            <select class="text_box" name="option[scroll_wheel]" id="wpl_o_scroll_wheel">
                <option value="false" <?php if(isset($this->options->scroll_wheel) and $this->options->scroll_wheel == 'false') echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="true" <?php if(isset($this->options->scroll_wheel) and $this->options->scroll_wheel == 'true') echo 'selected="selected"'; ?>><?php echo __('Enabled', 'wpl'); ?></option>
            </select>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_map_height"><?php echo __('Map height', 'wpl'); ?></label>
            <input class="text_box" name="option[map_height]" type="text" id="wpl_o_map_height" value="<?php echo isset($this->options->map_height) ? $this->options->map_height : '480'; ?>" />
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_infowindow_event"><?php echo __('Infowindow Event', 'wpl'); ?></label>
            <select class="text_box" name="option[infowindow_event]" id="wpl_o_infowindow_event">
                <option value="click" <?php if(isset($this->options->infowindow_event) and $this->options->infowindow_event == 'click') echo 'selected="selected"'; ?>><?php echo __('Click', 'wpl'); ?></option>
                <option value="mouseover" <?php if(isset($this->options->infowindow_event) and $this->options->infowindow_event == 'mouseover') echo 'selected="selected"'; ?>><?php echo __('Mouse Over', 'wpl'); ?></option>
            </select>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_overviewmap"><?php echo __('Overview Map', 'wpl'); ?></label>
            <select class="text_box" name="option[overviewmap]" id="wpl_o_overviewmap">
                <option value="0" <?php if(isset($this->options->overviewmap) and $this->options->overviewmap == 0) echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->overviewmap) and $this->options->overviewmap == 1) echo 'selected="selected"'; ?>><?php echo __('Enabled', 'wpl'); ?></option>
            </select>
        </div>
        <?php if(wpl_global::check_addon('aps')): ?>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_get_direction"><?php echo __('Get Direction', 'wpl'); ?></label>
            <select class="text_box" name="option[get_direction]" id="wpl_o_get_direction">
                <option value="0" <?php if(isset($this->options->get_direction) and $this->options->get_direction == 0) echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->get_direction) and $this->options->get_direction == 1) echo 'selected="selected"'; ?>><?php echo __('Enabled', 'wpl'); ?></option>
                <option value="2" <?php if(isset($this->options->get_direction) and $this->options->get_direction == 2) echo 'selected="selected"'; ?>><?php echo __('Enabled - Show Direction Text', 'wpl'); ?></option>
            </select>
        </div>
        <?php endif; ?>
        <?php if(wpl_global::check_addon('spatial')): ?>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_spatial"><?php echo __('Spatial API', 'wpl'); ?></label>
            <select class="text_box" name="option[spatial]" id="wpl_o_spatial">
                <option value="0" <?php if(isset($this->options->spatial) and $this->options->spatial == 0) echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->spatial) and $this->options->spatial == 1) echo 'selected="selected"'; ?>><?php echo __('Enabled', 'wpl'); ?></option>
            </select>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php if(wpl_global::check_addon('aps')): ?>
<div class="wpl-gen-accordion">
    <h4 class="wpl-gen-accordion-title" id="wpl_accordion2"><?php echo __('Map Search', 'wpl'); ?></h4>
    <div class="wpl-gen-accordion-cnt" id="wpl_accordion2_cnt">
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_map_search"><?php echo __('Map Search', 'wpl'); ?></label>
            <select class="text_box" name="option[map_search]" id="wpl_o_map_search">
                <option value="0" <?php if(isset($this->options->map_search) and $this->options->map_search == 0) echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->map_search) and $this->options->map_search == 1) echo 'selected="selected"'; ?>><?php echo __('Enabled - Checked', 'wpl'); ?></option>
                <option value="2" <?php if(isset($this->options->map_search) and $this->options->map_search == 2) echo 'selected="selected"'; ?>><?php echo __('Enabled - Unchecked', 'wpl'); ?></option>
            </select>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_map_search_toggle"><?php echo __('Map Search Toggle', 'wpl'); ?></label>
            <select class="text_box" name="option[map_search_toggle]" id="wpl_o_map_search_toggle">
                <option value="0" <?php if(isset($this->options->map_search_toggle) and $this->options->map_search_toggle == 0) echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->map_search_toggle) and $this->options->map_search_toggle == 1) echo 'selected="selected"'; ?>><?php echo __('Enabled', 'wpl'); ?></option>
            </select>
        </div>
    </div>
</div>
<div class="wpl-gen-accordion">
    <h4 class="wpl-gen-accordion-title" id="wpl_accordion6"><?php echo __('Marker Clustering', 'wpl'); ?></h4>
    <div class="wpl-gen-accordion-cnt" id="wpl_accordion6_cnt">
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_clustering"><?php echo __('Marker Clustering', 'wpl'); ?></label>
            <select class="text_box" name="option[clustering]" id="wpl_o_clustering">
                <option value="0" <?php if(isset($this->options->clustering) and $this->options->clustering == 0) echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->clustering) and $this->options->clustering == 1) echo 'selected="selected"'; ?>><?php echo __('Enabled', 'wpl'); ?></option>
            </select>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="wpl-gen-accordion">
    <h4 class="wpl-gen-accordion-title" id="wpl_accordion3"><?php echo __('Google Place', 'wpl'); ?></h4>
    <div class="wpl-gen-accordion-cnt" id="wpl_accordion3_cnt">
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_google_place"><?php echo __('Google place', 'wpl'); ?></label>
            <?php if(!wpl_global::check_addon('pro')): ?>
            <span id="wpl_o_google_place" class="gray_tip"><?php echo __('Pro addon must be installed for this!', 'wpl'); ?></span>
            <?php else: ?>
            <select class="text_box" name="option[google_place]" id="wpl_o_google_place">
                <option value="0" <?php if(isset($this->options->google_place) and $this->options->google_place == 0) echo 'selected="selected"'; ?>><?php echo __('Disable', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->google_place) and $this->options->google_place == 1) echo 'selected="selected"'; ?>><?php echo __('Enable', 'wpl'); ?></option>
            </select>
            <?php endif; ?>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_google_place_radius"><?php echo __('Google place radius', 'wpl'); ?></label>
            <?php if(!wpl_global::check_addon('pro')): ?>
            <span id="wpl_o_google_place_radius" class="gray_tip"><?php echo __('Pro addon must be installed for this!', 'wpl'); ?></span>
            <?php else: ?>
            <input class="text_box" name="option[google_place_radius]" type="text" id="wpl_o_google_place_radius" value="<?php echo isset($this->options->google_place_radius) ? $this->options->google_place_radius : '1000'; ?>" />
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if(wpl_global::check_addon('demographic')): ?>
<div class="wpl-gen-accordion">
    <h4 class="wpl-gen-accordion-title" id="wpl_accordion4"><?php echo __('Demographic', 'wpl'); ?></h4>
    <div class="wpl-gen-accordion-cnt" id="wpl_accordion4_cnt">
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic"><?php echo __('Demographic', 'wpl'); ?></label>
            <select class="text_box" name="option[demographic]" id="wpl_o_demographic">
                <option value="0" <?php if(isset($this->options->demographic) and $this->options->demographic == 0) echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->demographic) and $this->options->demographic == 1) echo 'selected="selected"'; ?>><?php echo __('Enabled', 'wpl'); ?></option>
            </select>
        </div>
        <?php
            /** Demographic Object **/
            _wpl_import('libraries.addon_demographic');
            $this->demographic = new wpl_addon_demographic();
            $this->categories = $this->demographic->get_categries();
        ?>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic_category"><?php echo __('Category', 'wpl'); ?></label>
            <select class="text_box" name="option[demographic_category]" id="wpl_o_demographic_category">
                <?php foreach($this->categories as $category): ?>
                <option value="<?php echo $category; ?>" <?php echo ((isset($this->options->demographic_category) and $this->options->demographic_category == $category) ? 'selected="selected"' : ''); ?>><?php echo __(wpl_global::human_readable($category), 'wpl'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic_color"><?php echo __('Color', 'wpl'); ?></label>
            <input class="text_box" type="text" name="option[demographic_color]" id="wpl_o_demographic_color" value="<?php echo isset($this->options->demographic_color) ? $this->options->demographic_color : '88c1e1'; ?>" />
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic_bcolor"><?php echo __('Border Color', 'wpl'); ?></label>
            <input class="text_box" type="text" name="option[demographic_bcolor]" id="wpl_o_demographic_bcolor" value="<?php echo isset($this->options->demographic_bcolor) ? $this->options->demographic_bcolor : '549cf2'; ?>" />
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic_hcolor"><?php echo __('Hover Color', 'wpl'); ?></label>
            <input class="text_box" type="text" name="option[demographic_hcolor]" id="wpl_o_demographic_hcolor" value="<?php echo isset($this->options->demographic_hcolor) ? $this->options->demographic_hcolor : 'fefefe'; ?>" />
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic_fill_opacity"><?php echo __('Fill Opacity', 'wpl'); ?></label>
            <input class="text_box" type="text" name="option[demographic_fill_opacity]" id="wpl_o_demographic_fill_opacity" value="<?php echo isset($this->options->demographic_fill_opacity) ? $this->options->demographic_fill_opacity : '0.25'; ?>" />
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic_auto_color"><?php echo __('Auto Color', 'wpl'); ?></label>
            <select class="text_box" id="wpl_o_demographic_auto_color" name="option[demographic_auto_color]">
                <option value="0"><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="average_home_value" <?php echo ((isset($this->options->demographic_auto_color) and $this->options->demographic_auto_color == 'average_home_value') ? 'selected="selected"' : ''); ?>><?php echo __('Average Home Value', 'wpl'); ?></option>
                <option value="median_income" <?php echo ((isset($this->options->demographic_auto_color) and $this->options->demographic_auto_color == 'median_income') ? 'selected="selected"' : ''); ?>><?php echo __('Median Income', 'wpl'); ?></option>
                <option value="population" <?php echo ((isset($this->options->demographic_auto_color) and $this->options->demographic_auto_color == 'population') ? 'selected="selected"' : ''); ?>><?php echo __('Population', 'wpl'); ?></option>
            </select>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic_show_map_guide"><?php echo __('Show Map Guide', 'wpl'); ?></label>
            <select class="text_box" id="wpl_o_demographic_show_map_guide" name="option[demographic_show_map_guide]">
                <option value="0" <?php echo ((isset($this->options->demographic_show_map_guide) and $this->options->demographic_show_map_guide == 0) ? 'selected="selected"' : ''); ?>><?php echo __('No', 'wpl'); ?></option>
                <option value="1" <?php echo ((isset($this->options->demographic_show_map_guide) and $this->options->demographic_show_map_guide == 1) ? 'selected="selected"' : ''); ?>><?php echo __('Yes', 'wpl'); ?></option>
            </select>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic_layer_toggle"><?php echo __('Layer Toggle', 'wpl'); ?></label>
            <select class="text_box" id="wpl_o_demographic_layer_toggle" name="option[demographic_layer_toggle]">
                <option value="0" <?php echo ((isset($this->options->demographic_layer_toggle) and $this->options->demographic_layer_toggle == 0) ? 'selected="selected"' : ''); ?>><?php echo __('No', 'wpl'); ?></option>
                <option value="1" <?php echo ((isset($this->options->demographic_layer_toggle) and $this->options->demographic_layer_toggle == 1) ? 'selected="selected"' : ''); ?>><?php echo __('Yes - Checked', 'wpl'); ?></option>
                <option value="2" <?php echo ((isset($this->options->demographic_layer_toggle) and $this->options->demographic_layer_toggle == 2) ? 'selected="selected"' : ''); ?>><?php echo __('Yes - Unchecked', 'wpl'); ?></option>
            </select>
        </div>
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_o_demographic_show_categories"><?php echo __('Show Categories', 'wpl'); ?></label>
            <select class="text_box" id="wpl_o_demographic_show_categories" name="option[demographic_show_categories]">
                <option value="0" <?php echo ((isset($this->options->demographic_show_categories) and $this->options->demographic_show_categories == 0) ? 'selected="selected"' : ''); ?>><?php echo __('No', 'wpl'); ?></option>
                <option value="1" <?php echo ((isset($this->options->demographic_show_categories) and $this->options->demographic_show_categories == 1) ? 'selected="selected"' : ''); ?>><?php echo __('Yes', 'wpl'); ?></option>
            </select>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(wpl_global::check_addon('aps')): ?>
<div class="wpl-gen-accordion">
    <h4 class="wpl-gen-accordion-title" id="wpl_accordion5"><?php echo __('Property Preview', 'wpl'); ?></h4>
    <div class="wpl-gen-accordion-cnt" id="wpl_accordion5_cnt">
        <div class="wpl-gen-accordion-row fanc-row">
            <label for="wpl_map_property_preview"><?php echo __('Property Preview', 'wpl'); ?></label>
            <select class="text_box" name="option[map_property_preview]" id="wpl_map_property_preview">
                <option value="0" <?php if(isset($this->options->map_property_preview) and $this->options->map_property_preview == 0) echo 'selected="selected"'; ?>><?php echo __('Disabled', 'wpl'); ?></option>
                <option value="1" <?php if(isset($this->options->map_property_preview) and $this->options->map_property_preview == 1) echo 'selected="selected"'; ?>><?php echo __('Enabled', 'wpl'); ?></option>
            </select>
            <p><i><?php echo __('Note: To use this feature, the Map Search field must be enabled!', 'wpl') ?></i></p>
        </div>
</div>
<?php endif; ?>