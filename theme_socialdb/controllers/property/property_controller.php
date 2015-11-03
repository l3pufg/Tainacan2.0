<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

require_once(dirname(__FILE__).'../../../models/property/property_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_property_data/event_property_data_create_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_property_data/event_property_data_edit_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_property_data/event_property_data_delete_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_property_object/event_property_object_create_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_property_object/event_property_object_edit_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_property_object/event_property_object_delete_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_property_term/event_property_term_create_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_property_term/event_property_term_edit_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_property_term/event_property_term_delete_model.php');
require_once(dirname(__FILE__).'../../general/general_controller.php');  

 class PropertyController extends Controller{
	 public function operation($operation,$data){
		$property_model = new PropertyModel();
		switch ($operation) {
                    case "add_property_data":
                       //return $property_model->add_property_data($data);
                       return $this->insert_event_property_data_add($data);
                        break;
                    case "add_property_object":
                        //return $property_model->add_property_object($data);
                        return $this->insert_event_property_object_add($data);
                        break;
                    case "add_property_term":
                        //return $property_model->add_property_term($data);
                        return $this->insert_event_property_term_add($data);
                        break;
                    case "edit_property_data":
                        return $property_model->edit_property($data);
                        break;   
                    case "edit_property_object":
                        return $property_model->edit_property($data);
                        break;   
                    case 'edit_property_term':
                         return $property_model->edit_property($data);
                        break;
                    case "update_property_data":
                        //return $property_model->update_property_data($data);
                        return $this->insert_event_property_data_update($data);
                        break;  
                    case "update_property_object":
                        //return $property_model->update_property_object($data);
                        return $this->insert_event_property_object_update($data);
                        break; 
                     case "update_property_term":
                        //return $property_model->update_property_term($data);
                        return $this->insert_event_property_term_update($data);
                        break;
                    case "delete":
                       // return $property_model->delete($data);
                        return $this->insert_event_property_delete($data);
                        break;
                    case "list":
                        $data = $property_model->list_data($data);
                        return $this->render(dirname(__FILE__).'../../../views/property/list.php', $data);
                        break;
                      case "list_property_terms":
                        return $property_model->list_property_terms($data);
                    case "list_property_data":
                        return $property_model->list_property_data($data);
                        break;
                    case "list_property_object":
                        return $property_model->list_property_object($data);
                        break;
                    case 'show_reverses':// utiliza a mesma funcao porem muda a categoria para procuar suas propriedades
                        return $property_model->list_property_object($data,true);
                    // properties repository
                    case "list_repository":
                        $data['category_id'] = get_term_by('slug', 'socialdb_category', 'socialdb_category_type')->term_id;
                        $data['is_configuration_repository'] = true;
                        $data = $property_model->list_data($data);
                        return $this->render(dirname(__FILE__).'../../../views/theme_options/property/list.php', $data);
                        break;
                    // properties terms actions
                    case 'get_children_property_terms':
                        return json_encode($property_model->get_children_property_terms($data));
                        break;
		}
	}
        /**
     * @signature - function insert_event_add($object_id, $data )
     * @param int $object_id O id do Objeto
     * @param array $data Os dados vindos do formulario
     * @return array os dados para o evento
     * @description - 
     * @author: Eduardo 
     */
    public function insert_event_property_data_add($data) {
        $eventAddProperty = new EventPropertyDataCreate();
        $data['socialdb_property_default_value'] = $data['socialdb_property_default_value'];
        $data['socialdb_event_property_data_create_name'] = $data['property_data_name'];
        $data['socialdb_event_property_data_create_widget'] = $data['property_data_widget'];
        $data['socialdb_event_property_data_create_ordenation_column'] = $data['property_data_column_ordenation'];
        $data['socialdb_event_property_data_create_required'] = $data['property_data_required'];
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventAddProperty->create_event($data);
    }
     /**
     * @signature - function insert_event_update($object_id, $data )
     * @param int $object_id O id do Objeto
     * @param array $data Os dados vindos do formulario
     * @return array os dados para o evento
     * @description - 
     * @author: Eduardo 
     */
    public function insert_event_property_data_update($data) {
        $eventAddProperty = new EventPropertyDataEdit();
        $data['socialdb_event_property_data_edit_id'] = $data['property_data_id'];
        $data['socialdb_property_default_value'] = $data['socialdb_property_default_value'];
        $data['socialdb_event_property_data_edit_name'] = $data['property_data_name'];
        $data['socialdb_event_property_data_edit_widget'] = $data['property_data_widget'];
        $data['socialdb_event_property_data_edit_ordenation_column'] = $data['property_data_column_ordenation'];
        $data['socialdb_event_property_data_edit_required'] = $data['property_data_required'];
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventAddProperty->create_event($data);
    }
    /**
     * @signature - function insert_event_add($object_id, $data )
     * @param int $object_id O id do Objeto
     * @param array $data Os dados vindos do formulario
     * @return array os dados para o evento
     * @description - 
     * @author: Eduardo 
     */
    public function insert_event_property_object_add($data) {
        $eventAddProperty = new EventPropertyObjectCreate();
        $data['socialdb_event_property_object_create_name'] = $data['property_object_name'];
        $data['socialdb_event_property_object_create_category_id'] = $data['property_object_category_id'];
        $data['socialdb_event_property_object_create_required'] = $data['property_object_required'];
        $data['socialdb_event_property_object_create_is_reverse'] = $data['property_object_is_reverse'];
        if($data['property_object_is_reverse']=='true'){
           $data['socialdb_event_property_object_create_reverse'] = $data['property_object_reverse'];   
        }
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventAddProperty->create_event($data);
    }
    /**
     * @signature - function insert_event_add($object_id, $data )
     * @param int $object_id O id do Objeto
     * @param array $data Os dados vindos do formulario
     * @return array os dados para o evento
     * @description - 
     * @author: Eduardo 
     */
    public function insert_event_property_object_update($data) {
        $eventAddProperty = new EventPropertyObjectEdit();
        $data['socialdb_event_property_object_edit_id'] = $data['property_object_id'];
        $data['socialdb_event_property_object_edit_name'] = $data['property_object_name'];
        $data['socialdb_event_property_object_category_id'] = $data['property_object_category_id'];
        $data['socialdb_event_property_object_edit_required'] = $data['property_object_required'];
        $data['socialdb_event_property_object_edit_is_reverse'] = $data['property_object_is_reverse'];
        if($data['property_object_is_reverse']=='true'){
           $data['socialdb_event_property_object_edit_reverse'] = $data['property_object_reverse'];   
        }
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventAddProperty->create_event($data);
    }
     /**
     * @signature - function insert_event_add($object_id, $data )
     * @param int $object_id O id do Objeto
     * @param array $data Os dados vindos do formulario
     * @return array os dados para o evento
     * @description - 
     * @author: Eduardo 
     */
    public function insert_event_property_term_add($data) {
        $eventAddProperty = new EventPropertyTermCreate();
        $data['socialdb_event_property_term_create_name'] = $data['property_term_name'];
        $data['socialdb_event_property_term_create_cardinality'] = $data['socialdb_property_term_cardinality'];
        $data['socialdb_event_property_term_create_root'] = $data['socialdb_property_term_root'];
        $data['socialdb_event_property_term_create_widget'] = $data['socialdb_property_term_widget'];
        $data['socialdb_event_property_term_create_required'] = $data['property_term_required'];
        $data['socialdb_event_property_term_create_help'] = $data['socialdb_property_help'];
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventAddProperty->create_event($data);
    }
     /**
     * @signature - function insert_event_update($object_id, $data )
     * @param int $object_id O id do Objeto
     * @param array $data Os dados vindos do formulario
     * @return array os dados para o evento
     * @description - 
     * @author: Eduardo 
     */
    public function insert_event_property_term_update($data) {
        $eventAddProperty = new EventPropertyTermEdit();
        $data['socialdb_event_property_term_edit_id'] = $data['property_term_id'];
        $data['socialdb_event_property_term_edit_name'] = $data['property_term_name'];
        $data['socialdb_event_property_term_edit_cardinality'] = $data['socialdb_property_term_cardinality'];
        $data['socialdb_event_property_term_edit_root'] = $data['socialdb_property_term_root'];
        $data['socialdb_event_property_term_edit_widget'] = $data['socialdb_property_term_widget'];
        $data['socialdb_event_property_term_edit_required'] = $data['property_term_required'];
        $data['socialdb_event_property_term_edit_help'] = $data['socialdb_property_help'];
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventAddProperty->create_event($data);
    }
    
    /**
     * @signature - function insert_event_update($object_id, $data )
     * @param int $object_id O id do Objeto
     * @param array $data Os dados vindos do formulario
     * @return array os dados para o evento
     * @description - 
     * @author: Eduardo 
     */
    public function insert_event_property_delete($data) {
        $eventAddProperty = new EventPropertyTermDelete();
        $data['socialdb_event_property_term_delete_id'] = $data['property_delete_id'];
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventAddProperty->create_event($data);
    }
 }
 /*
 * Controller execution
 */
 if($_POST['operation']){
      $operation = $_POST['operation'];
      $data = $_POST;
 }else{
     $operation = $_GET['operation'];
     $data = $_GET;
 }

 $property_controller = new PropertyController();
 echo $property_controller->operation($operation,$data);





?>