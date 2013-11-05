<?php

$app = require_once __DIR__ . '/config/config.php';

$app->get('/', function () {
    return 'Hello!';
});

return $app;
