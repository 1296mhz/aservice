<?php include_once("auth.php"); ?>

<?php include_once("../Cshlovjah/Applications/Controller/Controller.php"); ?>
<?php
if (isset($_GET['get'])) {
    $req = $_GET['get'];
    switch ($req) {
        case 'currentDate':
            echo "dummy";
            break;
        case 'events':
            Controller::sendJson(Controller::getEvents($_SESSION['user_id'], $_SESSION['role'], $_GET['start'], $_GET['end']));
            break;
        case 'init':
            Controller::sendJson(Controller::getInitData($_SESSION['username']));
            break;
        case 'resources':
            Controller::sendJson(Controller::getResources($_SESSION['user_id'], $_SESSION['role']), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        case 'repairTypes':
            Controller::sendJson(Controller::getRepairTypes($_SESSION['user_id']), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        case 'humanResources':
            Controller::sendJson(Controller::getHumanResources($_SESSION['user_id'], $_SESSION['role']), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        case 'repairType':
            Controller::sendJson(Controller::getRepairType($_POST['boxid']), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        case 'getAllStatus':
            Controller::sendJson(Controller::getAllStatus(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        case 'search':
            Controller::sendJson(Controller::search($_POST['context'],$_POST['search']), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        case 'addEvent':
            Controller::sendJson(Controller::addHandlerEvent($_SESSION['user_id'],$_POST), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        case 'updateEvent':
            Controller::sendJson(Controller::updateHandlerEvent($_SESSION['user_id'],$_POST), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
        case 'watch':
            Controller::sendJson(Controller::dummy($_SESSION), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
    }

} else {
    $req = 'Научись НА КНОПКИ НАЖИМАТЬ!';
}
?>
<?php ?>

