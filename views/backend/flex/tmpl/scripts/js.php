<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');
?>
<script type="text/javascript">
jQuery(document).ready(function()
{
    wplj(".sortable").sortable(
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

            request_str = 'wpl_format=b:flex:ajax&wpl_function=sort_flex&sort_ids='+stringDiv+'&_wpnonce=<?php echo $this->nonce; ?>';

            wplj.ajax(
            {
                type: "POST",
                url: '<?php echo wpl_global::get_full_url(); ?>',
                data: request_str,
                success: function(data)
                {},
                error: function(jqXHR, textStatus, errorThrown)
                {
                    wpl_show_messages('<?php echo addslashes(__('Error Occured.', 'wpl')); ?>', '.wpl_flex_list .wpl_show_message', 'wpl_red_msg');
                }
            })
        }
    });

    wplj(".categories_sortable").sortable(
    {
        handle: 'span.icon-move',
        cursor: "move" ,
        update : function(e, ui)
        {
            var stringDiv = "";
            wplj(this).children("tr").each(function(i)
            {
                var tr = wplj(this);
                var tr_id = tr.attr("id").split("-");
                if(i != 0) stringDiv += ",";
                stringDiv += tr_id[2];
            });

            request_str = 'wpl_format=b:flex:ajax&wpl_function=sort_categories&sort_ids='+stringDiv+'&_wpnonce=<?php echo $this->nonce; ?>';

            wplj.ajax(
                {
                    type: "POST",
                    url: '<?php echo wpl_global::get_full_url(); ?>',
                    data: request_str,
                    success: function(data)
                    {window.location='<?php echo wpl_global::get_full_url(); ?>'},
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        wpl_show_messages('<?php echo addslashes(__('Error Occured.', 'wpl')); ?>', '.wpl_flex_list .wpl_show_message', 'wpl_red_msg');
                    }
                })
        }
    });
});

function wpl_category_form(cat_id)
{
	request_str = 'wpl_format=b:flex:ajax&wpl_function=category_form&_wpnonce=<?php echo $this->nonce; ?>&cat_id='+cat_id;

	wplj.ajax(
		{
			type: "POST",
			url: '<?php echo wpl_global::get_full_url(); ?>',
			data: request_str,
			success: function(data)
			{
				wplj("#wpl_flex_category").append(data);
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				wpl_show_messages('<?php echo addslashes(__('Error Occured.', 'wpl')); ?>', '.wpl_flex_list .wpl_show_message', 'wpl_red_msg');
			}
		});
}

function wpl_save_category(cat_id)
{
	var name = wplj('#category_name').val();
	var kind = wplj('#category_kind').val();
	request_str = 'wpl_format=b:flex:ajax&wpl_function=update_category&_wpnonce=<?php echo $this->nonce; ?>&cat_id='+cat_id+'&category_name='+name+'&category_kind='+kind;
	
	var message_path = '#wpl_category_form_message';
	var ajax_loader_element = "#wpl_category_form_loader";
	wplj(ajax_loader_element).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');

	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element);

	ajax.success(function(data)
	{
		if(data.success == 1)
		{
			wplj._realtyna.lightbox.close();
		}
		else if(data.success == 0)
		{
			wplj(ajax_loader_element).html('');
			wpl_show_messages(data.message, message_path, 'wpl_red_msg');
			wplj(message_path).delay(3000).fadeOut(200);
		}
	});
}

