<?php
class LogoutController extends Controller {
    public function beforeFilter() {
        if (!$this->user) $this->redirect();
    }

    public function afterFilter() {
    }

    public function index() {
        setcookie('session', '', time() - 1, "/twitter/", "service.tnnsst35.com");
        setcookie('session_ssl', '', time() - 1, "/twitter/", "service.tnnsst35.com");
        $this->redirect();
    }
}
