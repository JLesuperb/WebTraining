<?php
/**
 * Created by IntelliJ IDEA.
 * User: JonathanLesuperb
 * Date: 2018/05/22
 * Time: 9:22 AM
 */

class HomeController extends Controller
{

    public function index()
    {
        $this->render('home/index');
    }
}