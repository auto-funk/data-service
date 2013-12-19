<?php

namespace DataService\DataGenerator;

use DataService\Model\Model;

interface DataGeneratorInterface
{
    /**
     * Generate all model data.
     *
     * @param Model $model
     *
     * @return array
     */
    public function generateCollection(Model $model);
}
