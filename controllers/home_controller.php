<?php
loadFile("libs/Twitter.class.php");

class HomeController extends Controller {
    public function beforeFilter() {
        if (!$this->user) $this->redirect();
        $this->loadModel("UserTweet");
    }

    public function afterFilter() {
    }

    public function index() {
        $this->loadModel("UserTweet");
        $this->loadModel("UserFollow");
        $this->loadModel("UserFollower");

        $this->startPost();
        $page = 1;
        $twitter  = new Twitter($this);

        $username = getParam("user");
        $owner = $username ? $this->User->findByUsername($username) : $this->user;

        $mypage = true;

        if (!$owner) {
            $mypage = false;
            $this->setError("{$username}は存在しません");
        }

        if ($this->isError()) {
            $this->assign("error", $this->getError());
        } else {
            $mypage = $this->user["username"] === $owner["username"];

            if (!$mypage) $this->assign("isFollow", $twitter->isFollow($this->user["id"], $owner["id"]));

            $follow   = $twitter->getFollowUsers($owner["id"]);
            $follower = $twitter->getFollowerUsers($owner["id"]);

            $this->assign("follow",   $follow);
            $this->assign("follower", $follower);
            $timeline = $twitter->getTimeline($owner, $mypage ? $follow : null, $page);

            $this->assign("timeline", $timeline);
        }


        $this->assign("owner",    $owner);
        $this->assign("mypage",   $mypage);
        $this->display("home/index");
    }

    public function tweet() {
        if (!$this->finishPost()) {
            $this->setError("CSRFトークンエラー");
        }

        $text = postParam("tweet");
        $text = trim($text);
        if (mb_strlen($text) <= 0) {
            $this->setError("つぶやきを入力してください");
        }

        if ($this->isError()) {
            $this->assign("error", $this->getError());
            $this->index();
            exit;
        }

        $this->loadModel("UserTweet");

        $twitter  = new Twitter($this);
        $twitter->tweet($this->user["id"], $text);

        $this->redirect("home/");
    }
}
