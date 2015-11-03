<?php

include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
//require_once 'facebook/autoload.php';

/**
 * @clas-name	FacebookModel 
 * @description	integrar uma conta do facebook a uma coleção do socialDB
 * @author     	Saymon de Oliveira Souza (alxsay@hotmail.com)
 * @version    	1.0
 */
class FacebookModel {

    public $images_ids;

    public function getPhotos($accessToken, $collection_id) {
        $object_model = new ObjectModel();
        $config = get_option('socialdb_theme_options');
        $app['app_id'] = $config['socialdb_fb_api_id'];
        $app['app_secret'] = $config['socialdb_fb_api_secret'];

        $fbApp = new Facebook\FacebookApp($app['app_id'], $app['app_secret']);
        $request = new Facebook\FacebookRequest(
                $fbApp, $accessToken, 'GET', '/me/photos', array(
            'fields' => 'album,backdated_time,backdated_time_granularity,can_delete,can_tag,created_time,event,from,height,icon,id,images,link,name,name_tags,page_story_id,picture,place,updated_time,tags,likes,width,comments',
            'limit' => '300',
            'type' => 'uploaded'
                )
        );

        $request_me = new Facebook\FacebookRequest(
                $fbApp, $accessToken, 'GET', '/me'
        );

        $urlBase_me = 'https://graph.facebook.com' . $request_me->getUrl();
        $urlBase = 'https://graph.facebook.com' . $request->getUrl();

        $resposta_me = file_get_contents($urlBase_me);
        $resposta = file_get_contents($urlBase);
        $json_me = &json_decode($resposta_me, true);
        $json = &json_decode($resposta, true);

        $user_id = $json_me['id'];

        //Verifica se esse ID já foi importado alguma vez
        $list_ids = self::list_facebook_identifier($collection_id);

        if ($list_ids && !empty($list_ids)) {
            $id_exists = 0;
            foreach ($list_ids['identifier'] as $list_id) {
                if ($list_id['name'] == $user_id) {
                    $id_exists = 1;
                    $imported_photos = $list_id['UpdateIds'];
                    $fb_post_id = $list_id['id'];
                    break;
                }
            }

            if ($id_exists != 1) {
                $fb_post_id = self::insert_facebook_identifier($user_id, $collection_id);
            }
        } else {
            $fb_post_id = self::insert_facebook_identifier($user_id, $collection_id);
        }

        if (empty($imported_photos[0]) && !isset($imported_photos[0])) {
            $imported_photos[0] = array();
        }

//        echo "<hr>";
//        echo "<pre>";
//        var_dump($imported_photos);
//        echo "<hr>";
//        var_dump($json);
//        echo "</pre>";
//        echo "<hr>";
//        exit();

        $this->images_ids = [];
        if (!empty($json['data'])) {
            self::setImportStatus($fb_post_id, 1);
            foreach ($json['data'] as $photo) {
                if ($photo['from']['id'] == $user_id) {
                    if (!in_array($photo['id'], $imported_photos[0])) {
                        $img_tag = '<img src="' . $photo['images'][0]['source'] . '" style="max-width:200px; max-height:200px;" /><br>';
                        $post_id = $object_model->add_photo($collection_id, $photo['name'], $img_tag . $photo['id']);
                        if ($post_id) {
                            $this->images_ids[] = $photo['id'];
                            $object_model->add_thumbnail_url($photo['images'][0]['source'], $post_id);
                            add_post_meta($post_id, 'socialdb_uri_imported', $photo['images'][0]['source']);
                        }
                    } else {
                        $this->images_ids[] = $photo['id'];
                    }
                }
            }
        }

        if (isset($json['paging']['next']) && !empty($json['paging']['next'])) {
            $this->interaction_getPhotos($json['paging']['next'], $user_id, $collection_id, $imported_photos, $fb_post_id);
        } else {
            self::setUpdateIdsFacebook($fb_post_id, $this->images_ids);
        }
        wp_redirect(get_the_permalink($collection_id));
    }

