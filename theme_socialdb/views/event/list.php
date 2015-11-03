<?php
include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
include_once ('js/list_js.php');

?>  
<div id="events_title" class="row">
    <div class="col-md-2">
        <br><button onclick="backToMainPage();" class="btn btn-default pull-right"><?php _e('Back','tainacan') ?></button>
    </div>    
    <div class="col-md-9">  
        <h3><?php _e('Events','tainacan') ?></h3> 
        <div id="alert_success_categories" class="alert alert-success" style="display: none;">
            <button type="button" class="close" onclick="hide_alert();"><span aria-hidden="true">&times;</span></button>
            <?php _e('Operation was successful.','tainacan') ?>
        </div>    
        <div id="alert_error_categories" class="alert alert-danger" style="display: none;">
            <button type="button" class="close" onclick="hide_alert();"><span aria-hidden="true">&times;</span></button>
            <?php _e('Error! Operation was unsuccessful.','tainacan') ?>&nbsp;<span id="message_category"></span>
        </div>    
    </div>
</div>
<div class="events_menu" class="row">
    <div class="col-md-2">
        
    </div>
    <div class="col-md-10">
       
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a id="click_events_not_verified" href="#events_not_verified_tab" aria-controls="property_data_tab" role="tab" data-toggle="tab">
                        <?php _e('Events not verified','tainacan') ?><span>(<?php if(is_array($events_not_observed)): echo count($events_not_observed); else: echo '0'; endif; ?>)</span>
                    </a>
                </li>
                <li role="presentation">
                    <a id="click_events_verified" href="#events_verified_tab" aria-controls="property_object_tab" role="tab" data-toggle="tab">
                        <?php _e('Events verified','tainacan') ?><span>(<?php if(is_array($events_observed)): echo count($events_observed); else: echo '0'; endif; ?>)</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="events_not_verified_tab">
                <div id="list_events_not_verified">
                    <?php 
                    if(isset($events_not_observed)){     // se existir eventos a serem verificaos ?>
                        <table id="event_not_verified_table" class="table table-striped table-bordered" cellspacing="0" width="100%">  <!--class="table table-bordered" style="background-color: #d9edf7;"-->
                             <thead>
                               <tr>  
                                <th><?php _e('Date','tainacan','tainacan'); ?></th>
                                <th><?php _e('Event Type','tainacan'); ?></th>
                                <th><?php _e('Event Description','tainacan'); ?></th>
                                <th><?php _e('State','tainacan'); ?></th>
                               </tr> 
                             </thead>     
                            <tbody id="table_events_not_verified" >
                             <?php foreach ($events_not_observed as $event) { ?>
                                    <tr>
                                       <td> 
                                           <?php echo date("d/m/Y", $event['date']); ?>
                                       </td>   
                                       <td> 
                                           <?php echo $event['type']; ?>
                                       </td> 
                                       <td> 
                                           <?php echo $event['name']; ?>
                                       </td> 
                                       <td> 
                                           <a href="#configuration" onclick="show_verify_event_not_confirmed('<?= $event['id'] ?>','<?= $collection_id ?>')"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;<?php _e('Not verified','tainacan') ?></a>
                                       </td> 
                                    </tr>    
                            <?php
                                }
                            ?>
                            </tbody>    
                        </table>
                    <?php
                    }else{ // se caso nao existir eventos a serem observados
                    ?>
                        <div id="post-0">
                                <h5 class="page-title"><strong><?php echo _e('No events in this section','tainacan'); ?></strong></h5>
                        </div><!-- #post-0 -->
                    <?php
                    }
                    ?>
                </div> 
            </div>
            <div role="tabpanel" class="tab-pane" id="events_verified_tab">
                 <div id="list_events_verified">
                    <?php 
                    if(isset($events_observed)){ // se existir eventos a serem verificaos ?>
                        <table  id="event_verified_table"  class="table table-striped table-bordered" >
                            <thead>
                               <tr>  
                                    <th><?php _e('Date','tainacan'); ?></th>
                                    <th><?php _e('Event Type','tainacan'); ?></th>
                                    <th><?php _e('Event Description','tainacan'); ?></th>
                                    <th><?php _e('State','tainacan'); ?></th>
                                    <th><?php _e('Approval Date','tainacan'); ?></th>
                                    <th><?php _e('Approved by','tainacan'); ?></th>
                                </tr>    
                               </thead> 
                               <tbody id="table_events_verified" >
                               <?php foreach ($events_observed as $event) { ?>
                                    <tr>
                                       <td> 
                                           <?php echo date("d/m/Y", $event['date']); ?>
                                       </td>   
                                       <td> 
                                           <?php echo $event['type']; ?>
                                       </td> 
                                       <td> 
                                           <?php echo $event['name']; ?>
                                       </td> 
                                       <td>
                                           <a href="#configuration" onclick="show_verify_event_confirmed('<?= $event['id'] ?>','<?= $collection_id ?>')"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;
                                               <?php 
                                               if($event['state']=='confirmed'): _e('Confirmed','tainacan'); 
                                               elseif($event['state']=='not_confirmed'): _e('Not Confirmed','tainacan');
                                               elseif($event['state']=='invalid'): _e('Invalid','tainacan'); endif;
                                               ?>
                                           </a>
                                       </td>
                                       <td> 
                                           <?php if($event['state']!='invalid'): ?>
                                           <?php echo  date("d/m/Y", get_post_meta($event['id'], 'socialdb_event_approval_date', true)); ?>
                                           <?php else: ?>
                                           <?php _e('Invalid','tainacan') ?>
                                           <?php endif; ?>
                                       </td> 
                                       <td> 
                                           <?php if($event['state']!='invalid'): ?>
                                           <?php echo get_user_by( 'id',  get_post_meta($event['id'], 'socialdb_event_approval_by', true) )->data->user_nicename; ?>
                                           <?php else: ?>
                                           <?php _e('Invalid','tainacan') ?>
                                           <?php endif; ?>
                                       </td>  
                                    </tr>    
                               <?php
                                }
                                ?>
                                </tbody>    
                        </table>
                    <?php
                    }else{ // se caso nao existir eventos a serem observados
                    ?>
                        <div id="post-0">
                                <h5 class="page-title"><strong><?php echo _e('No events in this section','tainacan'); ?></strong></h5>
                        </div><!-- #post-0 -->
                    <?php
                    }
                    ?>
                </div> 
            </div>
        </div>    
    </div>    
