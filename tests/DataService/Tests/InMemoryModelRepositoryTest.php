<?php

use DataService\Model\InMemoryModelRepository;
use DataService\Model\Model;
use DataService\Model\Property;

class PropertyTest extends PHPUnit_Framework_TestCase
{
	private $modelRepo;

	public function testConstructor()
	{
		$model = [new Model('Name1', 'Description 1', ['properties1'], ['filter1'])];
		$this->modelRepo = new InMemoryModelRepository($model);
		$model1 = [new Model('Name1', 'Description 1', ['properties1'], ['filter1'])];
		$modelRepo1 = new InMemoryModelRepository($model1);
		$this->assertEquals($modelRepo1, $this->modelRepo);
	}

	public function testFind()
	{
		$model = [new Model('Toto', 'Description 1', ['properties1'], ['filter1'])];
		$this->modelRepo = new InMemoryModelRepository($model);
		$this->assertEquals(new Model('Toto', 'Description 1', ['properties1'], ['filter1']), $this->modelRepo->find("Toto"));
	}

	/**
	 *	Return model list
	 */
	public function listConstruction()
	{
		$listProperty1 = [
		 		new Property('name1', 'string', 'description name1', 'pattern1')
			];
		$model1 = new Model('Tata', 'test de la description tata', $listProperty1,['filter taa']);

		$property2 = new Property('name2', 'string', 'description name2', 'pattern2');
		$property22 = new Property('name22', 'string', 'description name22', 'pattern22');
		$listProperty2 = array($property2, $property22);
		$model2 = new Model('Tutu', 'Description tutu', $listProperty2, ['filter tu']);


		$property3 = new Property('name3','string', 'description name3', 'pattern3');
		$listProperty3 = array($property3);
		$model3 = new Model('Titi', 'test de la description titi', $listProperty3,['filter tii']);

		$property44 = new Property('name22', 'string', 'description name22', 'pattern22');
		$listProperty4 = array($property44);
		$model4 = new Model('Totor', 'test de la description totor', $listProperty4,['filter tor']);

		$model = array($model1, $model2, $model3, $model4);

		return $model;
	}


	public function testFindAll()
	{
		$listModel = $this->listConstruction();

		$this->modelRepo = new InMemoryModelRepository($listModel);
		$this->assertEquals($listModel, $this->modelRepo->findAll());
	}

	public function testFindBy()
	{
		$listModel = $this->listConstruction();
		$m=array($listModel[1], $listModel[3]);
		$p22 = new Property('name22', 'string', 'description name22', 'pattern22');

		$this->modelRepo = new InMemoryModelRepository($listModel);
		$this->assertEquals($m, $this->modelRepo->findBy($p22));
	}

	public function testAdd()
	{
		$p5 = new Property('name5', 'string', 'description name5', 'pattern5');
		$ar5 = array($p5);
		$m5 = new Model('Tutur', 'test de la description tutur', $ar5,['filter tur']);

		$listModel = $this->listConstruction();

		$this->modelRepo = new InMemoryModelRepository($listModel);
		$this->modelRepo->add($m5);
		$listModel[] = $m5;

		$this->assertEquals($listModel, $this->modelRepo->findAll());
	}

	public function testRemove()
	{
		$p3 = new Property('name3','string', 'description name3', 'pattern3');
		$ar3 = array($p3);
		$m3 = new Model('Titi', 'test de la description titi', $ar3,['filter tii']);

		$listModel = $this->listConstruction();

		$this->modelRepo = new InMemoryModelRepository($listModel);
		$this->modelRepo->remove($m3);

		foreach($listModel as $key => $value){
            if($value == $m3){
                unset($listModel[$key]);
                $listModel = array_merge($listModel);
            }
        }
		$this->assertEquals($listModel, $this->modelRepo->findAll());
	}
}