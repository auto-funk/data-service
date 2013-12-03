<?php

use DataService\Model\Property;

class PropertyTest extends PHPUnit_Framework_TestCase
{
	private $property;

	public function testCompleteConstructor()
	{
		$this->property = new Property('Name1', 'type 1', 'description 1', 'pattern 1', 'format 1');
		$property1 = new Property('Name1', 'type 1', 'description 1', 'pattern 1', 'format 1');
		$this->assertEquals($property1, $this->property);
	}

	public function testConstructorNameType()
	{
		$this->property = new Property('Name1', 'type 1');
		$property1 = new Property('Name1', 'type 1');
		$this->assertEquals($property1, $this->property);
	}

	public function testConstructorNameTypeDescription()
	{
		$this->property = new Property('Name1', 'type 1', 'description 1');
		$property1 = new Property('Name1', 'type 1', 'description 1');
		$this->assertEquals($property1, $this->property);
	}

	public function testConstructorNameTypePattern()
	{
		$this->property = new Property('Name1', 'type 1', null, 'pattern 1');
		$property1 = new Property('Name1', 'type 1', null, 'pattern 1');
		$this->assertEquals($property1, $this->property);
	}

	public function testConstructorNameTypeFormat()
	{
		$this->property = new Property('Name1', 'type 1', null, null, 'format 1');
		$property1 = new Property('Name1', 'type 1', null, null, 'format 1');
		$this->assertEquals($property1, $this->property);
	}

	public function testConstructorNameTypeDescriptionPattern()
	{
		$this->property = new Property('Name1', 'type 1', 'description 1', 'pattern 1');
		$property1 = new Property('Name1', 'type 1', 'description 1', 'pattern 1');
		$this->assertEquals($property1, $this->property);
	}

	public function testConstructorNameTypeDescriptionFormat()
	{
		$this->property = new Property('Name1', 'type 1', 'description 1', null, 'format 1');
		$property1 = new Property('Name1', 'type 1', 'description 1', null, 'format 1');
		$this->assertEquals($property1, $this->property);
	}

	public function testConstructorNameTypePatternFormat()
	{
		$this->property = new Property('Name1', 'type 1', null, 'pattern1', 'format 1');
		$property1 = new Property('Name1', 'type 1', null, 'pattern1', 'format 1');
		$this->assertEquals($property1, $this->property);
	}

	public function testGetName()
	{
		$this->property = new Property('Name1', 'type 1', 'description 1', 'pattern 1', 'format 1');
		$this->assertEquals('Name1', $this->property->getName());
	}

	public function testGetNameNull()
	{
		$this->property = new Property(null, 'type 1', 'description 1', 'pattern 1', 'format 1');
		$this->assertEquals(null, $this->property->getName());
	}

	public function testGetType()
	{
		$this->property = new Property('Name1', 'type 1', 'decription 1', 'pattern 1', 'format 1');
		$this->assertEquals('type 1', $this->property->getType());
	}

	public function testGetTypeNull()
	{
		$this->property = new Property('Name1', null, 'description 1', 'pattern 1', 'format 1');
		$this->assertEquals(null, $this->property->getType());
	}

	public function testGetDescription()
	{
		$this->property = new Property('Name1', 'type 1', 'description 1', 'pattern 1', 'format 1');
		$this->assertEquals('description 1', $this->property->getDescription());
	}

	public function testGetFormat()
	{
		$this->property = new Property('Name1', 'type 1', 'description 1', 'pattern 1', 'format 1');
		$this->assertEquals('format 1', $this->property->getFormat());
	}

	public function testGetPattern()
	{
		$this->property = new Property('Name1', 'type 1', 'description 1', 'pattern 1', 'format 1');
		$this->assertEquals('pattern 1', $this->property->getPattern());
	}
}
