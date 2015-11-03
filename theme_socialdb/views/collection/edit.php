<?php
include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
include_once ('js/edit_js.php');
?>
    <div class="col-md-12 fuelux">
        <div id="MyWizard" class=" fuelux wizard">

            <ul class="steps fuelux step-content">
                <a onclick="showCollectionConfiguration('<?php echo get_template_directory_uri() ?>');"><li  class="active"><span class="badge badge-info">1</span><?= __("Configuration",'tainacan') ?><span class="chevron"></span></li></a>
                <a onclick="showPropertiesConfiguration('<?php echo get_template_directory_uri() ?>');"><li ><span class="fuelux badge">2</span><?= __("Metadata",'tainacan') ?><span class="fuelux chevron"></span></li></a>
                <a onclick="showRankingConfiguration('<?php echo get_template_directory_uri() ?>');"><li><span class="fuelux badge">3</span><?= __("Rankings",'tainacan') ?><span class="fuelux chevron"></span></li></a>
                <a onclick="showSearchConfiguration('<?php echo get_template_directory_uri() ?>');"><li><span class="fuelux badge">4</span><?= __("Searching",'tainacan') ?><span class="fuelux chevron"></span></li></a>
                <a onclick="showDesignConfiguration('<?php echo get_template_directory_uri() ?>');"><li><span class="fuelux badge">5</span><?= __("Design",'tainacan') ?><span class="fuelux chevron"></span></li></a>
            </ul>
            <div class="fuelux actions">
                <a onclick="showPropertiesConfiguration('<?php echo get_template_directory_uri() ?>');" href="#" class="btn btn-mini btn-next" data-last="Finish"><?= __("Next",'tainacan') ?><span class="glyphicon glyphicon-chevron-right"></span></i></a>
            </div>
        </div>
    </div> 
    <div class="col-md-1">

        <br>

    </div>	
    <div class="col-md-10">

        <h3>
            <?php _e('Collection Configuration','tainacan'); ?>
            <button onclick="backToMainPage();" id="btn_back_collection" class="btn btn-default pull-right"><?php _e('Back to collection','tainacan') ?></button>
        </h3>
        <hr>
        <form  id="submit_form_edit_collection">
            <div class="form-group">
                <label for="collection_name"><?php _e('Collection name','tainacan'); ?></label>
                <input type="text" class="form-control" id="collection_name" name="collection_name" required="required" value="<?php echo $collection_post->post_title; ?>">
            </div>
            <div id="thumb-idea-form">
                <label for="collection_thumbnail"><?php _e('Collection thumbnail','tainacan'); ?></label>
                <br>
                <?php
                if (get_the_post_thumbnail($collection_post->ID, 'thumbnail')) {
                    echo get_the_post_thumbnail($collection_post->ID, 'thumbnail');
                    ?>
                    <br><br>
                    <label for="remove_thumbnail"><?php _e('Remove Thumbnail','tainacan'); ?></label>
                    <input type="checkbox"  id="remove_thumbnail" name="remove_thumbnail" value="true">
                   <!--<button onclick="remove_thumbnail('<?php echo $collection_post->ID; ?>')" class="btn btn-default" ><?php _e('Remove thumbnail') ?></button>-->
                    <br><br>
                <?php
                } else {

                }
                ?>
                <input type="file" size="50" id="collection_thumbnail" name="collection_thumbnail" class="btn btn-default btn-sm">

                <br>
            </div>
            <div id="socialdb_cover">
                <label for="socialdb_collection_cover"><?php _e('Collection Cover','tainacan'); ?></label>
                <br>
                <?php
                if (get_post_meta($collection_post->ID, 'socialdb_collection_cover_id', true)) {
                    $url_image = wp_get_attachment_url( get_post_meta($collection_post->ID, 'socialdb_collection_cover_id', true) );
                    echo "<img src=".$url_image." style='max-height:150px;' />";
                    //echo get_the_post_thumbnail($collection_post->ID, 'thumbnail');
                    ?>
                    <br><br>
                    <label for="remove_cover"><?php _e('Remove Cover','tainacan'); ?></label>
                    <input type="checkbox"  id="remove_cover" name="remove_cover" value="true">
                    <br><br>
                <?php } ?>
                <input type="file" size="50" id="socialdb_collection_cover" name="socialdb_collection_cover" class="btn btn-default btn-sm">

                <br>
            </div>
            <!------------------- Descricao-------------------------->
            <div class="form-group">
                <label for="collection_description"><?php _e('Collection description','tainacan'); ?></label>           
                <textarea rows="4" id="editor" name="editor"   value="" placeholder='<?= __("Describe your collection in few words",'tainacan'); ?>'><?php echo $collection_post->post_content; ?></textarea>

            </div>
            <div class="form-group">
                <a href="#advanced_config" id="show_adv_config_link" onclick="showAdvancedConfig();"><?php _e('Advanced Configuration','tainacan'); ?></a>
                <a href="#advanced_config" id="hide_adv_config_link" onclick="hideAdvancedConfig();" style="display: none;"><?php _e('Hide Advanced Configuration','tainacan'); ?></a>
            </div>

            <!------------------- DIV ADVANCED -------------------------->
            <div id="advanced_config" style="display: none;">
                <!------------------- Endereco da colecao -------------------------->
                <div class="form-group">
                    <label for="collection_description"><?php _e('Collection Address','tainacan'); ?>*</label><br>
                    <span class="label label-default"><?php _e('*The address must not contain spaces or special characters. If it contains will be removed by the system.','tainacan'); ?></span><br>
                </div>
                <div class="form-inline form-group">
                    <div class="alert alert-success" style="display: none;width: 30%;" id="collection_name_success"><span class="glyphicon glyphicon-ok" ></span>&nbsp;&nbsp;<?php _e('Valid name!','tainacan') ?></div>
                    <div class="alert alert-danger" style="display: none;width: 30%;" id="collection_name_error"><span class="glyphicon glyphicon-warning-sign" >&nbsp;&nbsp;</span><?php _e('Invalid name!','tainacan') ?></div>
                    <label class="control-label" ><?php echo site_url() . '/collection/'; ?></label>
                    <input onkeyup="verify_name_collection();" id="suggested_collection_name" required="required" type="text" class="form-control" name="socialdb_collection_address"  value="<?php echo $collection_post->post_name; ?>" >
                    <input type="hidden" id="initial_address"  name="initial_address"  value="<?php echo $collection_post->post_name; ?>" >
                </div>
                <!------------------- Esconder tags-------------------------->
                <div class="form-group">
                    <label for="socialdb_collection_hide_tags"><?php _e('Hide Tags','tainacan'); ?></label> 
                    <select name="socialdb_collection_hide_tags" class="form-control">
                        <option value="no"  <?php
                                    if ($collection_metas['socialdb_collection_hide_tags'] == 'no' || $collection_metas['socialdb_collection_hide_tags'] == '') {
                                        echo 'selected = "selected"';
                                    }
                                    ?>>
                                <?php _e('No','tainacan'); ?>
                        </option>
                        <option value="yes" <?php
                                if ($collection_metas['socialdb_collection_hide_tags'] == 'yes') {
                                    echo 'selected = "selected"';
                                }
                                ?>>
    <?php _e('Yes','tainacan'); ?>
                        </option>
                    </select>
                </div>
                <!------------------- Privacidade-------------------------->
                <div class="form-group">
                    <label for="collection_privacy"><?php _e('Collection privacy','tainacan'); ?></label> 
                    <select name="collection_privacy" class="form-control">
                        <option value="public" <?php
                                if ($collection_metas['sociadb_collection_privacity'][0]->name == 'socialdb_collection_public' || empty($collection_metas['sociadb_collection_privacity'])) {
                                    echo 'selected = "selected"';
                                }
                                ?>>
    <?php _e('Public','tainacan'); ?>
                        </option>
                        <option value="private" <?php
    if ($collection_metas['sociadb_collection_privacity'][0]->name == 'socialdb_collection_private') {
        echo 'selected = "selected"';
    }
    ?>>
    <?php _e('Private','tainacan'); ?>
                        </option>
                    </select>
                </div>
                <!------------------- Parent-------------------------->
                <input type="hidden" id="selected_parent_collection" value="<?php if ($collection_metas['socialdb_collection_parent'] && $collection_metas['socialdb_collection_parent'] != ''): echo $collection_metas['socialdb_collection_parent'];
    endif; ?>">

                <div class="form-group">
                    <label for="socialdb_collection_parent"><?php _e('Collection Parent','tainacan'); ?></label> 
                    <select name="socialdb_collection_parent" class="combobox form-control" id="socialdb_collection_parent">
                    </select>
                </div>
                <!------------------- Hierarquia-------------------------->
                <div class="form-group">
                    <label for="socialdb_collection_allow_hierarchy"><?php _e('Collection Hierarchy','tainacan'); ?></label> 
                    <select name="socialdb_collection_allow_hierarchy" class="form-control">
                        <option value="true" <?php
                                    if ($collection_metas['socialdb_collection_allow_hierarchy'] == 'true' || empty($collection_metas['socialdb_collection_allow_hierarchy'])) {
                                        echo 'selected = "selected"';
                                    }
    ?>>
    <?php _e('Yes','tainacan'); ?>
                        </option>
                        <option value="false" <?php
    if ($collection_metas['socialdb_collection_allow_hierarchy'] == 'false') {
        echo 'selected = "selected"';
    }
    ?>>
                        <?php _e('No','tainacan'); ?>
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="collection_attachments"><?php _e('You allow attachments to objects from the collection?','tainacan'); ?></label> 
                    <select name="collection_attachments" class="form-control">
                        <option value="yes" <?php
                if ($collection_metas['socialdb_collection_attachment'] == 'yes' || empty($collection_metas['socialdb_collection_attachment'])) {
                    echo 'selected = "selected"';
                }
    ?>>
                <?php _e('Yes','tainacan'); ?>
                        </option>
                        <option value="no" <?php
                if ($collection_metas['socialdb_collection_attachment'] == 'no') {
                    echo 'selected = "selected"';
                }
                ?>>
    <?php _e('No','tainacan'); ?>
                        </option>
                    </select>
                </div>

                <!--div class="form-group">
                     <label for="collection_show_labels"><?php _e('You want to show labels?','tainacan'); ?></label> 
                     <select name="collection_show_labels" class="form-control">
                         <option value="yes"  <?php
                                    if ($collection_metas['socialdb_collection_show_labels'] == 'yes' || empty($collection_metas['socialdb_collection_show_labels'])) {
                                        echo 'selected = "selected"';
                                    }
                                    ?>>
    <?php _e('Yes','tainacan'); ?>
                         </option>
                         <option value="no" <?php
    if ($collection_metas['socialdb_collection_show_labels'] == 'no') {
        echo 'selected = "selected"';
    }
    ?>>
                            <?php _e('No','tainacan'); ?>
                         </option>
                     </select>
                 </div -->

                <div class="form-group">
                    <label for="collection_most_participatory"><?php _e('You want to show the ranking of the most participatory authors?','tainacan'); ?></label> 
                    <select name="collection_most_participatory" class="form-control">
                        <option value="yes"  <?php
                            if ($collection_metas['socialdb_collection_most_participatory'] == 'yes' || empty($collection_metas['socialdb_collection_most_participatory'])) {
                                echo 'selected = "selected"';
                            }
                            ?>>
    <?php _e('Yes','tainacan'); ?>
                        </option>
                        <option value="no" <?php
    if ($collection_metas['socialdb_collection_most_participatory'] == 'no') {
        echo 'selected = "selected"';
    }
    ?>>
    <?php _e('No','tainacan'); ?>
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for=""><?php _e('Collection Moderators','tainacan'); ?></label> 
                    <input type="text" onkeyup="autocomplete_moderators('<?php echo $collection_post->ID; ?>');" id="autocomplete_moderator" placeholder="<?php _e('Type the three first letters of the user name ','tainacan'); ?>"  class="chosen-selected form-control"  />
                    <select onclick="clear_select_moderators(this);"  id="moderators_<?php echo $collection_post->ID; ?>" multiple class="chosen-selected2 form-control" style="height: auto;" multiple name="collection_moderators[]" id="chosen-selected2-user"  >
    <?php if ($collection_metas['socialdb_collection_moderator']) { ?>
        <?php foreach ($collection_metas['socialdb_collection_moderator'] as $moderator) {  // percoro todos os objetos   ?>
                                <option selected='selected' value="<?php echo $moderator['id'] ?>"><?php echo $moderator['name'] ?></span>
        <?php } ?> 
    <?php } ?>            
                    </select>
                </div>            

                <div class="form-group">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border"><strong><?php _e('Permissions - Choose permissions for each of the following actions','tainacan'); ?></strong></legend>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="socialdb_collection_permission_create_category"><?php _e('Create Category','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_create_category" id="socialdb_collection_permission_create_category" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_create_category'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_create_category'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_create_category'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="socialdb_collection_permission_edit_category"><?php _e('Edit Category','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_edit_category" id="socialdb_collection_permission_edit_category" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_edit_category'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_edit_category'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_edit_category'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="socialdb_collection_permission_delete_category"><?php _e('Delete Category','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_delete_category" id="socialdb_collection_permission_delete_category" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_delete_category'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_delete_category'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_delete_category'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_add_classification"><?php _e('Add Classification','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_add_classification" id="socialdb_collection_permission_add_classification" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_add_classification'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_add_classification'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_add_classification'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_delete_classification"><?php _e('Delete Classification','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_delete_classification" id="socialdb_collection_permission_delete_classification" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_delete_classification'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_delete_classification'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_delete_classification'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_create_object"><?php _e('Create Object','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_create_object" id="socialdb_collection_permission_create_object" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_create_object'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_create_object'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_create_object'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_delete_object"><?php _e('Delete Object','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_delete_object" id="socialdb_collection_permission_delete_object" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_delete_object'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_delete_object'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_delete_object'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_create_property_data"><?php _e('Create Property Data','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_create_property_data" id="socialdb_collection_permission_create_property_data" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_create_property_data'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_create_property_data'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_create_property_data'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_edit_property_data"><?php _e('Edit Property Data','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_edit_property_data" id="socialdb_collection_permission_edit_property_data" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_edit_property_data'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_edit_property_data'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_edit_property_data'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_delete_property_data"><?php _e('Delete Property Data','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_delete_property_data" id="socialdb_collection_permission_delete_property_data" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_delete_property_data'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_delete_property_data'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_delete_property_data'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_edit_property_data_value"><?php _e('Edit Property Data Value','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_edit_property_data_value" id="socialdb_collection_permission_edit_property_data_value" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_edit_property_data_value'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_edit_property_data_value'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_edit_property_data_value'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_create_property_object"><?php _e('Create Property Object','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_create_property_object" id="socialdb_collection_permission_create_property_object" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_create_property_object'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_create_property_object'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_create_property_object'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_edit_property_object"><?php _e('Edit Property Object','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_edit_property_object" id="socialdb_collection_permission_edit_property_object" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_edit_property_object'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_edit_property_object'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_edit_property_object'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_delete_property_object"><?php _e('Delete Property Object','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_delete_property_object" id="socialdb_collection_permission_delete_property_object" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_delete_property_object'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_delete_property_object'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_delete_property_object'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="socialdb_collection_permission_edit_property_object_value"><?php _e('Edit Property Object Value','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_edit_property_object_value" id="socialdb_collection_permission_edit_property_object_value" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_edit_property_object_value'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_edit_property_object_value'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_edit_property_object_value'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="socialdb_collection_permission_create_comment"><?php _e('Create Comment','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_create_comment" id="socialdb_collection_permission_create_comment" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_create_comment'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_create_comment'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_create_comment'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="socialdb_collection_permission_edit_comment"><?php _e('Edit Comment','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_edit_comment" id="socialdb_collection_permission_edit_comment" class="form-control">
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_edit_comment'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_edit_comment'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="socialdb_collection_permission_delete_comment"><?php _e('Delete Comment','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_delete_comment" id="socialdb_collection_permission_delete_comment" class="form-control">
                                        <!--option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_delete_comment'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option-->
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_delete_comment'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_delete_comment'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="socialdb_collection_permission_create_tags"><?php _e('Create Tags','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_create_tags" id="socialdb_collection_permission_create_tags" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_create_tags'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_create_tags'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_create_tags'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="socialdb_collection_permission_edit_tags"><?php _e('Edit Tags','tainacan'); ?></label>
                                    <select name="socialdb_collection_permission_edit_tags" id="socialdb_collection_permission_edit_tags" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_edit_tags'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_edit_tags'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_edit_tags'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members'); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="socialdb_collection_permission_delete_tags"><?php _e('Delete Tags'); ?></label>
                                    <select name="socialdb_collection_permission_delete_tags" id="socialdb_collection_permission_delete_tags" class="form-control">
                                        <option value="anonymous" <?php if ($collection_metas['socialdb_collection_permission_delete_tags'] == 'anonymous') {
        echo 'selected = "selected"';
    } ?>><?php _e('Anonymous','tainacan'); ?></option>
                                        <option value="approval" <?php if ($collection_metas['socialdb_collection_permission_delete_tags'] == 'approval') {
        echo 'selected = "selected"';
    } ?>><?php _e('Approval','tainacan'); ?></option>
                                        <option value="members" <?php if ($collection_metas['socialdb_collection_permission_delete_tags'] == 'members') {
        echo 'selected = "selected"';
    } ?>><?php _e('Members','tainacan'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <input type="hidden" id="verify_collection_name" name="verify_collection_name" value="allow">
            <input type="hidden" id="redirect_to_caegories" name="redirect_to_caegories" value="false">
            <input type="hidden" id="collection_content" name="collection_content" value="">
            <input type="hidden" id="collection_id" name="collection_id" value="<?php echo $collection_post->ID; ?>">
            <input type="hidden" id="operation" name="operation" value="update">
            <input type="hidden" id="save_and_next" name="save_and_next" value="false">
            <button type="submit" id="submit_configuration" class="btn btn-success"><?php _e('Save','tainacan'); ?></button>
            <button type="submit" id="button_save_and_next"  class="btn btn-primary" style="float: right;" ><?php _e('Save & Next','tainacan'); ?></button>
        </form>
    </div>
 