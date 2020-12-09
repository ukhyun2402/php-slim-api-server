<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
// define('ROUTE_NAME_ANSWER', 'answer');

$db = new mysqli('localhost','root','','test');

$app = AppFactory::create();
$app->setBasePath("/api");

$app->get('/', function (Request $request, Response $response, $args) use ($app,$db) {
    $stmt = $db -> prepare("SHOW TABLES");
    $stmt->execute();
    $stmt->bind_result($data);
    $result = array();
    while($stmt->fetch()){
        array_push($result,$data);
    }
    $response->getBody()->write(var_export($result, true));
    return $response;
});

$app->get('/hello', function (Request $request, Response $response, $args) {
    $result = array("Hello" => "world");
    $response->getBody()->write(json_encode($result));
    return $response;
});

$app->run();