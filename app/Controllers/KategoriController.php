<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class KategoriController extends BaseController
{
    protected $product_category; 
    protected $validation;

    function __construct()
    {
        $this->product_category = new CategoryModel();
    }

    public function index()
    {
        $product_category = $this->product_category->findAll();
        $data['product_category'] = $product_category;

        return view('v_kategori', $data);
    }

    public function create()
    {
        $dataForm = [
            'nama_kategori' => $this->request->getPost('nama'),
            'created_at' => date("Y-m-d H:i:s")
        ];

        $this->product_category->insert($dataForm);

        return redirect('kategori')->with('success', 'Data Berhasil Ditambah');
    }


    public function edit($id)
    {
        $dataForm = [
            'nama_kategori' => $this->request->getPost('nama'), 
            'updated_at' => date("Y-m-d H:i:s")
        ];
    
        $this->product_category->update($id, $dataForm);
    
        return redirect('kategori')->with('success', 'Data Berhasil Diubah');
    }
    

public function delete($id)
{
    $dataKategori = $this->product_category->find($id);

    $this->product_category->delete($id);

    return redirect('kategori')->with('success', 'Data Berhasil Dihapus');
}
}