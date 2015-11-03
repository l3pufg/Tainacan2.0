<?php

include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
require_once(dirname(__FILE__) . '../../general/general_model.php');

class SocialMappingModel extends Model {

    public function generate_selects($data) {
        $html = '<option value="">' . __('Select', 'tainacan') . '</option>';

        switch ($data['social_network']) {
            case 'youtube':
                $tags_dc = array(
                    'title',
                    'date',
                    'description',
                    'channel',
                    'idchannel',
                    'idvideo',
                    'url',
                    'type',
                    'content'
                );
                break;
            case 'facebook':
                $tags_dc = array(
                    'from_name',
                    'from_id',
                    'created_time',
                    'id',
                    'link',
                    'name',
                    'place',
                    'type',
                    'content'
                );
                break;
            case 'flickr':
                $tags_dc = array(
                    'title',
                    'ownername',
                    'tags',
                    'description',
                    'owner',
                    'date_upload',
                    'url',
                    'id',
                    'content',
                    'type',
                    'license',
                    'latitude',
                    'longitude'
                );
                break;
            case 'instagram':
                $tags_dc = array(
                    'id',
                    'username',
                    'tags',
                    'caption',
                    'userid',
                    'users_in_photo',
                    'created_time',
                    'type',
                    'link',
                    'location',
                    'content'
                );
                break;
        }

        if ($tags_dc) {
            foreach ($tags_dc as $tag_dc) {
                $html .= "<option value='$tag_dc'>$tag_dc</option>";
            }
        }
        return $html;
    }

}