function wpl_remove_category(cat_id,confirmed)
{
	var message_path = '.wpl_flex_list .wpl_show_message';

	if(!cat_id)
	{
		alert('cat');
		wpl_show_messages("<?php echo addslashes(__('Invalid field', 'wpl')); ?>", message_path);
		return false;
	}

	if(!confirmed)
	{
		var message = "<?php echo addslashes(__('Are you sure you want to remove this item?', 'wpl')); ?>&nbsp;(<?php echo addslashes(__('ID', 'wpl')); ?>:"+cat_id+")&nbsp;<?php echo addslashes(__('All related items will be removed.', 'wpl')); ?>";
		message += '<span class="wpl_actions" onclick="wpl_remove_category(\''+cat_id+'\', 1);"><?php echo addslashes(__('Yes', 'wpl')); ?></span>&nbsp;<span class="wpl_actions" onclick="wpl_remove_message(\''+message_path+'\');"><?php echo addslashes(__('No', 'wpl')); ?></span>';

		wpl_show_messages(message, message_path);
		return false;
	}
	else if(confirmed) wpl_remove_message(message_path);

	ajax_loader_element = "#category_remove_loader"+cat_id;
	wplj(ajax_loader_element).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');

	request_str = 'wpl_format=b:flex:ajax&wpl_function=remove_category&cat_id='+cat_id+'&_wpnonce=<?php echo $this->nonce; ?>';

	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element);

	ajax.success(function(data)
	{
		if(data.success == 1)
		{
			wplj(ajax_loader_element).html('');
			wpl_show_messages(data.message, message_path, 'wpl_green_msg');
			wplj(message_path).delay(3000).fadeOut(200);
			wplj(".cat_"+cat_id).hide(200);
			wplj("#wpl_slide_label_id"+cat_id).hide(200);
		}
		else if(data.success == 0)
		{
			wpl_show_messages(data.message, message_path, 'wpl_red_msg');
			wplj(message_path).delay(3000).fadeOut(200);
			wplj(ajax_loader_element).html('');
		}
	});
}

function wpl_toggle_category_status(cat_id)
{
    request_str = 'wpl_format=b:flex:ajax&wpl_function=toggle_category_status&cat_id='+cat_id+'&_wpnonce=<?php echo $this->nonce; ?>';
    wplj.ajax(
    {
        type: "POST",
        url: '<?php echo wpl_global::get_full_url(); ?>',
        data: request_str,
        success: function(data)
        {
            window.location='<?php echo wpl_global::get_full_url(); ?>';
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            wpl_show_messages('<?php echo addslashes(__('Error Occured.', 'wpl')); ?>', '.wpl_flex_list .wpl_show_message', 'wpl_red_msg');
        }
    });
}

function wpl_dbst_mandatory(dbst_id, mandatory_status)
{
	if(!dbst_id)
	{
		wpl_show_messages("<?php echo addslashes(__('Invalid field', 'wpl')); ?>", '.wpl_flex_list .wpl_show_message');	
		return false;
	}
	
	ajax_loader_element = '#wpl_flex_ajax_loader_'+dbst_id;
	wplj(ajax_loader_element).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');
	
	request_str = 'wpl_format=b:flex:ajax&wpl_function=mandatory&dbst_id='+dbst_id+'&mandatory_status='+mandatory_status+'&_wpnonce=<?php echo $this->nonce; ?>';
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element);
	
	ajax.success(function(data)
	{
		if(data.success == 1)
		{
			wpl_show_messages(data.message, '.wpl_flex_list .wpl_show_message', 'wpl_green_msg');
			wplj(ajax_loader_element).html('');
			
			if(mandatory_status == 0)
			{
				wplj('#wpl_flex_field_mandatory_span'+dbst_id).removeClass("wpl_show").addClass("wpl_hidden");
				wplj('#wpl_flex_field_mandatory_dis_span'+dbst_id).removeClass("wpl_hidden").addClass("wpl_show");
			}
			else
			{
				wplj('#wpl_flex_field_mandatory_span'+dbst_id).removeClass("wpl_hidden").addClass("wpl_show");
				wplj('#wpl_flex_field_mandatory_dis_span'+dbst_id).removeClass("wpl_show").addClass("wpl_hidden");
			}
		}
		else if(data.success != 1)
		{
			wpl_show_messages(data.message, '.wpl_flex_list .wpl_show_message', 'wpl_red_msg');
			wplj(ajax_loader_element).html('');
		}
	});
}

function wpl_dbst_enabled(dbst_id, enabled_status)
{
	if(!dbst_id)
	{
		wpl_show_messages("<?php echo addslashes(__('Invalid field', 'wpl')); ?>", '.wpl_flex_list .wpl_show_message');	
		return false;
	}
	
	ajax_loader_element = '#wpl_flex_ajax_loader_'+dbst_id;
	wplj(ajax_loader_element).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');
	
	request_str = 'wpl_format=b:flex:ajax&wpl_function=enabled&dbst_id='+dbst_id+'&enabled_status='+enabled_status+'&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element);
	
	ajax.success(function(data)
	{
		if(data.success == 1)
		{
			wpl_show_messages(data.message, '.wpl_flex_list .wpl_show_message', 'wpl_green_msg');
			wplj(ajax_loader_element).html('');		
			
			if(enabled_status == 0)
			{
				wplj('#wpl_flex_field_enable_span'+dbst_id).removeClass("wpl_show").addClass("wpl_hidden");
				wplj('#wpl_flex_field_disable_span'+dbst_id).removeClass("wpl_hidden").addClass("wpl_show");
			}
			else
			{
				wplj('#wpl_flex_field_enable_span'+dbst_id).removeClass("wpl_hidden").addClass("wpl_show");
				wplj('#wpl_flex_field_disable_span'+dbst_id).removeClass("wpl_show").addClass("wpl_hidden");
			}
		}
		else if(data.success != 1)
		{
			wpl_show_messages(data.message, '.wpl_flex_list .wpl_show_message', 'wpl_red_msg');
			wplj(ajax_loader_element).html('');
		}
	});
}

