<?php

require_once __DIR__.'/../../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new \KPhoen\Provider\FakerServiceProvider());

$app['validator.mapping.class_metadata_factory'] = new Symfony\Component\Validator\Mapping\ClassMetadataFactory(
    new Symfony\Component\Validator\Mapping\Loader\YamlFileLoader(__DIR__ . '/validation.yml')
);

$app['data_service.repository'] = $app->share(function () {
    return new DataService\Model\InMemoryModelRepository(require __DIR__ . '/fixtures.php');
});

$app['data_service.data_generator'] = $app->share(function () use ($app) {
    return new DataService\DataGenerator\FakerDataGenerator($app['faker']);
});

return $app;
