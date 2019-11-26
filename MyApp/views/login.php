<?php
session_start();
if(isset($_SESSION['usr'])) header('location:/public/home');
?>
<html>
    <head>
    </head>
    <body>
        <div id="login-controls">
            <h2>Login</h2>
            <form method="POST" action="/public/">
                <p>User Name:<br/>
                <input type="text" name="user"/>
                </P>
                <p>Password:<br/>
                <input type="password" name="pass"/>
                </P>
                <p>
                <input type="submit" name="op" value="login"/>
                </p>
                <p>
                <a href="//localhost/OAuthServer/controllers/authorize.php?response_type=code&client_id=testclient&state=xyz">OAuth</a>
                </p>
            </form>
        </div>
    </body>
</html>