function generate_modify_page(field_id, field_type)
{
	if(!field_id) field_id = 0;
	if(field_id == 0) field_type = wplj("#wpl_dbst_types_select").val();
	cat_id = wplj(".wpl-side-2 .active").data("id");

	ajax_loader_element = '';
	request_str = 'wpl_format=b:flex:modify&wpl_function=generate_modify_page&field_type='+field_type+'&field_id='+field_id+'&cat_id='+cat_id+'&kind=<?php echo $this->kind; ?>&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element, "HTML");
	
	ajax.success(function(data)
	{
		wplj("#wpl_flex_edit_div").html(data);
		
		/** for fixing horizontal scroll **/
		wplj("#wpl_flex_edit_div").width("auto");
	});
}

function get_specific_options_string(prefix)
{
	specific_str = '';
	
	/** specific options **/
	wplj("#wpl_flex_specific_options input:text, #wpl_flex_specific_options input[type='hidden'], #wpl_flex_specific_options select, #wpl_flex_specific_options textarea").each(function (index, element)
	{
		specific_str += "&"+element.id.replace(prefix, "")+"="+encodeURIComponent(wplj(element).val());
	});
	
	return specific_str;
}

function save_dbst(prefix, dbst_id)
{
	if(!dbst_id) dbst_id = 0;
	
	request_str = "";
	
	ajax_loader_element = "#wpl_dbst_modify_ajax_loader";
	wplj(ajax_loader_element).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');
    
	/** general options **/
	wplj("#wpl_flex_general_options input:text, #wpl_flex_general_options input[type='hidden'], #wpl_flex_general_options select, #wpl_flex_general_options textarea").each(function (index, element)
	{
		request_str += "&fld_"+element.id.replace(prefix,"")+"="+wplj(element).val();
	});
	
	/** Data Specific **/
	specificable = wplj("#"+prefix+"specificable").val();
	if(specificable == 1) /** listing specific **/
	{
		listing_specific = '';
		
		if(!wplj("#wpl_flex_listing_checkbox_all").is(':checked'))
		{
			wplj(".wpl_listing_specific_ul input[type='checkbox']").each(function(index, element)
			{
				if(element.id != "wpl_flex_listing_checkbox_all" && element.checked) { listing_specific += element.value +','; }
			});
		}
		
		request_str += "&fld_listing_specific="+listing_specific+"&fld_property_type_specific=&fld_user_specific=&fld_field_specific=";
	}
	else if(specificable == 2) /** property type specific **/
	{
		property_type_specific = '';
		
		if(!wplj("#wpl_flex_property_type_checkbox_all").is(':checked'))
		{
			wplj(".wpl_property_type_specific_ul input[type='checkbox']").each(function(index, element)
			{
				if(element.id != "wpl_flex_property_type_checkbox_all" && element.checked) { property_type_specific += element.value +','; }
			});
		}
		
		request_str += "&fld_property_type_specific="+property_type_specific+"&fld_listing_specific=&fld_user_specific=&fld_field_specific=";
	}
    else if(specificable == 3) /** user type specific **/
	{
		user_specific = '';
		
		if(!wplj("#wpl_flex_user_checkbox_all").is(':checked'))
		{
			wplj(".wpl_user_specific_ul input[type='checkbox']").each(function(index, element)
			{
				if(element.id != "wpl_flex_v_checkbox_all" && element.checked) { user_specific += element.value +','; }
			});
		}
		
		request_str += "&fld_user_specific="+user_specific+"&fld_listing_specific=&fld_property_type_specific=&fld_field_specific=";
	}
	else if(specificable == 4) /** field specific **/
	{
		field_specific = wplj("#"+prefix+"field_specific_name").val() + ':' + wplj("#"+prefix+"field_specific_value").val();

		request_str += "&fld_field_specific="+field_specific+"&fld_listing_specific=&fld_property_type_specific=&fld_user_specific=";
	}
	else if(specificable == 0) /** No specific **/
	{
		request_str += "&fld_property_type_specific=&fld_listing_specific=&fld_user_specific=&fld_field_specific=";
	}
    
    /** Data Accesses **/
	viewable = wplj("#"+prefix+"accesses").val();
	if(viewable == 1) /** Selected Users **/
	{
		var accesses_str = '';
		
		wplj(".wpl_accesses_ul input[type='checkbox']").each(function(index, element)
        {
            if(element.checked) accesses_str += element.value+',';
        });
		
        var accesses_message = wplj("#"+prefix+"accesses_message").val();
		request_str += "&fld_accesses="+accesses_str+"&fld_accesses_message="+accesses_message;
	}
	else if(viewable == 2) /** All Users **/
	{
		request_str += "&fld_accesses=&fld_accesses_message=";
	}
	
	/** specific options **/
	if(get_specific_options_string(prefix)) request_str += get_specific_options_string(prefix);
	
	request_str = 'wpl_format=b:flex:ajax&wpl_function=save_dbst&dbst_id='+dbst_id+request_str+'&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element);
	
	ajax.success(function(data)
	{
		wplj(ajax_loader_element).html('');
		wplj("#wpl_dbst_submit_button").removeAttr("disabled");
		wplj._realtyna.lightbox.close();
	});
}

