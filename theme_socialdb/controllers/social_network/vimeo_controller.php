<?php
require_once(dirname(__FILE__).'../../../models/social_network/vimeo_model.php');
require_once(dirname(__FILE__).'../../../models/object/object_model.php');
require_once(dirname(__FILE__).'../../general/general_controller.php');  

class VimeoController extends Controller
{
	public function operation($operation, $data){
		//$vimeo_model = new VimeoModel();
		//$vimeo_ch = new ChannelModel();
                //var_dump($operation, $data);
                //exit();
		
		switch ($operation) {
			case "insertIdentifierVimeo":
                            return VimeoModel::insert_vimeo_identifier($data['identifier'], $data['collectionId'] );
                            break;
                        
		
                        case "listIdentifiersVimeo":
                                return VimeoModel::list_vimeo_identifier($data['collectionId'] );
                                break;

                        case "editIdentifierVimeo":
                                return VimeoModel::edit_vimeo_identifier($data['identifier'], $data['new_identifier'] );
                                break;

                        case "deleteIdentifierVimeo":
                                return VimeoModel::delete_vimeo_identifier($data['identifier'], $data['collection_id'] );
                                break;
			
		}
	}
	
}

if($_POST['operation']){
	$operation = $_POST['operation'];
	$data = $_POST;
}else {
	$operation = $_GET['operation'];
	$data = $_GET;
}

$vimeo_controller = new VimeoController();
echo $vimeo_controller->operation($operation, $data);
	

?>