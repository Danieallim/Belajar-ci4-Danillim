<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Elektronik',
                'deskripsi'     => 'Produk-produk elektronik seperti laptop, HP, dan TV',
                'created_at'    => date("Y-m-d H:i:s"),
            ],
            [
                'nama_kategori' => 'Fashion',
                'deskripsi'     => 'Pakaian, sepatu, dan aksesoris',
                'created_at'    => date("Y-m-d H:i:s"),
            ],
            [
                'nama_kategori' => 'Makanan & Minuman',
                'deskripsi'     => 'Snack, minuman kemasan, dan kebutuhan harian',
                'created_at'    => date("Y-m-d H:i:s"),
            ],
        ];

        foreach ($data as $item) {
            $this->db->table('product_category')->insert($item);
        }
    }
}
