<?php
class Home extends Controller{
    public function index(){
        require_once '../MyApp/Utility/Utility.php';
        //$this->model('User',array(''));
        $this->view('home');
        #echo json_encode($data);
    }

    
}