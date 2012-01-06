<?php
class UserSession extends MysqlModel {
    public function save($data) {
        $sql = "INSERT INTO user_sessions (user_id, session, session_ssl, created, updated) VALUES (?, ?, ?, NOW(), NOW())";
        return $this->execute($sql, array(
                    $data["user_id"],
                    $data["session"],
                    $data["session_ssl"],
                    ));
    }

    public function update($user_id, $session, $session_ssl) {
        $sql = "UPDATE user_sessions SET session = ?, session_ssl = ? WHERE user_id = ?";
        return $this->execute($sql, array(
                    $session,
                    $session_ssl,
                    $user_id,
                    ));
    }

    public function countByUserId($user_id) {
        $sql = "SELECT COUNT(*) AS num FROM user_sessions WHERE user_id = ?";
        $res = $this->findOne($sql, $user_id);
        return $res ? (int)$res["num"] : null;
    }
    
    public function findByUserId($user_id) {
        $sql = "SELECT * FROM user_sessions WHERE user_id = ? LIMIT 1";
        return $this->findOne($sql, $user_id);
    }

    public function findBySession($session) {
        $sql = "SELECT * FROM user_sessions WHERE session = ? LIMIT 1";
        return $this->findOne($sql, $session);
    }
}

//class UserSession extends Model {
//    public $collection = "user_sessions";
//    public $fields = array(
//            "user_id",
//            "session",
//            "session_ssl",
//            "created",
//            "updated",
//            );
//
//    public function countByUserId($user_id) {
//        return $this->db()->find(array("user_id" => $user_id))->count();
//    }
//    
//    public function findByUserId($user_id) {
//        return $this->db()->findOne(array("user_id" => $user_id));
//    }
//
//    public function findBySession($session) {
//        return $this->db()->findOne(array("session" => $session));
//    }
//}
