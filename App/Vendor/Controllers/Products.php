<?php

namespace Vendor\Controllers;
use Vendor\Core as Core;

/**
 * Product Controller class
 * Handle CRUD ops for products
 */
class Products extends Core\Controller
{
    private $productModel;

    /**
     * __construct function
     * Istantiate Product Model
     */
    public function __construct()
    {
        $this->productModel = $this->model('Product');
    }

    /**
     * all function
     * It gets all products and load products/all view passing $data[]
     * @return load requested view
     */
    public function all($page = null, $items = null)
    {
        // Get all products, format array[] of obj
        $data = $this->productModel->readAll($page, $items);
        $this->view("products/all", $data);
    }
}
