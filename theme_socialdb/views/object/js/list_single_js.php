<script>
    $(function () {
        var stateObj = {foo: "bar"};
        history.replaceState(stateObj, "page 2", $('#socialdb_permalink_object').val());
        
        list_files_single($('#single_object_id').val());
        list_ranking_single($('#single_object_id').val());
        list_properties_single($('#single_object_id').val());
        list_properties_edit_remove_single($('#single_object_id').val());
        list_comments($('#single_object_id').val());
        $('[data-toggle="popoverObject"]').popover();

        var myPopoverObject = $('#iframebuttonObject').data('popover');
        $('#iframebuttonObject').popover('hide');
        myPopoverObject.options.html = true;
        //<iframe width="560" height="315" src="https://www.youtube.com/embed/CGyEd0aKWZE" frameborder="0" allowfullscreen></iframe>
        myPopoverObject.options.content = $('#socialdb_permalink_object').val();
        
    });
//BEGIN: funcao para mostrar os arquivos
    function list_files_single(id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/object/object_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'show_files', object_id: id}
        }).done(function (result) {
            $('#single_list_files_' + id).html(result);
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
            $("#wpadminbar").focus();
        });
    }
//END
//BEGIN: funcao para mostrar votacoes
    function list_ranking_single(id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/ranking/ranking_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'single_list_ranking_object', object_id: id}
        }).done(function (result) {
            $('#single_list_ranking_' + id).html(result);
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab(); 
        });
    }
//END
//BEGIN:as proximas funcoes sao para mostrar os eventos
// list_properties(id): funcao que mostra a primiera listagem de propriedades
    function list_properties_single(id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/object/objectsingle_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'list_properties', object_id: id}
        }).done(function (result) {
            $('#single_list_all_properties_' + id).html(result);
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();  
        });
    }
// mostra a listagem apos clique no botao para edicao e exclusao
    function list_properties_edit_remove_single(id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/object/objectsingle_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'list_properties_edit_remove', object_id: id}
        }).done(function (result) {
            $('#single_list_properties_edit_remove').html(result);
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
        });
    }

// mostra o formulario para criacao de propriedade de dados
    function show_form_data_property_single(object_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/object/objectsingle_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'show_form_data_property', object_id: object_id}
        }).done(function (result) {
            $('#single_data_property_form_' + object_id).html(result);
            $('#single_list_all_properties_' + object_id).hide();
            $('#single_object_property_form_' + object_id).hide();
            $('#single_edit_data_property_form_' + object_id).hide();
            $('#single_edit_object_property_form_' + object_id).hide();
            $('#single_data_property_form_' + object_id).show();
            $('.dropdown-toggle').dropdown();  
        });
    }
// mostra o formulario para criacao de propriedade de objeto
    function show_form_object_property_single(object_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/object/objectsingle_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'show_form_object_property', object_id: object_id}
        }).done(function (result) {
            $('#single_object_property_form_' + object_id).html(result);
            $('#single_list_all_properties_' + object_id).hide();
            $('#single_data_property_form_' + object_id).hide();
            $('#single_edit_data_property_form_' + object_id).hide();
            $('#single_edit_object_property_form_' + object_id).hide();
            $('#single_object_property_form_' + object_id).show();
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
        });
    }
// funcao acionando no bolta voltar que mostra a listagem principal
    function back_button_single(object_id) {
        $('#single_data_property_form_' + object_id).hide();
        $('#single_object_property_form_' + object_id).hide();
        $('#single_edit_data_property_form_' + object_id).hide();
        $('#single_edit_object_property_form_' + object_id).hide();
        $('#single_list_all_properties_' + object_id).show();
    }
// END:fim das funcoes que mostram as propriedades
//funcao que mostra as classificacoes apos clique no botao show_classification
    function show_classifications_single(object_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/object/objectsingle_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'show_classifications', object_id: object_id}
        }).done(function (result) {
            $('#single_classifications_' + object_id).html(result);
            $('#single_show_classificiations_' + object_id).hide();
            $('#single_classifications_' + object_id).show();
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
        });
    }

    //mostrar modal de denuncia
    function single_show_report_abuse(object_id) {
        $('#single_modal_delete_object' + object_id).modal('show');
    }

    //Events deletes (category) alert
    function single_remove_event_category_classication(title, text, category_id, object_id, time) {
        swal({
            title: title,
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: $('#src').val() + "/controllers/event/event_controller.php",
                    data: {
                        operation: 'add_event_classification_delete',
                        socialdb_event_create_date: time,
                        socialdb_event_user_id: $('#current_user_id').val(),
                        socialdb_event_classification_object_id: object_id,
                        socialdb_event_classification_term_id: category_id,
                        socialdb_event_classification_type: 'category',
                        socialdb_event_collection_id: $('#collection_id').val()}
                }).done(function (result) {
                    elem_first = jQuery.parseJSON(result);
                    show_classifications_single(object_id);
                    showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);

                });
            }
        });
    }

    function single_remove_event_property_classication(title, text, category_id, object_id, time, type) {
        swal({
            title: title,
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: $('#src').val() + "/controllers/event/event_controller.php",
                    data: {
                        operation: 'add_event_classification_delete',
                        socialdb_event_create_date: time,
                        socialdb_event_user_id: $('#current_user_id').val(),
                        socialdb_event_classification_object_id: object_id,
                        socialdb_event_classification_term_id: category_id,
                        socialdb_event_classification_type: type,
                        socialdb_event_collection_id: $('#collection_id').val()}
                }).done(function (result) {
                    elem_first = jQuery.parseJSON(result);
                    show_classifications_single(object_id);
                    showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);

                });
            }
        });
    }
