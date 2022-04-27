<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Category extends BaseController
{
    public function read_category()
    {
        header('Content-Type: application/json');

        $getQuery = $this->db->query("SELECT * FROM tbl_category WHERE a.state = 'ACTIVE'");
        if ($getQuery->getResult())
        {
            foreach ($getQuery->getResult() as $product) 
            {
                $data[] = [
                    $product->category_id,
                    $product->state,
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
    public function create_category()
    {
        //
    }
    public function update_category()
    {
        //
    }
    public function delete_category()
    {
        //
    }
}
