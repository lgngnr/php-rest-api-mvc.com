<?php

namespace Vendor\Controllers;

use Vendor\Core as Core;
use Vendor\Popo;
use Vendor\Helpers\Helpers;

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
     * index function
     * According to the REQUEST_METHOD execute the correct CRUD OP
     * Return 405 if method not allowed
     *
     * @param array ...$args
     *
     * @return void
     */
    public function index(...$args)
    {
        // Check HTTP METHOD
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (Helpers::authorize()) {
                    if (count($args) == 1) {
                        $this->read($args[0]);
                    } else if (count($args) == 2) {
                        $this->readAll($args[0], $args[1]);
                    } else {
                        // 400 Bad Request
                        http_response_code(400);
                    }
                } else {
                    Helpers::unauthorized();
                }

                break;
            case 'POST':
                if (Helpers::authorize()) {
                    if (count($args) == 0) {
                        $this->create();
                    } else {
                        // 400 Bad Request
                        http_response_code(400);
                    }
                } else {
                    Helpers::unauthorized();
                }
                break;
            case 'PUT':
                if (Helpers::authorize()) {
                    if (count($args) == 0) {
                        $this->update();
                    } else {
                        // 400 Bad Request
                        http_response_code(400);
                    }
                } else {
                    Helpers::unauthorized();
                }
                break;
            case 'DELETE':
                if (Helpers::authorize()) {
                    if (count($args) == 1) {
                        $this->delete($args[0]);
                    } else {
                        // 400 Bad Request
                        http_response_code(400);
                    }
                } else {
                    Helpers::unauthorized();
                }
                break;
            default:
                http_response_code(405);
                header('Access-Control-Allow-Method: GET,POST,PUT,DELETE');
        }
    }

    /**
     * create Crud function
     * Add a new product if is a POST
     *
     * @return void
     */
    private function create()
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
        if ($res) {
            $this->view(
                "products/index",
                array(
                    'message' => "New product created"
                )
            );
        } else {
            $this->view(
                "products/index",
                array(
                    'message' => "An error occurred"
                )
            );
        }
    }

    /**
     * read cRud function
     * It gets all products and load products/all view passing $data[]
     * @param integer $id - product id
     * 
     * @return load requested view
     */
    private function read($id = null)
    {
        if (isset($id)) {
            // Sanitize $id
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            // Get product, format obj Popo\Product
            $product = $this->productModel->read($id);
            $data = array(
                'data' => $product->__getObj()
            );
            $this->view("products/index", $data);
        } else {
            // 400 Bad Request
            http_response_code(400);
        }
    }

    /**
     * update crUd function
     * Update a product if is a PUT
     *
     * @return void
     */
    private function update()
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
        if ($res) {
            $this->view(
                "products/index",
                array(
                    'message' => "Product updated"
                )
            );
        } else {
            $this->view(
                "products/index",
                array(
                    'message' => "An error occurred"
                )
            );
        }
    }

    /**
     * delete cruD function
     * Delete a product if is a DELETE, send 405 Method not allowed otherwise
     *
     * @return void
     */
    private function delete($id = null)
    {
        if (isset($id)) {
            // Sanitize $id
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            // Get product, format obj Popo\Product
            $res = $this->productModel->delete($id);

            if ($res) {
                $this->view(
                    "products/index",
                    array(
                        'message' => "Product deleted"
                    )
                );
            } else {
                $this->view(
                    "products/index",
                    array(
                        'message' => "An error occurred"
                    )
                );
            }
        } else {
            // 400 Bad Request
            http_response_code(400);
        }
    }

    /**
     * all function
     * It gets all products and load products/all view passing $data[]
     * @param integer $page - page number
     * @param integer $items - items/page
     * @return load requested view
     */
    private function readAll($page = null, $items = null)
    {
        // Sanitize page and intems
        $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
        $items = filter_var($items, FILTER_SANITIZE_NUMBER_INT);
        // Get all products, format array[] of obj
        $data = $this->productModel->readAll($page, $items);
        $this->view("products/index", $data);
    }
}