// deletar objeto
    function single_delete_object(title, text, object_id, time) {
        swal({
            title: title,
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: $('#src').val() + "/controllers/event/event_controller.php",
                    data: {
                        operation: 'add_event_object_delete',
                        socialdb_event_create_date: time,
                        socialdb_event_user_id: $('#current_user_id').val(),
                        socialdb_event_object_item_id: object_id,
                        socialdb_event_collection_id: $('#collection_id').val()}
                }).done(function (result) {
                    elem_first = jQuery.parseJSON(result);
                    backToMainPage();
                    showList($('#src').val());
                    showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);
                });
            }
        });
    }

    function single_report_abuse_object(title, text, object_id, time) {
        $('#modal_delete_object' + object_id).modal('hide');
        swal({
            title: title,
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: $('#src').val() + "/controllers/event/event_controller.php",
                    data: {
                        operation: 'add_event_object_delete',
                        socialdb_event_create_date: time,
                        socialdb_event_observation: $('#observation_delete_object' + object_id).val(),
                        socialdb_event_user_id: $('#current_user_id').val(),
                        socialdb_event_object_item_id: object_id,
                        socialdb_event_collection_id: $('#collection_id').val()}
                }).done(function (result) {
                    elem_first = jQuery.parseJSON(result);
                    backToMainPage();
                    showList($('#src').val());
                    showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);
                });
            }
        });
    }


    function single_remove_event_tag_classication(title, text, tag_id, object_id, time) {
        swal({
            title: title,
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: $('#src').val() + "/controllers/event/event_controller.php",
                    data: {
                        operation: 'add_event_classification_delete',
                        socialdb_event_create_date: time,
                        socialdb_event_user_id: $('#current_user_id').val(),
                        socialdb_event_classification_object_id: object_id,
                        socialdb_event_classification_term_id: tag_id,
                        socialdb_event_classification_type: 'tag',
                        socialdb_event_collection_id: $('#collection_id').val()}
                }).done(function (result) {
                    elem_first = jQuery.parseJSON(result);
                    show_classifications_single(object_id);
                    showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);

                });
            }
        });
    }

//mostrar modal de denuncia
    function show_edit_object(object_id) {
        backToMainPage();
        edit_object(object_id);
    }
// editando objeto
    function edit_object(object_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/object/object_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'edit', object_id: object_id}
        }).done(function (result) {
            $("#container_socialdb").hide('slow');
            $("#form").hide();
            $("#form").html(result);
            $('#form').show('slow');
            $('#create_button').hide();
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
        });
    }
//################  FUNCOES PARA OS COMENTARIOS ################################# 
//listando os comentarios
    function list_comments(object_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/object/object_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'list_comments', object_id: object_id}
        }).done(function (result) {
            $("#comments_object").html(result);
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
        });
    }
