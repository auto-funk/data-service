<?php

$app = require __DIR__ . '/config/config.php';

use DataService\Form\Type\ModelType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', function () {
    return 'Hello world!';
});

$app->post('/models', function (Request $request) use ($app) {
    $form = $app['form.factory']->create(new ModelType());
    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();

        //Save in database
        return new Response(null, 201);
    }

    return $app->abort(400, $form->getErrorsAsString());
});

// Example
// Make it generic
$app->get('/authors', function (Request $request) use ($app) {
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

    return $app['serializer']->serialize($data, $request->attributes->get('_format', 'json'));
});

return $app;
