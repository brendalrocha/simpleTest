<?php

class Category
{
    private $id;
    private $name;
    private $description;
    private $product_count;

    public function __construct($id = null, $name = null, $description = null, $product_count=null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->product_count = $product_count;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getProductCount()
    {
        return $this->product_count;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
}