    public function interaction_getPhotos($url, $user_id, $collection_id, $imported_photos, $fb_post_id) {
        $object_model = new ObjectModel();
        $resposta = file_get_contents($url);
        $json = &json_decode($resposta, true);

        if (!empty($json['data'])) {
            foreach ($json['data'] as $photo) {
                if ($photo['from']['id'] == $user_id) {
                    if (!in_array($photo['id'], $imported_photos[0])) {
                        $img_tag = '<img src="' . $photo['images'][0]['source'] . '" style="max-width:200px; max-height:200px;" /><br>';
                        //$post_id = $object_model->add_photo($collection_id, $photo['name'], $img_tag . $photo['id']);
                        $post_id = $object_model->add_photo($collection_id, $photo['name'], $photo['images'][0]['source']);
                        if ($post_id) {
                            $this->images_ids[] = $photo['id'];
                            $object_model->add_thumbnail_url($photo['images'][0]['source'], $post_id);
                            add_post_meta($post_id, 'socialdb_uri_imported', $photo['images'][0]['source']);
                        }
                    } else {
                        $this->images_ids[] = $photo['id'];
                    }
                }
            }
        }

        if (isset($json['paging']['next']) && !empty($json['paging']['next'])) {
            $this->interaction_getPhotos($json['paging']['next'], $user_id, $collection_id, $imported_photos, $fb_post_id);
        } else {
            self::setUpdateIdsFacebook($fb_post_id, $this->images_ids);
        }
    }

    /**
     * @description - function insert_facebook_identifier($identifier)
     * $identifier é o nome do usuário do perfil flickr 
     * Insere um identificador de canal no banco
     * 
     * @autor: Saymon 
     */
    public static function insert_facebook_identifier($identifier, $colectionId) {
        $postId = wp_insert_post(['post_title' => $identifier, 'post_status' => 'publish', 'post_type' => 'socialdb_channel']);
        if ($postId) {
            add_post_meta($postId, 'socialdb_facebook_identificator', $colectionId);
            add_post_meta($postId, 'socialdb_facebook_identificator_last_update', '');
            add_post_meta($postId, 'socialdb_facebook_import_status', 0);
            return $postId;
        } else {
            return false;
        }
    }

    /**
     * @description - function edit_facebook_identifier($identifier)
     * $identifier -  o nome do usuário do perfil flickr 
     * $newIdentifier - novo valor  
     * altera um identificador de um dado perfil flickr
     * 
     * @autor: Saymon 
     */
    public static function edit_facebook_identifier($identifier, $newIdentifier) {
        if (!empty($newIdentifier)) {
            $my_post = array(
                'ID' => $identifier,
                'post_title' => $newIdentifier,
            );
            $postEdted = wp_update_post($my_post);
            return ($postEdted) ? true : false;
        } else {
            return false;
        }
    }

    /**
     * @description - function delete_facebook_identifier($identifier)
     * $identifier -  o nome do usuário do perfil flickr 
     * $colectionId - coleção a que o identificador pertence  
     * exclui um identificador de um dado perfil flickr
     * 
     * @autor: Saymon 
     */
    public static function delete_facebook_identifier($identifierId, $colectionId) {
        $deletedIdentifier = wp_delete_post($identifierId);
        if ($deletedIdentifier) {
            delete_post_meta($identifierId, 'socialdb_facebook_identificator', $identifier);
            delete_post_meta($identifierId, 'socialdb_facebook_identificator', $colectionId);
            return true;
        } else {

            return false;
        }
    }

    public static function list_facebook_identifier($collectionId) {
        //array de configuração dos parâmetros de get_posts()
        $args = array(
            'meta_key' => 'socialdb_facebook_identificator',
            'meta_value' => $collectionId,
            'post_type' => 'socialdb_channel',
            'post_status' => 'publish',
            'suppress_filters' => true
        );
        $results = get_posts($args);
        if (is_array($results)) {
            $json = [];
            foreach ($results as $ch) {
                if (!empty($ch)) {
                    $postMetaLastUpdate = get_post_meta($ch->ID, 'socialdb_facebook_ids_last_update');
                    $postMetaImportSatus = get_post_meta($ch->ID, 'socialdb_facebook_import_status');
                    $array = array('name' => $ch->post_title, 'id' => $ch->ID, 'UpdateIds' => $postMetaLastUpdate, 'importStatus' => $postMetaImportSatus);
                    $json['identifier'][] = $array;
                }
            }
            return $json;
        } else {
            return false;
        }
    }

    private static function setUpdateIdsFacebook($post_id, $ids) {
        update_post_meta($post_id, 'socialdb_facebook_ids_last_update', $ids);
    }

    private function setImportStatus($post_id, $status) {
        update_post_meta($post_id, 'socialdb_facebook_import_status', $status);
    }

}

?>