<script> 
$(document).ready(function() { 
     notification_events_repository();
    $('.nav-tabs').tab();
    $('#event_not_verified_table').DataTable();
    $('#event_verified_table').DataTable();
    <?php // Submissao do form de exclusao da categoria ?> 
    $('#submit_form_event_not_confirmed' ).submit( function( e ) {
        e.preventDefault();
         $.ajax( {
              url: $('#src').val()+'/controllers/event/event_controller.php',
              type: 'POST',
              data: new FormData( this ),
              processData: false,
              contentType: false
        }).done(function( result ) {
                 $('#modal_verify_event_not_confirmed').modal('hide');
                 showHeaderCollection($('#src').val());
                 showEvents($('#src').val());
                 notification_events_repository();
                 elem_first =jQuery.parseJSON(result); 
                 if(elem_first.operation&&elem_first.operation!=='socialdb_event_collection_delete'){
                     showEvents($('#src').val());
                 }else{
                     showEventsRepository($('#src').val(),'<?php echo get_option('collection_root_id'); ?>');
                 }
                 if(elem.success==='true'){
                     showAlertGeneral('<?php _e('Atention','tainacan') ?>', '<?php _e('An error ocurred, this event does not exist anymore','tainacan') ?>', 'error');
                 }else{
                     showAlertGeneral('<?php _e('Success','tainacan') ?>', '<?php _e('Event confirmed successfuly','tainacan') ?>', 'success');
                 }
                 $('.dropdown-toggle').dropdown();
        }); 
        e.preventDefault();
    });
    
     $('#click_events_not_verified' ).click(function( e ) {
         e.preventDefault();
         $(this).tab('show');
     });
     $('#click_events_verified' ).click(function( e ) {
          e.preventDefault();
          $(this).tab('show');
     });
    
});
<?php //vincular categorias com a colecao (facetas)   ?>
function show_verify_event_not_confirmed(event_id,collection_id){
$.ajax({
        type: "POST",
        url: $('#src').val()+"/controllers/event/event_controller.php",
        data: {collection_id:  collection_id,operation:'get_event_info',event_id:event_id}
    }).done(function( result ) {
        elem = jQuery.parseJSON(result);
        elem = jQuery.parseJSON(result);
        if(!elem.author||elem.author===null||elem.author=='<?php get_option('anonimous_user') ?>'){
            elem.author = '<?php _e('Anonimous','tainacan') ?>';
        }
        if (elem.name) {
             $('#event_date_create').text(elem.date);
             $('#event_author').text(elem.author);
             $('#event_description').text(elem.name);
              $('#event_observation').text(elem.observation);
             $('#event_operation').val(elem.operation);
             $('#event_id').val(elem.id);
        }
         $('.dropdown-toggle').dropdown();
         $('#modal_verify_event_not_confirmed').modal('show');
    });
}

function show_verify_event_confirmed(event_id,collection_id){
$.ajax({
        type: "POST",
        url: $('#src').val()+"/controllers/event/event_controller.php",
        data: {collection_id:  collection_id,operation:'get_event_info',event_id:event_id}
    }).done(function( result ) {
        elem = jQuery.parseJSON(result);
        if(!elem.author||elem.author===null||elem.author=='<?php get_option('anonimous_user') ?>'){
            elem.author = '<?php _e('Anonimous','tainacan') ?>';
        }
        if (elem.name) {
             $('#event_date_create').text(elem.date);
             $('#event_author').text(elem.author);
             $('#event_description').text(elem.name);
             $('#event_operation').val(elem.operation);
             $('#event_id').val(elem.id);
        }
         $('.dropdown-toggle').dropdown();
         $('#modal_verify_event_not_confirmed').modal('show');
    });
}
</script>
            