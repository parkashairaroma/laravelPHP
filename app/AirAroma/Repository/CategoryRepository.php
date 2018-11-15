<?php

namespace AirAroma\Repository;
use AirAroma\Model\Category;

class CategoryRepository
{

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getCategories($options = [])
    {
        return $this->category->get();
    }
}
