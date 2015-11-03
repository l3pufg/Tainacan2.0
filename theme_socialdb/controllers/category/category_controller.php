
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
require_once(dirname(__FILE__).'../../../models/category/category_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_term/event_term_create_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_term/event_term_edit_model.php');
require_once(dirname(__FILE__).'../../../models/event/event_term/event_term_delete_model.php');
require_once(dirname(__FILE__).'../../general/general_controller.php');  

 class CategoryController extends Controller{
	 public function operation($operation,$data){
		$category_model = new CategoryModel();
		switch ($operation) {
                    case "add":
                        //return json_encode($category_model->add($data));
                        return $this->insert_event_add($data);
                        break;
                    case "update":
                        //return json_encode($category_model->update($data));
                        return $this->insert_event_update($data);
                        break;    
                    case "delete":
                        //return $category_model->delete($data);
                        return $this->insert_event_delete($data);
                        break;    
                    case 'vinculate_facets':
                        return $category_model->vinculate_facets($data);
                        break;
                    case "get_parent":
                        return json_encode($category_model->get_category_array($category_model->get_parent($data)));
                        break;
                    case "initDynatree":
                        return $category_model->initCategoriesDynatree($data);
                        break;  
                    case 'initDynatreeTerms':
                         return $category_model->initCategoriesDynatreeTerms($data);
                        break;
                    case 'findDynatreeChild':
                        return $category_model->find_dynatree_children($data);
                        break;
                    case "initPropertyDynatree":
                        return $category_model->initPropertyCategoriesDynatree($data);
                        break;
                    case "get_metas":
                        return json_encode($category_model->get_metas($data));
                        break;
                    case "list":
                        return $this->render(dirname(__FILE__).'../../../views/category/list.php', $data);
                        break;  
                    case "insert_hierarchy":
                        return json_encode($category_model->insert_hierarchy($data));
                        break;
                     case "export_hierarchy":
                        $category_model->export_hierarchy($data);
                        break;
                    case 'verify_has_children':
                        return json_encode($category_model->verify_has_children($data));
                        break;
                    case 'get_category_root_name':
                        return json_encode(['key'=> $data['category_id'],'title'=> get_term_by('id', $data['category_id'], 'socialdb_category_type')->name]);
                    case 'initDynatreeDynamic':
                         return $category_model->initCategoriesDynatreeDynamic($data);
                        break;   
                    case 'verify_name_in_taxonomy':
                        return $category_model->verify_name_in_taxonomy($data);
                        
                        
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
    public function insert_event_add($data) {
        $eventAddTerm = new EventTermCreate();
        $data['socialdb_event_term_suggested_name'] = $data['category_name'];
        $data['socialdb_event_term_parent'] = $data['category_parent_id'];
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventAddTerm->create_event($data);
    }
    /**
     * @signature - function insert_event_update( $data )
     * @param array $data Os dados vindos do formulario
     * @return array os dados para o evento
     * @description - 
     * @author: Eduardo 
     */
    
     public function insert_event_update($data) {
         $eventEditTerm = new EventTermEdit();
        $data['socialdb_event_term_id'] = $data['category_id'];
        $data['socialdb_event_term_suggested_name'] = $data['category_name'];
        $data['socialdb_event_term_suggested_parent'] = $data['category_parent_id'];
        $data['socialdb_event_term_previous_parent'] = 'Not informed';
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventEditTerm->create_event($data);
    }
    /**
     * @signature - function insert_event_update( $data )
     * @param array $data Os dados vindos do formulario
     * @return array os dados para o evento
     * @description - 
     * @author: Eduardo 
     */
    
     public function insert_event_delete($data) {
        $eventDeleteTerm = new EventTermDelete();
        $data['socialdb_event_term_id'] = $data['category_delete_id'];
        $data['socialdb_event_collection_id'] = $data['collection_id'];
        $data['socialdb_event_user_id'] = get_current_user_id();
        $data['socialdb_event_create_date'] = mktime();
        return $eventDeleteTerm->create_event($data);
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

$category_controller = new CategoryController();
echo $category_controller->operation($operation,$data);


?>