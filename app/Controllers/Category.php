<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Category extends BaseController
{
    public function read_category()
    {
        header('Content-Type: application/json');

        $getQuery = $this->db->query("SELECT a.* FROM tbl_category a");
        if ($getQuery->getResult())
        {
            foreach ($getQuery->getResult() as $category) 
            {

                $categoryId = '<span data-category-id="'.$category->category_id.'">'.$category->category_id.'</span>';

                $categoryState = '<span class="badge bg-light">ERROR</span>';
                if ($category->state == "ACTIVE")
                {
                    $categoryState = '<span class="badge bg-primary">'.$category->state.'</span>';
                    $actionButton = [
                        '<button id="btnView_'.$category->category_id.'" class="btn btn-primary btn-sm me-1">VIEW</button>',
                        '<button id="btnDisable_'.$category->category_id.'" class="btn btn-warning btn-sm">DISABLE</button>',
                    ];
                }
                else if ($category->state == "INACTIVE") 
                {
                    $categoryState = '<span class="badge bg-danger">'.$category->state.'</span>';
                    $actionButton = [
                        '<button id="btnView_'.$category->category_id.'" class="btn btn-primary btn-sm me-1">VIEW</button>',
                        '<button id="btnEnable_'.$category->category_id.'" class="btn btn-success btn-sm me-1">ENABLE</button>',
                        '<button id="btnDelete_'.$category->category_id.'" class="btn btn-danger btn-sm">DELETE</button>',
                    ];
                }
                $actionButtonWrapper = '<div class="d-flex">'.implode($actionButton).'</div>';
                

                $data[] = [
                    $categoryId,
                    $categoryState,
                    $category->category_name,
                    $category->date_modified,
                    $actionButtonWrapper
                ];
            }
        }

        echo json_encode(['data' => $data]);
    }
    
    public function read_category_detail($categoryId, $data = [])
    {
        header('Content-Type: application/json');

        $getQuery = $this->db->query("SELECT a.* FROM tbl_category a WHERE a.category_id = $categoryId");
        if ($getQuery->getResult())
        {
            foreach ($getQuery->getResult() as $column => $category) 
            {
                $data[$column] = $category;
            }
        }

        echo trim(json_encode($data), '[]');
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
