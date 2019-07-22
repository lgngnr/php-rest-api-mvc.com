<?php

namespace Vendor\Controllers;

use Vendor\Core as Core;
use Vendor\Popo;

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

    public function index(...$args){
        $this->view(
            "products/index",
            array(
                'message' => "Hello",
                'data' => $args
            )
        );
    }

    /**
     * create Crud function
     * Add a new product if is a POST, send 405 Method not allowed otherwise
     *
     * @return void
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            // Get raw data
            $data = json_decode(file_get_contents("php://input"));
            
            //Sanitize data
            $data->name = filter_var($data->name, FILTER_SANITIZE_STRING);
            $data->category_id = filter_var($data->category_id, FILTER_SANITIZE_NUMBER_INT);
            $data->description = filter_var($data->description, FILTER_SANITIZE_STRING);
            $data->price = filter_var($data->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            
            // Fill Popo
            $product = new Popo\Product(
                0,
                $data->name,
                $data->category_id,
                $data->description,
                $data->price
            );
            // Create product
            $res = $this->productModel->create($product);
            // Check result
            if ($res) 
            {
                $this->view(
                    "products/index",
                    array(
                        'message' => "New product created"
                    )
                );
            } 
            else 
            {
                $this->view(
                    "products/index",
                    array(
                        'message' => "An error occurred"
                    )
                );
            }
        }
        else 
        {
            http_response_code(405);
            header('Access-Control-Allow-Method: POST');
        }
    }

    /**
     * read cRud function
     * It gets all products and load products/all view passing $data[]
     * @param integer $id - product id
     * 
     * @return load requested view
     */
    public function read($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($id))
        {
            // Sanitize $id
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            // Get product, format obj Popo\Product
            $product = $this->productModel->read($id);
            $data = array(
                'data' => $product->__getObj()
            );
            $this->view("products/index", $data);
        }
        else if(!isset($id))
        {
            // 400 Bad Request
            http_response_code(400);
        }
        else
        {
            // 405 Method Not Allowed
            http_response_code(405);
            header('Access-Control-Allow-Method: GET');
        }
    }

    /**
     * update crUd function
     * Update a product if is a PUT, send 405 Method not allowed otherwise
     *
     * @return void
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') 
        {

            // Get raw data
            $data = json_decode(file_get_contents("php://input"));
            
            //Sanitize data
            $data->id = filter_var($data->id, FILTER_SANITIZE_NUMBER_INT);
            $data->name = filter_var($data->name, FILTER_SANITIZE_STRING);
            $data->category_id = filter_var($data->category_id, FILTER_SANITIZE_NUMBER_INT);
            $data->description = filter_var($data->description, FILTER_SANITIZE_STRING);
            $data->price = filter_var($data->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            
            // Fill Popo
            $product = new Popo\Product(
                $data->id,
                $data->name,
                $data->category_id,
                $data->description,
                $data->price
            );

            // Create product
            $res = $this->productModel->update($product);
            // Check result
            if ($res) 
            {
                $this->view(
                    "products/index",
                    array(
                        'message' => "Product updated"
                    )
                );
            } 
            else 
            {
                $this->view(
                    "products/index",
                    array(
                        'message' => "An error occurred"
                    )
                );
            }
        } 
        else 
        {
            http_response_code(405);
            header('Access-Control-Allow-Method: PUT');
        }
    }

    /**
     * delete cruD function
     * Delete a product if is a DELETE, send 405 Method not allowed otherwise
     *
     * @return void
     */
    public function delete($id =null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($id))
        {
            // Sanitize $id
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            // Get product, format obj Popo\Product
            $res = $this->productModel->delete($id);
            
            if ($res) 
            {
                $this->view(
                    "products/index",
                    array(
                        'message' => "Product deleted"
                    )
                );
            } 
            else 
            {
                $this->view(
                    "products/index",
                    array(
                        'message' => "An error occurred"
                    )
                );
            }
        }
        else if(!isset($id))
        {
            // 400 Bad Request
            http_response_code(400);
        }
        else
        {
            // 405 Method Not Allowed
            http_response_code(405);
            header('Access-Control-Allow-Method: DELETE');
        }
    }

    /**
     * all function
     * It gets all products and load products/all view passing $data[]
     * @param integer $page - page number
     * @param integer $items - items/page
     * @return load requested view
     */
    public function all($page = null, $items = null)
    {
        // Sanitize page and intems
        $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
        $items = filter_var($items, FILTER_SANITIZE_NUMBER_INT);
        // Get all products, format array[] of obj
        $data = $this->productModel->readAll($page, $items);
        $this->view("products/index", $data);
    }
}
