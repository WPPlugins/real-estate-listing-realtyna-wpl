<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

/** set params **/
$user_id = isset($params['user_id']) ? $params['user_id'] : '';
$wpl_properties = isset($params['wpl_properties']) ? $params['wpl_properties'] : NULL;
$picture_width = isset($params['picture_width']) ? $params['picture_width'] : 'auto';
$picture_height = isset($params['picture_height']) ? $params['picture_height'] : '145';
$mailto = isset($params['mailto']) ? $params['mailto'] : 0;

$description_column = 'about';
if(wpl_global::check_multilingual_status() and wpl_addon_pro::get_multiligual_status_by_column($description_column, 2)) $description_column = wpl_addon_pro::get_column_lang_name($description_column, wpl_global::get_current_language(), false);

/** getting user id from current property (used in property_show and property_listing) **/
if(!trim($user_id)) $user_id = $wpl_properties['current']['data']['user_id'];

$wpl_user = wpl_users::full_render($user_id, wpl_users::get_pshow_fields(), NULL, array(), true);

/** resizing profile image **/
$params['image_parentid'] = $user_id;
$params['image_name']     = isset($wpl_user['profile_picture']['name']) ? $wpl_user['profile_picture']['name'] : '';
$profile_path             = isset($wpl_user['profile_picture']['path']) ? $wpl_user['profile_picture']['path'] : '';
$profile_image            = wpl_images::create_profile_images($profile_path, $picture_width, $picture_height, $params);

/** resizing company logo **/
$params['image_parentid'] = $user_id;
$params['image_name']     = isset($wpl_user['company_logo']['name']) ? $wpl_user['company_logo']['name'] : '';
$logo_path                = isset($wpl_user['company_logo']['path']) ? $wpl_user['company_logo']['path'] : '';
$logo_image               = isset($wpl_user['company_logo']['url']) ? $wpl_user['company_logo']['url'] : '';

$agent_name               = isset($wpl_user['materials']['first_name']['value']) ? $wpl_user['materials']['first_name']['value'] : '';
$agent_l_name             = isset($wpl_user['materials']['last_name']['value']) ? $wpl_user['materials']['last_name']['value'] : '';
$company_name             = isset($wpl_user['materials']['company_name']['value']) ? $wpl_user['materials']['company_name']['value'] : '';
$description              = stripslashes($wpl_user['raw'][$description_column]);
$description              = (!preg_match('!!u', $description) ? utf8_decode($description) : $description);

/** Preparing website URL **/
$website = '';
if(isset($wpl_user['materials']['website']['value']))
{
	$website = $wpl_user['materials']['website']['value'];
	if(stripos($website, 'http://') === false and stripos($website, 'https://') === false)
	{
		$website = 'http://'.$website;
	}
}
?>
<div <?php echo $this->itemscope.' '.$this->itemtype_RealEstateAgent; ?> class="wpl_agent_info clearfix" id="wpl_agent_info">
	<div class="wpl_agent_details clearfix">
		<div class="wpl_agent_info_l wpl_agent_info_pic" style="width:<?php echo $picture_width; ?>">
			<?php
			if(isset($wpl_user['profile_picture'])) echo '<img '.$this->itemprop_image.' src="'.$profile_image.'" alt="'.$agent_name. ' '.$agent_l_name.'" />';
			else echo '<div class="no_image"></div>';
			?>
		</div>
		<div class="wpl_agent_info_detail">
			<div class="wpl_agent_info_c wpl-large-8 wpl-medium-8 wpl-small-12 wpl-column clearfix">
				<div class="wpl_profile_container_title" <?php echo $this->itemprop_name; ?>>
					<?php echo $agent_name. ' '.$agent_l_name; ?>
				</div>
				<ul>
					<?php if($website): ?>
						<li class="website"><a <?php echo $this->itemprop_url; ?> href="<?php echo $website; ?>" target="_blank"><?php echo __('View website', 'wpl') ?></a></li>
					<?php endif; ?>

					<?php if(isset($wpl_user['materials']['tel']['value'])): ?>
						<li class="tel" <?php echo $this->itemprop_telephone; ?> ><a href="tel:<?php echo $wpl_user['materials']['tel']['value']; ?>"><?php echo $wpl_user['materials']['tel']['value']; ?></a></li>
					<?php endif; ?>

					<?php if(isset($wpl_user['materials']['mobile']['value'])): ?>
						<li class="mobile" <?php echo $this->itemprop_telephone; ?> ><a href="tel:<?php echo $wpl_user['materials']['mobile']['value']; ?>"><?php echo $wpl_user['materials']['mobile']['value']; ?></a></li>
					<?php endif; ?>

					<?php if(isset($wpl_user['materials']['fax']['value'])): ?>
						<li class="fax" <?php echo $this->itemprop_faxNumber; ?> ><?php echo $wpl_user['materials']['fax']['value']; ?></li>
					<?php endif; ?>

					<?php if(isset($wpl_user['main_email_url'])): ?>
						<li class="email">
							<?php if($mailto): ?>
								<a <?php echo $this->itemprop_email; ?> href="mailto:<?php echo $wpl_user['materials']['main_email']['value']; ?>"><img src="<?php echo $wpl_user['main_email_url']; ?>" alt="<?php echo $agent_name. ' '.$agent_l_name; ?>" /></a>
							<?php else: ?>
								<img src="<?php echo $wpl_user['main_email_url']; ?>" alt="<?php echo $agent_name. ' '.$agent_l_name; ?>" />
							<?php endif; ?>
						</li>
					<?php endif; ?>

					<?php if(isset($wpl_user['second_email_url'])): ?>
						<li class="second_email">
							<?php if($mailto): ?>
								<a <?php echo $this->itemprop_email; ?> href="mailto:<?php echo $wpl_user['materials']['secondary_email']['value']; ?>"><img src="<?php echo $wpl_user['second_email_url']; ?>" alt="<?php echo $agent_name. ' '.$agent_l_name; ?>" /></a>
							<?php else: ?>
								<img src="<?php echo $wpl_user['second_email_url']; ?>" alt="<?php echo $agent_name. ' '.$agent_l_name; ?>" />
							<?php endif; ?>
						</li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="wpl_agent_info_r wpl-large-4 wpl-medium-4 wpl-small-12  wpl-column">
				<?php
				if(isset($wpl_user['company_logo'])) echo '<img '.$this->itemprop_logo.' src="'.$logo_image.'" alt="'.$company_name.'" />';
				if(trim($company_name) != '') echo '<div class="company" '.$this->itemprop_name.'>'.$company_name.'</div>';
				if(isset($wpl_user['materials']['company_address'])) echo '<div class="location" '.$this->itemprop_address.''.$this->itemscope.' '.$this->itemtype_PostalAddress.' ><span '.$this->itemprop_addressLocality.'>'.$wpl_user['materials']['company_address']['value'].'</Span></div>';
				?>
			</div>
		</div>
	</div>
	<div class="wpl_agent_about" <?php echo $this->itemprop_description; ?> ><?php echo $description;?></div>
</div>