<?php

use GuzzleHttp\Client;

class Mahasiswa_model extends CI_Model
{
    private $_client;

    public function __construct()
    {
        $this->_client = new Client([
            'base_uri' => 'http://localhost/wpu/wpu-api/8.autentikasi-rest-server-ci/',
            'auth' => ['sandhika', 'wpu123']
        ]);
    }

    public function getAllMahasiswa()
    {
        // return $query = $this->db->get("mahasiswa")->result_array();
        $response = $this->_client->request('GET', 'mahasiswa', [
            'query' => [
                'wpu-key' => 'rahasia'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result['data'];
    }


    public function getMahasiswaById($id)
    {
        // return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
        $response = $this->_client->request('GET', 'mahasiswa', [
            'query' => [
                'wpu-key' => 'rahasia',
                'id' => $id
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result['data'][0];
    }


    public function tambahDataMahasiswa()
    {
        $data = [
            'nama' => $this->input->post('nama', true),
            'nrp' => $this->input->post('nrp', true),
            'email' => $this->input->post('email', true),
            'jurusan' => $this->input->post('jurusan'),
            'wpu_key' => 'rahasia'
        ];

        // $this->db->insert('mahasiswa', $data);
        $response = $this->_client->request('POST', 'mahasiswa', [
            'form_params' => $data
        ]);

        $result = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return $result;
    }


    public function hapusDataMahasiswa($id)
    {
        // $this->db->delete('mahasiswa', ['id' => $id]);
        $response = $this->_client->request('DELETE', 'mahasiswa', [
            'form_params' => [
                'id' => $id,
                'wpu-key' => 'rahasia'
            ]
        ]);

        $result = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return $result;
    }


    public function ubahDataMahasiswa()
    {
        $data = [
            'nama' => $this->input->post('nama', true),
            'nrp' => $this->input->post('nrp', true),
            'email' => $this->input->post('email', true),
            'jurusan' => $this->input->post('jurusan'),
            'id' => $this->input->post('id'),
            'wpu_key' => 'rahasia'
        ];
        // $this->db->where('id', $this->input->post('id'));
        // $this->db->update('mahasiswa', $data);

        $response = $this->_client->request('PUT', 'mahasiswa', [
            'form_params' => $data
        ]);

        $result = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return $result;
    }

    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        $this->db->or_like('nrp', $keyword);
        $this->db->or_like('email', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }
}
