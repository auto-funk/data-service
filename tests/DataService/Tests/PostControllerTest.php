<?php

namespace DataService\Tests;

use Silex\WebTestCase;

/**
 * Class PostControllerTest
 * @package DataService\Tests
 */
class PostControllerTest extends WebTestCase {

    public function createApplication()
    {
        return require __DIR__ . '/../../../data-service/app/data-service.php';
    }

    public function testEmptyRequest() {
        $client = $this->createClient();
        $crawler = $client->request('POST', '/models');
        $this->assertContains('Json data badly written', $crawler);
    }

    public function testRequestWithoutProperties() {
        $client = $this->createClient();
        $crawler = $client->request('POST','/models',array(), array(), array(), array(),
            '{"model": {"metadata":{"name":{"value":"People", "type":"string"}, "description": { "value":"Des personnes", "type":"string"}}}}');
        //Assert pour verifier que l'erreur properties est absente (ne marche pas pour l'instant, pb entre les tests validator et les tests verification
    }
}