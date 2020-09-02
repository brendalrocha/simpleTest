<?php

require_once "model/CategoryDAO.php";
require_once "model/Category.php";
require_once "view/View.php";

use Valitron\Validator;

class CategoryController
{
    private $data;

    public function index()
    {
        $this->data = array();
        $catdao = new CategoryDAO();

        try {
            $categories = $catdao->selectAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->data['categories'] = $categories;

        View::load('view/template/header.html');
        View::load('view/category/index.php', $this->data);
        View::load('view/template/footer.html');
    }

    public function show($id)
    {
        $this->data = array();
        $catdao = new CategoryDAO();

        try {
            $categories = $catdao->select($id);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->data['categories'] = $categories;

        View::load('view/template/header.html');
        View::load('view/category/show.php', $this->data);
        View::load('view/template/footer.html');
    }

    public function create()
    {
        View::load('view/template/header.html');
        View::load('view/category/create.php');
        View::load('view/template/footer.html');
    }

    public function store($data)
    {
        try {
            $catDAO = new CategoryDAO();
            $v = new Validator($data);
            $v->rule('required', ['name', 'description']);
            if ($v->validate()) {
                $newCategory = new Category();
                $newCategory->setName($data['name']);
                $newCategory->setDescription($data['description']);
                $catDAO->insert($newCategory);
                header('location: index.php?category=index');
            } else {
                $this->data = [];
                $this->data['errors'] = $this->handleValidationErrors($v->errors());
                View::load('view/template/header.html');
                View::load('view/category/create.php', $this->data);
                View::load('view/template/footer.html');
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function edit($id)
    {
        $this->data = array();
        $catdao = new CategoryDAO();

        try {
            $categories = $catdao->select($id);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->data['categories'] = $categories;

        View::load('view/template/header.html');
        View::load('view/category/edit.php', $this->data);
        View::load('view/template/footer.html');
    }

    public function update($data)
    {
        try {
            $v = new Validator($data);
            $catdao = new CategoryDAO();
            $v->rule('required', ['name', 'description']);
            if ($v->validate()) {
                $categoryEdit = new Category();
                $categoryEdit->setId($data['id']);
                $categoryEdit->setName($data['name']);
                $categoryEdit->setDescription($data['description']);
                $catdao->update($categoryEdit);
                header('location: index.php?category=index');
            } else {
                $this->data = [];
                $categories = $catdao->select($data['id']);
                $this->data['categories'] = $categories;
                $this->data['errors'] = $this->handleValidationErrors($v->errors());
                View::load('view/template/header.html');
                View::load('view/category/edit.php', $this->data);
                View::load('view/template/footer.html');
            }
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function destroy($id)
    {
        $catdao = new CategoryDAO();
        try {
            $catdao->delete($id);
            header('location: index.php?category=index');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function handleValidationErrors($errors)
    {
        $data = [];
        foreach ($errors as $errors) {
            foreach ($errors as $validation) {
                array_push($data, $validation);
            }
        }
        return $data;
    }
}
