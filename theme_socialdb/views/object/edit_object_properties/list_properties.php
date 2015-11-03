<?php 
/*
 * View Responsavel em mostrar as propriedades na hora de EDITAR do objeto, NAO UTILIZADA NOS EVENTOS
 */
include_once ('js/list_properties_js.php'); 
$properties_terms_radio = [];
$properties_terms_tree = [];
$properties_terms_selectbox = [];
$properties_terms_checkbox = [];
$properties_terms_multipleselect = [];
$properties_terms_treecheckbox = [];

if(isset($property_object)): ?>
    <h4><?php _e('Object Properties','tainacan'); ?></h4>
    <?php foreach ($property_object as $property) { ?>
        <?php //if($property['metas']['socialdb_property_object_is_facet']=='false'): ?>
            <div class="form-group">
                <label for="object_tags"><?php echo $property['name']; ?></label>
                <a class="btn btn-primary btn-xs" href="<?php echo get_permalink($property['metas']['collection_data'][0]->ID); ?>"><?php _e('Add new','tainacan'); ?><?php echo ' '.$property['metas']['collection_data'][0]->post_title; ?></a>
                <input type="text" onkeyup="autocomplete_object_property_edit('<?php echo $property['id']; ?>', '<?php echo $object_id; ?>');" id="autocomplete_value_<?php echo $property['id']; ?>_<?php echo $object_id; ?>" placeholder="<?php _e('Type the three first letters of the object of this collection ','tainacan'); ?>"  class="chosen-selected form-control"  />    
                <select onclick="clear_select_object_property(this);" id="property_value_<?php echo $property['id']; ?>_<?php echo $object_id; ?>_edit" multiple class="chosen-selected2 form-control" style="height: auto;" name="socialdb_property_<?php echo $property['id']; ?>[]" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?> >
                        <?php if(!empty($property['metas']['objects'])){ ?>     
                            <?php foreach ($property['metas']['objects'] as $object) { ?>
                                <?php if(isset($property['metas']['value'])&&!empty($property['metas']['value'])&&in_array($object->ID, $property['metas']['value'])): // verifico se ele esta na lista de objetos da colecao ?>    
                                   <option selected='selected' value="<?php echo $object->ID ?>"><?php echo $object->post_title ?></span>
                               <?php endif; ?>
                            <?php } ?> 
                        <?php }else { ?>   
                             <option value=""><?php _e('No objects added in this collection','tainacan'); ?></option>
                        <?php } ?>       
                   </select>
             </div>  
        <?php// endif; ?>
    <?php  } ?>
<?php endif; ?>

<?php if(isset($property_data)): ?>
    <h4><?php _e('Data properties','tainacan'); ?></h4>
    <?php foreach ($property_data as $property) {
        ?>
        <div class="form-group">
            <label ><?php echo $property['name']; ?></label> 
                <?php if($property['type']=='text'){ ?>     
                      <input type="text" class="form-control" value="<?php if($property['metas']['value']) echo $property['metas']['value'][0]; ?>" name="socialdb_property_<?php echo $property['id']; ?>" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>>
                <?php }elseif($property['type']=='textarea') { ?>   
                      <textarea class="form-control" value="<?php if($property['metas']['value']) echo $property['metas']['value'][0]; ?>" name="socialdb_property_<?php echo $property['id']; ?>" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>></textarea>
                 <?php }elseif($property['type']=='numeric') { ?>   
                      <input type="number" class="form-control" name="socialdb_property_<?php echo $property['id']; ?>" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?> value="<?php if($property['metas']['value']) echo $property['metas']['value'][0]; ?>">
                 <?php }elseif($property['type']=='autoincrement') { ?>   
                      <input disabled="disabled"  type="number" class="form-control" name="hidded_<?php echo $property['id']; ?>" value="<?php if($property['metas']['value']) echo $property['metas']['value'][0]; ?>">
                 <?php }else{ ?> 
                      <input type="text" class="form-control input_date" value="<?php if($property['metas']['value']) echo $property['metas']['value'][0]; ?>" name="socialdb_property_<?php echo $property['id']; ?>" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>>
                <?php } ?> 
        </div>              
     <?php  } ?>
