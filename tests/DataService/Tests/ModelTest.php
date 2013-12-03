<?php

use DataService\Model\Model;
use DataService\Model\Property;

class ModelTest extends PHPUnit_Framework_TestCase
{
	private $model;


	public function testConstructor()
	{
		$this->model = new Model('Name1', 'Description 1', ['properties1'], ['filter1']);
		$model1 = new Model('Name1', 'Description 1', ['properties1'], ['filter1']);
		$this->assertEquals($model1, $this->model);
	}

	public function testConstructorName()
	{
		$this->model = new Model('Name1');
		$model1 = new Model('Name1');
		$this->assertEquals($model1, $this->model);
	}
	public function testConstructorNameDescription()
	{
		$this->model = new Model('Name1', 'Description 1');
		$model1 = new Model('Name1', 'Description 1');
		$this->assertEquals($model1, $this->model);
	}

	public function testConstructorNameProperties()
	{
		$this->model = new Model('Name1', null, ['properties1']);
		$model1 = new Model('Name1', null, ['properties1']);
		$this->assertEquals($model1, $this->model);
	}

	public function testConstructorNameFilter()
	{
		$this->model = new Model('Name1', null, array(), ['filter 1']);
		$model1 = new Model('Name1', null, array(), ['filter 1']);
		$this->assertEquals($model1, $this->model);
	}

	public function testConstructorNameDescriptionProperties()
	{
		$this->model = new Model('Name1', 'Description 1', ['properties1']);
		$model1 = new Model('Name1', 'Description 1', ['properties1']);
		$this->assertEquals($model1, $this->model);
	}

	public function testConstructorNameDescriptionFilter()
	{
		$this->model = new Model('Name1', 'Description 1', array(), ['filter 1']);
		$model1 = new Model('Name1', 'Description 1', array(), ['filter 1']);
		$this->assertEquals($model1, $this->model);
	}

	public function testConstructorNamePropertiesFilter()
	{
		$this->model = new Model('Name1', null, ['properties1'], ['filter 1']);
		$model1 = new Model('Name1', null, ['properties1'], ['filter 1']);
		$this->assertEquals($model1, $this->model);
	}


	public function testGetName()
	{
		$this->model = new Model('Name1', 'Description 1', ['properties1'], ['filter1']);
		$this->assertEquals('Name1', $this->model->getName());
	}

	public function testGetNameNull()
	{
		$this->model = new Model(null, 'Description 1', ['properties1'], ['filter1']);
		$this->assertEquals(null, $this->model->getName());
	}

	public function testGetDescription()
	{
		$this->model = new Model('Name1', 'Description 1', ['properties1'], ['filter1']);
		$this->assertEquals('Description 1', $this->model->getDescription());
	}

	public function testGetFilters()
	{
		$this->model = new Model('Name1', 'Description 1', ['properties1'], ['filter1']);
		$this->assertEquals(['filter1'], $this->model->getFilters());
	}

	public function testGetProperties()
	{
		$this->model = new Model('Name1', 'Description 1', ['properties1'], ['filter1']);
		$this->assertEquals(['properties1'], $this->model->getProperties());
	}

	public function testGetProperty()
	{
		$property = new Property('name4','string', 'description name4', 'patter4');
		$this->model = new Model('Name1', 'Description 1', [new Property('name4','string', 'description name4', 'patter4')], ['filter1']);
		$this->assertEquals($property, $this->model->getProperty(0));
	}

	public function testGetPropertyNull()
	{
		$property = new Property('name4','string', 'description name4', 'patter4');
		$this->model = new Model('Name1', 'Description 1', [new Property('name4','string', 'description name4', 'patter4')], ['filter1']);
		$this->assertEquals(null, $this->model->getProperty(1));
	}

	public function testGetPropertyNullDefault()
	{
		$property = new Property('name4','string', 'description name4', 'patter4');
		$this->model = new Model('Name1', 'Description 1', [new Property('name4','string', 'description name4', 'patter4')], ['filter1']);
		$this->assertEquals(false, $this->model->getProperty(1,false));
	}
}