</div> 
<!-- modal exluir -->
<div class="modal fade" id="modal_verify_event_not_confirmed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form id="submit_form_event_not_confirmed">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><?php _e('Verify Event','tainacan')?></h4>
            </div>
            <div class="modal-body">
               <!-- <span><b><?php _e('Collection','tainacan')?></b>: <span id="event_collection_name"></span></span><br>-->
                <span><b><?php _e('Event created date','tainacan')?></b>: <span id="event_date_create"></span></span><br>
                <span><b><?php _e('Event author','tainacan')?></b>: <span id="event_author"></span></span><br>
                <hr>
                <span><b><?php _e('Event description','tainacan')?></b>:<br> <span id="event_description"></span></span><br>
                <hr>
                <span><b><?php _e('Event confirmation','tainacan')?></b>: </span><br>
                <div>
                    <input type="radio" name="socialdb_event_confirmed" id="event_confirmed_true" value="true"> <?php _e('Confirmed','tainacan')?>
                    <input type="radio" name="socialdb_event_confirmed" checked="checked" id="event_confirmed_false" value="false"> <?php _e('Not confirmed','tainacan')?>				  			
                </div><br>
                <span><b><?php _e('Event observation','tainacan')?></b>: </span><br>
                <textarea class="form-control" name="socialdb_event_observation" id="event_observation"></textarea>
                <input type="hidden" id="event_operation" name="operation" value="">
                <input type="hidden" id="event_id" name="event_id" value="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','tainacan')?></button>
              <button type="submit" class="btn btn-primary"><?php _e('Save','tainacan')?></button>
            </div>
          </form>    
        </div>
    </div>
</div>    
<!-- modal exluir -->
<div class="modal fade" id="modal_verify_event_confirmed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form id="submit_form_event_not_confirmed">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><?php _e('Verify Event','tainacan')?></h4>
            </div>
            <div class="modal-body">
               <!-- <span><b><?php _e('Collection','tainacan')?></b>: <span id="event_collection_name"></span></span><br>-->
                <span><b><?php _e('Event created date','tainacan')?></b>: <span id="event_date_create"></span></span><br>
                <span><b><?php _e('Event author','tainacan')?></b>: <span id="event_author"></span></span><br>
                <hr>
                <span><b><?php _e('Event description','tainacan')?></b>:<br> <span id="event_description"></span></span><br>
                <hr>
                <span><b><?php _e('Event confirmation','tainacan')?></b>: </span><br>
                <div>
                    <input  type="radio" name="socialdb_event_confirmed" id="event_confirmed_true" value="true"> <?php _e('Confirmed','tainacan')?>
                    <input type="radio" name="socialdb_event_confirmed" checked="checked" id="event_confirmed_false" value="false"> <?php _e('Not confirmed','tainacan')?>				  			
                </div><br>
                <span><b><?php _e('Event observation','tainacan')?></b>: </span><br>
                <textarea class="form-control" name="socialdb_event_observation" id="event_observation"></textarea>
                <input type="hidden" id="event_operation" name="operation" value="">
                <input type="hidden" id="event_id" name="event_id" value="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','tainacan')?></button>
              <button type="submit" class="btn btn-primary"><?php _e('Save','tainacan')?></button>
            </div>
          </form>    
        </div>
    </div>
</div>  