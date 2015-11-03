<script>!function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = p + '://platform.twitter.com/widgets.js';
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, 'script', 'twitter-wjs');</script> 
<script>
    $.widget("custom.catcomplete", $.ui.autocomplete, {
        _create: function () {
            this._super();
            this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
        },
        _renderMenu: function (ul, items) {
            var that = this,
                    currentCategory = "";
            $.each(items, function (index, item) {
                var li;
                if (item.category != currentCategory) {
                    ul.append("<li class='ui-autocomplete-category'><b>" + item.category + "</b></li>");
                    currentCategory = item.category;
                }
                li = that._renderItemData(ul, item);
                if (item.category) {
                    li.attr("aria-label", item.category + " : " + item.label);
                }
            });
        }
    });
</script>

<script>
    $(function () {
        $("#search_objects").catcomplete({
            delay: 0,
            minLength: 2,
            source: <?php echo json_encode($json_autocomplete); ?>,
            select: function (event, ui) {
                console.log(event);
                $("#search_objects").val('');
                //var temp = $("#chosen-selected2 [value='" + ui.item.value + "']").val();
                $("#dynatree").dynatree("getRoot").visit(function (node) {
                    console.log(node.data.key, ui.item.id, '' + node.data.key + '' === '' + ui.item.id + '');
                    if ('' + node.data.key + '' === '' + ui.item.id + '') {
                        match = node;
                        node.toggleExpand();
                        node.select(node);
                        return true; // stop traversal (if we are only interested in first match)
                    }
                });
                setTimeout(function () {
                    $("#search_objects").val(ui.item.label);
                }, 100);
            }
        });


        notification_events();

        //popover
        $('[data-toggle="popover"]').popover();

        // *************** Iframe Popover Collection ****************
        //$('#iframebutton').attr('data-content', 'Teste').data('bs.popover').setContent();
        var myPopover = $('#iframebutton').data('popover');
        $('#iframebutton').popover('hide');
        myPopover.options.html = true;
        //<iframe width="560" height="315" src="https://www.youtube.com/embed/CGyEd0aKWZE" frameborder="0" allowfullscreen></iframe>
        myPopover.options.content = '<form><input type="text" style="width:200px;" value="<iframe width=\'800\' height=\'600\' src=\'' + $("#socialdb_permalink_collection").val() + '\' frameborder=\'0\'></iframe>" /></form>';

    });


    function clear_list() {
        $("#value_search").val('');
        $("#search_objects").val('');
        $("#search_collections").val('');
        $("#search_collection_field").val('');
        $("#dynatree").dynatree("getRoot").visit(function (node) {
            node.select(false);
        });
//        if ($("#collection_id").val() == get_option('collection_root_id')) {
//
//        } else {
//
//        }

        list_main_ordenation();
        wpquery_clean();
    }
    

    function set_value(e) {
        var search_for = $(e).val();
        $("#value_search").val(search_for);
    }

    function notification_events() {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/event/event_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'notification_events'}
        }).done(function (result) {
            $('#notification_events').html(result);
            $('.dropdown-toggle').dropdown();
            $('.nav-tabs').tab();
        });
    }
    


    function export_selected_objects() {
        var search_for = $("#search_objects").val();
        console.log(search_for);
        var selKeys = $.map($("#dynatree").dynatree("getSelectedNodes"), function (node) {
            return node.data.key;
        });

        window.location = $('#src').val() + '/controllers/export/export_controller.php?operation=export_selected_objects' +
                '&collection_id=' + $("#collection_id").val() +
                '&classifications=' + selKeys.join(", ") +
                '&ordenation_id=' + $('#collection_single_ordenation').val() +
                '&order_by=' +
                '&keyword=' + search_for;
//        $('#loader_objects').show();
//        $.ajax({
//            url: $('#src').val() + '/controllers/export/export_controller.php',
//            type: 'POST',
//            data: {
//                operation: 'export_selected_objects',
//                collection_id: $("#collection_id").val(),
//                classifications: selKeys.join(", "),
//                ordenation_id: $('#collection_single_ordenation').val(),
//                order_by: '',
//                keyword: search_for
//            }
//        }).done(function (result) {
//            $('#loader_objects').hide();
//            $('#list').html(result);
//            $('#list').show();
//        });
    }
    
 function deleteCollection(collection_id){
    swal({
        title: '<?php _e('Are you sure','tainacan') ?>',
        text: '<?php _e('Delete this collection?','tainacan') ?>',
        type: "warning",
        showCancelButton: true,
        cancelButtonText: '<?php _e('Cancel','tainacan') ?>',
        confirmButtonClass: 'btn-danger',
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "POST",
                url: $('#src').val() + "/controllers/collection/collection_controller.php",
                data: {
                    operation: 'delete_collection',
                    collection_id:collection_id
                }
            }).done(function (result) {
                elem_first = jQuery.parseJSON(result);
                showAlertGeneral(elem_first.title, elem_first.msg, elem_first.type);
                
                window.location = elem_first.url;
            });
        }
    });
} 

//mostrar modal de denuncia
function show_report_abuse_collection(collection_id){
    $('#modal_delete_collection'+collection_id).modal('show');
}
</script>