function wpl_generate_params_page(dbst_id)
{
	if(!dbst_id) dbst_id = '';
	
	request_str = 'wpl_format=b:flex:ajax&wpl_function=generate_params_page&dbst_id='+dbst_id+'&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	wplj.ajax(
	{
		type: "POST",
		url: '<?php echo wpl_global::get_full_url(); ?>',
		data: request_str,
		success: function(data)
		{
			wplj("#wpl_flex_edit_div").html(data);
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			wplj._realtyna.lightbox.close();
		}
	});
}

function wpl_remove_dbst(dbst_id, confirmed)
{
    var message_path = '.wpl_flex_list .wpl_show_message';
    
	if(!dbst_id)
	{
		wpl_show_messages("<?php echo addslashes(__('Invalid field', 'wpl')); ?>", message_path);
		return false;
	}
	
	if(!confirmed)
	{
		message = "<?php echo addslashes(__('Are you sure you want to remove this item?', 'wpl')); ?>&nbsp;(<?php echo addslashes(__('ID', 'wpl')); ?>:"+dbst_id+")&nbsp;<?php echo addslashes(__('All related items will be removed.', 'wpl')); ?>";
		message += '<span class="wpl_actions" onclick="wpl_remove_dbst(\''+dbst_id+'\', 1);"><?php echo addslashes(__('Yes', 'wpl')); ?></span>&nbsp;<span class="wpl_actions" onclick="wpl_remove_message(\''+message_path+'\');"><?php echo addslashes(__('No', 'wpl')); ?></span>';
		
		wpl_show_messages(message, message_path);
		return false;
	}
	else if(confirmed) wpl_remove_message(message_path);
	
	ajax_loader_element = "#wpl_flex_remove_ajax_loader"+dbst_id;
	wplj(ajax_loader_element).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');
	
	request_str = 'wpl_format=b:flex:ajax&wpl_function=remove_dbst&dbst_id='+dbst_id+'&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element);
	
	ajax.success(function(data)
	{
		if(data.success == 1)
		{
			wplj(ajax_loader_element).html('');
			wplj("#item_row_"+dbst_id).slideUp(200);
		}
		else if(data.success == 0)
		{
			wpl_show_messages(data.message, message_path, 'wpl_red_msg');
			wplj(ajax_loader_element).html('');
		}
	});
}

function wpl_flex_change_specificable(specificable_value, prefix)
{
	wplj(".wpl_flex_specificable_cnt").slideUp();
    wplj("#"+prefix+"specificable"+specificable_value).slideDown();
}

function wpl_listing_specific_all(checked)
{
	if(checked)
	{
		wplj(".wpl_listing_specific_ul input[type='checkbox']").each(function(index, element)
		{
			if(element.id != "wpl_flex_listing_checkbox_all") { element.checked = true; element.disabled = true; }
		});
	}
	else
	{
		wplj(".wpl_listing_specific_ul input[type='checkbox']").each(function(index, element)
		{
			if(element.id != "") { element.disabled = false; }
		});
	}
}

