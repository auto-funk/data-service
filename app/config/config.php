<?php

require_once __DIR__.'/../../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());

$app['validator.mapping.class_metadata_factory'] = new Symfony\Component\Validator\Mapping\ClassMetadataFactory(
    new Symfony\Component\Validator\Mapping\Loader\YamlFileLoader(__DIR__ . '/validation.yml')
);

return $app;
