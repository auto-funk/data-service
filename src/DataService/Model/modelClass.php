<?php

//namespace DataService\Model;

/** Model class */
class Model
{
	/** Model name */
	private $name;

	/** Model description */
	private $description;

	/** Model properties */
	private $properties=array();

	/** Model filters */
	private $filters=array();

	/** Constructor model
	  * @param 	name 			model name
	  * @param 	description 	model description
	  * @param 	properties 		model properties
	  * @param 	filters 		model filters
	  */
	public function __construct($name, $description=null, $properties=null, $filters=null)
	{
		$this->name = $name;
		if($description!=null)
		{
			$this->description = $description;
		}
		if($properties!=null)
		{
			if (is_array($properties))
			{
	            foreach ($properties as $key => $value)
	            {
	                $this->properties[$key] = $value;
	            }
	        }
	    }
		if($filters!=null)
		{
			$this->filters = $filters;
		}

	}

	/** Return model name
	  * @return model name
	  */
	public function getName()
	{
		return $this->name;
	}

	/** Return model description
	  * @return model description
	  */
	public function getDescription()
	{
		return $this->description;
	}

	/** Return model description
	  * @return model description
	  */
	public function getFilters()
	{
		return $this->filters;
	}

	/** Return model properties
	  * @return model properties
	  */
	public function getProperties()
	{
		return $this->properties;
	}

	/** Return one model property
	  * @param value 	property's value
	  * @return model property
	  */
	public function getProperty($value)
	{
		return $this->properties[$value];
	}
}