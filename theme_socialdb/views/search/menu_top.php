<?php include_once ('js/menu_top_js.php'); 
if(count($facets)>0):
$class =   floor(12/count($facets));
endif;
?> 
 <!-- TAINACAN: widgets do menu na parte superior -->   
<?php  foreach ($facets as $facet): ?>
  
    <?php if($facet['widget']=='range'):   ?>   
                            <!-- TAINACAN: widget para realizacao de busca nos items  -->
                             <div class="col-md-<?php echo $class ?> form-group">
                                 <label for="object_tags"><?php echo $facet['name']; ?></label><br>
                                          <?php foreach ($facet['options'] as $range): ?>
                                            <a href="#" onclick="wpquery_range('<?php echo $facet['id'] ?>','<?php echo $facet['type'] ?>','<?php echo $range['value_1'] ?>','<?php echo $range['value_2'] ?>')"><?php echo $range['value_1'] . ' ' . __('until','tainacan') . ' ' . $range['value_2']; ?></a><br>
                                        <?php endforeach; ?>
                                    </div> 
     <?php elseif($facet['widget']=='from_to'): ?> 
                            <!-- TAINACAN: widget para realizacao de busca nos items  -->
                           <div class="col-md-<?php echo $class ?> form-group">
                                  <label for="object_tags"><?php echo $facet['name']; ?></label> <br>
                                 <?php if($facet['type']=='date'){ ?>
                                  <input type="text" class="input_date" value="" id="facet_<?php echo $facet['id']; ?>_1" name="facet_<?php echo $facet['id']; ?>_1"> <?php _e('until','tainacan') ?> <input type="text" class="input_date" value="" id="facet_<?php echo $facet['id']; ?>_2" name="facet_<?php echo $facet['id']; ?>_2"><button onclick="wpquery_fromto('<?php echo $facet['id']; ?>','date');" ><span class="glyphicon glyphicon-arrow-right"></span></button>
                                    <?php }elseif($facet['type']=='numeric'){ ?>
                                    <input type="numeric" value="" id="facet_<?php echo $facet['id']; ?>_1" name="facet_<?php echo $facet['id']; ?>_1"> <?php _e('until','tainacan') ?> <input type="numeric" value="" id="facet_<?php echo $facet['id']; ?>_2" name="facet_<?php echo $facet['id']; ?>_2"><button onclick="wpquery_fromto('<?php echo $facet['id']; ?>','numeric');" ><span class="glyphicon glyphicon-arrow-right"></span></button>
                                    <?php }else{ ?>
                                    <input type="text" value="" id="facet_<?php echo $facet['id']; ?>_1" name="facet_<?php echo $facet['id']; ?>_1"> <?php _e('until','tainacan') ?> <input type="text" value="" id="facet_<?php echo $facet['id']; ?>_2" name="facet_<?php echo $facet['id']; ?>_2"><button onclick="wpquery_fromto('<?php echo $facet['id']; ?>','text');" ><span class="glyphicon glyphicon-arrow-right"></span></button>
                                    <?php }?>
                            </div>
      <?php elseif($facet['widget']=='multipleselect'||$facet['widget']=='searchbox'): ?> 
                            <!-- TAINACAN: widget para realizacao de busca nos items  -->
                             <div class="col-md-<?php echo $class ?> form-group">
                                <label for="object_tags"><?php echo $facet['name']; ?></label>
                                      <input type="text" onkeyup="autocomplete_menu_top('<?php echo $facet['id']; ?>');" id="autocomplete_multipleselect_<?php echo $facet['id']; ?>" placeholder="<?php _e('Type the three first letters of the object of this collection ','tainacan'); ?>"  class="chosen-selected form-control"  />  
                                    <select onclick="clear_autocomplete_menu_top(this,'<?php echo $facet['id']; ?>');" id="multipleselect_value_<?php echo $facet['id']; ?>" multiple class="chosen-selected2 form-control" style="height: auto;" name="multipleselect_value_<?php echo $facet['id']; ?>[]"  >   
                                   </select>
                             </div>  
      <?php elseif($facet['widget']=='radio'): ?> 
                            <!-- TAINACAN: widget para realizacao de busca nos items  -->
                             <div class="col-md-<?php echo $class ?> form-group">
                               <label for="object_tags"><?php echo $facet['name']; ?></label>
                                    <?php foreach($facet['categories'] as $category):  ?>
                                        <input type="radio" onchange="wpquery_radio(this,'<?php echo $facet['id']; ?>');"  value="<?php echo $facet['id']. get_option('socialdb_divider').$category->term_id ; ?>" name="facet_<?php echo $facet['id']; ?>">&nbsp; <?php echo $category->name; ?>
                                    <?php endforeach;  ?>
                             </div>
      
        <?php elseif($facet['widget']=='checkbox'): ?> 
                            <!-- TAINACAN: widget para realizacao de busca nos items  -->
                             <div class="col-md-<?php echo $class ?> form-group">
                                 <label for="object_tags"><?php echo $facet['name']; ?></label><br>
                                    <?php foreach($facet['categories'] as $category):  ?>
                                        <input type="checkbox" value="<?php echo $category->term_id ; ?>" onchange="wpquery_checkbox(this,'<?php echo $facet['id']; ?>');" name="facet_<?php echo $facet['id']; ?>[]">&nbsp; <?php echo $category->name; ?>&nbsp;&nbsp;
                                    <?php endforeach;  ?>
                             </div> 
         <?php elseif($facet['widget']=='selectbox'): ?> 
                            <!-- TAINACAN: widget para realizacao de busca nos items  -->
                             <div class="col-md-<?php echo $class ?> form-group">
                                 <label for="object_tags"><?php echo $facet['name']; ?></label>
                                <select class="form-control" onchange="wpquery_select(this,'<?php echo $facet['id']; ?>');" name="facet_<?php echo $facet['id']; ?>">
                                       <option value="">  <?php echo __('Select...','tainacan'); ?></option>
                                    <?php foreach($facet['categories'] as $category):  ?>
                                       <option value="<?php echo $category->term_id ; ?>" >  <?php echo $category->name; ?></option>
                                    <?php endforeach;  ?>
                                   </select>      
                             </div>
         <?php elseif($facet['widget']=='menu'):  ?> 
                            <!-- TAINACAN: widget para realizacao de busca nos items  -->
                            <div class="col-md-<?php echo $class ?> form-group">
                                        <nav class="navbar navbar-default">
                                            <div class="container-fluid">
                                                <div class="navbar-header">
                                                    <a class="navbar-brand" href="#"><?php echo $facet['name']; ?></a>
                                                </div>
                                                <div>
                                                    <ul class="nav navbar-nav">
                                                        <?php echo $facet['html']; ?>
                                                    </ul>  
                                                </div> 
                                            </div>   
                                        </nav>    
                            </div>    
          <?php endif; ?>         
<?php endforeach; 
?>	