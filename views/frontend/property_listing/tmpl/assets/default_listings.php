<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

$description_column = 'field_308';
if(wpl_global::check_multilingual_status() and wpl_addon_pro::get_multiligual_status_by_column($description_column, $this->kind)) $description_column = wpl_addon_pro::get_column_lang_name($description_column, wpl_global::get_current_language(), false);

// Membership ID of current user
$current_user_membership_id = wpl_users::get_user_membership();

foreach($this->wpl_properties as $key=>$property)
{
    if($key == 'current') continue;

    /** unset previous property **/
    unset($this->wpl_properties['current']);

    /** set current property **/
    $this->wpl_properties['current'] = $property;

    if(isset($property['materials']['bedrooms']['value']) and trim($property['materials']['bedrooms']['value'])) $room = sprintf('<div class="bedroom"><span class="value">%s</span><span class="name">%s</span></div>', $property['materials']['bedrooms']['value'], __("Bedroom(s)", "wpl"));
	elseif(isset($property['materials']['rooms']['value']) and trim($property['materials']['rooms']['value'])) $room = sprintf('<div class="room"><span class="value">%s</span><span class="name">%s</span></div>', $property['materials']['rooms']['value'], __("Room(s)", "wpl"));
	else $room = '';

	$bathroom = (isset($property['materials']['bathrooms']['value']) and trim($property['materials']['bathrooms']['value'])) ? sprintf('<div class="bathroom"><span class="value">%s</span><span class="name">%s</span></div>', $property['materials']['bathrooms']['value'], __("Bathroom(s)", "wpl")) : '';
	$parking = (isset($property['materials']['f_150']['values'][0]) and trim($property['materials']['f_150']['values'][0])) ? sprintf('<div class="parking"><span class="value">%s</span><span class="name">%s</span></div>', $property['materials']['bathrooms']['value'], __("Parking(s)", "wpl")) : '';
	$pic_count = (isset($property['raw']['pic_numb']) and trim($property['raw']['pic_numb'])) ? sprintf('<div class="pic_count"><span class="value">%s</span><span class="name">%s</span></div>', $property['raw']['pic_numb'], __("Picture(s)", "wpl")) : '';
	
	$living_area = isset($property['materials']['living_area']['value']) ? explode(' ', $property['materials']['living_area']['value']) : (isset($property['materials']['lot_area']['value']) ? explode(' ', $property['materials']['lot_area']['value']): array());
	$living_area_count = count($living_area);
	
	$build_up_area = $living_area_count ? '<div class="built_up_area">'.(isset($living_area[0]) ? implode(' ', array_slice($living_area, 0, $living_area_count-1)) : '').'<span>'.$living_area[$living_area_count-1].'</span></div>' : '';
	$property_price = isset($property['materials']['price']['value']) ? $property['materials']['price']['value'] : '&nbsp;';
    
    $description = stripslashes(strip_tags($property['raw'][$description_column]));
    $cut_position = strrpos(substr($description, 0, 400), '.', -1);
    if(!$cut_position) $cut_position = 399;
    ?>
	<div class="wpl-column">
		<div class="wpl_prp_cont wpl_prp_cont_old
			<?php echo ((isset($this->property_css_class) and in_array($this->property_css_class, array('row_box', 'grid_box'))) ? $this->property_css_class : ''); ?>"
				  id="wpl_prp_cont<?php echo $property['data']['id']; ?>"
				  <?php	echo $this->itemscope.' '.$this->itemtype_SingleFamilyResidence; ?> >
			<div class="wpl_prp_top">
				<div class="wpl_prp_top_boxes front">
					<?php wpl_activity::load_position('wpl_property_listing_image', array('wpl_properties'=>$this->wpl_properties)); ?>
				</div>
				<div class="wpl_prp_top_boxes back">
					<a <?php echo $this->itemprop_url;?> id="prp_link_id_<?php echo $property['data']['id']; ?>" href="<?php echo $property['property_link']; ?>" class="view_detail"><?php echo __('More Details', 'wpl'); ?></a>
				</div>
			</div>
			<div class="wpl_prp_bot">

				<a <?php echo 'id="prp_link_id_'.$property['data']['id'].'_view_detail" href="'.$property['property_link'].'" class="view_detail" title="'.$property['property_title'].'"'; ?>>
				  <h3 class="wpl_prp_title"	<?php echo $this->itemprop_name; ?> > <?php echo $property['property_title'] ?></h3>
				</a>
                
                <?php $location_visibility = wpl_property::location_visibility($property['data']['id'], $property['data']['kind'], $current_user_membership_id); ?>
				<h4 class="wpl_prp_listing_location"><span <?php echo $this->itemprop_address.''.$this->itemscope.' '.$this->itemtype_PostalAddress;?> ><span <?php echo $this->itemprop_addressLocality; ?>><?php echo ($location_visibility === true ? $property['location_text'] : $location_visibility);?></span></span></h4>

				<div class="wpl_prp_listing_icon_box"><?php echo $room . $bathroom . $parking . $pic_count . $build_up_area; ?></div>
				<div class="wpl_prp_desc" <?php echo $this->itemprop_description; ?>><?php echo substr($description, 0, $cut_position + 1); ?></div>
			</div>
			<div class="price_box" <?php echo $this->itemscope.' '.$this->itemtype_offer; ?>>
				<span <?php echo $this->itemprop_price; ?>><?php echo $property_price; ?></span>
			</div>
		</div>
	</div>
    <?php
}