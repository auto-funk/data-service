<?php

$app = require_once __DIR__ . '/config/config.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', function () {
    return 'Hello world!';
});

$request = Request::create('','',array(), array(), array(), array(),
    '{"model": { "properties": {"firstName":{"type":"string", "description":"Nom de la personne"}}, "metadata":{"name":{"value":"people", "type":"string"}, "description": { "value":"Des personnes", "type":"string"}}}}');
$request->headers->set('Accept', array('application/json'));
$request->headers->set('content_type', array('application/json'));

$before = function () use ($request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
};

/*
$description
$name
$filters
$properties
*/
$app->post('/models', function () use ($request, $app) {
    $model = json_decode($request->getContent());
    $right = false;
    if ($model != null){
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
                        for ($i = 0 ; $i < count($attributeList) ; $i ++) {
                            foreach ($attributeList as $key => $value) {
                                $name = $key;
                                $typeProperties = '';
                                $descriptionProperties = '';
                                $patternExist = false;
                                $formatExist = false;

                                if (strcmp($key, 'type') == 0) {
                                    $typeProperties = $value;
                                }
                                if (strcmp($key, 'description') == 0) {
                                    $descriptionProperties = $value;
                                }
                                if (strcmp($key, 'pattern') == 0) {
                                    $patternExist = true;
                                    $patternProperties = $value;
                                }
                                if (strcmp($key, 'format') == 0) {
                                    $formatExist = true;
                                    $formatProperties = $value;
                                }
                            }
                        }
                        if ($patternExist && $formatExist) {
                            $property = array(
                                'name' => $name,
                                'type' => $typeProperties,
                                'description' => $descriptionProperties,
                                'pattern' => $patternProperties,
                                'format' => $formatProperties
                            );
                        }
                        else {
                            if ($patternExist) {
                                $property = array(
                                    'name' => $name,
                                    'type' => $typeProperties,
                                    'description' => $descriptionProperties,
                                    'pattern' => $patternProperties
                                );
                            }
                            else {
                                if ($formatExist) {
                                    $property = array(
                                        'name' => $name,
                                        'type' => $typeProperties,
                                        'description' => $descriptionProperties,
                                        'format' => $formatProperties
                                    );
                                }
                                else {
                                    $property = array(
                                        'name' => $name,
                                        'type' => $typeProperties,
                                        'description' => $descriptionProperties
                                    );
                                }
                            }
                        }
                        array_push($properties, $property);
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
    return new Response('New model created', 200);
})
    ->before($before)
    ->method('GET|POST');

return $app;
