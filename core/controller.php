<?php

/**
 * Created by PhpStorm.
 * User: JonathanLesuperb
 * Date: 1/15/2017
 * Time: 1:19 PM
 */
class Controller
{
    public $vars = [];
    protected function set($array)
    {
        $this->vars = array_merge($this->vars, $array);
    }
    protected function detectLang()
    {
        if(isset($_SESSION['language']))
            return $_SESSION['language'];
        else
            return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
    }
    protected function isAjax()
    {
        //return isset($_SERVER["HTTP_X_REQUESTED"]) && $_SERVER["HTTP_X_REQUESTED"]=="Is-X-Requested";
        return true;
    }

    /**
     * @param array $result
     */
    protected function ajaxReturns($result)
    {
        if(isset($_SERVER["HTTP_X_REQUESTED_TYPE"]) && $_SERVER["HTTP_X_REQUESTED_TYPE"]=="XML")
        {
            header('Content-Type: application/xml');
            print json_encode($result);
        }
        else
        {
            header('Content-Type: application/json');
            print json_encode($result);
        }
    }

    protected function render($page = "")
    {
        if ($page != "")
        {
            if(is_file(ROOT . 'views/' . $page . '.php'))
            {
                header('Content-Type:text/html;charset=UTF-8');
                extract($this->vars);
                require_once(ROOT . 'views/' . $page . '.php');
            }
            else
            {
                App::internalError('');
            }
        }
        else
        {
            if(is_file(ROOT . 'views/' . str_replace('controller', '', strtolower(get_class($this))) . '/index.php'))
            {
                header('Content-Type:text/html;charset=UTF-8');
                extract($this->vars);
                require_once(ROOT . 'views/' . str_replace('controller', '', strtolower(get_class($this))) . '/index.php');
            }
            else
            {
                App::internalError('');
            }
        }
    }
    protected function ajaxUnknownMethod()
    {
        //http_response_code(404);
        $this->ajaxReturns(["isSucceeded"=>false,"error"=>"method-not-found"]);
    }
}