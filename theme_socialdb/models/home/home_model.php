<?php

/**
 * Author: Eduardo Humberto
 */
include_once ('../../../../../wp-config.php');
include_once ('../../../../../wp-load.php');
include_once ('../../../../../wp-includes/wp-db.php');
require_once(dirname(__FILE__) . '../../general/general_model.php');

class HomeModel extends Model {
    public function display_view_main_page($data) {
        $data['populars'] = $this->get_popular($data['max_collection_showed']);
        $data['recents'] = $this->get_recents($data['max_collection_showed']);
        return $data;
    }
    
     public function display_recents($data) {
        $data['recents'] = $this->get_recents($data['max_collection_showed']);
        return $data;
    }
    public function display_populars($data) {
        $data['populars'] = $this->get_popular($data['max_collection_showed']);
        return $data;
    }
    
    public function get_popular($max_size){
        $low_limit = $max_size-6;
        global $wpdb;
        $most_popular_collections = [];
        $array_total_items = [];
        $wp_posts = $wpdb->prefix . "posts";
        $query = "
                        SELECT p.* FROM $wp_posts p
                        WHERE p.post_type like 'socialdb_collection' and p.post_status LIKE 'publish' and p.ID NOT IN (".get_option('collection_root_id').")
                ";                 
        $results = $wpdb->get_results($query);
        if ($results&&is_array($results)&&count($results)>0) {
            foreach ($results as $result) {
                $array_total_items[$result->ID] = count($this->get_collection_posts($result->ID,'ID'));
            }
        }else{
            return false;
        }
        //
        if(!empty($array_total_items)){
            $cont = 0;
           // sort($array_total_items);
            //var_dump(arsort($array_total_items));
            arsort($array_total_items);
            foreach ($array_total_items as $collection_id => $value) {
                if($cont==$max_size){
                    break;
                }elseif($cont<$low_limit){
                    $cont++;
                    continue;
                }
                $array['collection'] = get_post($collection_id);
                $array['count'] = $value;
                $array['class'] = 'popular'.$max_size;
                $most_popular_collections[] = $array;
                $cont++;
            }
        }
        return $most_popular_collections;
    }
    
    public function get_recents($max_size) {
        $low_limit = $max_size-6;
        global $wpdb;
        $most_recent_collections = [];
        $array_total_items = [];
        $wp_posts = $wpdb->prefix . "posts";
        $query = "
                        SELECT p.* FROM $wp_posts p
                        WHERE p.post_type like 'socialdb_collection' and p.post_status LIKE 'publish' and p.ID NOT IN (".get_option('collection_root_id').") ORDER BY p.post_date DESC
                ";                 
        $results = $wpdb->get_results($query);
        if ($results&&is_array($results)&&count($results)>0) {
            foreach ($results as $result) {
                $array_total_items[$result->ID] = count($this->get_collection_posts($result->ID,'ID'));
            }
        }else{
            return false;
        }
        //
        if(!empty($array_total_items)){
            $cont = 0;
            foreach ($array_total_items as $collection_id => $value) {
                if($cont==$max_size){
                    break;
                }elseif($cont<$low_limit){
                    $cont++;
                    continue;
                }
                $array['collection'] = get_post($collection_id);
                $array['count'] = $value;
                $array['class'] = 'recent'.$max_size;
                $most_recent_collections[] = $array;
                $cont++;
            }
        }else{
            return false;
        }
        $this->aasort($most_recent_collections, 'count');
        return array_reverse($most_recent_collections);
    }
    
    public function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }

}