<?php

//namespace DataService\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/** Property class */
class Property
{
	/** Property name */
	private $name;

	/** Property type */
	private $type;

	/** Property description */
	private $description;

	/** Property pattern */
	private $pattern;

	/** Property format */
	private $format;

	/** Constructor property
	  * @param 	name 			property name
	  * @param 	type 		 	property type
	  * @param 	description 	property description
	  * @param 	pattern 		property pattern
	  * @param 	format 			property format (ex : for birth date)
	  */
	public function __construct($name, $type, $description=null, $pattern=null, $format=null)
	{
		$this->name = $name;
		$this->type = $type;
		if($description!=null)
		{
			$this->description = $description;
		}
		if($pattern!=null)
		{
			$this->pattern = $pattern;
		}
		if($format!=null)
		{
			$this->format = $format;
		}
	}

    /** Property validator
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('type', new Assert\NotBlank());
    }

	/** Return property name
	  * @return property name
	  */
	public function getName()
	{
		return $this->name;
	}

	/** Return property description
	  * @return property description
	  */
	public function getDescription()
	{
		return $this->description;
	}

	/** Return property type
	  * @return property type
	  */
	public function getType()
	{
		return $this->type;
	}

	/** Return property format
	  * @return property format
	  */
	public function getFormat()
	{
		return $this->format;
	}

	/** Return property pattern
	  * @return property pattern
	  */
	public function getPattern()
	{
		return $this->pattern;
	}
}