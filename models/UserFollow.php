<?php
class UserFollow extends MysqlModel {
    public function save($data) {
        $sql = "INSERT INTO user_follows (user_id, follow_user_id, created, updated) VALUES (?, ?, NOW(), NOW())";
        return $this->execute($sql, array(
                    $data["user_id"],
                    $data["follow_user_id"]
                    ));
    }

    public function findByUserId($user_id) {
        $sql = "SELECT * FROM user_follows WHERE user_id = ?";
        return $this->findAll($sql, $user_id);
    }

    public function findByUserIdAndFollowUserId($user_id, $follow_user_id) {
        $sql = "SELECT * FROM user_follows WHERE user_id = ? AND follow_user_id = ? LIMIT 1";
        return $this->findOne($sql, array($user_id, $follow_user_id));
    }
}

//class UserFollow extends Model {
//    const NOFOLLOW = 0;
//    const FOLLOW   = 1;
//
//    public $collection = "user_follows";
//    public $fields = array(
//            "user_id",
//            "follow_user_id",
//            "status",
//            "created",
//            "updated",
//            );
//
//
//    public function findByUserId($user_id, $status = self::FOLLOW) {
//        return $this->db()->find(array("user_id" => $user_id, "status" => $status));
//    }
//
//    public function findByUserIdAndFollowUserId($user_id, $follow_user_id, $status = self::FOLLOW) {
//        return $this->db()->findOne(array("user_id" => $user_id, "follow_user_id" => $follow_user_id, "status" => $status));
//    }
//}
