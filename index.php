<?php
/**
 * Created by IntelliJ IDEA.
 * User: JLesuperb
 * Date: 2017-11-12
 * Time: 2:21 AM
 */
define('WEB_ROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
define('ASSETS_ROOT',rtrim(WEB_ROOT,'/'));
define('ROOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
require 'core/app.php';
//require 'core/db.php';
require 'core/controller.php';
/** Check if the isset page  */
session_start();
if(!isset($_GET['page']))
{
    $_SESSION['errorCode'] = 404;
    App::sendRedirect('error?url=http://'.$_SERVER['SERVER_NAME'].''.$_SERVER['REQUEST_URI']);
}
$requests=explode('/',$_GET['page']);
App::unSetErrorCode($requests[0]);
switch ($requests[0])
{
    case "":
    case "home":
        define('CURRENT_PAGE','home');
        App::loadController('homeController');
        $homeController = new HomeController();
        if(!isset($requests[1])||empty($requests[1]))
        {
            $homeController->index();
        }
        else
        {
            App::foundError();
        }
        break;
    default:
        $_SESSION['errorCode'] = 404;
        App::loadController('errorController');
        $errorController = new ErrorController();
        $errorController->error();
        break;
}