<?php

include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
require_once(dirname(__FILE__) . '../../general/general_model.php');

class InstagramModel extends Model {

    /**
     * constantes contendo as chaves da api
     * e as urls bases para login, autenticação e requisição
     */
    const API_URL = 'https://api.instagram.com/v1/';
    const API_OAUTH_URL = 'https://api.instagram.com/oauth/authorize/';
    const API_OAUTH_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';
    const CONTLROLLER_PATH = '/controllers/social_network/instagram_controller.php';

    /**
     * armazena a id de usuário. Necessário para requisitar dados
     */
    private $userId;

    /**
     * armazena configurações da API
     */
    private $clientId;
    private $clientSecret;

    /**
     * @__construct 
     * @description: constutor da classe seta a id do usuário
     * @param: $username - nome de usuário válido do instagram
     */
    function __construct($username, array $config) {
        $this->clientId = $config['socialdb_instagram_api_id'];
        $this->clientSecret = $config['socialdb_instagram_api_secret'];
        if ($username) {
            $requestUserId = self::API_URL . 'users/search?q=' . $username . '&count=1&client_id=' . $this->clientId;
            $result = file_get_contents($requestUserId);
            $jsonResponse = json_decode($result, true);
            $this->userId = $jsonResponse['data'][0]['id'];
        }
    }

    /**
     * @name: getUserId 
     * @description: retorna a id do usuário associado a um nome de usuário válido
     * instagram
     * @return:string
     */
    private function getUserId() {
        return $this->userId;
    }

    /**
     * @name: getUriRedirect() 
     * @description: retorna a uri de redirecionamento(url corrente)
     * instagram
     * @return:string
     */
    private function getUriRedirect() {
        return $this->uriRedirect;
    }

    /**
     * @name: requestInstagramApi 
     * @description: faz uma requisição autenticado 
     * @return: string
     */
    static function requestInstagramApi($url) {
        $response = file_get_contents($url);
        return $response;
    }

    /**
     * @name: loginInstagram 
     * @description: faz o login de um usuário 
     * @return: array
     */
    public function loginInstagram() {
        $urlLogin = self::API_OAUTH_URL . '?client_id=' . $this->clientId;
        $urlLogin .= '&redirect_uri=' . get_bloginfo('template_directory') . self::CONTLROLLER_PATH;
        $urlLogin .= '&response_type=code';
        header('location: ' . $urlLogin);
    }

// get_bloginfo('template_directory')

    /**
     * @name: getAccessToken 
     * @description: autentica um usuário logado
     * @param: $code, string enviada via URL pela API do instagram 
     * como resposta a uma solicitação de autenticação 
     * @return: array
     */
    private function getAccessToken($code) {
        $paramConfig = array(
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => get_bloginfo('template_directory') . self::CONTLROLLER_PATH,
            'code' => $code
        );

        $ch = curl_init(self::API_OAUTH_TOKEN_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paramConfig);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $jsonData = curl_exec($ch);
        curl_close($ch);
        $arrayJson = json_decode($jsonData, true);
        return $arrayJson['access_token']; //['access_token'];
    }

    /**
     * @name: getUserMediaRecent 
     * @description: recupera as imagens de um dado usuário
     * @param: $param, string; $flag, boolean, se true $param é um access_token,
     * false, indica que se trata de uma url completa para paginação de pedidos
     * da API do instagram
     * @return: array contendo dados de 20 imagens mais a url para
     * próxima página de resultados
     */
    private function getUserMediaRecent($param, $flag = true) {
        if ($flag) {
            $user_id = $this->getUserId();
            $url = self::API_URL . 'users/' . $user_id . '/media/recent';
            $url .= '?access_token=' . $param;
            $response = self::requestInstagramApi($url);
        } else {
            //flag falsa faz a requisição através da url da resposta seguinte
            $response = self::requestInstagramApi($param);
        }

        $jsonResponse = json_decode($response, true);

        return $jsonResponse;
    }

