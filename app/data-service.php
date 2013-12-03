<?php

$app = require_once __DIR__ . '/config/config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->register(new Silex\Provider\ValidatorServiceProvider());

require_once __DIR__ . '/../src/DataService/Model/modelClass.php';
require_once __DIR__ . '/../src/DataService/Model/propertyClass.php';

$app->get('/', function () {
    return 'Hello world!';
});

// Request created for testing
$request = Request::create('POST','',array(), array(), array(), array(),
    '{"model": {"metadata":{"name":{"value":"People", "type":"string"}, "description": { "value":"Des personnes", "type":"string"}}}}');/*
$request = Request::create('POST','',array(), array(), array(), array(),
    '{"model": { "properties": {"firstName":{"type":"string"}, "lastName":{"type":"string", "description":"Nom de la personne"}, "age":{"type":"integer"}}, "metadata":{"name":{"value":"People", "type":"string"}, "description": { "value":"Des personnes", "type":"string"}}}}');*/
$request->headers->set('Accept', array('application/json'));
$request->headers->set('content_type', array('application/json'));

$before = function () use ($request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
};

$app->post('/models', function () use ($request, $app) {
    $model = $request->request->model;

    $right = false;
    if ($model != null){
        $filters = null;
        $attributeList = get_object_vars($model);
        $existModel = false;
        $existProperties = false;
        $existMetadata = false;
        $existName = false;
        foreach ($attributeList as $key => $value) {
            if (strcmp($key, 'model') == 0) {
                $existModel = true;
            }
        }
        if ($existModel) {
            if (is_object($model->{'model'})) {
                $attributeList = get_object_vars($model->{'model'});
                foreach ($attributeList as $key => $value) {
                    if (strcmp($key, 'properties') == 0) {
                        $existProperties = true;
                    }
                    if (strcmp($key, 'metadata') == 0) {
                        $existMetadata = true;
                    }
                    if (strcmp($key, 'filters') == 0) {
                        if (is_object($model->{'model'}->{'filters'})) { // No else because filters are not required
                            $attributeList = get_object_vars($model->{'model'}->{'filters'});
                            foreach ($attributeList as $key => $value) {
                                $filters[$key] = $value;
                            }
                        }
                    }
                }
            }
            else {
                $right = true;
            }
        }
        else {
            $right = true;
        }
        if ($existProperties && $existMetadata) {
            if (is_object($model->{'model'}->{'properties'}) && is_object($model->{'model'}->{'metadata'})) {

                // Metadata
                $attributeList = get_object_vars($model->{'model'}->{'metadata'});
                $description = '';
                foreach ($attributeList as $key => $value) {
                    if (strcmp($key, 'name') == 0) {
                        $existName = true;
                    }
                    if (strcmp($key, 'description') == 0) {
                        if (is_object($model->{'model'}->{'metadata'}->{'description'})) { // No else because description is not required
                            $attributeList = get_object_vars($model->{'model'}->{'metadata'}->{'description'});
                            foreach ($attributeList as $key => $value) {
                                if (strcmp($key, 'type') == 0) {
                                    if (strcmp($value, 'string') == 0) {
                                        foreach ($attributeList as $key => $value) {
                                            if (strcmp($key, 'value') == 0) {
                                                $description = $value;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // Properties
                $attributeList = get_object_vars($model->{'model'}->{'properties'});
                $properties = array();
                foreach ($attributeList as $key => $value) {
                    if (is_object($model->{'model'}->{'properties'}->$key)) {
                        $attributeList = get_object_vars($model->{'model'}->{'properties'}->$key);
                        $nameProperty = $key;
                        $typeProperty = '';
                        $descriptionExist = false;
                        $patternExist = false;
                        $formatExist = false;
                        foreach ($attributeList as $key => $value) {

                            if (strcmp($key, 'type') == 0) {
                                $typeProperty = $value;
                            }
                            if (strcmp($key, 'description') == 0) {
                                $descriptionExist = true;
                                $descriptionProperty = $value;
                            }
                            if (strcmp($key, 'pattern') == 0) {
                                $patternExist = true;
                                $patternProperty = $value;
                            }
                            if (strcmp($key, 'format') == 0) {
                                $formatExist = true;
                                $formatProperty = $value;
                            }
                        }
                        if ($descriptionExist && $patternExist && $formatExist) {
                            $property = new Property($nameProperty, $typeProperty, $descriptionProperty, $patternProperty, $formatProperty);
                        }
                        else {
                            if ($descriptionExist) {
                                $property = new Property($nameProperty, $typeProperty, $descriptionProperty);
                            }
                            else {
                                if ($patternExist) {
                                    $property = new Property($nameProperty, $typeProperty, null, $patternProperty);
                                }
                                else {
                                    if ($formatExist) {
                                        $property = new Property($nameProperty, $typeProperty, null, null, $formatProperty);
                                    }
                                    else {
                                        if ($descriptionExist && $patternExist) {
                                            $property = new Property($nameProperty, $typeProperty, $descriptionProperty, $patternProperty);
                                        }
                                        else {
                                            if ($descriptionExist && $formatExist) {
                                                $property = new Property($nameProperty, $typeProperty, $descriptionProperty, null, $formatProperty);
                                            }
                                            else {
                                                if ($patternExist && $formatExist) {
                                                    $property = new Property($nameProperty, $typeProperty, null, $patternProperty, $formatProperty);
                                                }
                                                else {
                                                    $property = new Property($nameProperty, $typeProperty);

                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $errors = $app['validator']->validate($property);
                        if (count($errors) > 0) {
                            $right = true;
                            echo 'Properties errors: <br/>';
                            foreach ($errors as $error) {
                                echo $error->getPropertyPath().' '.$error->getMessage().'<br/>';
                            }
                            echo '<br/>';
                        }

                        if (count($errors) > 0) {
                            $right = true;
                        }
                        else {
                            array_push($properties, $property);
                        }
                    }
                    else {
                        $right = true;
                    }
                }
            }
            else {
                $right = true;
            }
        }
        else {
            $right = true;
        }
        if ($existName) {
            $existNameValue = false;
            if (is_object($model->{'model'}->{'metadata'}->{'name'})) {
                $attributeList = get_object_vars($model->{'model'}->{'metadata'}->{'name'});
                foreach ($attributeList as $key => $value) {
                    if (strcmp($key, 'type') == 0) {
                        if (strcmp($value, 'string') == 0) {
                            foreach ($attributeList as $key => $value) {
                                if (strcmp($key, 'value') == 0) {
                                    $name = $value;
                                    if ($name != null || strcmp(trim($name), '') != 0) {
                                        $existNameValue = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            else {
                $right = true;
            }
        }
        else {
            $right = true;
        }
    }
    else {
        $right = true;
    }
    if ($right || !$existNameValue) {
        return new Response('Json data badly written', 400);
    }
    else {
        $model = new Model($name, $description, $properties, $filters);
        $errors = $app['validator']->validate($model);
        if (count($errors) > 0) {
            echo 'Model errors: <br/>';
            foreach ($errors as $error) {
                echo $error->getPropertyPath().' '.$error->getMessage().'<br/>';
            }
            echo '<br/>';
            return new Response('Json data badly written', 400);
        }
        else {
            return new Response('Model '.$name.' created', 200);
        }
    }
})
->before($before)
->method('GET|POST');


return $app;
