<?php

require_once "controller/CategoryController.php";
require_once "controller/ProductController.php";
require_once "vendor/autoload.php";

if (isset($_GET['product'])) {
    $product = new ProductController();
    switch ($_GET['product']) {
        case 'index':
            $product->index();
            break;
        case 'show':
            $product->show($_GET['id']);
            break;
        case 'create':
            $product->create();
            break;
        case 'store':
            $product->store($_POST);
            break;
        case 'destroy':
            $product->destroy($_GET['id']);
            break;
        case 'edit':
            $product->edit($_GET['id']);
            break;
        case 'update':
            $product->update($_POST);
            break;
        default:
            http_response_code(404);
    }
} elseif (isset($_GET['category'])) {
    $cat = new CategoryController();
    switch ($_GET['category']) {
        case 'index':
            $cat->index();
            break;
        case 'show':
            $cat->show($_GET['id']);
            break;
        case 'create':
            $cat->create();
            break;
        case 'store':
            $cat->store($_POST);
            break;
        case 'edit':
            $cat->edit($_GET['id']);
            break;
        case 'update':
            $cat->update($_POST);
            break;
        case 'destroy':
            $cat->destroy($_GET['id']);
            break;
        default:
            http_response_code(404);
    }
} else {
    $product = new ProductController();
    $product->index();
}
