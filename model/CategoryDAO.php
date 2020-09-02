<?php

require_once "Category.php";
require_once "DAO.php";

class CategoryDAO extends DAO
{
    public function selectAll()
    {
        $sql = "SELECT c.id, c.name, c.description, 
                       (select count(1) from products where category_id = c.id) as product_count 
                FROM `categories` as c ORDER BY id";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category', ['name', 'description', 'id', 'product_count']);

            return $categories;
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function select($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id ORDER BY name";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category', ['name', 'description', 'id']);

            return $categories;
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function insert($category)
    {
        $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $this->connection->prepare($sql);

        $categoryName = $category->getName();
        $categoryDescription = $category->getDescription();

        $stmt->bindParam(':name', $categoryName);
        $stmt->bindParam(':description', $categoryDescription);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw $e;
            return false;
        }
    }

    public function update($category)
    {
        $sql = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->connection->prepare($sql);

        $categoryId = $category->getId();
        $categoryName = $category->getName();
        $categoryDescription = $category->getDescription();

        $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $categoryName, PDO::PARAM_STR);
        $stmt->bindParam(':description', $categoryDescription, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw $e;
            return false;
        }
    }

    public function delete($id)
    {
        $sql = "select count(1) as product_count from products where category_id = :id";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $products = $stmt->fetchAll();

            if($products[0]['product_count'] == 0)
            {
                $sql = "DELETE FROM categories WHERE id = :id";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindParam(':id', $id);

                try {
                    $stmt->execute();
                    return true;
                } catch (PDOException $e) {
                    throw new PDOException($e);
                }
            }

        } catch (PDOException $e) {
            throw new PDOException($e);
        }



    }
}
