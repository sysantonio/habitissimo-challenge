<?php
require (__DIR__ . '/../vendor/autoload.php');
require (__DIR__ . '/../src/models/User.php');
require (__DIR__ . '/../src/models/Budget.php');
require (__DIR__ . '/../src/handlers/exceptions.php');


$config = include(__DIR__ . '/../src/config.php');

$app = new \Slim\App(['settings'=> $config]);
$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$capsule->getContainer()->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// Connect using the Laravel Database component
$conn = $capsule->connection();

//$app->get('/user/', function($request, $response) {
//    return $response->getBody()->write(User::all()->toJson());
//});
$app->get('/budgets/', '\App\Controller\BudgetController:list');

$app->get('/user/{email}/', function($request, $response, $args) {
    $email = $args['email'];
    $user = User::where('email', $email)->get();
    $response->getBody()->write($user);
    return $response;
});

$app->post('/budget/', function($request, $response, $args) {
    $data = $request->getParsedBody();
    $user = User::updateOrCreate($request);
    $budget = new User();
    $budget->fill($data);
    $budget->save();

    return $response->withStatus(201)->getBody()->write($budget->toJson());
});

$app->post('/user/', function($request, $response, $args) {
    $data = $request->getParsedBody();
    $user = new User();
    $user->fill($data);
    $user->save();
    return $response->withStatus(201)->getBody()->write($user->toJson());
});

$app->delete('/budget/{id}/', function($request, $response, $args) {
    $id = $args['id'];
    $budget = Budget::find($id);
    $budget->delete();

    return $response->withStatus(200);
});

$app->put('/budget/{id}/', function($request, $response, $args) {
    $id = $args['id'];
    $data = $request->getParsedBody();
    $budget = Budget::find($id);
    $budget->fill($data);
    $budget->save();

    return $response->getBody()->write($budget->toJson());
});

$app->run();
