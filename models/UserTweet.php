<?php
class UserTweet extends MongoModel {
    public $collection = "user_tweets";
    public $fields = array(
            "user_id",
            "text",
            "created",
            "updated",
            );

    public function findByUserId($user_ids) {
        // http://www.mongodb.org/display/DOCS/Advanced+Queries
        return $this->db()->find(array("user_id" => array('$in' => $user_ids)))->sort(array("created" => -1));
    }

    public function findByKeyword($keyword, $limit) {
        return $this->db()->find(array("text" => new MongoRegex("/$keyword/")))->limit($limit);
    }
}
