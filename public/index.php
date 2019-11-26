<?php

require_once '../MyApp/init.php';
$app = new MyApp;
@$op = $_REQUEST['op'];
    require_once '../MyApp/controllers/login.php';
    $login_controller = new Login();

    switch ($op) {
        case 'login':
            $uName = $_POST['user'];
            $pwd = $_POST['pass'];
            if($login_controller->loginUser($uName,$pwd)){
                header('location:/public/home');
            }
            break;
        case 'logout':
            $login_controller->logout();
            header('location:/public/login');
            break;
        default:
            break;
    }

?>