function wpl_property_type_specific_all(checked)
{
	if(checked)
	{
		wplj(".wpl_property_type_specific_ul input[type='checkbox']").each(function(index, element)
		{
			if(element.id != "wpl_flex_property_type_checkbox_all") { element.checked = true; element.disabled = true; }
		});
	}
	else
	{
		wplj(".wpl_property_type_specific_ul input[type='checkbox']").each(function(index, element)
		{
			if(element.id != "") { element.disabled = false; }
		});
	}
}

function wpl_user_specific_all(checked)
{
	if(checked)
	{
		wplj(".wpl_user_specific_ul input[type='checkbox']").each(function(index, element)
		{
			if(element.id != "wpl_flex_user_checkbox_all") { element.checked = true; element.disabled = true; }
		});
	}
	else
	{
		wplj(".wpl_user_specific_ul input[type='checkbox']").each(function(index, element)
		{
			if(element.id != "") { element.disabled = false; }
		});
	}
}

function wpl_flex_change_accesses(value, prefix)
{
    if(value == '1') wplj("#"+prefix+"accesses_cnt").slideDown();
    else wplj("#"+prefix+"accesses_cnt").slideUp();
}

function convert_dbst(prefix, dbst_id, new_type)
{
	if(!dbst_id) dbst_id = 0;
	
	ajax_loader_element = "#wpl_dbst_modify_ajax_loader";
	wplj(ajax_loader_element).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');
	
	request_str = 'wpl_format=b:flex:ajax&wpl_function=convert_dbst&dbst_id='+dbst_id+'&type='+new_type+'&_wpnonce=<?php echo $this->nonce; ?>';
	
	/** run ajax query **/
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element);
	
	ajax.success(function(data)
	{
		wplj(ajax_loader_element).html('');
		wplj("#wpl_dbst_submit_button").removeAttr("disabled");
		wplj._realtyna.lightbox.close();
	});
}

function wpl_sort_option(dbst_id, kind, status)
{
	if(!dbst_id)
	{
		wpl_show_messages("<?php echo addslashes(__('Invalid field', 'wpl')); ?>", '.wpl_flex_list .wpl_show_message');	
		return false;
	}
	
	ajax_loader_element = '#wpl_flex_ajax_loader_'+dbst_id;
	wplj(ajax_loader_element).html('<img src="<?php echo wpl_global::get_wpl_asset_url('img/ajax-loader3.gif'); ?>" />');
	
	request_str = 'wpl_format=b:flex:ajax&wpl_function=sort_option&dbst_id='+dbst_id+'&kind='+kind+'&status='+status+'&_wpnonce=<?php echo $this->nonce; ?>';
	ajax = wpl_run_ajax_query('<?php echo wpl_global::get_full_url(); ?>', request_str, ajax_loader_element);
	
	ajax.success(function(data)
	{
		if(data.success == 1)
		{
			wpl_show_messages(data.message, '.wpl_flex_list .wpl_show_message', 'wpl_green_msg');
			wplj(ajax_loader_element).html('');
			
			if(status == 0)
			{
				wplj('#wpl_flex_field_sort_option_span'+dbst_id).removeClass("wpl_show").addClass("wpl_hidden");
				wplj('#wpl_flex_field_sort_option_dis_span'+dbst_id).removeClass("wpl_hidden").addClass("wpl_show");
			}
			else
			{
				wplj('#wpl_flex_field_sort_option_span'+dbst_id).removeClass("wpl_hidden").addClass("wpl_show");
				wplj('#wpl_flex_field_sort_option_dis_span'+dbst_id).removeClass("wpl_show").addClass("wpl_hidden");
			}
		}
		else if(data.success != 1)
		{
			wpl_show_messages(data.message, '.wpl_flex_list .wpl_show_message', 'wpl_red_msg');
			wplj(ajax_loader_element).html('');
		}
	});
}

function wpl_flex_compare_change(element)
{
	if(typeof(element) == 'undefined' || !wplj(element).length) return;

	if(!wplj('.wpl-compare-row-container').length) return;

	if(parseInt(wplj(element).val()))
	{
		wplj('.wpl-compare-row-container').show();
	}
	else
	{
		wplj('.wpl-compare-row-container').hide();
	}
}
</script>