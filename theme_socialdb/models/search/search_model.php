<?php

require_once(dirname(__FILE__) . '../../general/general_model.php');
require_once(dirname(__FILE__) . '../../property/property_model.php');

class SearchModel extends Model {

    /**
     * 
     * @param array $data
     * @return array Com a confirmacao dos dados da submissao
     */
    public function add($data) {

        $facets_id = array_filter(array_unique(get_post_meta($data['collection_id'], 'socialdb_collection_facets')));
        if (in_array($data['search_add_facet'], $facets_id)) {
            $result['title'] = __('Warning','tainacan');
            $result['msg'] = __('Facet already registered.','tainacan');
            $result['type'] = 'warning';
            $result['result'] = 'false';
        } else {
            $collection_id = $data['collection_id'];
            add_post_meta($collection_id, 'socialdb_collection_facets', $data['search_add_facet']);
            update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['search_add_facet'] . '_widget', $data['search_data_widget']);
            if ($data['search_data_widget'] == 'tree') {
                update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['search_add_facet'] . '_color', $data['color_facet']);
                $orientation = get_post_meta($collection_id, 'socialdb_collection_facet_widget_tree_orientation', true);
                $orientation = ($orientation == '' ? 'left-column' : $orientation);
            } elseif ($data['search_data_widget'] == 'range') {
                $options_range = array();
                $max_range = $data['counter_range'];
                for ($i = 0; $i <= $max_range; $i++):
                    if ((isset($data['range_' . $i . '_1']) && !empty($data['range_' . $i . '_1'])) && (isset($data['range_' . $i . '_2']) && !empty($data['range_' . $i . '_2']))) {
                        $options_range[] = array('value_1' => $data['range_' . $i . '_1'], 'value_2' => $data['range_' . $i . '_2']);
                    }
                endfor;
                update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['search_add_facet'] . '_range_options', serialize($options_range));
                update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['search_add_facet'] . '_orientation', $data['search_data_orientation']);
                $orientation = $data['search_data_orientation'];
            } else {
                update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['search_add_facet'] . '_orientation', $data['search_data_orientation']);
                $orientation = $data['search_data_orientation'];
            }

            //Pega as facetas cadastradas de acordo com a orientação escolhiada para cadastrar com a ordenação correta.
            $priority = $this->get_the_priorities_facets($facets_id, $orientation, $collection_id);
            update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['search_add_facet'] . '_priority', $priority);

            $result['title'] = __('Success','tainacan');
            $result['msg'] = __('Facet successfully saved.','tainacan');
            $result['type'] = 'success';
            $result['result'] = 'true';
        }
        return $result;
    }

    public function get_the_priorities_facets(array $facets_ids, $orientation, $collection_id) {
        $orientation_tree = get_post_meta($collection_id, 'socialdb_collection_facet_widget_tree_orientation', true);
        $orientation_tree = ($orientation_tree == '' ? 'left-column' : $orientation_tree);
        $priority = array();

        foreach ($facets_ids as $facet_id) {
            $is_tree = get_post_meta($collection_id, 'socialdb_collection_facet_' . $facet_id . '_widget', true);

            if ($is_tree == 'tree' && $orientation_tree == $orientation) {
                $priority[] = get_post_meta($collection_id, 'socialdb_collection_facet_' . $facet_id . '_priority', true);
            } else {
                $same_ordenation = get_post_meta($collection_id, 'socialdb_collection_facet_' . $facet_id . '_orientation', true);

                if ($same_ordenation == $orientation) {
                    $priority[] = get_post_meta($collection_id, 'socialdb_collection_facet_' . $facet_id . '_priority', true);
                }
            }
        }

        if (empty($priority)) {
            $result = 1;
        } else {
            asort($priority);
            $result = ((int) array_pop($priority)) + 1;
        }

        return $result;
    }

    public function update($data) {
        $collection_id = $data['collection_id'];
        if ($data['property_id'] != '') {
            update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['property_id'] . '_widget', $data['search_data_widget']);

            delete_post_meta($collection_id, 'socialdb_collection_facet_' . $data['property_id'] . '_color');
            delete_post_meta($collection_id, 'socialdb_collection_facet_' . $data['property_id'] . '_range_options');
            delete_post_meta($collection_id, 'socialdb_collection_facet_' . $data['property_id'] . '_orientation');

            if ($data['search_data_widget'] == 'tree') {
                update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['property_id'] . '_color', $data['color_facet']);
            } elseif ($data['search_data_widget'] == 'range') {
                $options_range = array();
                $max_range = $data['counter_range'];
                for ($i = 0; $i <= $max_range; $i++):
                    if ((isset($data['range_' . $i . '_1']) && !empty($data['range_' . $i . '_1'])) && (isset($data['range_' . $i . '_2']) && !empty($data['range_' . $i . '_2']))) {
                        $options_range[] = array('value_1' => $data['range_' . $i . '_1'], 'value_2' => $data['range_' . $i . '_2']);
                    }
                endfor;
                update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['property_id'] . '_range_options', serialize($options_range));
                update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['property_id'] . '_orientation', $data['search_data_orientation']);
            } else {
                update_post_meta($collection_id, 'socialdb_collection_facet_' . $data['property_id'] . '_orientation', $data['search_data_orientation']);
            }

            $result['title'] = __('Success','tainacan');
            $result['msg'] = __('Facet successfully updated.','tainacan');
            $result['type'] = 'success';
            $result['result'] = 'true';
        } else {
            $result['title'] = __('Error','tainacan');
            $result['msg'] = __('Something went wrong. Please try again.','tainacan');
            $result['type'] = 'error';
            $result['result'] = 'false';
        }

        return $result;
    }

    public function delete($data) {
        delete_post_meta($data['collection_id'], 'socialdb_collection_facets', $data['facet_id']);

        $result['title'] = __('Success','tainacan');
        $result['msg'] = __('Facet successfully deleted.','tainacan');
        $result['type'] = 'success';

        return $result;
    }

    /**
     * 
     * @param array $data
     * @return array O array com os dados a ser montado na formulario de submissao da faceta
     */
    public function get_widgets($data) {
        $options = array();
        $defaults_array = ['socialdb_object_from','socialdb_object_dc_type','socialdb_object_dc_source','socialdb_license_id'];
        $propertyModel = new PropertyModel;
        $options['select']['0'] = __('Select...','tainacan');
        if ($data['property_id'] == 'tag') {
            $options['select']['tree'] = __('Tree','tainacan');
        } elseif ($propertyModel->get_property_type($data['property_id']) == 'socialdb_property_object') {
            $options['select']['multipleselect'] = __('Multiple Select','tainacan');
            $options['select']['tree'] = __('Tree','tainacan');
        } elseif ($propertyModel->get_property_type($data['property_id']) == 'socialdb_property_data') {
            if ($this->get_widget($data['property_id']) == 'numeric' || $this->get_widget($data['property_id']) == 'date') {
                $options['select']['range'] = __('Range','tainacan');
                $options['select']['from_to'] = __('From/To','tainacan');
            } else {
                $options['select']['searchbox'] = __('Search box with autocomplete','tainacan');
                $options['select']['tree'] = __('Tree','tainacan');
            }
            //} elseif ($propertyModel->get_property_type($data['property_id']) == 'socialdb_property_term') {
        }elseif(in_array($data['property_id'], $defaults_array)){
            //$options['select']['searchbox'] = __('Search box with autocomplete','tainacan');
            $options['select']['tree'] = __('Tree','tainacan');
        } 
        else {
            $options['select']['tree'] = __('Tree','tainacan');
            $options['select']['menu'] = __('Menu','tainacan');
            $options['select']['radio'] = __('Radio Button','tainacan');
            $options['select']['checkbox'] = __('Check Button','tainacan');
            $options['select']['selectbox'] = __('Select Box','tainacan');
            $options['select']['multipleselect'] = __('Multiple Select','tainacan');
        }
        return $options;
    }
 /**
     * 
     * @param array $data
     * @return array O array com os dados a ser montado na formulario de submissao da faceta
     */
    public function get_widget($property_id) {
        $propertyModel = new PropertyModel;
        $data = $this->get_all_property($property_id, true);
        return $data['metas']['socialdb_property_data_widget'];
    }
     /**
     * 
     * @param array $data
     * @return array O array com os dados a ser montado na formulario de submissao da faceta
     */
    public function get_widget_tree_type($property_id) {
        if($property_id=='tag'){
            return 'tag';
        }elseif(get_term_by('id', $property_id, 'socialdb_property_type')){
            return 'property_object';
        }else{
             return 'property_term';
        }
        return '';
    }
    public function save_default_widget_tree($data) {
        if (update_post_meta($data['collection_id'], 'socialdb_collection_facet_widget_tree', $data['tree_type'])) {
            $result['title'] = __('Success','tainacan');
            $result['msg'] = __('Default widget tree changed successfully','tainacan');
            $result['type'] = 'success';
        } else {
            $result['title'] = __('Error!','tainacan');
            $result['msg'] = __('Something went wrong...','tainacan');
            $result['type'] = 'error';
        }
        return $result;
    }

    public function save_default_widget_tree_orientation($data) {
        if (update_post_meta($data['collection_id'], 'socialdb_collection_facet_widget_tree_orientation', $data['orientation_type'])) {
            $result['title'] = __('Success','tainacan');
            $result['msg'] = __('Default widget tree changed successfully','tainacan');
            $result['type'] = 'success';
        } else {
            $result['title'] = __('Error!','tainacan');
            $result['msg'] = __('Something went wrong...','tainacan');
            $result['type'] = 'error';
        }
        return $result;
    }

    public function get_saved_facets($collection_id) {
        $default_tree_orientation = get_post_meta($collection_id, 'socialdb_collection_facet_widget_tree_orientation', true);
        $default_tree_orientation = ($default_tree_orientation != '' ? $default_tree_orientation : 'left-column');
        $facets_id = array_filter(array_unique(get_post_meta($collection_id, 'socialdb_collection_facets')));
        foreach ($facets_id as $facet_id) {
            $facet['id'] = $facet_id;

            $facet['widget'] = get_post_meta($collection_id, 'socialdb_collection_facet_' . $facet_id . '_widget', true);
            //buscando os dados de cada tipo
            if ($facet['id'] == 'tag') {
                $facet['nome'] = 'Tag';
                $facet['widget'] = 'tree';
                $facet['orientation'] = $default_tree_orientation;
            }else if ($facet['id'] == 'socialdb_object_from') {
                $facet['nome'] = __('Format','tainacan');
                $facet['widget'] = 'tree';
                $facet['orientation'] = $default_tree_orientation;
            }else if ($facet['id'] == 'socialdb_object_dc_type') {
                $facet['nome'] = __('Type','tainacan');
                $facet['widget'] = 'tree';
                $facet['orientation'] = $default_tree_orientation;
            }else if ($facet['id'] == 'socialdb_object_dc_source') {
                $facet['nome'] = __('Source','tainacan');
                $facet['widget'] = 'tree';
                $facet['orientation'] = $default_tree_orientation;
            }else if ($facet['id'] == 'socialdb_license_id') {
                $facet['nome'] = __('License','tainacan');
                $facet['widget'] = 'tree';
                $facet['orientation'] = $default_tree_orientation;
            } else {
                $property = get_term_by('id', $facet['id'], 'socialdb_property_type');
                if ($facet['widget'] == 'tree') {
                    $facet['orientation'] = $default_tree_orientation;
                    $facet['nome'] = $property->name;
                    $property = get_term_by('id', $facet['id'], 'socialdb_category_type');
                    if($property){
                         $facet['nome'] = $property->name;
                    }
                } else {
                    $facet['orientation'] = get_post_meta($collection_id, 'socialdb_collection_facet_' . $facet['id'] . '_orientation', true);
                    if ($property) {
                        $facet['nome'] = $property->name;
                    } else {
                        $property = get_term_by('id', $facet['id'], 'socialdb_category_type');
                        $facet['nome'] = $property->name;
                    }
                }
            }

            $facet['priority'] = get_post_meta($collection_id, 'socialdb_collection_facet_' . $facet_id . '_priority', true);


            $arrFacets[] = $facet;
        }

        // sort by priority
        usort($arrFacets, 'compare_priority');
        
        return $arrFacets;
    }

    function get_widget_edit($data) {
        $data['widget'] = get_post_meta($data['collection_id'], 'socialdb_collection_facet_' . $data['property_id'] . '_widget', true);
        if ($data['widget'] == 'tree') {
            $data['class_color'] = get_post_meta($data['collection_id'], 'socialdb_collection_facet_' . $data['property_id'] . '_color', true);
        } elseif ($data['widget'] == 'range') {
            $data['range_options'] = unserialize(get_post_meta($data['collection_id'], 'socialdb_collection_facet_' . $data['property_id'] . '_range_options', true));
            $data['orientation'] = get_post_meta($data['collection_id'], 'socialdb_collection_facet_' . $data['property_id'] . '_orientation', true);
        } else {
            $data['orientation'] = get_post_meta($data['collection_id'], 'socialdb_collection_facet_' . $data['property_id'] . '_orientation', true);
        }
        return $data;
    }

    function update_ordenation($data) {
        $post_id = $data['collection_id'];
        update_post_meta($post_id, 'socialdb_collection_ordenation_form', $data['socialdb_collection_ordenation_form']);
        update_post_meta($post_id, 'socialdb_collection_default_ordering', $data['collection_order']);

        $result['title'] = __('Success','tainacan');
        $result['msg'] = __('Ordenation changed successfully','tainacan');
        $result['type'] = 'success';

        return $result;
    }

    function save_new_priority($data) {
        if(isset($data['arrFacets'])){
            foreach ($data['arrFacets'] as $facet) {
                update_post_meta($data['collection_id'], 'socialdb_collection_facet_' . $facet[0] . '_priority', $facet[1]);
            }
        }
        return true;
    }
    // ordenation save ordination
    /**
     * function remove_property_ordenation($property_id)
     */
    public function remove_property_ordenation($data) {
        $is_repository_properties = false;
        if($data['property_id']&& is_array($data['property_id'])){
            foreach ($data['property_id'] as $property_id) {
                $created_category = get_term_meta($property_id, 'socialdb_property_created_category', true);
                if($created_category!=$this->get_category_root($data['collection_id'])){
                     $is_repository_properties = true;
                }else{
                     update_term_meta($property_id, 'socialdb_property_data_column_ordenation','false');
                }
             }
        }
        
        if(!$is_repository_properties){
            $data['title'] = __('Success','tainacan');
            $data['msg'] = __('The property was removed as property ordination','tainacan');
            $data['type'] = 'success';
        }
        else{
            $data['title'] = __('Attention','tainacan');
            $data['msg'] = __('You can not remove ordination owned by another collecion','tainacan');
            $data['type'] = 'info';
        }
        
        return json_encode($data);
    }
    
    public function add_property_ordenation($data) {
         if($data['property_id']&&  is_array($data['property_id'])){
            foreach ($data['property_id'] as $property_id) {
                update_term_meta($property_id, 'socialdb_property_data_column_ordenation','true');
            }
        }$data['title'] = __('Success','tainacan');
        $data['msg'] = __('The property was added as property ordination','tainacan');
        $data['type'] = 'success';
        return json_encode($data);
    }

}
