<?php

namespace Bgies\EdiLaravel\Lib;


/**
 * 
 * @author rbgie_000
 *
 * Property Type is used to tell the front end how to compose the editable field
 */
class PropertyType
{
    public string $propertyType = 'string'; 
    public int $minLength = 0;
    public int $maxLength = 255;
    public bool $allowNull = true;
    public bool $required = false;
    public ?int $dataElement = null; 
    public bool $canEdit = true;
    public bool $displayInForm = true;
    
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct(string $propertyType,
       int $minLength, int $maxLength, bool $allowNull,
       bool $required, ?int $dataElement, ?bool $canEdit = true,
       ?bool $displayInForm = true)
    {
       $this->propertyType = $propertyType;
       $this->minLength = $minLength;
       $this->maxLength = $maxLength;
       $this->allowNull = $allowNull;
       $this->required = $required;
       $this->dataElement = $dataElement;       
       $this->canEdit = $canEdit;     
       $this->displayInForm = $displayInForm; 
    }
    
   
}