<?php
class View {
    private $tpl;
    private $data;

    public function __construct() {
        $this->tpl  = "views/";
        $this->data = array();
    }

    public function tokenTag() {
        echo '<input type="hidden" name="__token" value="' . h($this->data["__token"]) . '" />';
    }

    public function assign($key, $value) {
        $this->data[$key] = $value;
    }

    public function display($layout, $path) {
        foreach ($this->data as $key => $value) {
            ${$key} = $value;
        }
        $site = "http://service.tnnsst35.com/twitter/";
        $tplPath = $this->tpl . $path . ".tpl";
        include_once($this->tpl . "layout/" . $layout . ".tpl");
    }
}
