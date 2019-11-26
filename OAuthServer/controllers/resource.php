<?php
// include our OAuth2 Server object
require_once __DIR__.'/server.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/OAuthServer/Utility/Utility.php';
$request = OAuth2\Request::createFromGlobals();
if (!$server->verifyResourceRequest($request)) {
    $resp = $server->getResponse()->send();
    die;
}

$token = $server->getAccessTokenData($request);
$id = $token['user_id'];

if($id != 0){    
    echo json_encode(array('success' => true, 'roll' => $id ));
}
else
    echo json_encode(array('success' => false, 'message' => 'Unauthorized', 'roll' => 0));
?>