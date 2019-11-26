<?php
require_once '../models/User.php';
require_once '../Utility/Utility.php';
    
//Source code, License and reference for OAuth
//https://github.com/bshaffer/oauth2-server-php/blob/master/LICENSE
//https://bshaffer.github.io/oauth2-server-php-docs/cookbook/



//url of authorize form at OAuthserver
//http://172.26.83.104/OAuthServer/controllers/authorize.php?response_type=code&client_id=testclient&state=xyz



$code = $_GET['code'];
// exchange authorization code for access token

// echo $code;
// die;
$query = array(
    'grant_type'    => 'authorization_code',
    'code'          => $code,
    'client_id'     => 'testclient',
    'client_secret' => 'testpass',
    'redirect_uri' => 'http://localhost/MyApp/views/temp.php'
);

$opt = array( "exceptions"=> false );
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost/OAuthServer/controllers/token.php',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $query
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
$json = json_decode($resp, true);
// Close request to clear up some resources
$token = $json['access_token'];
$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_URL => 'http://localhost/OAuthServer/controllers/resource.php?access_token=' .$token,
  CURLOPT_USERAGENT => 'Modular Sample cURL Request'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
$json = json_decode($resp, true);

curl_close($curl);

session_start();
session_destroy();

if(!isset($_SESSION['usr'])) {
    if($json['success']){
        session_start();
        $user = new User(array('id'=>$json['roll'], 'local'=>true));
        $_SESSION['usr'] = $user;
        $util = new StudentUtility();
        $_SESSION['alldata'] = $util->getAllData();
        header('location: http://localhost/public/home');
        echo "redirect<a href=//localhost/public/home>home</a>";
    }
    else
        header('location: http://localhost/public/'); 
}
else
 header('location: http://localhost/public/'); 
//echo $json['roll'];
?>


