<?php

// Подключение ядра сайта
require_once(ROOT . '/core/Router.php');
require_once(ROOT . '/core/Model.php');
require_once(ROOT . '/core/View.php');
require_once(ROOT . '/core/Controller.php');

// Создание объекта класса Router
$router = new Router();

// Вызов метода run() класса Router, который выполняет определение актуальной пары Controller/action по введённому запросу и дальнейший их вызов
$router->run();
