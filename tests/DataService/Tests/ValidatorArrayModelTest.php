<?php

namespace DataService\Tests;

use DataService\Model\ValidatorArrayModel;

class ValidatorArrayModelTest extends TestCase {
	private $validatorArrayModel;

	public function testEmptyRequest() {
	    $this->validatorArrayModel = new ValidatorArrayModel(array());
	    $this->assertEquals($this->validatorArrayModel->getArrayJSON(), array());
	}

	public function testRequestWithoutModelTag() {
        $this->validatorArrayModel = new ValidatorArrayModel(json_decode('{"ml":"toto"}', true));
        $this->assertEquals($this->validatorArrayModel->getArrayJSON(), array());
        $this->assertNull($this->validatorArrayModel->getModel());
    }

    public function testRequestWithoutPropertiesTag() {
        $this->validatorArrayModel = new ValidatorArrayModel(json_decode('{"model":{"metadata":{"name":{"value":"People", "type":"string"}, "description": { "value":"Des personnes", "type":"string"}}}}', true));
        $this->assertNull($this->validatorArrayModel->getPropertiesFromJSON());
        $this->assertNotNull($this->validatorArrayModel->getMetadataFromJSON());
    }

    public function testRequestWithoutMetadataTag() {
        $this->validatorArrayModel = new ValidatorArrayModel(json_decode('{"model":{"properties":{"toto":"tata"}}}', true));
        $this->assertNull($this->validatorArrayModel->getMetadataFromJSON());
    }

    public function testGoodRequest() {
        $this->validatorArrayModel = new ValidatorArrayModel(json_decode('{"model": { "properties": {"firstName":{"type":"string"},
                                                                       "lastName":{"type":"string", "description":"Nom de la personne"},
                                                                       "age":{"type":"integer"}}, "metadata":{"name":{"value":"People", "type":"string"},
                                                                       "description": { "value":"Des personnes", "type":"string"}}}}', true));

        $this->assertNotNull($this->validatorArrayModel->getModel());
    }
}