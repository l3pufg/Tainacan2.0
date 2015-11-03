<?php 
/*
 * View Responsavel em mostrar as propriedades na hora de INSERCAO do objeto, NAO UTILIZADA NOS EVENTOS
 */
include_once ('js/show_insert_object_properties_js.php'); 
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
                    <input type="text" onkeyup="autocomplete_object_property_add('<?php echo $property['id']; ?>', '<?php echo $object_id; ?>');" id="autocomplete_value_<?php echo $property['id']; ?>_<?php echo $object_id; ?>" placeholder="<?php _e('Type the three first letters of the object of this collection ','tainacan'); ?>"  class="chosen-selected form-control"  />  
                    <select onclick="clear_select_object_property(this);" id="property_value_<?php echo $property['id']; ?>_<?php echo $object_id; ?>_add" multiple class="chosen-selected2 form-control" style="height: auto;" name="socialdb_property_<?php echo $property['id']; ?>[]" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?> >
                        <?php if(!empty($property['metas']['objects'])){ ?>     
                           
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
    <?php foreach ($property_data as $property) { ?>
        <div class="form-group">
            <label ><?php echo $property['name']; ?></label> 
                <?php if($property['type']=='text'){ ?>     
            <input type="text" class="form-control" value="<?php if($property['metas']['socialdb_property_default_value']): echo $property['metas']['socialdb_property_default_value']; endif; ?>" name="socialdb_property_<?php echo $property['id']; ?>" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>>
                <?php }elseif($property['type']=='textarea') { ?>   
                      <textarea class="form-control" value="<?php if($property['metas']['socialdb_property_default_value']): echo $property['metas']['socialdb_property_default_value']; endif; ?>" name="socialdb_property_<?php echo $property['id']; ?>" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>></textarea>
                 <?php }elseif($property['type']=='numeric') { ?>   
                      <input type="number" value="<?php if($property['metas']['socialdb_property_default_value']): echo $property['metas']['socialdb_property_default_value']; endif; ?>" class="form-control" name="socialdb_property_<?php echo $property['id']; ?>" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>>
                 <?php }elseif($property['type']=='autoincrement') {  ?>   
                      <input disabled="disabled"  type="number" class="form-control" name="only_showed_<?php echo $property['id']; ?>" value="<?php if(is_numeric($property['metas']['socialdb_property_data_value_increment'])): echo $property['metas']['socialdb_property_data_value_increment']+1; endif; ?>">
                      <!--input type="hidden"  name="socialdb_property_<?php echo $property['id']; ?>" value="<?php if($property['metas']['socialdb_property_data_value_increment']): echo $property['metas']['socialdb_property_data_value_increment']+1; endif; ?>" -->
                <?php }else{ ?>
                      <input type="text" value="<?php if($property['metas']['socialdb_property_default_value']): echo $property['metas']['socialdb_property_default_value']; endif; ?>" class="form-control input_date" name="socialdb_property_<?php echo $property['id']; ?>" <?php if($property['metas']['socialdb_property_required']=='true'): echo 'required="required"'; endif; ?>>
                <?php } ?> 
        </div>              
     <?php  } ?>
<?php endif; 
 if((isset($property_term)&&count($property_term)>1)||(count($property_term)==1&&!empty($property_term[0]['has_children']))): ?>
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
    
<input type="hidden" name="properties_terms_radio" id='properties_terms_radio' value="<?php echo implode(',',$properties_terms_radio); ?>">
<input type="hidden" name="properties_terms_tree" id='properties_terms_tree' value="<?php echo implode(',',$properties_terms_tree); ?>">
<input type="hidden" name="properties_terms_selectbox" id='properties_terms_selectbox' value="<?php echo implode(',',$properties_terms_selectbox); ?>">
<input type="hidden" name="properties_terms_checkbox" id='properties_terms_checkbox' value="<?php echo implode(',',$properties_terms_checkbox); ?>">
<input type="hidden" name="properties_terms_multipleselect" id='properties_terms_multipleselect' value="<?php echo implode(',',$properties_terms_multipleselect); ?>">
<input type="hidden" name="properties_terms_treecheckbox" id='properties_terms_treecheckbox' value="<?php echo implode(',',$properties_terms_treecheckbox); ?>">
<?php if(isset($all_ids)): ?>
<input type="hidden" name="properties_id" value="<?php echo $all_ids; ?>">
<?php endif; 

