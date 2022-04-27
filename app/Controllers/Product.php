<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Product extends BaseController
{

    public function read_product($data = [])
    {
        header('Content-Type: application/json');

        $getQuery = $this->db->query("SELECT a.*, b.category_name FROM tbl_product a INNER JOIN tbl_category b ON a.category_id = b.category_id WHERE a.state = 'ACTIVE'");
        if ($getQuery->getResult())
        {
            foreach ($getQuery->getResult() as $product) 
            {
                $productState = '<span class="badge bg-light">ERROR</span>';
                if ($product->state == "ACTIVE")
                {
                    $productState = '<span class="badge bg-primary">'.$product->state.'</span>';

                }
                else if ($product->state == "INACTIVE") 
                {
                    $productState = '<span class="badge bg-danger">'.$product->state.'</span>';
                }

                $data[] = [
                    $product->product_id,
                    $productState,
                    $product->sku,
                    $product->product_name,
                    $product->category_name,
                    $product->current_stock,
                    $product->ceiling_stock,
                    $product->flooring_stock,
                    $product->date_modified,
                    NULL
                ];
            }
        }

        echo json_encode(['data' => $data]);
    }

    public function create_product()
    {
        //
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
