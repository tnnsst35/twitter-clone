<?php
loadFile("libs/Twitter.class.php");

class SearchController extends Controller {
    public function beforeFilter() {
        if (!$this->user) $this->redirect();
    }

    public function afterFilter() {
    }

    public function index() {
        $keyword = getParam("keyword");
        $keyword = trim($keyword);

        if (mb_strlen($keyword) <= 0) {
            $this->setError("検索キーワードを入力してください");
        }

        if ($this->isError()) {
            $this->assign('error', $this->getError());
        } else {
            $this->loadModel("UserTweet");
            $twitter = new Twitter($this);
            $users = $twitter->searchUser($keyword, 5);
            $this->assign("users", $users);
            $tweets = $twitter->searchTweet($keyword, 5);
            $this->assign("tweets", $tweets);
        }

        $this->assign("keyword", $keyword);
        $this->display();
    }
}
