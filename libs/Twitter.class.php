<?php
loadFile("libs/Benchmark.class.php");

/**
 * Twitterぽいことをやるクラス
 */
class Twitter {
    private $controller;

    public function __construct($controller) {
        $this->controller = $controller;
    }

    /**
     * つぶやく
     *
     * @params user_id MongoOdj つぶやく人のID
     * @params text    String   内容
     */
    public function tweet($user_id, $text) {
        $data = array(
                "user_id" => $user_id,
                "text"    => $text,
                );

        $benchmark = new Benchmark();
        $benchmark->start();

        $this->controller->UserTweet->save($data);

        $benchmark->finish();
        $benchmark->writeTime("MongoDB-tweet");
    }

    /**
     * タイムラインを取得する
     *
     * @params user_id MongoOdj タイムラインを取得する人のID
     * @params page    int      ページ
     * @params limit   int      読み込み数
     */
    public function getTimeline($user, $follow, $page, $limit = 20) {
        $user_ids = array($user["id"]);
        if ($follow) {
            foreach ($follow as $f) {
                $user_ids[] = $f["follow_user_id"];
            }
        }

        $benchmark = new Benchmark();
        $benchmark->start();

        $data = $this->controller->UserTweet->findByUserId($user_ids);
        if ($data->count() <= 0) return null;
        $ret = array();
        foreach ($data as $k => $d) {
            $d["User"] = $this->controller->User->findById($d["user_id"]);
            $ret[] = $d;
        }

        $benchmark->finish();
        $benchmark->writeTime("MongoDB-getTimeline");

        return $ret;
    }

    /**
     * ユーザを検索する
     */
    public function searchUser($keyword, $limit) {
        $data = $this->controller->User->findByKeyword($keyword, $limit);
        return count($data) > 0 ? $data : null;
    }

    /**
     * ツイート検索
     */
    public function searchTweet($keyword, $limit) {
        $data = $this->controller->UserTweet->findByKeyword($keyword, $limit);
        if ($data->count() <= 0) return null;
        $ret = array();
        foreach ($data as $k => $d) {
            $d["User"] = $this->controller->User->findById($d["user_id"]);
            $ret[] = $d;
        }
        return $ret;
    }

    /**
     * フォローする
     */
    public function follow($user_id, $follow_user_id) {
        $this->controller->UserFollow->begin();

        $r = $this->controller->UserFollow->save(array(
            "user_id"        => $user_id,
            "follow_user_id" => $follow_user_id,
            //"status"         => UserFollower::FOLLOW,
        ));

        if (!$r) {
            $this->controller->UserFollow->rollback();
            return false;
        }

        $r = $this->controller->UserFollower->save(array(
            "user_id"          => $follow_user_id,
            "follower_user_id" => $user_id,
            //"status"           => UserFollower::FOLLOW,
        ));

        if (!$r) {
            $this->controller->UserFollow->rollback();
            return false;
        }

        $this->controller->UserFollow->commit();
        return true;
    }

    /**
     * フォローしている一覧
     */
    public function getFollowUsers($user_id) {
        $data = $this->controller->UserFollow->findByUserId($user_id);
        if (count($data) <= 0) return null;
        $ret = array();
        foreach ($data as $k => $d) {
            $d["User"] = $this->controller->User->findById($d["follow_user_id"]);
            $ret[] = $d;
        }
        return $ret;
    }

    /**
     * フォロされている一覧
     */
    public function getFollowerUsers($user_id) {
        $data = $this->controller->UserFollower->findByUserId($user_id);
        if (count($data) <= 0) return null;
        $ret = array();
        foreach ($data as $k => $d) {
            $d["User"] = $this->controller->User->findById($d["follower_user_id"]);
            $ret[] = $d;
        }
        return $ret;
    }

    /**
     * フォロー中か？
     */
    public function isFollow($user_id, $follow_user_id) {
        $data = $this->controller->UserFollow->findByUserIdAndFollowUserId($user_id, $follow_user_id);
        return $data ? true : false;
    }
}
