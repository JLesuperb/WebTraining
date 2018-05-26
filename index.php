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
    case "about":
        define('CURRENT_PAGE','about');
        App::loadController('aboutController');
        $aboutController = new AboutController();
        if(isset($requests[1]) && !empty($requests[1]))
        {
            switch ($requests[1])
            {
                case 'author':
                    if((!isset($requests[2]) || empty(isset($requests[2]))))
                        $aboutController->author();
                    else
                        App::foundError();
                    break;
                case 'summary':
                    if((!isset($requests[2]) || empty(isset($requests[2]))))
                        $aboutController->summary();
                    else
                        App::foundError();
                    break;
                case 'members':
                    if((!isset($requests[2]) || empty(isset($requests[2]))))
                    {
                        $aboutController->members();
                    }
                    else if(isset($requests[2]) && !empty($requests[2]) && (!isset($requests[3]) || empty(isset($requests[3]))))
                    {
                        $id = $requests[2];
                        $aboutController->membersDetail($id);
                    }
                    else
                        App::foundError();
                    break;
                default:
                    App::foundError();
                    break;
            }
        }
        else
        {
            App::foundError();
        }
        break;
    case "activities":
        define('CURRENT_PAGE','activities');
        App::loadController('activitiesController');
        $activitiesController = new ActivitiesController();
        if(!isset($requests[1])||empty($requests[1]))
        {
            $activitiesController->index();
        }
        else if(isset($requests[1]) && !empty($requests) && !isset($requests[2]))
        {
            $id = $requests[1];
            $activitiesController->detail($id);
        }
        else
        {
            App::foundError();
        }
        break;
    case "epa":
        define('CURRENT_PAGE','epa');
        App::loadController('epaController');
        $epaController = new EPAController();
        if(isset($requests[1]) && !empty($requests) && !isset($requests[2]))
        {
            switch ($requests[1])
            {
                case "registers":
                    $epaController->registers();
                    break;
                case "sign-up":
                    $epaController->signUp();
                    break;
                default:
                    App::foundError();
                    break;
            }
        }
        else
        {
            App::foundError();
        }
        break;
    case "medias":
        define('CURRENT_PAGE','medias');
        App::loadController('mediasController');
        $mediasController = new MediasController();
        if(isset($requests[1]) && !empty($requests[1]))
        {
            switch ($requests[1])
            {
                case "articles":
                    if((!isset($requests[2]) || empty(isset($requests[2]))))
                    {
                        $mediasController->articles();
                    }
                    else if(isset($requests[2]) && !empty($requests[2]) && (!isset($requests[3]) || empty(isset($requests[3]))))
                    {
                        $id = $requests[2];
                        $mediasController->articlesDetail($id);
                    }
                    else
                        App::foundError();
                    break;
                case "pictures":
                    if((!isset($requests[2]) || empty(isset($requests[2]))))
                    {
                        $mediasController->pictures();
                    }
                    else
                    {
                        App::foundError();
                    }
                    break;
                case "videos":
                    $mediasController->videos();
                    break;
                default:
                    App::foundError();
                    break;
            }
        }
        else
        {
            App::foundError();
        }
        break;
    case "programmes":
        define('CURRENT_PAGE','programmes');
        App::loadController('programmesController');
        $programmesController = new ProgrammesController();
        if(isset($requests[1]) && !empty($requests) && !isset($requests[2]))
        {
            switch ($requests[1])
            {
                case "education":
                    $programmesController->education();
                    break;
                case "health":
                    $programmesController->health();
                    break;
                case "protection":
                    $programmesController->protection();
                    break;
                case "partners":
                    $programmesController->partners();
                    break;
                case "leadership":
                    $programmesController->leadership();
                    break;
                case "kinds":
                    $programmesController->kinds();
                    break;
                default:
                    App::foundError();
                    break;
            }
        }
        else
        {
            App::foundError();
        }
        break;
    case "contact-us":
        define('CURRENT_PAGE','contact');
        App::loadController('contactController');
        $contactController = new ContactController();
        if(!isset($requests[1])||empty($requests[1]))
        {
            $contactController->index();
        }
        else
        {
            App::foundError();
        }
        break;
    case "themes":
        define('CURRENT_PAGE','themes');
        App::loadController('themesController');
        $themesController = new ThemesController();
        if(isset($requests[1]) && !empty($requests) && !isset($requests[2]))
        {
            switch ($requests[1])
            {
                case "education-development":
                    $themesController->firstEducation();
                    break;
                case "leadership-entrepreneurship":
                    $themesController->leadership();
                    break;
                case "health":
                    $themesController->health();
                    break;
                case "education-culture":
                    $themesController->secondEducation();
                    break;
                case "humans-right":
                    $themesController->humans();
                    break;
                case "protection":
                    $themesController->protection();
                    break;
                case "child-right":
                    $themesController->child();
                    break;
                case "culture-art":
                    $themesController->culture();
                    break;
                default:
                    App::foundError();
                    break;
            }
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