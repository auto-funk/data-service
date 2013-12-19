<?php

namespace DataService\Model;

/**
 * Format the JSON file
 */
class JsonFormat
{
    /**
     * Return a model
     *
     * @param Model[Properties[],Metadata[],filters[]]
     * @return Model[]
     */
    public function modelFormat($tabModel)
    {
        if (is_array($tabModel)) {
            return array('model' => $tabModel);
        }

        return false;
    }

    /**
     * Return a model
     *
     * @param Model[Properties[],Metadata[],filters[]]
     */
    public function putFile($model)
    {
        $modele = array();
        $tabModel = $this->arrayFormat($model);
        $this->deleteFile();
        foreach ($tabModel as $value) {
            if (is_array($value["properties"]) && is_array($value["metadata"]) && is_array($value["filters"])) {
                $filters = $this->filtersFormat($value["filters"]);
                $modele = array('properties' => $value["properties"], 'metadata' => $value["metadata"], 'filters' => $filters);

                file_put_contents("testJSONFile.json", json_encode($this->modelFormat($modele)), FILE_APPEND | LOCK_EX);
            }
        }
    }

    /**
     * Delete old json file
     */
    public function deleteFile()
    {
        if (file_exists("testJSONFile.json")) {
            unlink("testJSONFile.json");
        }
    }

    /**
     * Return all the models
     *
     */
    public function getFile()
    {
        return file("testJSONFile.json");
    }

    /**
     * Return an array with models on the correct format
     *
     * @param Model[]
     * @return Model[]
     */
    public function arrayFormat($model)
    {
        $tabModel = array();
        if (count($model) == 1) {
            foreach ($model as $key => $value) {
                $tabModel[] = $value;
            }
        } elseif (count($model) >=2) {
            for ($i=0; $i < count($model); $i++) {
                $tabModel[$i] = $model[$i];
            }
        } else {
            $tabModel = null;
        }

        return $tabModel;
    }

    /**
     * Return an array with filters on the correct format
     *
     * @param filters[]
     * @return filters[]
     */
    public function filtersFormat($tabFilters)
    {
        $filter = array();
        for ($i = 0 ; $i < count($tabFilters) ; $i++) {
            $filter[]=array("name" => $tabFilters[$i]);
        }

        return $filter;
    }
}
