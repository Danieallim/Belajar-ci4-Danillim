<?php 
namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
	protected $table = 'product_category'; 
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'nama_kategori','created_at','updated_at'
	];  
}