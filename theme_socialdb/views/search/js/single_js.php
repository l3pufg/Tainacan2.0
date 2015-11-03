<?php ?>
<script>
    $(function () {
        set_containers_class($('#collection_id').val());
    });

    function set_containers_class(collection_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/collection/collection_controller.php",
            data: {operation: 'set_container_classes', collection_id: collection_id}
        }).done(function (result) {
            $('.dropdown-toggle').dropdown();
            elem = jQuery.parseJSON(result);
            if (elem.has_left && elem.has_left == 'true' && (!elem.has_right || elem.has_right !== 'true')) {
                $('#div_left').removeClass('col-md-2');
                $('#div_left').addClass('col-md-2');
                $('#div_central').removeClass('col-md-8');
                $('#div_central').removeClass('col-md-10');
                $('#div_central').removeClass('col-md-12');
                $('#div_central').addClass('col-md-10');
                $('#div_right').removeClass('col-md-2');
                $('#div_central').show();
                $('#div_left').show();
                $('#div_right').html('');
                load_menu_left(collection_id);
                load_menu_top(collection_id);
            }
            else if (elem.has_right && elem.has_right == 'true' && (!elem.has_left || elem.has_left !== 'true')) {
                $('#div_right').removeClass('col-md-2');
                $('#div_right').addClass('col-md-2');
                $('#div_central').removeClass('col-md-8');
                $('#div_central').removeClass('col-md-10');
                $('#div_central').removeClass('col-md-12');
                $('#div_central').addClass('col-md-10');
                $('#div_left').removeClass('col-md-2');
                $('#div_central').show();
                $('#div_left').html('');
                $('#div_right').show();
                load_menu_right(collection_id);
                load_menu_top(collection_id);
            }
            else if (elem.has_right && elem.has_right == 'true' && elem.has_left && elem.has_left == 'true') {
                $('#div_left').removeClass('col-md-2');
                $('#div_left').addClass('col-md-2');
                $('#div_central').removeClass('col-md-8');
                $('#div_central').removeClass('col-md-10');
                $('#div_central').removeClass('col-md-12');
                $('#div_central').addClass('col-md-8');
                $('#div_right').removeClass('col-md-2');
                $('#div_right').addClass('col-md-2');
                load_menu_left(collection_id);
                load_menu_right(collection_id);
                load_menu_top(collection_id);
            } else {
                $('#div_left').removeClass('col-md-2');
                $('#div_central').removeClass('col-md-8');
                $('#div_central').removeClass('col-md-10');
                $('#div_central').removeClass('col-md-12');
                $('#div_central').addClass('col-md-12');
                $('#div_right').removeClass('col-md-2');
                $('#div_central').show();
                $('#div_left').html('');
                $('#div_right').html('');
                load_menu_top(collection_id);
            }
        });
    }


    function load_menu_left(collection_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/collection/collection_controller.php",
            data: {operation: 'load_menu_left', collection_id: collection_id}
        }).done(function (result) {
            $('.dropdown-toggle').dropdown();
            $('#div_left').html(result);
        });
    }

    function load_menu_right(collection_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/collection/collection_controller.php",
            data: {operation: 'load_menu_right', collection_id: collection_id}
        }).done(function (result) {
            $('.dropdown-toggle').dropdown();
            $('#div_right').html(result);
        });
    }

    function load_menu_top(collection_id) {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/collection/collection_controller.php",
            data: {operation: 'load_menu_top', collection_id: collection_id}
        }).done(function (result) {
            $('.dropdown-toggle').dropdown();
            $('#horizontal_menu').html(result);
        });
    }
    //wp query functions
    function wpquery_dynatree(value) {
        $('#list').hide();
        $('#loader_objects').show();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_dynatree', wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_menu(term_id, facet_id) {
        $('#list').hide();
        $('#loader_objects').show();
        var value = term_id;
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_menu', facet_id: facet_id, wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_radio(seletor, facet_id) {
        $('#list').hide();
        $('#loader_objects').show();
        var value = $(seletor).val();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_radio', facet_id: facet_id, wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_select(seletor, facet_id) {
        $('#list').hide();
        $('#loader_objects').show();
        var value = $(seletor).val();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_select', facet_id: facet_id, wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_checkbox(seletor, facet_id) {
        $('#list').hide();
        $('#loader_objects').show();
        var value = $('input:checkbox:checked#' + seletor).map(function () {
            return this.value;
        }).get().join(",");
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_checkbox', facet_id: facet_id, wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_multipleselect(facet_id, seletor) {
        $('#list').hide();
        var value = '';
        $('#loader_objects').show();
        if (!$('#' + seletor)) {
            value = '';
        } else {
            if ($('#' + seletor).val()) {
                value = $('#' + seletor).val().join(",");
            } else {
                value = '';
            }
        }
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_multipleselect', facet_id: facet_id, wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_range(facet_id, facet_type, value1, value2) {
        $('#list').hide();
        $('#loader_objects').show();
        var value = value1 + ',' + value2;
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_range', facet_id: facet_id, facet_type: facet_type, wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_fromto(facet_id, facet_type) {

        if ($('#facet_' + facet_id + '_1').val() !== '' && $('#facet_' + facet_id + '_2').val() !== '') {
            $('#list').hide();
            $('#loader_objects').show();
            var value = $('#facet_' + facet_id + '_1').val() + ',' + $('#facet_' + facet_id + '_2').val();
            $.ajax({
                type: "POST",
                url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
                data: {operation: 'wpquery_fromto', facet_id: facet_id, facet_type: facet_type, wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
            }).done(function (result) {
                elem = jQuery.parseJSON(result);
                $('#loader_objects').hide();
                $('#list').html(elem.page);
                $('#wp_query_args').val(elem.args);
                show_filters($('#collection_id').val(), elem.args);
                $('#list').show();
                if (elem.empty_collection) {
                    $('#collection_empty').show();
                    $('#items_not_found').hide();
                }

            });
        }
    }

    function wpquery_ordenation(value) {
        $('#list').hide();
        $('#loader_objects').show();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_ordenation', wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_orderBy(value) {
        $('#list').hide();
        $('#loader_objects').show();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_orderby', wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_keyword(value) {
        $('#list').hide();
        $('#loader_objects').show();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_keyword', wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }

        });
    }

    function wpquery_page(value) {
        $('#list').hide();
        $('#loader_objects').show();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'wpquery_page', wp_query_args: $('#wp_query_args').val(), value: value, collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }
        });
    }

    function wpquery_filter() {
        $('#list').hide();
        $('#loader_objects').show();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'filter', wp_query_args: $('#wp_query_args').val(), collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            $('#list').show();
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }
        });
    }

    function wpquery_clean() {
        $('#list').hide();
        $('#loader_objects').show();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {operation: 'clean', wp_query_args: $('#wp_query_args').val(), collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }
            $('#list').show();
        });
    }

    function wpquery_remove(index_array, type, value) {
        $('#list').hide();
        $('#loader_objects').show();
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/wp_query/wp_query_controller.php",
            data: {
                index_array: index_array,
                type: type,
                value: value,
                operation: 'remove',
                wp_query_args: $('#wp_query_args').val(),
                collection_id: $('#collection_id').val()}
        }).done(function (result) {
            elem = jQuery.parseJSON(result);
            $('#loader_objects').hide();
            $('#list').html(elem.page);
            $('#wp_query_args').val(elem.args);
            show_filters($('#collection_id').val(), elem.args);
            if (elem.empty_collection) {
                $('#collection_empty').show();
                $('#items_not_found').hide();
            }
            $('#flag_dynatree_ajax').val('true');
            $('#list').show();
        });
    }

    // funcao que captura a action on change no selectbox na pagina single.php
    function getOrder(value) {
        wpquery_ordenation($(value).val());
        //list_all_objects(selKeys.join(", "), $("#collection_id").val(), $(value).val());
    }