    //fim do método getUserMediaRecent()

    /**
     * @name: getUserMediaRecentUpdate 
     * @description: recupera as imagens de um dado usuário para update apartir do ultimo item
     * @param: $param, string; $lastId, string; $flag, boolean, se true $param é um access_token,
     * false, indica que se trata de uma url completa para paginação de pedidos
     * da API do instagram
     * @return: array contendo dados de 20 imagens mais a url para
     * próxima página de resultados
     */
    private function getUserMediaRecentUpdate($param, $lastDate, $flag = true) {
        $curr_time = date("Y-m-d H:i:s", strtotime($lastDate) + 60);

        $lastDate = strtotime($curr_time);

        if ($flag) {
            $user_id = $this->getUserId();
            $url = self::API_URL . 'users/' . $user_id . '/media/recent';
            $url .= '?access_token=' . $param;
            $url .= '&min_timestamp=' . $lastDate;
            $response = self::requestInstagramApi($url);
        } else {
            //flag falsa faz a requisição através da url da resposta seguinte
            $response = self::requestInstagramApi($param);
        }

        $jsonResponse = json_decode($response, true);

        return $jsonResponse;
    }

    //fim do método getUserMediaRecentUpdate()

    /**
     * @name: getAllUserMediaRecent 
     */
    public function getAllUserMediaRecent(array $param, ObjectModel $object_model) {
        set_time_limit(0);
        $access_token = $this->getAccessToken($param['code']);
        if (isset($access_token)) {
            //requisita as midias mais recentes postadas pelo usuário intanciado
            if (isset($param['real_op']) && $param['real_op'] == 'updatePhotosInstagram' && isset($param['lastDate'])) {
                $response = $this->getUserMediaRecentUpdate($access_token, $param['lastDate']);
            } else {
                $response = $this->getUserMediaRecent($access_token);
            }

            //seta a data do post (imagem ou video) mais recente
            $dateUpdate = $response['data'][0]['created_time'];
            $lastId = $response['data'][0]['id'];
            if (isset($dateUpdate) && isset($lastId)) {
                self::setLastDateInstagram($param['postIdUserInstagram'], $dateUpdate);
                self::setLastIdInstagram($param['postIdUserInstagram'], $lastId);
                // altera o status do identificador do canal como importado
                self::setImportStatus($param['postIdUserInstagram'], 1);
            } else {
                return false;
            }

            foreach ($response['data'] as &$media) {
                if ($media['type'] == 'image') {
                    $media_content = '<img src="' . $media['images']['standard_resolution']['url'] . '" width="200" height="200" />';
                    $media_content = $media['images']['standard_resolution']['url'];
                } elseif ($media['type'] == 'video') {
                    $media_content = '<iframe src="' . $media['videos']['standard_resolution']['url'] . '" width="200" height="200" frameborder="0" scrolling="no" allowfullscreen />';
                    $media_content =$media['videos']['standard_resolution']['url'];
                }

                //$post_id = $object_model->add_photo($param['collection_id'], 'inserir um título', $media_content);
                $post_id = $object_model->add_photo($param['collection_id'], 'inserir um título', $media_content);
                if ($post_id) {
                    $object_model->add_thumbnail_url($media['images']['standard_resolution']['url'], $post_id);
                    add_post_meta($post_id, 'socialdb_uri_imported', $media['images']['standard_resolution']['url']);
                }
            }

            $nextUrl;

            // se houver mais de 20 imagens, realiza iterações
            do {
                if (isset($response['pagination']['next_url'])) {
                    $nextUrl = $response['pagination']['next_url'];
                    $response = $this->getUserMediaRecent($nextUrl, false);
                    foreach ($response['data'] as &$media) {
                        //$post_id = $object_model->add_photo($param['collection_id'], 'inserir um título', '<embed width=400 height=350 src=\'' . $media['images']['standard_resolution']['url'] . '\'>');
                        $post_id = $object_model->add_photo($param['collection_id'], 'inserir um título',  $media['images']['standard_resolution']['url'] );
                        if ($post_id) {
                            $object_model->add_thumbnail_url($media['images']['thumbnail']['url'], $post_id);
                            add_post_meta($post_id, 'socialdb_uri_imported', $media['images']['thumbnail']['url']);
                        }
                    }
                } else {
                    unset($nextUrl);
                }
            } while (isset($nextUrl));

            return true;
        } else {
            return false;
        }
    }

//fim do método getAllUserMediaRecent()

