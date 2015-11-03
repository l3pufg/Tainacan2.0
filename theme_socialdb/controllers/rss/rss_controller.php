
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
require_once(dirname(__FILE__) . '../../../models/rss/rss_model.php');
require_once(dirname(__FILE__) . '../../general/general_controller.php');

class RssController extends Controller {

    public function operation($operation, $data) {
        $rss_model = new RssModel();
        switch ($operation) {
            case "feed":
                header("Content-Type: application/xml; charset=ISO-8859-1");
                echo $rss_model->feed($data['collection_id']);
                break;
            
        }
    }

}

/*
 * Controller execution
 */

if (isset($_POST['operation'])) {
    $operation = $_POST['operation'];
    $data = $_POST;
} else {
    $operation = $_GET['operation'];
    $data = $_GET;
}

$rss_controller = new RssController();
echo $rss_controller->operation($operation, $data);
?>