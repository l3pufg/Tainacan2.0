<?php
include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
include_once ('js/edit_js.php');
$tags_name = [];
if(isset($tags)){
    foreach ($tags as $tag) {
        $tags_name[] = get_term_by('id',$tag,'socialdb_tag_type')->name; 
    }
}
$fields = ['text','video','image','pdf','audio'];
?>
<h3><?php _e('Edit Object','tainacan'); ?><button onclick="back_main_list();"class="btn btn-default pull-right"><b><?php _e('Back','tainacan') ?></b></button></h3>
<hr>
<form  id="submit_form_edit_object">
    <div class="form-group">
          <label for="object_name"><?php _e('Item name','tainacan'); ?></label>
          <input type="text" class="form-control" name="object_name" id="object_name_edit" value="<?= $object->post_title ?>">
    </div>
    <!-- Tainacan: type do objeto -->
    <div class="form-group">
        <label for="object_name"><?php _e('Item type','tainacan'); ?></label><br>
        <input type="radio" 
               onchange="edit_show_other_type_field(this)" 
               name="object_type" 
               <?php if($socialdb_object_dc_type=='text'): echo 'checked="checked"'; endif;  ?>
               value="text" 
               required>&nbsp;<?php _e('Text','tainacan'); ?><br>
        <input type="radio" 
               name="object_type"
               <?php if($socialdb_object_dc_type=='video'): echo 'checked="checked"'; endif;  ?>
               id="video_type"
               onchange="edit_show_other_type_field(this)" 
               value="video" required>&nbsp;<?php _e('Video','tainacan'); ?><br>
        <input type="radio" 
               onchange="edit_show_other_type_field(this)" 
               name="object_type" 
               <?php if($socialdb_object_dc_type=='image'): echo 'checked="checked"'; endif;  ?>
               value="image" required>&nbsp;<?php _e('Image','tainacan'); ?><br>
        <input type="radio" 
               onchange="edit_show_other_type_field(this)" 
               name="object_type" 
                <?php if($socialdb_object_dc_type=='pdf'): echo 'checked="checked"'; endif;  ?>
               value="pdf" required>&nbsp;<?php _e('PDF','tainacan'); ?><br>
        <input type="radio" 
               name="object_type" 
               <?php if($socialdb_object_dc_type=='audio'): echo 'checked="checked"'; endif;  ?>
               onchange="edit_show_other_type_field(this)" 
               value="audio" required>&nbsp;<?php _e('Audio','tainacan'); ?><br>
        <input type="radio"
               onchange="edit_show_other_type_field(this)" 
               <?php if(!in_array($socialdb_object_dc_type, $fields)): echo 'checked="checked"'; endif;  ?>
               name="object_type" 
               value="other"  required>&nbsp;<?php _e('Other','tainacan'); ?>
        <!--  TAINACAN:  Field extra para outro formato -->
        <input <?php if(!in_array($socialdb_object_dc_type, $fields)): echo 'style="display:block"';else:echo 'style="display:none"'; endif;  ?>
               type="text" 
               id="object_type_other" 
               name="object_type_other" 
               value="<?php if(!in_array($socialdb_object_dc_type, $fields)): echo $socialdb_object_dc_type; else: echo ''; endif; ?>" >
        <br>
    </div>
    <!-- Tainacan: se o item eh importado ou uploaded -->
    <div id="thumb-idea-form">
        <label for="object_thumbnail">
            <?php _e('Internal or external','tainacan'); ?>
        </label><br>
        <input type="radio" 
               name="object_from" 
               id="external_option"
               onchange="edit_toggle_from(this)" 
               <?php if($socialdb_object_from=='external'): echo 'checked="checked"'; endif;  ?>
               value="external" required>&nbsp;<?php _e('Web Address','tainacan'); ?>
            <!--  TAINACAN: Campo para importacao de noticias ou outros item VIA URL do tipo texto -->
            <div style="display:<?php if($socialdb_object_from=='external'&&$socialdb_object_dc_type=='text'): echo 'block';else: echo 'none'; endif;  ?>;
                padding-top: 10px;" 
                id="object_url_text" 
                class="input-group">
                <!-- Tainacan: input para url do tipo texto para importacao de noicias e outros sites -->
                <input onkeyup="edit_set_source(this)" 
                       type="text" 
                       id="url_object_edit" 
                       value="<?php echo $socialdb_object_content;  ?>"
                       class="form-control input-medium placeholder"  
                       placeholder="<?php _e('Type/paste the URL and click in the button import','tainacan'); ?>" 
                       name="object_url"  >
                <!-- Tainacan: botao para realizar a importacao -->
                <span class="input-group-btn">
                    <button onclick="import_object_edit()" class="btn btn-primary" type="button"><?php _e('Import','tainacan'); ?></button>
                </span>
            </div> 
            <!-- TAINACAN: Campo para importacao de outros arquivos via url -->
            <div id="object_url_others" style="display: <?php if($socialdb_object_from=='external'&&$socialdb_object_dc_type!='text'): echo 'block';else: echo 'none'; endif;  ?>;padding-top: 10px;" >
                <input type="text" 
                       onkeyup="edit_set_source(this)"
                       id="object_url_others_input" 
                       placeholder="<?php _e('Type/paste the URL','tainacan'); ?>"
                       class="form-control"
                       name="object_url" 
                       value="<?php echo $socialdb_object_content;  ?>" >  
            </div>
        <br>
        <!-- TAINACAN: seleciona se o objeto eh interno -->
        <input type="radio"
               id="internal_option"
               onchange="edit_toggle_from(this)" 
               <?php if($socialdb_object_from=='internal'): echo 'checked="checked"'; endif;  ?>
               name="object_from" 
               value="internal"  required>&nbsp;<?php _e('Local','tainacan'); ?>
          <!-- TAINACAN: input file para fazer o upload de arquivo --> 
         <input style="display: <?php if($socialdb_object_from=='internal'&&$socialdb_object_dc_type!='text'): echo 'block';else: echo 'none'; endif;  ?>;padding-top: 10px;" 
                type="file" size="50" 
                id="object_file" 
                name="object_file" 
                class="btn btn-default btn-sm">
          <?php 
          // mostra o link para o content atual do item
          if($socialdb_object_dc_type!='text'&&$socialdb_object_from=='internal'):
              echo '<h4>'.__('Actual Item Content','tainacan').'</h4>';
             echo get_post($socialdb_object_content)->post_title."<br>";
              echo wp_get_attachment_link($socialdb_object_content, 'thumbnail', false, true);
          endif;   
           ?>
        <br>
        <br>
    </div> 
    <div id="object_content_text_edit" style="display:<?php if($socialdb_object_dc_type=='text'): echo 'block';else: echo 'none'; endif;  ?>;" class="form-group">
            <label for="object_editor"><?php _e('Item Content','tainacan'); ?></label>
            <textarea class="form-control" id="objectedit_editor" name="objectedit_editor" placeholder="<?php _e('Object Content','tainacan'); ?>">
            <?php echo get_post_meta($object->ID, 'socialdb_object_content', true); ?>
            </textarea>     
    </div>
    <div id="thumb-idea-form">
        <label for="object_thumbnail"><?php _e('Item Thumbnail','tainacan'); ?></label><BR>
        <input type="hidden" name="thumbnail_url" id="thumbnail_url_edit" value="">
         <div id="existent_thumbnail">
         <?php if(get_the_post_thumbnail($object->ID,'thumbnail')){
                echo  get_the_post_thumbnail($object->ID,'thumbnail');
                ?>
                <br><br>
            <label for="remove_thumbnail"><?php _e('Remove Thumbnail','tainacan'); ?></label>
            <input type="hidden" name="object_has_thumbnail" value="true">
            <input type="checkbox"  id="remove_thumbnail_object" name="remove_thumbnail_object" value="true">
            <br><br>
            <?php
          }else{ ?> 
            <input type="hidden" name="object_has_thumbnail" value="false">
             <img src="<?php echo get_item_thumbnail_default($object->ID); ?>">
          <?php } ?>
        </div>     
        <div id="image_side_edit_object">
        </div>
        <input type="file" size="50" id="object_thumbnail_edit" name="object_thumbnail" class="btn btn-default btn-sm">
        <br>
    </div>
    <!-- TAINACAN: a fonte do item -->
    <div class="form-group">
        <label for="object_editor">
            <?php _e('Item Source','tainacan'); ?>
        </label>
        <input  
               type="text" 
               id="object_source" 
               class="form-control"
               name="object_source" 
               placeholder="<?php _e('Where your object come from','tainacan'); ?>"
               value="<?php echo $socialdb_object_dc_source;  ?>" >  
    </div>
    <!-- TAINACAN: a descricao do item -->
    <div id="object_description" class="form-group">
        <label for="object_description"><?php _e('Item Description','tainacan'); ?></label>
        <textarea class="form-control" id="object_description_example" name="object_description" ></textarea>     
    </div>
    <!-- TAINACAN: DROPZONE --> 
    <div id="dropzone_edit" <?php if($socialdb_collection_attachment=='no') echo 'style="display:none"' ?> class="dropzone">
    </div>
    <div class="form-group">
        <label for="object_tags"><?php _e('Object tags','tainacan'); ?></label>
        <input type="text" class="form-control" id="object_tags" name="object_tags"  value="<?= implode(',', $tags_name) ?>" placeholder="<?php _e('The set of tags may be inserted by comma','tainacan') ?>">
    </div>
    <div id="show_form_properties_edit">
    </div>    
    <div id="show_form_licenses">
    </div>
    <input type="hidden" id="object_id_edit" name="object_id" value="<?= $object->ID ?>">
    <input type="hidden" id="selected_nodes_dynatree" name="selected_nodes_dynatree" value="">
    <input type="hidden" id="object_classifications_edit" name="object_classifications" value="<?= $classifications ?>">
    <input type="hidden" id="object_content_edit" name="object_content" value="<?= strip_tags(get_post_meta($object->ID, 'socialdb_object_content', true)) ?>">
    <input type="hidden" id="edit_object_collection_id" name="collection_id" value="<?= $collection_id ?>">
    <input type="hidden" id="operation_edit" name="operation" value="update">
    <button type="submit" id="submit_edit" class="btn btn-primary btn-lg pull-right"><?php _e('Submit','tainacan'); ?></button>
</form>