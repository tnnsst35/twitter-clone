<?php
loadFile("libs/Hash.class.php");

class RegisterController extends Controller {
    public function beforeFilter() {
        if ($this->user) $this->redirect();
    }

    public function afterFilter() {
    }

    public function index() {
        $this->startPost();
        $this->display();
    }

    public function confirm() {
        if (!$this->finishPost()) {
            $this->setError("CSRFトークンエラー");
        }
        $data = array(
                "username"     => postParam("username"),
                "nickname"     => postParam("nickname"),
                "email"        => postParam("email"),
                "password"     => postParam("password"),
                //"private_mode" => (int)postParam("private_mode"),
                );
        $this->checkData($data);
        $this->assign('username',     $data["username"]);
        $this->assign('nickname',     $data["nickname"]);
        $this->assign('email',        $data["email"]);
        //$this->assign('private_mode', $data["private_mode"]);
        $this->startPost();
        if ($this->isError()) {
            $this->assign('error', $this->getError());
            $this->display("register/index");
            exit;
        }
        $this->assign('password', Hash::passwordHash($data["password"]));
        $this->display();
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
                //"private_mode" => (int)postParam("private_mode"),
                );
        $this->checkData($data, false);
        if ($this->isError()) {
            $this->assign('username',     $data["username"]);
            $this->assign('nickname',     $data["nickname"]);
            $this->assign('email',        $data["email"]);
            //$this->assign('private_mode', $data["private_mode"]);
            $this->startPost();
            $this->assign('error', $this->getError());
            $this->display("register/index");
            exit;
        }
        $this->User->save($data);
        $this->redirect('register/finish');
    }

    public function finish() {
        $this->display();
    }

    private function checkData($data, $passwordCheck = true) {
        if (!$data["username"]) {
            $this->setError("usernameを入力してください");
        } else {
            if (!preg_match('/[a-zA-Z0-9]/', $data["username"])) {
                $this->setError("usernameに使用できるのは英数字のみです");
            }
            if (mb_strlen($data["username"], "UTF-8") > 8) {
                $this->setError("usernameは8文字以内です");
            }
            if ($this->User->countByUsername($data["username"]) > 0) {
                $this->setError("このusernameはすでに使用されています");
            }
        }
        if (!$data["nickname"]) {
            $this->setError("nicknameを入力してください");
        } else {
            if (mb_strlen($data["nickname"], "UTF-8") > 8) {
                $this->setError("nicknameは8文字以内です");
            }
        }
        if (!$data["email"]) {
            $this->setError("emailを入力してください");
        } else {
            if (!preg_match('/[a-zA-Z0-9.]@[a-zA-Z0-9.]/', $data["email"])) {
                $this->setError("emailが正しくありません");
            } else if ($this->User->countByEmail($data["email"]) > 0) {
                $this->setError("emailはすでに使用されています");
            }
        }
        if ($passwordCheck) {
            if (!$data["password"]) {
                $this->setError("passwordを入力してください");
            } else {
                if (!preg_match('/[a-zA-Z0-9]/', $data["password"])) {
                    $this->setError("passwordに使用できるのは英数字のみです");
                }
                if (!inRange(mb_strlen($data["password"], "UTF-8"), 6, 12)) {
                    $this->setError("passwordは6文字以上12文字以内です");
                }
                if ($data["password"] !== postParam("repassword")) {
                    $this->setError("パスワードと確認用パスワードが一致しません");
                }
            }
        }
        //if ($data["private_mode"] === null) {
        //    $this->setError("private_modeを入力してください");
        //}
    }
}