// funcao que captura a action on change no selectbox na pagina single.php
    function desc_ordenation() {
        wpquery_orderBy('desc');
        //  var selKeys = $.map($("#dynatree").dynatree("getSelectedNodes"), function (node) {
        //     return node.data.key;
        // });
        //list_all_objects(selKeys.join(", "), $("#collection_id").val(), $('#collection_single_ordenation').val(), 'desc');
    }
// funcao que captura a action on change no selectbox na pagina single.php
    function asc_ordenation() {
        wpquery_orderBy('asc');
        // var selKeys = $.map($("#dynatree").dynatree("getSelectedNodes"), function (node) {
        //    return node.data.key;
        // });
        //  list_all_objects(selKeys.join(", "), $("#collection_id").val(), $('#collection_single_ordenation').val(), 'asc');
    }
    function search_objects(e) {
        var search_for = $(e).val();
        wpquery_keyword(search_for);
        // list_all_objects(selKeys.join(", "), $("#collection_id").val(), $('#collection_single_ordenation').val(), '', search_for);
    }

    function backToMainPage() {
        //wpquery_filter();
        wpquery_clean();
        list_main_ordenation_filter();
        $('#display_view_main_page').show();
        $('#collection_post').show();
        $('#configuration').hide();
        $('#form').hide();
        $('#create_button').show();
        $('#menu_object').show();
        $("#list").show();
        $("#container_socialdb").show('fast');
        $('#main_part').show('slow');
        set_containers_class($('#collection_id').val());
    }
    //apenas para a pagina de demonstracao do item
    function backToMainPageSingleItem() {
        wpquery_filter();
        list_main_ordenation_filter();
        $('#display_view_main_page').show();
        $('#collection_post').show();
        $('#configuration').hide();
        $('#main_part').show('slow');
        var stateObj = {foo: "bar"};
        history.replaceState(stateObj, "page 2", '?');
        //set_containers_class($('#collection_id').val());
    }

    function show_filters(collection_id, filters) {
        $.ajax({
            url: $('#src').val() + '/controllers/collection/collection_controller.php',
            type: 'POST',
            data: {
                operation: 'show_filters',
                collection_id: collection_id,
                filters: filters
            }
        }).done(function (result) {
            $('#filters_collection').html(result);
            $('.remove-link-filters').show();
        });
    }

</script>
