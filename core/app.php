<?php
/**
 * Created by PhpStorm.
 * User: JonathanLesuperb
 * Date: 1/15/2017
 * Time: 1:19 PM
 */
class App
{
    private static $email = '';

    const APP_MAME = 'Aquilla\'s Group';

    /**
     * @param string $file
     */
    public static function loadController($file)
    {
        if(is_file(ROOT.'controllers/'.$file.'.php'))
            require ROOT.'controllers/'.$file.'.php';
    }

    /**
     * @param string $file
     */
    public static function loadModel($file)
    {
        if(is_file(ROOT.'models/'.$file.'.php'))
            require ROOT.'models/'.$file.'.php';
    }
    /**
     * @param string $file
     */
    public static function loadData($file)
    {
        if(is_file(ROOT.'models/data/'.$file.'.php'))
            require ROOT.'models/data/'.$file.'.php';
    }

    /**
     * @param string $file
     */
    public static function loadViews($file)
    {
        if(is_file(ROOT.'views/'.$file.'.php'))
            require ROOT.'views/'.$file.'.php';
    }

    /**
     * @param string $file
     */
    public static function loadInclude($file)
    {
        if(is_file(ROOT.'includes/'.$file.'.php'))
            require ROOT.'includes/'.$file.'.php';
    }

    /**
     * @param string $location
     */
    public static function sendRedirect($location)
    {
        header('Location:'.WEB_ROOT.$location);
        exit();
    }
    public static function debug()
    {
        print __FILE__;
    }
    public static function unSetErrorCode($page)
    {
        if($page!='error' && isset($_SESSION['errorCode']))
            unset($_SESSION['errorCode']);
    }

    public static function loadLanguage($controller,$lang)
    {
        $languages = ['en'=>'english','fr'=>'french'];
        $folder = str_replace('controller', '', strtolower($controller));
        $file = (in_array($lang,$languages))?$folder.'/'.$languages[$lang].'.json':$folder.'/'.$languages['en'].'.json';
        $output='';
        $path = ROOT.'controllers/languages/'.$file;
        if (is_file($path))
        {
            $fh = fopen($path,'r');
            while ($line = fgets($fh))
            {
                $output.=$line;
            }
            fclose($fh);
            $output = json_decode($output,true);
        }
        else
        {
            App::internalError('');
            $output = null;
        }
        return $output;
    }
    public static function sendAdminMail($subject='',$text)
    {
        $headers = 'From : <'.App::$email.'>' . "\r\n";
        try
        {
            mail(App::$email, $subject, $text, $headers);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
    public static function currentURL()
    {
        return 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }
    public static function internalError($msg='')
    {
        http_response_code(500);
        /*print $msg."\n";
        print get_class()."\n";
        print_r(debug_backtrace());*/
        App::loadViews('errors/500');
        exit();
    }
    public static function foundError($msg='')
    {
        http_response_code(404);
        //print_r(debug_backtrace());
        App::loadViews('errors/404');
        exit();
    }
    public static function permissionError($msg='')
    {
        http_response_code(403);
        print_r(debug_backtrace());
        App::loadViews('errors/403');
        exit();
    }
    public static function oldUrl()
    {
        return (isset($_REQUEST["oldUrl"]))?"oldUrl=".$_REQUEST["oldUrl"]:"";
    }
    public static function getId()
    {
        return round(microtime(true)*1000);
    }

    public static function getPluginHost()
    {
    }
}