<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
 $app->get('/friends/all', function (Request $request,Response $response){
    $sql = 'SELECT * FROM friends';
     try {
         $db = new DB();
         $conn = $db->connect();
         $stmt = $conn->query($sql);
         $friends = $stmt->fetchAll(PDO::FETCH_OBJ);
         $db = null;
         $response->getBody()->write(json_encode($friends));
         return $response->withHeader('content-type', 'application/json')->withStatus(200);
     }catch (PDOException $e){
         $error = array(
             "Error Message:"=> $e->getMessage()
         );
         $response->getBody()->write(json_encode($error));
         return $response->withHeader('content-type', 'application/json')->withStatus(500);

     }

 });
$app->get('/friend/{ID}', function (Request $request,Response $response,array $args){
    $id = $args['ID'];
    $sql = "SELECT * FROM friends WHERE id = $id";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $friend = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        $response->getBody()->write(json_encode($friend));
        return $response->withHeader('content-type', 'application/json')->withStatus(200);
    }catch (PDOException $e){
        $error = array(
            "Error Message:"=> $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response->withHeader('content-type', 'application/json')->withStatus(500);

    }

});

$app->post('/friend/add', function (Request $request,Response $response,array $args){
    $email = $request->getParsedBody("email");
    $display_name = $request->getParsedBody("display_name");
    $phone = $request->getParsedBody("phone");
    $surname = $request->getParsedBody("surname");
    $sql = "INSERT INTO friends (email,display_name, surname, phone) VALUE (:email, :display_name, :phone, :surname)";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":email",$email);
        $stmt->bindParam(":display_name",$display_name);
        $stmt->bindParam(":phone",$phone);
        $stmt->bindParam(":surname",$surname);
        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response->withHeader('content-type', 'application/json')->withStatus(201);
    }catch (PDOException $e){
        $error = array(
            "Error Message:"=> $e->getMessage()
        );
        $response->getBody()->write(json_encode($error));
        return $response->withHeader('content-type', 'application/json')->withStatus(500);

    }

});



$app->get('/', function (Request $request, Response $response, $args) {

    $response->getBody()->write("Hello world");
    return $response;
});


?>