<?php
require_once('../Cshlovjah/Applications/Controller/Controller.php');
require_once('../Cshlovjah/Applications/Controller/Validate.php');

session_start();
if(isset($_SESSION['username'])){
    header("Location: index.php");
    exit;
}

if( isset($_POST['user']) ) {
    $login = Validate::cleanAuth($_POST['user']);
    $password = Validate::cleanAuth($_POST['pass']);

    $account = Controller::getUserName($login);
    $_SESSION['role'] = $account['role'];
    if($_POST['submit']){
        if($account['name'] == $login && $account['password'] == md5($password)){

            $_SESSION['username'] = $account['name'];
            $_SESSION['user_id'] = $account['id'];
            header("Location: index.php");
            exit;
        }else echo '<p>Логин и пароль не верны!</p>';
    }
}
else {
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Автосервис : Планировщик</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <meta charset="UTF-8">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/dashboard.css">

        <script type="text/javascript" src="js/trash/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title"><h4 class="text-primary">Планировщик : Введите логин и пароль для
                            входа</h4></div>
                </div>
                <div style="padding-top:30px" class="panel-body">
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>


                    <form id="loginform" class="form-horizontal" role="form" method="POST" >
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control input-lg" name="user"
                                   value=""
                                   placeholder="Имя пользователя">
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control input-lg" name="pass"
                                   placeholder="Пароль">
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">

                                <input type="submit" name="submit" id="btn-login" class="btn btn-success btn-lg" value="Войти" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php
}
?>