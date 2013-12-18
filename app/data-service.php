<?php

$app = require __DIR__ . '/config/config.php';

use DataService\Form\Type\ModelType;
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

$app->get('/{name}', function ($name) use ($app) {
    if (null === $modelName = $app['data_service.repository']->find($name)) {
        $app->abort(404, sprintf('Model "%s" not found.', $name));
    }
    $data = $app['data_service.data_generator']->generateCollection($modelName);

    return $app->json($data);
});

return $app;
