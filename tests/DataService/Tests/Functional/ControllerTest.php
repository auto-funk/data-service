<?php

namespace DataService\Tests\Functional;

use Silex\WebTestCase;

class ControllerTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../app/data-service.php';
        $app['debug'] = true;

        return $app;
    }

    public function testPostShouldReturn400IfNoDataProvided()
    {
        $client  = $this->createClient();
        $client->request('POST', '/models');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testPostShouldReturn201IfGoodRequest()
    {
        $client  = $this->createClient();
        $client->request('POST', '/models', array(), array(), array(), <<<JSON
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
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

}
