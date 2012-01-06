<?php
loadFile("libs/Twitter.class.php");

class FollowController extends Controller {
    public function beforeFilter() {
        if (!$this->user) $this->redirect();
        $this->loadModel("UserTweet");
    }

    public function afterFilter() {
    }

    public function index() {
        $username = getParam("user");
        $owner = $username ? $this->User->findByUsername($username) : $this->user;

        if (!$owner || $this->user["username"] === $owner["username"]) {
            $this->redirect("home/");
        }

        $this->loadModel("UserFollow");
        $this->loadModel("UserFollower");

        $twitter  = new Twitter($this);
        if (!$twitter->follow($this->user["id"], $owner["id"])) {
            //TODO error
        }

        $this->redirect("home/?user={$username}");
    }
}
