<?php

$app = require_once __DIR__ . '/config/config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\FormServiceProvider;
use DataService\Model\ModelType;
use DataService\Model\Model;

$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new FormServiceProvider());

$app['validator.mapping.class_metadata_factory'] = new Symfony\Component\Validator\Mapping\ClassMetadataFactory(
    new Symfony\Component\Validator\Mapping\Loader\YamlFileLoader(__DIR__.'/../src/DataService/Model/validation.yml')
);

$app->get('/', function () {
    return 'Hello world!';
});

$request = Request::create('/models','POST',array(), array(), array(), array(),
    '{"model":{"properties":{"prop":{"name":"firstName", "type":"string"},
    "prop2":{"name":"lastName","type":"string","description":"Nom de la personne"},
    "prop3":{"name":"age","type":"integer"}},"metadata":{"name":"People","description":"Des personnes"}}}');
$request->headers->set('Accept', array('application/json'));
$request->headers->set('content_type', array('application/json'));

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
        return new Response('Model '.$data->getMetadata()->getName().' validated', 200);
    }

    return new Response('Json data badly written:', 400);
})
    ->before($before)
    ->method('POST|GET');

return $app;
