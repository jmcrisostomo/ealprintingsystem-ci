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
                        '<button id="btnDelete_'.$category->category_id.'" class="btn btn-danger btn-sm">DELETE</button>',
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
        header('Content-Type: application/json');

        if ($this->request->getMethod() == 'post')
        {
            $categoryName   = $this->request->getPost('category_name');
            
            if (empty($categoryName)) 
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
                'category_name' => $categoryName,
            ];
            
            $this->db->table('tbl_category')->insert($insertData);

            $response = [
                'status_code' => 200,
                'status'      => 'OK',
                'message'     => 'Category Created',
                'description' => 'Category Added',
            ];
            echo json_encode($response);
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
    public function update_category()
    {
        header('Content-Type: application/json');
        if ($this->request->getMethod() == 'post')
        {
            $categoryId     = $this->request->getPost('category_id');
            $categoryName   = $this->request->getPost('category_name');

            $updateData = [
                'category_name' => $categoryName,
            ];


            $builder = $this->db->table('tbl_category');
            $builder->set($updateData);
            $builder->where('category_id', $categoryId);
            if ($builder->update()) 
            {
                $response = [
                    'status_code' => 200,
                    'status'      => 'OK',
                    'message'     => 'Category Updated',
                    'description' => 'Category Updated',
                ];
                echo json_encode($response);
                // exit();
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
            // exit();
        }
        return redirect()->to(site_url(). 'admin/category');
    }
    public function delete_category()
    {
        header('Content-Type: application/json');
        if ($this->request->getMethod() == 'post')
        {
            $categoryId     = $this->request->getPost('category_id');


            $builder = $this->db->table('tbl_category');
            $builder->where('category_id', $categoryId);
            if ($builder->delete()) 
            {
                $response = [
                    'status_code' => 200,
                    'status'      => 'OK',
                    'message'     => 'Category DELETED',
                    'description' => 'Category DELETED',
                ];
                echo json_encode($response);
                // exit();
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
            // exit();
        }
        return redirect()->to(site_url(). 'admin/category');
    }
}
