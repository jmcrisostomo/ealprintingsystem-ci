<?php

namespace App\Controllers;

use App\Controllers\BaseController;
class Product extends BaseController
{

    public function read_product($data = [])
    {
        header('Content-Type: application/json');

        $getQuery = $this->db->query("SELECT a.*, b.category_name FROM tbl_product a INNER JOIN tbl_category b ON a.category_id = b.category_id");
        if ($getQuery->getResult())
        {
            foreach ($getQuery->getResult() as $product) 
            {
                
                $productId = '<span data-product-id="'.$product->product_id.'">'.$product->product_id.'</span>';

                $productState = '<span class="badge bg-light">ERROR</span>';
                if ($product->state == "ACTIVE")
                {
                    $productState = '<span class="badge bg-primary">'.$product->state.'</span>';
                    $actionButton = [
                        '<button id="btnView_'.$product->product_id.'" class="btn btn-primary btn-sm me-1">VIEW</button>',
                        '<button id="btnAddStock_'.$product->product_id.'" class="btn btn-primary btn-sm me-1">ADD STOCK</button>',
                        '<button id="btnDisable_'.$product->product_id.'" class="btn btn-warning btn-sm">DISABLE</button>',
                    ];
                }
                else if ($product->state == "INACTIVE") 
                {
                    $productState = '<span class="badge bg-danger">'.$product->state.'</span>';
                    $actionButton = [
                        '<button id="btnView_'.$product->product_id.'" class="btn btn-primary btn-sm me-1">VIEW</button>',
                        '<button id="btnEnable_'.$product->product_id.'" class="btn btn-success btn-sm me-1">ENABLE</button>',
                        '<button id="btnDelete_'.$product->product_id.'" class="btn btn-danger btn-sm">DELETE</button>',
                    ];
                }

                $productPrice = number_format($product->price, 2, '.', ',');
                $actionButtonWrapper = '<div class="d-flex">'.implode($actionButton).'</div>';

                $stocks = [
                    '<div class="d-flex mb-1">Current: <span class="badge bg-primary ms-auto">'.$product->current_stock.'</span></div>',
                    '<div class="d-flex mb-1">Ceiling: <span class="badge bg-primary ms-auto">'.$product->ceiling_stock.'</span></div>',
                    '<div class="d-flex mb-1">Flooring: <span class="badge bg-primary ms-auto">'.$product->flooring_stock.'</span></div>',
                ];

                $stockWrapper = '<div class="d-block">'.implode($stocks).'</div>';

                $dateModified = date("m/d/Y H:i A", strtotime($product->date_modified));

                $data[] = [
                    $productId,
                    $productState,
                    $product->sku,
                    $product->product_name,
                    $product->category_name,
                    $productPrice,
                    $stockWrapper,
                    $dateModified,
                    $actionButtonWrapper
                ];
            }
        }

        echo json_encode(['data' => $data]);
    }

    public function read_product_detail($productId, $data = [])
    {
        header('Content-Type: application/json');

        $getQuery = $this->db->query("SELECT a.*, b.category_name FROM tbl_product a INNER JOIN tbl_category b ON a.category_id = b.category_id WHERE a.product_id = $productId");
        if ($getQuery->getResult())
        {
            foreach ($getQuery->getResult() as $column => $product) 
            {
                $data[$column] = $product;
            }
        }

        echo trim(json_encode($data), '[]');
    }

    public function create_product($response = [])
    {
        header('Content-Type: application/json');
        
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
            $imageUpload   = $this->request->getFile('product_image');
            
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

            // file properties
            $fileName = urldecode($imageUpload->getClientName());
            $fileExt =  $imageUpload->getClientExtension();
            $imageUpload->move('assets/img/products/');


            $insertData = [
                'product_name'      => $productName,
                'description'       => $description,
                'category_id'       => $categoryID,
                'price'             => $price,
                'current_stock'     => 0,
                'ceiling_stock'     => $ceilingStock,
                'flooring_stock'    => $flooringStock,
                'sku'               => $sku,
                'product_image'     => $fileName,
                'product_image_ext' => $fileExt,
            ];
            
            if ( $this->db->table('tbl_product')->insert($insertData) )
            {
                $response = [
                    'status_code' => 200,
                    'status'      => 'OK',
                    'message'     => 'Product Created',
                    'description' => 'Product Added',
                ];
                echo json_encode($response);
                exit();
            }
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

    public function update_product()
    {
        //
    }

    public function delete_product()
    {
        //
    }
}
