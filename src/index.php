<?php
require_once '/opt/lampp/htdocs/vendor/autoload.php';
require_once '/opt/lampp/htdocs/src/services/UserService.class.php';

session_start();

if ($_SERVER['REQUEST_URI'] === '/') {
    require './controllers/HomeController.class.php';
    $HomeController = new HomeController();
    $HomeController->index();
    exit;
}

$controller = explode('/', $_SERVER['REQUEST_URI'])[1];
if (count(explode('/', $_SERVER['REQUEST_URI'])) === 3) {
    $method = explode('/', $_SERVER['REQUEST_URI'])[2];
} else {
    $method = '';
}

if (!file_exists('./controllers/' . ucfirst($controller) . 'Controller.class.php')) {
    echo 'deze pagina bestaat niet';
    http_response_code(404);
    exit;
}

require './controllers/' . ucfirst($controller) . 'Controller.class.php';

if (!method_exists(ucfirst($controller) . 'Controller', $method)) {
    $className = ucfirst($controller) . 'Controller';
    $class = new $className();
    $class->index($method);
    exit;
}
$className = ucfirst($controller) . 'Controller';

$class = new $className();

$class->$method();