    /**
     * @description - function insert_instagram_identifier($identifier)
     * $identifier é o nome do usuário do perfil flickr 
     * Insere um identificador de canal no banco
     * 
     * @autor: Saymon 
     */
    public static function insert_instagram_identifier($identifier, $colectionId) {
        $postId = wp_insert_post(['post_title' => $identifier, 'post_status' => 'publish', 'post_type' => 'socialdb_channel']);
        if ($postId) {
            add_post_meta($postId, 'socialdb_instagram_identificator', $colectionId);
            add_post_meta($postId, 'socialdb_instagram_identificator_last_update', '');
            add_post_meta($postId, 'socialdb_instagram_import_status', 0);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @description - function edit_vimeo_identifier($identifier)
     * $identifier -  o nome do usuário do perfil instagram 
     * $newIdentifier - novo valor  
     * altera um identificador de um dado perfil instagram
     * 
     * @autor: Saymon 
     */
    public static function edit_instagram_identifier($identifier, $newIdentifier) {
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
     * @name : delete_instagram_identifier()
     * @description : exclui um identificador de um dado perfil instagram
     * @param: identifier, $colectionId
     * $identifier -  o nome do usuário do perfil instagram 
     * $colectionId - coleção a que o identificador pertence  
     * $return - boolean (confimando a exlusão)
     * @autor: Saymon 
     */
    public static function delete_instagram_identifier($identifierId, $colectionId) {
        $deletedIdentifier = wp_delete_post($identifierId);
        if ($deletedIdentifier) {
            delete_post_meta($identifierId, 'socialdb_instagram_identificator', $identifier);
            delete_post_meta($identifierId, 'socialdb_instagram_identificator', $colectionId);
            return true;
        } else {
            return false;
        }
    }

    public static function list_instagram_identifier($collectionId) {
        //array de configuração dos parâmetros de get_posts()
        $args = array(
            'meta_key' => 'socialdb_instagram_identificator',
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
                    $postMetaLastUpdate = get_post_meta($ch->ID, 'socialdb_instagram_identificator_last_update', true);
                    $postMetaLastUpdate = ($postMetaLastUpdate == '' ? '' : date("Y-m-d H:i:s", $postMetaLastUpdate));

                    $postMetaLastIdUpdate = get_post_meta($ch->ID, 'socialdb_instagram_identificator_last_update_id');
                    $postMetaImportStatus = get_post_meta($ch->ID, 'socialdb_instagram_import_status');
                    $array = array('name' => $ch->post_title, 'id' => $ch->ID, 'lastUpdate' => $postMetaLastUpdate, 'importStatus' => $postMetaImportStatus, 'lastId' => $postMetaLastIdUpdate);
                    $json['identifier'][] = $array;
                }
            }
            echo json_encode($json);
        } else {
            return false;
        }
    }

    private static function setLastDateInstagram($post_id, $date) {
        update_post_meta($post_id, 'socialdb_instagram_identificator_last_update', $date);
    }

    private static function setLastIdInstagram($post_id, $last_id) {
        update_post_meta($post_id, 'socialdb_instagram_identificator_last_update_id', $last_id);
    }

    private static function setImportStatus($post_id, $status) {
        update_post_meta($post_id, 'socialdb_instagram_import_status', $status);
    }

}

?>