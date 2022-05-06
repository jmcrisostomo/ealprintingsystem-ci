<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Test extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        // header('Content-Type: application/json');
        
        // print_r($this->request->getPostGet('product_name'));

        if ($this->request->getMethod() == 'post')
        {
            $productName   = $this->request->getPost('product_name');
            $description   = $this->request->getPost('description');
            $categoryID    = $this->request->getPost('category');
            $price         = $this->request->getPost('price');
            $sku           = $this->request->getPost('sku');
            $ceilingStock  = $this->request->getPost('ceiling_stock');
            $flooringStock = $this->request->getPost('flooring_stock');
            
            if (empty($productName) || empty($price)) 
            {
                $response = [
                    'status_code' => 422,
                    'status'      => 'Unprocessable entity',
                    'message'     => 'Incomplete Fields',
                    'description' => 'Please input the required fields',
                ];
                echo json_encode($response);
                exit();
            }

            $insertData = [
                'product_name'      => $productName,
                'description'       => $description,
                'category_id'       => $categoryID,
                'price'             => $price,
                'current_stock'     => 0,
                'ceiling_stock'     => $ceilingStock,
                'flooring_stock'    => $flooringStock,
                'sku'               => $sku,
                'product_image'     => NULL,
                'product_image_ext' => NULL,
            ];
            
            $this->db->insert('tbl_product', $insertData);
            exit();
        } 
        else
        {
            $response = [
                'status_code' => 405,
                'status'      => 'Method Not Allowed',
                'message'     => 'Method Not Allowed',
                'description' => 'Please use other request method',
            ];
            echo json_encode($response);
            exit();
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
