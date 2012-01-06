<?php
class UserFollower extends MysqlModel {
    public function save($data) {
        $sql = "INSERT INTO user_followers (user_id, follower_user_id, created, updated) VALUES (?, ?, NOW(), NOW())";
        return $this->execute($sql, array(
                    $data["user_id"],
                    $data["follower_user_id"]
                    ));
    }

    public function findByUserId($user_id) {
        $sql = "SELECT * FROM user_followers WHERE user_id = ?";
        return $this->findAll($sql, $user_id);
    }
}

//class UserFollower extends Model {
//    const NOFOLLOW = 0;
//    const FOLLOW   = 1;
//
//    public $collection = "user_followers";
//    public $fields = array(
//            "user_id",
//            "follower_user_id",
//            "status",
//            "created",
//            "updated",
//            );
//
//    public function findByUserId($user_id, $status = self::FOLLOW) {
//        return $this->db()->find(array("user_id" => $user_id, "status" => $status));
//    }
//}
