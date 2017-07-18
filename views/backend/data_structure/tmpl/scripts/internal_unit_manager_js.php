 <?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
?>
<script type="text/javascript">

var wpl_ajax_loaders = {
	third : "<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>"
};

jQuery(document).ready(function()
{
	wplj(".sortable_unit").sortable(
    {
        handle: 'span.icon-move',
        cursor: "move" ,
        update : function(e, ui)
        {
            var stringDiv = "";
            wplj(this).children("tr").each(function(i)
            {
                var tr = wplj(this);
                var tr_id = tr.attr("id").split("_");
                if(i != 0) stringDiv += ",";
                stringDiv += tr_id[2];
            });

            request_str = 'wpl_format=b:data_structure:ajax_unit_manager&wpl_function=sort_units&sort_ids='+stringDiv+'&_wpnonce=<?php echo $this->nonce; ?>';

            wplj.ajax(
            {
                type: "POST",
                url: '<?php echo wpl_global::get_full_url(); ?>',
                data: request_str,
                success: function(data)
                {
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    wpl_show_messages('<?php echo addslashes(__('Error Occured.', 'wpl')); ?>', '.wpl_data_structure_list .wpl_show_message', 'wpl_red_msg');
                }
            });
        }
    });
});

//load new category whene select box changed for category show
function load_new_unit_category(type)
{
	ajax_loader = '#wpl_ajax_loader_span';
	wplj(ajax_loader).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');
	
	ajax_loader_element = '#unit_manager_content';
	request_str = 'wpl_format=b:data_structure:ajax_unit_manager&wpl_function=generate_new_page&type='+type+'&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element, "HTML");
	ajax.success(function(data)
	{
		wplj("#unit_manager_content").html(data);
		wplj(ajax_loader).html('');
	});	
}

//change enabled state enabled/disabled
function wpl_unit_enabled_change(unit_id)
{
	if(!unit_id)
	{
		wpl_show_messages("<?php echo addslashes(__('Invalid field', 'wpl')); ?>", '.wpl_show_message');
		return false;
	}
	
	ajax_loader_element = '#wpl_ajax_loader_'+unit_id;
	ajax_flag = '#wpl_ajax_flag_'+unit_id;
	
	//---get status for whene repate the state
	var enabled_status = null;
	if(wplj(ajax_flag).hasClass('icon-enabled')) enabled_status = 0;
	else if(wplj(ajax_flag).hasClass('icon-disabled')) enabled_status = 1;
	
	wplj(ajax_loader_element).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');
	request_str = 'wpl_format=b:data_structure:ajax_unit_manager&wpl_function=unit_enabled_state_change&unit_id='+unit_id+'&enabled_status='+enabled_status+'&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str);
	ajax.success(function(data)
	{
		if(data.success == 1)
		{
			if(enabled_status == 1) wplj(ajax_flag).removeClass('icon-disabled').addClass('icon-enabled');
			else wplj(ajax_flag).removeClass('icon-enabled').addClass('icon-disabled');
			wplj(ajax_loader_element).html('');
		}
		else if(data.success != 1)
		{
			wpl_show_messages(data.message, '.wpl_flex_list .wpl_show_message', 'wpl_red_msg');
			wplj(ajax_loader_element).html('');
		}
	});
}

function wpl_update_exchange_rates(element)
{
	var loading_element = wplj(element).nextAll('.wpl-loader');

	wplj(loading_element).html('<img src="' + wpl_ajax_loaders.third + '" />');
	wplj(element).attr('disabled','disabled');

	request_str = 'wpl_format=b:data_structure:ajax_unit_manager&wpl_function=update_exchange_rates&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, loading_element);
	
	ajax.success(function(data)
	{
		load_new_unit_category(4);
	});

	ajax.complete(function()
	{
		wplj(loading_element).html('');
		wplj(element).removeAttr('disabled');
	});
}

function wpl_update_a_exchange_rate(element)
{
	var id = parseInt(wplj(element).data('wpl-id'));
	var currency_code = wplj(element).data('wpl-currency-code').trim();

	var loading_element = wplj(element).nextAll('.wpl-loader');
	var tosi_input_element = wplj('input[data-wpl-id="' + id + '"][data-wpl-role="tosi-input"]');

	if(id <= 0 || currency_code == '') return;
	
	wplj(element).attr('disabled','disabled');
	wplj(loading_element).html('<img src="' + wpl_ajax_loaders.third + '" />');
	
	request_str = 'wpl_format=b:data_structure:ajax_unit_manager&wpl_function=update_a_exchange_rate&unit_id='+id+'&currency_code='+currency_code+'&_wpnonce=<?php echo $this->nonce; ?>';
	
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, loading_element);
	
	ajax.complete(function()
	{
		wplj(element).removeAttr('disabled');
		wplj(loading_element).html('');
	});

	ajax.success(function(data)
	{
		if(data.success == 1)
		{
			wplj(tosi_input_element).val(data.res);
		}
	});
}

function wpl_change_unit_name(element)
{
	var id = parseInt(wplj(element).data('wpl-id'));
	var value = wplj(element).val().trim();

	if(id <= 0 || value == '') return false;

	return wpl_modify_unit(id, 'name', value, wplj(element).nextAll('.wpl-loader'));
}

function wpl_change_unit_option(element)
{
	var id = parseInt(wplj(element).data('wpl-id'));
	var value = wplj(element).val().trim();
	var option = wplj(element).data('wpl-option').trim();

	if(id <= 0 || option == '') return false;

	return wpl_modify_unit(id, option, value, wplj(element).nextAll('.wpl-loader'));
}

function wpl_change_unit_tosi(element)
{
	var id = parseInt(wplj(element).data('wpl-id'));
	var value = parseFloat(wplj(element).val());

	if(id <= 0 || value <= 0) return false;

	return wpl_modify_unit(id, 'tosi', value, wplj(element).nextAll('.wpl-loader'));
}

function wpl_modify_unit(id, field, value, loading_element)
{
	wplj(loading_element).html('<img src="' + wpl_ajax_loaders.third + '" />');

	request_str = 'wpl_format=b:data_structure:ajax_unit_manager&wpl_function=modify_unit&id=' + id + '&field=' + field + '&value=' + value + '&_wpnonce=<?php echo $this->nonce; ?>';
	
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, loading_element);
	
	ajax.complete(function()
	{
		wplj(loading_element).html('');
	});

	ajax.success(function(data)
	{
		if(typeof(data.success) !== 'undefined' && data.success !== 1)
		{
			if(typeof(data.message) !== 'undefined' && data.message.trim() !== '')
			{
				wpl_show_messages(data.message, '.wpl_flex_list .wpl_show_message', 'wpl_red_msg');
			}
		}
	});
}
</script>