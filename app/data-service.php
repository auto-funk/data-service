<?php

$app = require __DIR__ . '/config/config.php';

use DataService\Model\Property;
use DataService\Model\Model;
use DataService\Model\Metadata;
use DataService\Model\JsonFormat;
use DataService\Model\YamlModelRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', function () {
    return 'Hello world!';
});

$before = function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
};

$app->post('/models', function (Request $request) use ($app) {
    $form = $app['form.factory']->create(new ModelType());
    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();

        //Save in database
        return new Response(null, 201);
    }

    return $app->abort(400, $form->getErrorsAsString());
})->before($before);


$app->get('/model', function () {

    $file = new YamlModelRepository("persistence.don");
    $models = $file->findAll();

    $jsonFormat = new JsonFormat("modelsJson.json");
    $jsonFormat->putFile($models);
    $contentFile = $jsonFormat->getFile();

    $response = new Response(json_encode($contentFile));
    $response->headers->set('Content-Type', 'application/json');

    return $response;
});

// Example
// Make it generic
$app->get('/authors', function () use ($app) {
    if (null === $modelAuthor = $app['data_service.repository']->find('authors')) {
        $app->abort(404, sprintf('Model "%s" not found.', '...'));
    }

    // 1. DataGeneratorInterface
    // 2. DataGeneratorImpl (FakerDataGenerator)
    //
    //$data = $app['data_service.data_generator']->generateCollection($modelAuthor);

    $data = array('authors' => array(
        array('firstName' => 'John', 'lastName' => 'Doe', 'email' => 'john.doe@gmail.com'),
    ));

    return $app->json($data);
});


return $app;
