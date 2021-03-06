<?php
loadFile("libs/view.class.php");
loadFile("libs/Csrf.class.php");

abstract class Controller {
    /**
     * private members
     */
    private $view;
    private $error;
    private $mysql;

    /**
     * protected members
     */
    protected $user;

    /**
     * public members
     */
    public $layout = "default";

    public function __construct() {
        $this->view  = new View();
        $this->mysql = connectMySQL();

        $this->setUser();

        $this->beforeFilter();
    }

    public function __destruct() {
        $this->view  = null;
        $this->mysql = null;
        $this->afterFilter();
    }

    /**
     * abstract function
     */
    abstract protected function index();

    /**
     * protected function
     */
    protected function beforeFilter() {
    }

    protected function afterFilter() {
    }

    protected function assign($key, $value) {
        $this->view->assign($key, $value);
    }

    protected function display($path = null) {
        if (!$path) {
            $access = getAccessInfo();
            $path   = "{$access['controller']}/{$access['method']}";
        }                
        $this->view->display($this->layout, $path);
    }

    protected function startPost() {
        Csrf::setToken($this->view);
    }

    protected function finishPost() {
        return Csrf::checkToken($this->view);
    }

    protected function loadModel($modelName) {
        loadFile("models/" . $modelName . ".php");
        $this->$modelName = new $modelName;
        if ($this->$modelName->type === "mysql") {
            $this->$modelName->setDbh($this->mysql);
        }
    }

    protected function setError($message) {
        $this->error[] = $message;
    }

    protected function getError() {
        return $this->error;
    }

    protected function isError() {
        return $this->error ? true : false;;
    }

    protected function redirect($path = "") {
        $site = "http://service.tnnsst35.com/twitter/";
        redirect($site . $path);
        exit;
    }

    protected function setUser() {
        $this->loadModel("User");
        $this->loadModel("UserSession");

        $session = isset($_COOKIE["session"]) ? $_COOKIE["session"] : null;
        if (!$session) return;
        //$session = "743b423c4886b8b09564723d556a18ac";

        $session = $this->UserSession->findBySession($session);
        if (!$session) return;

        $this->user = $this->User->findById($session["user_id"]);
        $this->assign("user", $this->user);
    }
                         
    /**
     * public function
     */
}
