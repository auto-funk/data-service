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
        $this->validatorArrayModel = new ValidatorArrayModel(array('{"mod":"toto"}'));
        $this->assertEquals($this->validatorArrayModel->getArrayJSON(), array());
    }

    public function testRequestWithoutPropertiesTag() {
        $this->validatorArrayModel = new ValidatorArrayModel(array('{"model":{"metadata":{"name":{"value":"People", "type":"string"}, "description": { "value":"Des personnes", "type":"string"}}}'));
        $this->assertNull($this->validatorArrayModel->getPropertiesFromJSON());
    }

    public function testRequestWithoutMetadataTag() {
        $this->validatorArrayModel = new ValidatorArrayModel(array('{"model":{"properties":{"toto":"tata"}}}'));
        $this->assertNull($this->validatorArrayModel->getMetadataFromJSON());
    }
}  