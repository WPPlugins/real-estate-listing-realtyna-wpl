<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
?>
<script type="text/javascript">
jQuery(document).ready(function()
{
    wplj('#wpl_clear_cache_form').on('submit', function(e)
    {
        e.preventDefault();
        
        var data = wplj('#wpl_clear_cache_form').serialize();
        var confirmed = wplj('#wpl_clear_cache_confirm').val();
        
        if(confirmed == 0)
        {
            var message = "<?php echo addslashes(__("Are you sure?", 'wpl')); ?>";
            message += '&nbsp;<span class="wpl_actions" onclick="wpl_clear_cache_confirm();"><?php echo addslashes(__('Yes', 'wpl')); ?></span>&nbsp;<span class="wpl_actions" onclick="wpl_remove_message();"><?php echo addslashes(__('No', 'wpl')); ?></span>';

            wpl_show_messages(message, '.wpl_maintenance .wpl_show_message');
            return false;
        }
        else if(confirmed) wpl_remove_message();
        
        /** Show AJAX loader **/
        var wpl_ajax_loader = Realtyna.ajaxLoader.show('#wpl_clear_cache_form_submit', 'tiny', 'leftOut');

        /** run ajax query **/
        var request_str = 'wpl_format=b:settings:ajax&wpl_function=clear_cache&_wpnonce=<?php echo $this->nonce; ?>&'+data;
        var ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str);

        ajax.success(function()
        {
            /** Remove AJAX loader **/
            Realtyna.ajaxLoader.hide(wpl_ajax_loader);
            
            wplj('#wpl_clear_cache_confirm').val('0');
        });
    });
    
    wplj('#wpl_cronjobs_toggle_form').on('submit', function(e)
    {
        e.preventDefault();
        
        var data = wplj('#wpl_cronjobs_toggle_form').serialize();
        
        /** Show AJAX loader **/
        var wpl_ajax_loader = Realtyna.ajaxLoader.show('#wpl_cronjobs_toggle_submit', 'tiny', 'rightOut');

        /** run ajax query **/
        var request_str = 'wpl_format=b:settings:ajax&wpl_function=toggle_cronjobs&_wpnonce=<?php echo $this->nonce; ?>&'+data;
        var ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str);

        ajax.success(function(response)
        {
            /** Remove AJAX loader **/
            Realtyna.ajaxLoader.hide(wpl_ajax_loader);
            
            wplj('#wpl_cronjobs_label').html(response.data.label);
            wplj('#wpl_cronjobs_toggle_submit').html(response.data.submit_label);
            wplj('#wpl_cronjobs_status').val(response.data.new_status);
        });
    });
});

function wpl_setting_save(setting_id, setting_name, setting_value, setting_category)
{
	wplj("#wpl_st_form_element"+setting_id).attr("disabled", "disabled");
	
	var element_type = wplj("#wpl_st_form_element"+setting_id).attr('type');
    var tag_name = wplj("#wpl_st_form_element"+setting_id).prop('tagName').toLowerCase();
	
	if(element_type == 'checkbox')
	{
		if(wplj("#wpl_st_form_element"+setting_id).is(':checked')) setting_value = 1;
		else setting_value = 0;
	}
    
    var ajax_loader_element = '#wpl_st_form_element'+setting_id;
    if(tag_name == 'select')
    {
        ajax_loader_element = '#wpl_st_form_element'+setting_id+'_chosen';
    }
	
    /** Show AJAX loader **/
    var wpl_ajax_loader = Realtyna.ajaxLoader.show(ajax_loader_element, 'tiny', 'rightOut');
	
	var request_str = 'wpl_format=b:settings:ajax&wpl_function=save&setting_name='+setting_name+'&setting_value='+encodeURIComponent(setting_value)+'&setting_category='+setting_category+'&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	var ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str);
	
	ajax.success(function(data)
	{
		wplj("#wpl_st_form_element"+setting_id).removeAttr("disabled");
		
		/** Remove AJAX loader **/
        Realtyna.ajaxLoader.hide(wpl_ajax_loader);
	});
}

function wpl_setting_show_shortcode(setting_id, shortcode_key, shortcode_value)
{
	wplj("#wpl_st_"+setting_id+"_shortcode_value").html(shortcode_key+'="'+shortcode_value+'"');
}

function wpl_clear_cache_confirm()
{
    wplj('#wpl_clear_cache_confirm').val('1');
    wplj('#wpl_clear_cache_form').trigger('submit');
}

