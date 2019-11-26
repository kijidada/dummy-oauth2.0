<?php
// include our OAuth2 Server object
require_once __DIR__.'/server.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/OAuthServer/Utility/Utility.php';
$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

// validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die;
}
// display an authorization form
if (empty($_POST)) {
  $form = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/OAuthServer/views/authform.html');
  exit($form);
}
$uName = $_POST['user'];
$pwd = $_POST['pass'];
$util = new StudentUtility();
$is_authorized =  $util->checkUser($uName,$pwd) ;
if($is_authorized)
{
  $server->handleAuthorizeRequest($request, $response, $is_authorized, $uName); 
  $response->send();
}