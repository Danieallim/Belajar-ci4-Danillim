<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskonModel;

    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('failed', 'Akses ditolak.');
        }

        $today = date('Y-m-d');

        $data = [
            'diskon' => $this->diskonModel->orderBy('tanggal', 'ASC')->findAll(),
            'diskon_hari_ini' => $this->diskonModel->where('tanggal', $today)->first(),
        ];

        return view('v_diskon', $data); 
    }


    public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        return view('diskon/create');
    }

public function store()
{
    if (session()->get('role') !== 'admin') {
        return redirect()->to('/');
    }

    $rules = [
        'tanggal' => [
            'rules' => 'required|is_unique[diskon.tanggal]',
            'errors' => [
                'required' => 'Tanggal tidak boleh kosong.',
                'is_unique' => 'Diskon untuk tanggal ini sudah ada.',
            ]
        ],
        'nominal' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'Nominal tidak boleh kosong.',
                'numeric' => 'Nominal harus berupa angka.',
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('failed', $this->validator->listErrors());
    }

    $this->diskonModel->save([
        'tanggal' => $this->request->getVar('tanggal'),
        'nominal' => $this->request->getVar('nominal'),
    ]);

    return redirect()->to('/diskon')->with('success', 'Diskon berhasil ditambahkan.');
}


    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $data['diskon'] = $this->diskonModel->find($id);
        return view('diskon/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $rules = [
            'nominal' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->diskonModel->update($id, [
            'nominal' => $this->request->getVar('nominal'),
        ]);

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil diubah.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $this->diskonModel->delete($id);
        return redirect()->to('/diskon')->with('success', 'Diskon berhasil dihapus.');
    }
}
