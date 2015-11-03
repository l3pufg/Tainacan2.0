<?php include_once ('js/menu_left_js.php');
$not_showed = false; ?>


<!-- TAINACAN: widgets do menu esquerdo -->                           
<?php foreach ($facets as $facet): ?>
    <?php if ($facet['widget'] == 'tree' && !$not_showed): $not_showed = true ?> 
        <div>
            <div class="btn-group">
                <!-- TAINACAN: panel para adicao de categorias e tags -->
                <h5 class="title-pipe"><?php _e('Categories and Tags','tainacan'); ?>
                    <!--a href="#" class="pull-right dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">+</a-->
                    <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="btnGroupVerticalDrop1">
                        <!-- TAINACAN: abre modal para adicao de categorias  -->
                        <li><a onclick="showModalFilters('add_category');" href="#submit_filters_add_category"><span class="glyphicon glyphicon-tree-deciduous"></span>&nbsp;<?php _e('Add Category','tainacan'); ?></a></li>
                        <!-- TAINACAN: abre modal para adicao de tags  -->
                        <li><a onclick="showModalFilters('add_tag');" href="#submit_filters_add_tag"><span class="glyphicon glyphicon-tag"></span>&nbsp;<?php _e('Add Tag','tainacan'); ?></a></li>
                    </ul>
                </h5>
            </div>
            <!--div class="panel panel-default clear">
                <div class="panel-heading" style="border-bottom: 0px;display:block;">
                    <span class="glyphicon glyphicon-tags color_icon"></span>&nbsp;&nbsp;<?php _e('Filters','tainacan'); ?>&nbsp;&nbsp;
                    <div class="btn-group">
                        <button style="font-size:11px;" id="btnGroupVerticalDrop1" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-plus color_icon"></span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupVerticalDrop1">
                            <!-- TAINACAN: abre modal para adicao de categorias  -->
                            <!--li><a onclick="showModalFilters('add_category');" href="#submit_filters_add_category"><span class="glyphicon glyphicon-tree-deciduous"></span>&nbsp;<?php _e('Add Facet'); ?></a></li>
                            <!-- TAINACAN: abre modal para adicao de tags  -->
                            <!--li><a onclick="showModalFilters('add_tag');" href="#submit_filters_add_tag"><span class="glyphicon glyphicon-tag"></span>&nbsp;<?php _e('Add Tag'); ?></a></li>
                        </ul>
                    </div>
                    <!--div class="btn-group" style="margin-left:5px;">
                        <a href="#" id="btnCollapseAll"><span class="glyphicon glyphicon-collapse-up filtros"> </a> <a href="#" id="btnExpandAll"><span class="glyphicon glyphicon-collapse-down filtros"> </a>
                    </div-->
                    <!--div class="dropdown" style="float:right;">
                        <button style="font-size:11px;" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle">
                            <!--Alterar Navega&ccedil;&atilde;o--> 
        <!--?php _e('Nav'); ?><span class="caret"></span>
                        </button>
                        <!-- TAINACAN: tipos de navegacao avancada  -->
                        <!--ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li><a href="<?php echo get_the_permalink() . "?nav=regular"; ?>"><span class="glyphicon glyphicon-th-list"></span>&nbsp;<?php _e('Regular'); ?></a></li>
                            <li><a href="<?php echo get_the_permalink() . "?nav=hypertree"; ?>"><span class="glyphicon glyphicon-tree-conifer"></span>&nbsp;<?php _e('Hypertree'); ?></a></li>
                            <li><a href="<?php echo get_the_permalink() . "?nav=spacetree"; ?>"><span class="glyphicon glyphicon-tree-conifer"></span>&nbsp;<?php _e('Spacetree'); ?></a></li>
                            <li><a href="<?php echo get_the_permalink() . "?nav=treemap"; ?>"><span class="glyphicon glyphicon-tree-conifer"></span>&nbsp;<?php _e('Treemap'); ?></a></li>
                            <li><a href="<?php echo get_the_permalink() . "?nav=rgraph"; ?>"><span class="glyphicon glyphicon-tree-conifer"></span>&nbsp;<?php _e('RGraph'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div-->
        </div>
        <!-- TAINACAN: os filtros do dynatree eram mostrados neste local -- desativado -->
        <div id="dynatree_filters">
        </div>
        <!-- TAINACAN: arvore montado nesta div pela biblioteca dynatree, html e css neste local totamente gerado pela biblioteca -->
        <div id="dynatree">
        </div>
        <br>
    <?php elseif ($facet['widget'] == 'range'): ?> 
        <!-- TAINACAN: widget para realizacao de busca nos items  -->
        <div class="form-group">
            <label for="object_tags"><?php echo $facet['name']; ?></label><br>
            <?php foreach ($facet['options'] as $range): ?>
                <a href="#" onclick="wpquery_range('<?php echo $facet['id'] ?>', '<?php echo $facet['type'] ?>', '<?php echo $range['value_1'] ?>', '<?php echo $range['value_2'] ?>')"><?php echo $range['value_1'] . ' ' . __('until','tainacan') . ' ' . $range['value_2']; ?></a><br>
        <?php endforeach; ?>
        </div>
    <?php elseif ($facet['widget'] == 'from_to'): ?> 
        <!-- TAINACAN: widget para realizacao de busca nos items  -->
        <div class="form-group">
            <label for="object_tags"><?php echo $facet['name']; ?></label><br>
            <?php if ($facet['type'] == 'date') { ?>
                <input size="9" type="text" class="input_date" value="" id="facet_<?php echo $facet['id']; ?>_1" name="facet_<?php echo $facet['id']; ?>_1"> <?php _e('until','tainacan') ?> <input type="text" class="input_date" size="9" value="" id="facet_<?php echo $facet['id']; ?>_2" name="facet_<?php echo $facet['id']; ?>_2">&nbsp;<button onclick="wpquery_fromto('<?php echo $facet['id']; ?>', 'date');" ><span class="glyphicon glyphicon-arrow-right"></span></button>
            <?php } elseif ($facet['type'] == 'numeric') { ?>
                <input size="9" type="numeric" value="" id="facet_<?php echo $facet['id']; ?>_1" name="facet_<?php echo $facet['id']; ?>_1"> <?php _e('until','tainacan') ?> <input type="numeric" size="9" value="" id="facet_<?php echo $facet['id']; ?>_2" name="facet_<?php echo $facet['id']; ?>_2">&nbsp;<button onclick="wpquery_fromto('<?php echo $facet['id']; ?>', 'numeric');" ><span class="glyphicon glyphicon-arrow-right"></span></button>
            <?php } else { ?>
                <input size="9" type="text" value="" id="facet_<?php echo $facet['id']; ?>_1" name="facet_<?php echo $facet['id']; ?>_1"> <?php _e('until','tainacan') ?> <input size="9" type="text" value="" id="facet_<?php echo $facet['id']; ?>_2" name="facet_<?php echo $facet['id']; ?>_2"><button onclick="wpquery_fromto('<?php echo $facet['id']; ?>', 'text');" ><span class="glyphicon glyphicon-arrow-right"></span></button>
        <?php } ?>
        </div> 
    <?php elseif ($facet['widget'] == 'multipleselect' || $facet['widget'] == 'searchbox'): ?> 
        <!-- TAINACAN: widget para realizacao de busca nos items  -->
        <div class="form-group">
            <label for="object_tags"><?php echo $facet['name']; ?></label>
            <input 
                   type="text" 
                   onkeyup="autocomplete_menu_left('<?php echo $facet['id']; ?>');" id="autocomplete_multipleselect_<?php echo $facet['id']; ?>" placeholder="<?php _e('Type the three first letters of the object of this collection ','tainacan'); ?>"  class="chosen-selected form-control"  />  
            <select style="display: none;"  id="multipleselect_value_<?php echo $facet['id']; ?>" multiple class="chosen-selected2 form-control" style="height: auto;" name="multipleselect_value_<?php echo $facet['id']; ?>[]"  >   
            </select>
        </div>   
    <?php elseif ($facet['widget'] == 'radio'): ?> 
        <!-- TAINACAN: widget para realizacao de busca nos items  -->
        <div class="form-group">
            <label for="object_tags"><?php echo $facet['name']; ?></label><br>
            <?php foreach ($facet['categories'] as $category): ?>
                <!--input type="radio" onchange="wpquery_radio(this, '<?php echo $facet['id']; ?>');"  value="<?php echo $facet['id'] . get_option('socialdb_divider') . $category->term_id; ?>" name="facet_<?php echo $facet['id']; ?>">&nbsp; <?php echo $category->name; ?><br-->
                <input type="radio" onchange="wpquery_radio(this, '<?php echo $facet['id']; ?>');"  value="<?php echo $category->term_id; ?>" name="facet_<?php echo $facet['id']; ?>">&nbsp; <?php echo $category->name; ?><br>
        <?php endforeach; ?>
        </div>


    <?php elseif ($facet['widget'] == 'checkbox'): ?> 
        <!-- TAINACAN: widget para realizacao de busca nos items  -->
        <div class="form-group">
            <label for="object_tags"><?php echo $facet['name']; ?></label><br>
            <?php foreach ($facet['categories'] as $category): ?>
                <input type="checkbox" id="checkbox_<?php echo $facet['id']; ?>_<?php echo $category->term_id; ?>" value="<?php echo $category->term_id; ?>" onchange="wpquery_checkbox(this, '<?php echo $facet['id']; ?>');" name="facet_<?php echo $facet['id']; ?>[]">&nbsp; <?php echo $category->name; ?><br>
        <?php endforeach; ?>
        </div> 
    <?php elseif ($facet['widget'] == 'selectbox'): ?> 
        <!-- TAINACAN: widget para realizacao de busca nos items  -->
        <div class="form-group">
            <label for="object_tags"><?php echo $facet['name']; ?></label>
            <select class="form-control" onchange="wpquery_select(this, '<?php echo $facet['id']; ?>');" id="facet_<?php echo $facet['id']; ?>" name="facet_<?php echo $facet['id']; ?>">
                <option value="">  <?php echo __('Select...','tainacan'); ?></option>
                <?php foreach ($facet['categories'] as $category): ?>
                    <option value="<?php echo $category->term_id; ?>" >  <?php echo $category->name; ?></option>
        <?php endforeach; ?>
            </select>    
        </div>
    <?php elseif ($facet['widget'] == 'menu'): ?> 
        <!-- TAINACAN: widget para realizacao de busca nos items  -->
        <div class="btn-group">
            <button disabled="disabled" type="button" class="btn btn-default"><?php echo $facet['name']; ?></button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
        <?php echo $facet['html']; ?>
            </ul>
        </div><br><br>

    <?php endif; ?>         
<?php endforeach;
?>		