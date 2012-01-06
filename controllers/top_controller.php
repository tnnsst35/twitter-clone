<?php
class TopController extends Controller {
    public function beforeFilter() {
        if ($this->user) $this->redirect("home/");
    }

    public function afterFilter() {
    }

    public function index() {
        $this->startPost();
        $this->display();
    }
}
