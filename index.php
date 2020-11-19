<?php

// FRONT CONTROLLER

ini_set('display errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));

// Загрузка сайта
require_once(ROOT . '/application/bootstrap.php');
