<?php

$app = require_once __DIR__ . '/config/config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use DataService\Model\ModelType;
use DataService\Model\Model;


$app->get('/', function () {
    return 'Hello world!';
});

$request = Request::create('/models', 'POST', array(), array(), array(), array(), <<<JSON
{
    "model": {
        "properties": [
            {
                "name": "firstName",
                "type": "string"
            },
            {
                "name": "lastName",
                "type": "string",
                "description": "Nom de la personne"
            },
            {
                "name": "age",
                "type": "integer"
            }
        ],
        "metadata": {
            "name": "People",
            "description": "Des personnes"
        }
    }
}
JSON
);

$request->headers->set('Accept', array('application/json'));
$request->headers->set('Content-Type', 'application/json');

$before = function () use ($request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
};

$app->post('/models', function () use ($request, $app) {
    $form = $app['form.factory']->create(new ModelType());

    $form->handleRequest($request);
    if ($form->isValid()) {
        $data = $form->getData();

        //Save in database

        return new Response(var_dump($data), 201);
    }

    return new Response($form->getErrorsAsString(), 400);
})
->before($before)
->method('POST|GET');

return $app;
