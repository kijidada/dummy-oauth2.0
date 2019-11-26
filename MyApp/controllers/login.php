<?php

class Login extends Controller {

    function login()
    {        
        require_once '../MyApp/controllers/login.php';
    }

    public function index(){
        require_once '../MyApp/Utility/Utility.php';
        $this->view('login');
    }

    function create($userName,$password,$email){
        //need to implement
    }

    function loginUser($userName,$password){
        if($this->authenticate($userName,$password)){
            session_start();

            $user = $this->model('User',array('id'=>$userName, 'local'=>true));
            $_SESSION['usr'] = $user;
            $util = new StudentUtility();
            $_SESSION['alldata'] = $util->getAllData();
            return true;
        }
        else
            return false;
    }
    
    static function authenticate($u,$p)
    {
        $authentic = false ;
        $pwdidx = 5;
        $util = new StudentUtility();
        $sInfo = $util->getStudentData($u);
        if(count($sInfo) > 0 && $sInfo[$pwdidx] == $p){
            $authentic = true;
        }
        return $authentic;
    }

    function logout(){
        session_start();
        session_destroy();
    }
}

?>