<?php require "auth.php"; ?>

<?php include_once("../Cshlovjah/Applications/Controller/Forms.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="js/components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/dashboard.css">

    <link type="text/css" href="css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
    <link type="text/css" href='css/fullcalendar.css' rel='stylesheet'/>
    <link type="text/css" href='css/fullcalendar.print.css' rel='stylesheet' media='print'/>
    <link type="text/css" href='css/scheduler.css' rel='stylesheet'/>
<!--    <link type="text/css" href="css/docs.css" rel="stylesheet">-->
<!--    <link type="text/css" href="css/prettify.css" rel="stylesheet">-->
    <link type="text/css" href="css/cal.css" rel="stylesheet">
<!--    <link type="text/css" href="css/jquery-ui-1.10.0.custom.css" rel="stylesheet">-->
    <link type="text/css" href="css/jquery-ui-1.9.2.custom.css" rel="stylesheet">
    <link rel="stylesheet"
          href="js/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"/>
    <script type="text/javascript" src="js/jquery-1.12.3.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.js"></script>
    <script type="text/javascript" src="js/components/bootstrap/dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="js/components/underscore/underscore.js"></script>
    <script type="text/javascript" src='js/components/moment/min/moment-with-locales.min.js'></script>
    <script type="text/javascript"
            src="js/components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/components/bootstrap3-typeahead/bootstrap3-typeahead.js"></script>
    <script type="text/javascript" src="js/components/bootstrap-notify/bootstrap-notify.js"></script>
    <script type="text/javascript" src='js/components/moment/moment.js'></script>
    <script type="text/javascript" src='js/fullcalendar.js'></script>
    <script type="text/javascript" src='js/scheduler.min.js'></script>
    <script type="text/javascript" src='js/leftmenu.js'></script>
    <script type="text/javascript" src='js/functions.js'></script>
    <script type="text/javascript" src='js/validate.js'></script>
    <script type="text/javascript" src='js/app.test.js'></script>

    <title>Автосервис</title>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Запись в автосервис</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right">


                <!--Имя пользователя-->
                <li><a id="username"></a></li>
                <!--Группа-->

                <li><a id="role"></a></li>
                <li><a href="index.php?do=logout">Выход</a></li>

            </ul>
            <div class="nav navbar-nav navbar-right">
                <button class="btn btn-success navbar-btn" id="add_event_button">Добавить событие</button>
                <button class="btn btn-success navbar-btn" id="reload">Обновить</button>
                <button class="btn btn-danger navbar-btn btn-exit">Выйти</button>
            </div>
            <form class="navbar-nav navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Найти...">
            </form>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="leftMenu" id="todayLeftMenu"><a href="#">Сегодня <span class="badge">2</span></a></li>
                <li class="leftMenu" id="weekLeftMenu"><a href="#">Неделя <span class="badge">76</span></a></li>
                <li class="leftMenu" id="monthLeftMenu"><a href="#">Месяц <span class="badge">276</span></a></li>
                <li class="leftMenu" id="siteLeftMenu"><a href="#">Сайт <span class="badge">76</span></a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


            <div class="container-fluid">
                <div id="calendar"></div>
                <?php echo Forms::load(ADD_EVENT_FORM) ?>
                <?php echo Forms::load(EDIT_EVENT_FORM) ?>
        </div>
    </div>
        <div class="navbar-fixed-bottom row-fluid navbar-inverse">
            <div class="navbar-inner">
                <div class="container">
                    <span class="label label-info text-left">АнтилопаGNU</span>
                    </div>
                </div>
            </div>
</body>
</html>