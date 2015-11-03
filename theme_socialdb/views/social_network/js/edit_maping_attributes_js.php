<script>
    var intervalo;
    $(function () {
        var src = $('#src').val();
        $('#collection_import_id').val($('#collection_id').val());
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/social_network/social_mapping_controller.php",
            data: {collection_id: $('#collection_id').val(), operation: 'generate_selects', 'social_network': $('#social_network').val()}
        }).done(function (result) {
            $('.data').html(result);
            //set_values();
        });
    });

    function set_values() {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/mapping/mapping_controller.php",
            data: {
                collection_id: $('#collection_id').val(),
                mapping_id: $("#mapping_id").val(),
                operation: 'get_mapping'}
        }).done(function (result) {
            var jsonObject = jQuery.parseJSON(result);
            if (jsonObject && jsonObject != null) {
                $.each(jsonObject.mapping, function (id, object) {
                    $('[name=' + object.socialdb_entity + ']').val(object.tag);
                });
            }

        });
    }


    function update_mapping() {
        $.ajax({
            type: "POST",
            url: $('#src').val() + "/controllers/mapping/mapping_controller.php",
            data: {
                collection_id: $('#collection_id').val(),
                form: $("#form_import").serialize(),
                mapping_id: $("#mapping_id").val(),
                operation: 'updating_mapping_oaipmh_dc_export'}
        }).done(function (result) {
            $('#maping_container_export').hide();
            $('#export_oaipmh_dc_container').show('slow');
        });
    }
    
    function cancel_export(){
         $('#edit_mapping').hide();
         $('#list_social_network').show('slow');
    }

</script>