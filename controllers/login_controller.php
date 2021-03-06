<?php
loadFile("libs/Random.class.php");
loadFile("libs/Hash.class.php");

class LoginController extends Controller {
    public function beforeFilter() {
        if ($this->user) $this->redirect();
    }

    public function afterFilter() {
    }

    public function index() {
        $data = array(
                "username" => postParam("username"),
                "password" => postParam("password"),
                );
        $this->checkData($data);

        $password = Hash::passwordHash($data["password"]);
        $num      = $this->User->countByUsername($data["username"]);
        if ($num <= 0) {
            $this->setError("ログインできません");
        } else {
            $user = $this->User->findByUsername($data["username"]);
            if ($user["password"] !== $password) {
                $this->setError("ログインできません");
            }
        }
        if ($this->isError()) {
            $this->startPost();
            $this->assign('error', $this->getError());
            $this->assign('username', $data["username"]);
            $this->display("top/index");
            exit;
        }

        $session     = Random::get();
        $session_ssl = Random::get();

        $num = $this->UserSession->countByUserId($user["id"]);
        if ($num <= 0) {
            $data = array(
                    "user_id"     => $user["id"],
                    "session"     => $session,
                    "session_ssl" => $session_ssl,
                    );
            $this->UserSession->save($data);
        } else {
            $this->UserSession->update($user["id"], $session, $session_ssl);
        }

        setcookie('session',     $session,     time() + 7 * DAY, "/twitter/", "service.tnnsst35.com");
        setcookie('session_ssl', $session_ssl, time() + 7 * DAY, "/twitter/", "service.tnnsst35.com");

        $this->redirect();
    }

    public function confirm() {
        if (!$this->finishPost()) {
            $this->setError("CSRFトークンエラー");
        }
        $this->assign('password', Hash::passwordHash($data["password"]));
    }

    public function execute() {
        if (!$this->finishPost()) {
            $this->setError("CSRFトークンエラー");
        }
        $data = array(
                "username"     => postParam("username"),
                "nickname"     => postParam("nickname"),
                "email"        => postParam("email"),
                "password"     => postParam("password"),
                "private_mode" => (int)postParam("private_mode"),
                );
        $this->checkData($data, false);
        if ($this->isError()) {
            $this->assign('username',     $data["username"]);
            $this->assign('nickname',     $data["nickname"]);
            $this->assign('email',        $data["email"]);
            $this->assign('private_mode', $data["private_mode"]);
            $this->startPost();
            $this->assign('error', $this->getError());
            $this->display("register/index");
            exit;
        }
        $this->User->save($data);
        $this->redirect('register/finish');
    }

    private function checkData($data, $passwordCheck = true) {
        if (!$data["username"]) {
            $this->setError("アカウントIDを入力してください");
        } else {
            if (!preg_match('/[a-zA-Z0-9]/', $data["username"])) {
                $this->setError("アカウントIDは英数字です");
            }
            if (mb_strlen($data["username"], "UTF-8") > 8) {
                $this->setError("アカウントIDは8文字以内です");
            }
        }
        if (!$data["password"]) {
            $this->setError("パスワードを入力してください");
        } else {
            if (!preg_match('/[a-zA-Z0-9]/', $data["password"])) {
                $this->setError("パスワードは英数字です");
            }
            if (!inRange(mb_strlen($data["password"], "UTF-8"), 6, 12)) {
                $this->setError("パスワードは6文字以上12文字以内です");
            }
        }
    }
}
