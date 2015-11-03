<script>
    $(function () {
        if ($('#open_wizard').val() == 'true') {
            $('#btn_back_collection').hide();
            $('#submit_configuration').hide();
            $('#save_and_next').val('true');
        }
        else {
            $('#MyWizard').hide();
            $('#button_save_and_next').hide();
            $('#save_and_next').val('false');
        }
        
        if($('#change_collection_images').val() == '1'){
            $('#collection_thumbnail').focus();
            $('#collection_thumbnail').trigger('click');
            $('#change_collection_images').val('');
        }else if($('#change_collection_images').val() == '2'){
            $('#socialdb_collection_cover').focus();
            $('#socialdb_collection_cover').trigger('click');
            $('#change_collection_images').val('');
        }
        
        //$('.combobox').combobox({bsVersion: '3'});
        var src = $('#src').val();
        // $('#my-wizard').wizard(); //wizard para navegacao
        $('#submit_form_edit_collection').submit(function (e) {
            var verify =  $( this ).serializeArray();
            if(verify[0].value.trim() === ''){
                showAlertGeneral('<?php _e('Attention','tainacan') ?>', '<?php _e('Please set a valid name','tainacan') ?>', 'info');
                return false;
            }
            else if ($("#verify_collection_name").val() !== 'block') {
                $("#collection_content").val(CKEDITOR.instances.editor.getData());
                e.preventDefault();
                $.ajax({
                    url: src + '/controllers/collection/collection_controller.php',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false
                }).done(function (result) {
                    elem = jQuery.parseJSON(result);
                    showHeaderCollection(src);
                    show_most_participatory_authors(src);
                    $('#redirect_to_caegories').show();
                    showAlertGeneral('<?php _e('Success','tainacan') ?>', '<?php _e('Configuration saved successfully!','tainacan') ?>', 'success');
                    if (elem.save_and_next&&elem.save_and_next=='true') {
                        setTimeout(function () {
                            //$('#configuration').hide();
                            //$('#configuration').html('');
                            showPropertiesConfiguration('<?php echo get_template_directory_uri() ?>');
                        }, 2000);
                    } else {
                        showCollectionConfiguration(src);
//                        $('html, body').animate({
//                            scrollTop: $("#collection_post").offset().top
//                        }, 2000);
                    }
                    //  
                    //  var selKeys = $.map($("#dynatree").dynatree("getSelectedNodes"), function (node) {
                    //    return node.data.key;
                    // });
                    // list_all_objects(selKeys.join(", "), $("#collection_id").val());
                    // $("#dynatree").dynatree("getTree").reload();
                });
                // $('#main_part').show();
                e.preventDefault();
                $('#configuration').focus();
            } else {
                $("#show_adv_config_link").hide('slow');
                $("#advanced_config").show('slow');
                $("#hide_adv_config_link").show('slow');
                $('#suggested_collection_name').focus();
                showAlertGeneral('<?php _e('Attention','tainacan') ?>', '<?php _e('Please set a valid address','tainacan') ?>', 'info');
                return false;
            }
        });
        //
        list_ordenation();
        list_collections_parent();
        showCKEditor();
    });
    function list_ordenation() {
        $.ajax({
            url: $('#src').val() + '/controllers/collection/collection_controller.php',
            type: 'POST',
            data: {operation: 'list_ordenation', collection_id: $("#collection_id").val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            if (elem.general_ordenation) {
                $("#collection_order").append("<optgroup label='<?php _e('General ordenation','tainacan') ?>'>");
                $.each(elem.general_ordenation, function (idx, general) {
                    if (general && general !== false) {
                        $("#collection_order").append("<option value='" + general.id + "' selected='selected' >" + general.name + "</option>");
                    }
                });
            }
            if (elem.property_data) {
                $("#collection_order").append("<optgroup label='<?php _e('Data properties','tainacan') ?>'>");
                $.each(elem.property_data, function (idx, data) {
                    if (data && data !== false) {
                        $("#collection_order").append("<option value='" + data.id + "' selected='selected' >" + data.name + "</option>");
                    }
                });
            }
            console.log(elem.rankings);
            if (elem.rankings) {
                $("#collection_order").append("<optgroup label='<?php _e('Rankings','tainacan') ?>'>");
                $.each(elem.rankings, function (idx, ranking) {
                    if (ranking && ranking !== false) {
                        $("#collection_order").append("<option value='" + ranking.id + "' selected='selected' >" + ranking.name + "</option>");
                    }
                });
            }
            if (elem.selected) {
                $("#collection_order").val(elem.selected);
            }
            $('.dropdown-toggle').dropdown();
        });
    }

    function autocomplete_moderators(collection_id) {
        $("#autocomplete_moderator").autocomplete({
            source: $('#src').val() + '/controllers/user/user_controller.php?operation=list_user&collection_id=' + collection_id,
            messages: {
                noResults: '',
                results: function () {
                }
            },
            minLength: 2,
            select: function (event, ui) {
                console.log(event);
                //$("#moderators_" + collection_id).html('');
                //$("#moderators_" + collection_id).val('');
                //var temp = $("#chosen-selected2 [value='" + ui.item.value + "']").val();
                var temp = $("#moderators_" + collection_id + " [value='" + ui.item.value + "']").val();
                if (typeof temp == "undefined") {
                    $("#moderators_" + collection_id).append("<option class='selected' value='" + ui.item.value + "' selected='selected' >" + ui.item.label + "</option>");

                }
                setTimeout(function () {
                    $("#autocomplete_moderator").val('');
                }, 100);
            }
        });
    }
    function clear_select_moderators(e) {
        $('option:selected', e).remove();
        //$('.chosen-selected2 option').prop('selected', 'selected');
    }
    function verify_name_collection() {
        $.ajax({
            url: $("#src").val() + '/controllers/collection/collection_controller.php',
            type: 'POST',
            data: {operation: 'verify_name_collection',
                suggested_collection_name: $('#suggested_collection_name').val(),
                collection_id: $("#collection_id").val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            if ($('#suggested_collection_name').val().trim() === '' || (elem.exists !== false && $('#initial_address').val() !== $('#suggested_collection_name').val())) {
                $("#verify_collection_name").val('block');
                $("#collection_name_success").hide('slow');
                $("#collection_name_error").show('slow');
                //$("#collection_name_error").delay(5000);
                //$("#collection_name_error").hide('slow');
            } else {
                $("#verify_collection_name").val('allow');
                $("#collection_name_error").hide('slow')
                $("#collection_name_success").show('slow');
                //$("#collection_name_success").delay(5000);
                //$("#collection_name_success").hide('slow');
            }
        });
    }
    function list_collections_parent() {
        $.ajax({
            url: $('#src').val() + '/controllers/collection/collection_controller.php',
            type: 'POST',
            data: {operation: 'list_collections_parent', collection_id: $("#collection_id").val()}
        }).done(function (result) {
            $("#socialdb_collection_parent").append("<option value='' selected='selected' >Selecione..</option>");
            $("#socialdb_collection_parent").append("<option value='collection_root' ><?php _e('Collection root','tainacan') ?></option>");
            elem = jQuery.parseJSON(result);
            console.log(elem);
            generate_select_list_collections_parent(elem.children, '&nbsp;&nbsp;');
            // $('#socialdb_collection_parent').combobox({bsVersion: '3'});
            //console.log($("#selected_parent_collection").val());
            if ($("#selected_parent_collection").val() !== '') {
                // $("[name=socialdb_collection_parent").val($("#selected_parent_collection").val());
                $("#socialdb_collection_parent").val($("#selected_parent_collection").val());
                // $('.combobox').val();
            }
        });
    }

    function generate_select_list_collections_parent(json, deep) {
        var deep_level;
        if (json.length > 0) {
            $.each(json, function (idx, collection) {
                if (collection && collection !== false) {
                    $("#socialdb_collection_parent").append("<option value='" + collection.id + "' >" + deep + "" + collection.name + "</option>");
                    if (collection.children.length > 0) {
                        deep_level = deep + '&nbsp;&nbsp;&nbsp;';
                        generate_select_list_collections_parent(collection.children, deep_level);
                    }
                }
            });
        }
    }

    function showAdvancedConfig() {
        $("#show_adv_config_link").hide('slow');
        $("#advanced_config").show('slow');
        $("#hide_adv_config_link").show('slow');
    }

    function hideAdvancedConfig() {
        $("#advanced_config").hide('slow');
        $("#hide_adv_config_link").hide('slow');
        $("#show_adv_config_link").show('slow');
    }
</script>

