<?php
require_once __DIR__ . '/../models/registerModel.php';

class RegisterController {
    private $model;

    public function __construct(){
        $this->model = new RegisterModel();
    }

    public function register($username, $password, $rol){
        return $this->model->register($username, $password, $rol);
    }
}
?>
