<?php

$app = require_once __DIR__ . '/config/config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DataService\Model\Model;
use DataService\Model\Property;
use DataService\Model\ValidatorArrayModel;

$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->get('/', function () {
    return 'Hello world!';
});

$request = Request::create('POST','',array(), array(), array(), array(),
    '{"model": { "properties": {"firstName":{"type":"string"},
    "lastName":{"type":"string", "description":"Nom de la personne"},
    "age":{"type":"integer"}}, "metadata":{"name":{"value":"People", "type":"string"},
    "description": { "value":"Des personnes", "type":"string"}}}}');
$request->headers->set('Accept', array('application/json'));
$request->headers->set('content_type', array('application/json'));

$before = function () use ($request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());

    }
};

$app->post('/models', function () use ($request, $app) {
    $arrayJSON = $request->request->all();
    $validatorModel = new ValidatorArrayModel($arrayJSON);
    if ($validatorModel->getArrayJSON() === array()) {
        return new Response('Json data badly written', 400);
    }
    if ($validatorModel->getMetadataFromJSON() === null) {
        return new Response('Json data badly written : No \'metadata\' tag', 400);
    }
    if ($validatorModel->getPropertiesFromJSON() === null) {
        return new Response('Json data badly written : No \'properties\' tag', 400);
    }

    $model = $validatorModel->getModel();
    $errorModel = false;
    $errors = $app['validator']->validate($model);
    if (count($errors) > 0) {
        $errorModel = true;
        echo 'Model errors: <br/>';
        foreach ($errors as $error) {
            echo $error->getPropertyPath().' '.$error->getMessage().'<br/>';
        }
        echo '<br/>';
    }
    if ($errorModel) {
        return new Response('Json data badly written: Problem in model', 400);
    }

    $properties = $validatorModel->getProperties();
    $countProperty = 0;
    $errorProperties = false;
    foreach ($properties as $property) {
        $errors = $app['validator']->validate($property);
        if (count($errors) > 0) {
            $errorProperties = true;
            echo 'Property '.$countProperty.' errors: <br/>';
            foreach ($errors as $error) {
                echo $error->getPropertyPath().' '.$error->getMessage().'<br/>';
            }
            echo '<br/>';
        }
        $countProperty ++;
    }
    if ($errorProperties) {
        return new Response('Json data badly written: Problem in properties', 400);
    }

    return new Response('Model '.$validatorModel->getName().' validated', 200);
})
->before($before)
->method('POST|GET');

return $app;
