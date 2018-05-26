<?php
/**
 * Created by PhpStorm.
 * User: JonathanLesuperb
 * Date: 1/15/2017
 * Time: 1:34 PM
 */
try
{
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=otp_database","root","");
}
catch(Exception $e)
{
    die($e);
}

class DB
{
    /** @var PDO */
    protected $db;
    protected function initDB()
    {
        global $pdo;
        $this->db = $pdo;
    }
}