//
    function submit_comment_old() {
        $.ajax({
            type: "POST",
            url: '<?php echo get_option('siteurl'); ?>/wp-comments-post.php',
            data: {
                comment_post_ID: $('#single_object_id').val(),
                comment: $('#comment').val(),
                author: $('#author').val(),
                email: $('#email').val(),
                url: $('#url').val(),
                redirect_to: $('#redirect_to').val()}
        }).done(function (result) {
            console.log(result);
            list_comments($('#single_object_id').val());
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
        });
    }
    function submit_comment() {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/event/event_controller.php",
            data: {
                operation: 'add_event_comment_create',
                socialdb_event_create_date: '<?php echo mktime() ?>',
                socialdb_event_user_id: $('#current_user_id').val(),
                socialdb_event_comment_create_object_id: $('#single_object_id').val(),
                socialdb_event_comment_create_content: $('#comment').val(),
                socialdb_event_comment_author_name: $('#author').val(),
                socialdb_event_comment_author_email: $('#email').val(),
                socialdb_event_comment_author_website: $('#url').val(),
                socialdb_event_comment_parent: 0,
                socialdb_event_collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem_first = jQuery.parseJSON(result);
            showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);
            list_comments($('#single_object_id').val());
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
        });
    }

    function submit_comment_reply_old() {
        $.ajax({
            type: "POST",
            url: '<?php echo get_option('siteurl'); ?>/wp-comments-post.php',
            data: {
                socialdb_event_user_id: $('#current_user_id').val(),
                comment_post_ID: $('#single_object_id').val(),
                comment: $('#comment_msg_reply').val(),
                author: $('#author_reply').val(),
                email: $('#email_reply').val(),
                url: $('#url_reply').val(),
                redirect_to: $('#redirect_to').val(),
                comment_parent: $('#comment_id').val()
            }
        }).done(function (result) {
            list_comments($('#single_object_id').val());
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
            $('#modalReplyComment').modal("hide");
            showAlertGeneral('<?php _e('Success', 'tainacan'); ?>', '<?php _e('Reply successfully sent.', 'tainacan'); ?>', 'success');
            $('html, body').animate({
                scrollTop: $("#comments").offset().top
            }, 2000);
        });
    }
    // submissao da resposta a um comentario
    function submit_comment_reply() {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/event/event_controller.php",
            data: {
                operation: 'add_event_comment_create',
                socialdb_event_create_date: '<?php echo mktime() ?>',
                socialdb_event_user_id: $('#current_user_id').val(),
                socialdb_event_comment_create_object_id: $('#single_object_id').val(),
                socialdb_event_comment_create_content: $('#comment_msg_reply').val(),
                socialdb_event_comment_author_name: $('#author_reply').val(),
                socialdb_event_comment_author_email: $('#email_reply').val(),
                socialdb_event_comment_author_website: $('#url_reply').val(),
                socialdb_event_comment_parent: $('#comment_id').val(),
                socialdb_event_collection_id: $('#collection_id').val()
            }
        }).done(function (result) {

            list_comments($('#single_object_id').val());
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
            $('#modalReplyComment').modal("hide");
            elem_first = jQuery.parseJSON(result);
            showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);
            $('html, body').animate({
                scrollTop: $("#comments").offset().top
            }, 2000);
        });
    }
    // mostra modal de resposta
    function showModalReply(comment_parent_id) {
        $('#comment_id').val(comment_parent_id);
        $('#modalReplyComment').modal("show");
    }
    // mostrar modal de reportar abuso
    function showModalReportAbuseComment(comment_parent_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/comment/comment_controller.php",
            data: {
                operation: 'get_comment_json',
                comment_id: comment_parent_id
            }
        }).done(function (result) {
            var comment = jQuery.parseJSON(result);
            $('#comment_id_report').val(comment_parent_id);
            $('#description_comment_abusive').html(comment.comment.comment_content);
            $('#showModalReportAbuseComment').modal("show");
        });
    }
    // mostrar edicao
    function showEditComment(comment_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/comment/comment_controller.php",
            data: {
                operation: 'get_comment_json',
                comment_id: comment_id
            }
        }).done(function (result) {
            var comment = jQuery.parseJSON(result);
            $('#comment_text_' + comment_id).hide("slow");
            $('#edit_field_value_' + comment_id).val(comment.comment.comment_content);
            $('#comment_edit_field_' + comment_id).show("slow");
        });
    }
    // cancelar edicao
    function cancelEditComment(comment_id) {
        $('#comment_edit_field_' + comment_id).hide("slow");
        $('#comment_text_' + comment_id).show("slow");
    }
    // disparado quando eh dono ou admin   
    function showAlertDeleteComment(comment_id, title, text, time) {
        swal({
            title: title,
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: $('#src').val() + "/controllers/event/event_controller.php",
                    data: {
                        operation: 'add_event_comment_delete',
                        socialdb_event_create_date: time,
                        socialdb_event_user_id: $('#current_user_id').val(),
                        socialdb_event_comment_delete_id: comment_id,
                        socialdb_event_collection_id: $('#collection_id').val()}
                }).done(function (result) {
                    list_comments($('#single_object_id').val());
                    elem_first = jQuery.parseJSON(result);
                    showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);

                });
            }
        });
    }
    // formulario de reportar abuso para demais usuarios
    function submit_report_abuse() {
        $('#showModalReportAbuseComment').modal("hide");
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/event/event_controller.php",
            data: {
                operation: 'add_event_comment_delete',
                socialdb_event_create_date: '<?php echo mktime() ?>',
                socialdb_event_observation: $('#comment_msg_report').val(),
                socialdb_event_user_id: $('#current_user_id').val(),
                socialdb_event_comment_delete_id: $('#comment_id_report').val(),
                socialdb_event_collection_id: $('#collection_id').val()}
        }).done(function (result) {
            list_comments($('#single_object_id').val());
            elem_first = jQuery.parseJSON(result);
            showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);
        });
    }
    // submissao do formulario de edicao
    function submitEditComment(comment_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/event/event_controller.php",
            data: {
                operation: 'add_event_comment_edit',
                socialdb_event_create_date: '<?php echo mktime() ?>',
                socialdb_event_user_id: $('#current_user_id').val(),
                socialdb_event_comment_edit_id: comment_id,
                socialdb_event_comment_edit_content: $('#edit_field_value_' + comment_id).val(),
                socialdb_event_collection_id: $('#collection_id').val()
            }
        }).done(function (result) {
            list_comments($('#single_object_id').val());
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
            elem_first = jQuery.parseJSON(result);
            showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);
            $('html, body').animate({
                scrollTop: $("#comments").offset().top
            }, 2000);
        });
    }

</script>
