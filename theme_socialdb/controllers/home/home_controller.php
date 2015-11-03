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
require_once(dirname(__FILE__) . '../../../models/home/home_model.php');
require_once(dirname(__FILE__) . '../../general/general_controller.php');

class HomeController extends Controller {  
    public function operation($operation, $data) {
        $home_model = new HomeModel();       
        switch ($operation) {
            case "display_view_main_page":
                $data = $home_model->display_view_main_page($data);
                return $this->render(dirname(__FILE__).'../../../views/home/popular_and_recents.php', $data);
                break;
             case "display_populars":
                $data = $home_model->display_view_main_page($data);
                return $this->render(dirname(__FILE__).'../../../views/home/populars_container.php', $data);
                break;
            case "display_recents":
                $data = $home_model->display_view_main_page($data);
                return $this->render(dirname(__FILE__).'../../../views/home/recents_container.php', $data);
                break;
            case 'total_collections':
                global $wpdb;
                $return = [];
                $wp_posts = $wpdb->prefix . "posts";
                $query = "
                                SELECT p.* FROM $wp_posts p
                                WHERE p.post_type like 'socialdb_collection' and p.post_status LIKE 'publish' and p.ID NOT IN (".get_option('collection_root_id').")
                        ";                 
                $results = $wpdb->get_results($query);
                if ($results&&is_array($results)&&count($results)>0) {
                    $return['size'] = count($results);
                }
                return json_encode($return);
                
        }
    }

}

/*
 * Controller execution
 */

if ($_POST['operation']) {
    $operation = $_POST['operation'];
    $data = $_POST;
} else {
    $operation = $_GET['operation'];
    $data = $_GET;
}

$collection_controller = new HomeController();
echo $collection_controller->operation($operation, $data);
?>