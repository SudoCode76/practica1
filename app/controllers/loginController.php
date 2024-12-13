<?php
require_once __DIR__ . '/../models/loginModel.php';




class LoginController {
    private $model;

    public function __construct(){
        $this->model = new LoginModel();
    }

    public function login($username, $password){
        return $this->model->login($username, $password);
    }

    public function index() {
        require_once __DIR__ . '/../views/login/login.php';
    }
}

?>