<?php endif; 
    
 if(isset($property_term)): ?>
    <h4><?php _e('Term properties','tainacan'); ?></h4>
    <?php foreach ($property_term as $property) { ?>
        <div class="form-group">
            <label ><?php echo $property['name']; ?></label> 
                <p><?php if($property['metas']['socialdb_property_help']){ echo $property['metas']['socialdb_property_help']; } ?></p> 
                <?php if($property['type']=='radio'){ 
                    $properties_terms_radio[] = $property['id']; 
                    ?>
                    <div id='field_property_term_<?php echo $property['id']; ?>'></div>
                    <?php
                 }elseif($property['type']=='tree') { 
                    $properties_terms_tree[] = $property['id']; 
                     ?>
                     <div class="row">
                         <div style='height: 150px;overflow: scroll;' class='col-lg-6'  id='field_property_term_<?php echo $property['id']; ?>'></div>
                         <select name='socialdb_propertyterm_<?php echo $property['id']; ?>' size='2' class='col-lg-6' id='socialdb_propertyterm_<?php echo $property['id']; ?>' <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>></select>
                    </div>
                    <?php
                 }elseif($property['type']=='selectbox') { 
                    $properties_terms_selectbox[] = $property['id']; 
                     ?>
                    <select class="form-control" name="socialdb_propertyterm_<?php echo $property['id']; ?>" id='field_property_term_<?php echo $property['id']; ?>' <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>></select>
                    <?php
                  }elseif($property['type']=='checkbox') { 
                    $properties_terms_checkbox[] = $property['id']; 
                     ?>
                    <div id='field_property_term_<?php echo $property['id']; ?>'></div>
                    <?php
                  }elseif($property['type']=='multipleselect') { 
                    $properties_terms_multipleselect[] = $property['id']; 
                     ?>
                     <select multiple class="form-control" name="socialdb_propertyterm_<?php echo $property['id']; ?>" id='field_property_term_<?php echo $property['id']; ?>' <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>></select>
                    <?php
                  }elseif($property['type']=='tree_checkbox') { 
                    $properties_terms_treecheckbox[] = $property['id']; 
                     ?>
                    <div class="row">
                         <div style='height: 150px;overflow: scroll;' class='col-lg-6'  id='field_property_term_<?php echo $property['id']; ?>'></div>
                         <select multiple size='6' class='col-lg-6' name='socialdb_propertyterm_<?php echo $property['id']; ?>[]' id='socialdb_propertyterm_<?php echo $property['id']; ?>' <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>></select>
                    </div>
                    <?php
                  }
                 ?> 
        </div>              
     <?php  } ?>
<?php endif; 

?>
 <input type="hidden" name="categories_id" id='edit_object_categories_id' value="<?php echo implode(',', $categories_id); ?>">   
<input type="hidden" name="properties_terms_radio" id='properties_terms_radio' value="<?php echo implode(',',$properties_terms_radio); ?>">
<input type="hidden" name="properties_terms_tree" id='properties_terms_tree' value="<?php echo implode(',',$properties_terms_tree); ?>">
<input type="hidden" name="properties_terms_selectbox" id='properties_terms_selectbox' value="<?php echo implode(',',$properties_terms_selectbox); ?>">
<input type="hidden" name="properties_terms_checkbox" id='properties_terms_checkbox' value="<?php echo implode(',',$properties_terms_checkbox); ?>">
<input type="hidden" name="properties_terms_multipleselect" id='properties_terms_multipleselect' value="<?php echo implode(',',$properties_terms_multipleselect); ?>">
<input type="hidden" name="properties_terms_treecheckbox" id='properties_terms_treecheckbox' value="<?php echo implode(',',$properties_terms_treecheckbox); ?>">
<?php if(isset($all_ids)): ?>
<input type="hidden" name="properties_id" value="<?php echo $all_ids; ?>">
<?php endif;  ?>


