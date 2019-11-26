<?php

class Controller{
    public function model($model,$params=array('')){
        require_once '../MyApp/models/' . $model . '.php';
        return new $model($params);
    }

    public function view($view, $data = []){
        require_once '../MyApp/views/' . $view .'.php';
    }
}