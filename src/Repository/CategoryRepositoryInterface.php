<?php

namespace App\Repository;

use App\Entity\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllCategory(): array;

    /**
     * @param int $categoryId
     * @return object
     */
    public function getOneCategory(int $categoryId): object;

    /**
     * @param Category $category
     * @return object
     */
    public function setCreateCategory(Category $category): object;

    /**
     * @param Category $category
     * @return object
     */
    public function setUpdateCategory(Category $category): object;

    /**
     * @param Category $category
     */
    public function setDeleteCategory(Category $category);

    /**
     * @return mixed
     */
    public function getFilterCategory();
}