function wpl_clear_calendar_data(confirmed)
{
    if(!confirmed)
	{
		message = "<?php echo addslashes(__("Are you sure you would like to remove listings calendar data?", 'wpl')); ?>";
		message += '&nbsp;<span class="wpl_actions" onclick="wpl_clear_calendar_data(1);"><?php echo addslashes(__('Yes', 'wpl')); ?></span>&nbsp;<span class="wpl_actions" onclick="wpl_remove_message();"><?php echo addslashes(__('No', 'wpl')); ?></span>';
		
		wpl_show_messages(message, '.wpl_maintenance .wpl_show_message');
		return false;
	}
	else if(confirmed) wpl_remove_message();
	
	/** Show AJAX loader **/
    var wpl_ajax_loader = Realtyna.ajaxLoader.show('#wpl_maintenance_clear_calendar_data', 'tiny', 'rightOut');
	
	request_str = 'wpl_format=b:settings:ajax&wpl_function=clear_calendar_data&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str);
	
	ajax.success(function(data)
	{
		/** Remove AJAX loader **/
        Realtyna.ajaxLoader.hide(wpl_ajax_loader);
	});
}

function wpl_export_settings()
{
	var format = wplj('#wpl_export_format').val();
	document.location = '<?php echo wpl_global::get_full_url(); ?>&wpl_format=b:settings:ajax&wpl_function=export_settings&wpl_export_format='+format+'&_wpnonce=<?php echo $this->nonce; ?>';
}

function wpl_add_sample_properties()
{
    wplj("#wpl_add_sample_properties_btn").prop('disabled', true);
    wpl_remove_message(".wpl-sample-properties .wpl_show_message");
	
    var wpl_ajax_loader = Realtyna.ajaxLoader.show('#wpl_add_sample_properties_ajax_loader', 'tiny', 'rightOut');
	var request_str = 'wpl_format=b:settings:ajax&wpl_function=add_sample_properties&_wpnonce=<?php echo $this->nonce; ?>';
	var ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str);
	
	ajax.success(function(data)
	{
        Realtyna.ajaxLoader.hide(wpl_ajax_loader);
    	wplj("#wpl_add_sample_properties_btn").prop('disabled', false);
    	wpl_show_messages(data.message, '.wpl-sample-properties .wpl_show_message', 'wpl_green_msg');
	});
}

var wpl_rank_update_ajax_loader;
function wpl_addon_rank_update_ranks_do()
{
    wplj("#wpl_addon_rank_update_ranks_btn").prop('disabled', true);
    wplj("#wpl_updated_ranks_cnt").removeClass('wpl-util-hidden');
    
    wpl_remove_message("#wpl_addon_rank_update_property_ranks .wpl_show_message");
	wpl_rank_update_ajax_loader = Realtyna.ajaxLoader.show('#wpl_addon_rank_update_ranks_ajax_loader', 'tiny', 'rightOut');
    
    wpl_addon_rank_update_ranks(0, 100);
}

function wpl_addon_rank_update_ranks(offset, limit)
{
	var request_str = 'wpl_format=b:settings:ajax&wpl_function=update_ranks&_wpnonce=<?php echo $this->nonce; ?>&offset='+offset+'&limit='+limit;
	
	wplj.ajax(
	{
		type: "POST",
		url: '<?php echo wpl_global::get_full_url(); ?>',
		data: request_str,
		dataType: 'JSON',
		success: function(data)
		{
			if(data.success)
			{
                wplj("#wpl_updated_ranks").html(data.offset);
                
                // Continue to update
                if(data.remained) wpl_addon_rank_update_ranks(data.offset, limit);
                else
                {
                    wplj("#wpl_addon_rank_update_ranks_btn").prop('disabled', false);
                    wpl_show_messages("<?php echo __("All listings' ranks updated.", 'wpl'); ?>", '#wpl_addon_rank_update_property_ranks .wpl_show_message', 'wpl_green_msg');
                }
			}
			else
			{
				Realtyna.ajaxLoader.hide(wpl_rank_update_ajax_loader);
                wplj("#wpl_addon_rank_update_ranks_btn").prop('disabled', false);
                wpl_show_messages("<?php echo __('Error Occured.', 'wpl'); ?>", '#wpl_addon_rank_update_property_ranks .wpl_show_message', 'wpl_red_msg');
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
            Realtyna.ajaxLoader.hide(wpl_rank_update_ajax_loader);
            wplj("#wpl_addon_rank_update_ranks_btn").prop('disabled', false);
            wpl_show_messages("<?php echo __('Error Occured.', 'wpl'); ?>", '#wpl_addon_rank_update_property_ranks .wpl_show_message', 'wpl_red_msg');
		}
	});
}
</script>