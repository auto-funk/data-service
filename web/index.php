<?php

$app = require_once __DIR__ . '/../app/data-service.php';
$app = include_once __DIR__ . '/../app/stack.php';
Stack\run($app);
