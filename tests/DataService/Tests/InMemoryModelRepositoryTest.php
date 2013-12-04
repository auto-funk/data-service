<?php

use DataService\Model\InMemoryModelRepository;
use DataService\Model\Model;
use DataService\Model\Property;

class PropertyTest extends PHPUnit_Framework_TestCase
{
    private $modelRepo;


    public function testFind()
    {
        $model = new Model('Toto', 'Description 1', ['properties1'], ['filter1']);
        $repo = new InMemoryModelRepository([$model]);
        $this->assertSame($model, $repo->find("Toto"));
    }

    public function testFindReturnsNullIfNameNotFound()
    {
        $model = new Model('Toto', 'Description 1', ['properties1'], ['filter1']);
        $repo = new InMemoryModelRepository([$model]);
        $this->assertSame(null, $repo->find("Titi"));
    }

    public function testFindAll()
    {
        $listModel = $this->getModels();

        $this->modelRepo = new InMemoryModelRepository($listModel);
        $this->assertEquals($listModel, $this->modelRepo->findAll());
    }

    public function testFindBy()
    {
        $listModel = $this->getModels();
        $expected=array($listModel[1], $listModel[3]);
        $property22 = new Property('name22', 'string', 'description name22', 'pattern22');

        $this->modelRepo = new InMemoryModelRepository($listModel);
        $this->assertEquals($expected, $this->modelRepo->findBy($property22));
    }

    public function testAdd()
    {
        $p5 = new Property('name5', 'string', 'description name5', 'pattern5');
        $ar5 = array($p5);
        $m5 = new Model('Tutur', 'test de la description tutur', $ar5,['filter tur']);

        $nbModels = count($this->getModels());
        $this->assertCount($nbModels, $this->modelRepo->findAll());
        $this->assertNull($this->modelRepo->find("Tutur"));

        $this->modelRepo->add($m5);

        $this->assertCount($nbModels + 1, $this->modelRepo->findAll());
        $this->assertNotNull($this->modelRepo->find("Tutur"));
    }

    public function testRemove()
    {
        $p3 = new Property('name3','string', 'description name3', 'pattern3');
        $ar3 = array($p3);
        $m3 = new Model('Titi', 'test de la description titi', $ar3,['filter tii']);

        $nbModels = count($this->getModels());
        $this->assertCount($nbModels, $this->modelRepo->findAll());
        $this->assertNotNull($this->modelRepo->find("Titi"));

        $this->modelRepo->remove($m3);

        $this->assertCount($nbModels - 1, $this->modelRepo->findAll());
        $this->assertNull($this->modelRepo->find("Titi"));
    }


    protected function setUp()
    {
        $this->modelRepo = new InMemoryModelRepository($this->getModels());
    }

     /**
     *  Return model list
     */
    protected function getModels()
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
}
