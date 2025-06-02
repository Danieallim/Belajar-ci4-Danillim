<?php

namespace App\Controllers;

use App\controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController{
    public function index()
    {
        return view('v_profile');
    }
}