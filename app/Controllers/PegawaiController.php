<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class PegawaiController extends ResourceController
{
    protected $modelName = 'App\Models\Pegawai';
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = [
            'message' => 'success',
            'data_pegawai' => $this->model->orderBy('id', 'DESC')->findAll()
        ];

        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = [
            'message' => 'success',
            'pegawai_byid' => $this->model->find($id)
        ];

        if ($data['pegawai_byid'] == null) {
            return $this->failNotFound('Data pegawai tidak ditemukan');
        }

        return $this->respond($data, 200);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = $this->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'bidang' => 'required',
            'alamat' => 'required',
            'email' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $this->model->insert([
            'nama' => esc($this->request->getVar('nama')),
            'jabatan' => esc($this->request->getVar('jabatan')),
            'bidang' => esc($this->request->getVar('bidang')),
            'alamat' => esc($this->request->getVar('alamat')),
            'email' => esc($this->request->getVar('email')),
        ]);

        $response = [
            'message' => 'Data pegawai berhasil ditambahkan',
        ];

        return $this->respondCreated($response);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $rules = $this->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'bidang' => 'required',
            'alamat' => 'required',
            'email' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        // id pegawai
        $this->model->update($id, [
            'nama' => esc($this->request->getVar('nama')),
            'jabatan' => esc($this->request->getVar('jabatan')),
            'bidang' => esc($this->request->getVar('bidang')),
            'alamat' => esc($this->request->getVar('alamat')),
            'email' => esc($this->request->getVar('email')),
        ]);

        $response = [
            'message' => 'Data pegawai berhasil diubah',
        ];

        return $this->respond($response, 200);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->model->delete($id);

        $response = [
            'message' => 'Data pegawai berhasil dihapus',
        ];

        return $this->respondDeleted($response);
    }
}
