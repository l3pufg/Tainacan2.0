<?php
include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
include_once ('js/filters_dynatree_js.php');


//keyword
if (isset($keyword) && $keyword != '') {
    ?>
    <?php echo $keyword; ?> 
     <a onclick="remove_search_word()" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
<?php 
} 
//categories
if (isset($categories)) {
    foreach ($categories as $category) {
        echo $category['name']; ?>
        <a class="remove-link-filters" onclick="remove_filter_category('<?php echo $category['facet']; ?>','<?php echo $category['id']; ?>')" 
         href="#"><span class="glyphicon glyphicon-remove"></span>
        </a>
         
    <?php
    }
}
//tags
if (isset($tags)) {
    foreach ($tags as $tag) {
        echo $tag['name']; ?>
         <a class="remove-link-filters" onclick="remove_filter_tag('<?php echo $tag['id']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}
//properties_multipleselect
if (isset($properties_multipleselect)) {
    foreach ($properties_multipleselect as $property) {
        echo $property['name']; ?>
         <a onclick="remove_filter_property_multipleselect('<?php echo $property['property_id']; ?>','<?php echo $property['value']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}
//properties_object_tree
if (isset($properties_object_tree)) {
    foreach ($properties_object_tree as $property) {
        echo $property['name']; ?>
         <a class="remove-link-filters" onclick="remove_filter_property_object_tree('<?php echo $property['property_id']; ?>','<?php echo $property['id']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}
//properties_data_tree
if (isset($properties_data_tree)) {
    foreach ($properties_data_tree as $property) {
        echo $property['name']; ?>
         <a class="remove-link-filters" onclick="remove_filter_property_data_tree('<?php echo $property['property_id']; ?>','<?php echo $property['id']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}
//licencas
if (isset($license_tree)) {
    foreach ($license_tree as $property) {
        echo $property['name']; ?>
         <a class="remove-link-filters" onclick="remove_licenses_tree('<?php echo $property['id']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}
//Tipos de items
if (isset($type_tree)) {
    foreach ($type_tree as $property) {
        echo $property['name']; ?>
         <a class="remove-link-filters" onclick="remove_type_tree('<?php echo $property['id']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}
//Formatos de items
if (isset($format_tree)) {
    foreach ($format_tree as $property) {
        echo $property['name']; ?>
         <a class="remove-link-filters" onclick="remove_format_tree('<?php echo $property['id']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}
//Fontes de items
if (isset($source_tree)) {
    foreach ($source_tree as $property) {
        echo $property['name']; ?>
         <a class="remove-link-filters" onclick="remove_source_tree('<?php echo $property['id']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}

//properties_multipleselect
if (isset($properties_data_range_numeric)) {
    foreach ($properties_data_range_numeric as $property) {
        echo $property['name']; ?>
         <a onclick="remove_filter_property_data_range_numeric('<?php echo $property['property_id']; ?>','<?php echo $property['value']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}

if (isset($properties_data_fromto_numeric)) {
    foreach ($properties_data_fromto_numeric as $property) {
        echo $property['name']; ?>
         <a onclick="remove_filter_property_data_fromto_number('<?php echo $property['property_id']; ?>','<?php echo $property['value']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}

//properties_multipleselect
if (isset($properties_data_range_date)) {
    foreach ($properties_data_range_date as $property) {
        echo $property['name']; ?>
         <a onclick="remove_filter_property_data_range_date('<?php echo $property['property_id']; ?>','<?php echo $property['value']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}
    
if (isset($properties_data_fromto_date)) {
    foreach ($properties_data_fromto_date as $property) {
        echo $property['name']; ?>
         <a onclick="remove_filter_property_data_fromto_date('<?php echo $property['property_id']; ?>','<?php echo $property['value']; ?>')" 
        href="#"><span class="glyphicon glyphicon-remove"></span>
     </a>
    <?php
    }
}