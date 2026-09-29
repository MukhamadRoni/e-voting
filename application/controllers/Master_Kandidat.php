<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_Kandidat extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kandidat_model');
        $this->load->library('form_validation');
    }

    /**
     * Helper standard JSON response
     */
    private function _json_response($status, $message, $data = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        $response = array(
            'status'  => $status, // 'success' atau 'error'
            'message' => $message,
        );

        if ($data !== null) {
            $response['data'] = $data;
        }

        echo json_encode($response);
        exit;
    }

    /**
     * Halaman Utama (SPA View Shell)
     * Hanya me-render kerangka UI. Seluruh data kandidat diisi via AJAX.
     */
    public function index()
    {
        $data['title']    = 'Data Kandidat';
        $data['username'] = $this->session->userdata('admin_username');

        $this->load->view('templates/header', $data);
        $this->load->view('master_kandidat/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * AJAX: Ambil semua data kandidat ketua & pengawas (JSON)
     */
    public function get_data()
    {
        $ketua    = $this->Kandidat_model->get_all_ketua();
        $pengawas = $this->Kandidat_model->get_all_pengawas();

        $this->_json_response('success', 'Data kandidat berhasil dimuat.', array(
            'ketua'    => $ketua,
            'pengawas' => $pengawas,
            'total_ketua'    => count($ketua),
            'total_pengawas' => count($pengawas)
        ));
    }

    /**
     * AJAX: Ambil detail 1 kandidat ketua by NIK (JSON)
     */
    public function get_ketua($nik)
    {
        $kandidat = $this->Kandidat_model->get_ketua_by_nik($nik);
        if (!$kandidat) {
            $this->_json_response('error', 'Data kandidat ketua tidak ditemukan.');
        }

        $this->_json_response('success', 'Data kandidat ketua ditemukan.', $kandidat);
    }

    /**
     * AJAX: Ambil detail 1 kandidat pengawas by NIK (JSON)
     */
    public function get_pengawas($nik)
    {
        $kandidat = $this->Kandidat_model->get_pengawas_by_nik($nik);
        if (!$kandidat) {
            $this->_json_response('error', 'Data kandidat pengawas tidak ditemukan.');
        }

        $this->_json_response('success', 'Data kandidat pengawas ditemukan.', $kandidat);
    }

    /**
     * AJAX: Tambah Kandidat Ketua (POST -> JSON)
     */
    public function tambah_ketua()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|is_unique[kandidat_ketua.nik]', array(
            'required'  => 'NIK wajib diisi.',
            'is_unique' => 'NIK sudah terdaftar sebagai kandidat ketua.'
        ));
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', array(
            'required' => 'Nama kandidat wajib diisi.'
        ));
        $this->form_validation->set_rules('visi_misi', 'Visi & Misi', 'required', array(
            'required' => 'Visi & Misi wajib diisi.'
        ));

        if ($this->form_validation->run() == FALSE) {
            $this->_json_response('error', validation_errors('<div>', '</div>'));
        }

        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $upload_res = $this->_upload_foto();
            if (!$upload_res['status']) {
                $this->_json_response('error', $upload_res['error']);
            }
            $foto = $upload_res['file_name'];
        }

        $insert = array(
            'nik'       => $this->input->post('nik', TRUE),
            'nama'      => $this->input->post('nama', TRUE),
            'foto'      => $foto,
            'visi_misi' => $this->input->post('visi_misi'),
        );

        $this->Kandidat_model->insert_ketua($insert);
        $this->_json_response('success', 'Kandidat ketua berhasil ditambahkan.');
    }

    /**
     * AJAX: Tambah Kandidat Pengawas (POST -> JSON)
     */
    public function tambah_pengawas()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|is_unique[kandidat_pengawas.nik]', array(
            'required'  => 'NIK wajib diisi.',
            'is_unique' => 'NIK sudah terdaftar sebagai kandidat pengawas.'
        ));
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', array(
            'required' => 'Nama kandidat wajib diisi.'
        ));
        $this->form_validation->set_rules('visi_misi', 'Visi & Misi', 'required', array(
            'required' => 'Visi & Misi wajib diisi.'
        ));

        if ($this->form_validation->run() == FALSE) {
            $this->_json_response('error', validation_errors('<div>', '</div>'));
        }

        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $upload_res = $this->_upload_foto();
            if (!$upload_res['status']) {
                $this->_json_response('error', $upload_res['error']);
            }
            $foto = $upload_res['file_name'];
        }

        $insert = array(
            'nik'       => $this->input->post('nik', TRUE),
            'nama'      => $this->input->post('nama', TRUE),
            'foto'      => $foto,
            'visi_misi' => $this->input->post('visi_misi'),
        );

        $this->Kandidat_model->insert_pengawas($insert);
        $this->_json_response('success', 'Kandidat pengawas berhasil ditambahkan.');
    }

    /**
     * AJAX: Edit/Update Kandidat Ketua (POST -> JSON)
     */
    public function edit_ketua($nik)
    {
        $kandidat = $this->Kandidat_model->get_ketua_by_nik($nik);
        if (!$kandidat) {
            $this->_json_response('error', 'Data kandidat ketua tidak ditemukan.');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', array(
            'required' => 'Nama kandidat wajib diisi.'
        ));
        $this->form_validation->set_rules('visi_misi', 'Visi & Misi', 'required', array(
            'required' => 'Visi & Misi wajib diisi.'
        ));

        if ($this->form_validation->run() == FALSE) {
            $this->_json_response('error', validation_errors('<div>', '</div>'));
        }

        $update = array(
            'nama'      => $this->input->post('nama', TRUE),
            'visi_misi' => $this->input->post('visi_misi'),
        );

        if (!empty($_FILES['foto']['name'])) {
            $upload_res = $this->_upload_foto();
            if (!$upload_res['status']) {
                $this->_json_response('error', $upload_res['error']);
            }

            // Hapus foto lama jika ada
            if ($kandidat->foto && file_exists('./assets/uploads/kandidat/' . $kandidat->foto)) {
                @unlink('./assets/uploads/kandidat/' . $kandidat->foto);
            }
            $update['foto'] = $upload_res['file_name'];
        }

        $this->Kandidat_model->update_ketua($nik, $update);
        $this->_json_response('success', 'Data kandidat ketua berhasil diperbarui.');
    }

    /**
     * AJAX: Edit/Update Kandidat Pengawas (POST -> JSON)
     */
    public function edit_pengawas($nik)
    {
        $kandidat = $this->Kandidat_model->get_pengawas_by_nik($nik);
        if (!$kandidat) {
            $this->_json_response('error', 'Data kandidat pengawas tidak ditemukan.');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', array(
            'required' => 'Nama kandidat wajib diisi.'
        ));
        $this->form_validation->set_rules('visi_misi', 'Visi & Misi', 'required', array(
            'required' => 'Visi & Misi wajib diisi.'
        ));

        if ($this->form_validation->run() == FALSE) {
            $this->_json_response('error', validation_errors('<div>', '</div>'));
        }

        $update = array(
            'nama'      => $this->input->post('nama', TRUE),
            'visi_misi' => $this->input->post('visi_misi'),
        );

        if (!empty($_FILES['foto']['name'])) {
            $upload_res = $this->_upload_foto();
            if (!$upload_res['status']) {
                $this->_json_response('error', $upload_res['error']);
            }

            // Hapus foto lama jika ada
            if ($kandidat->foto && file_exists('./assets/uploads/kandidat/' . $kandidat->foto)) {
                @unlink('./assets/uploads/kandidat/' . $kandidat->foto);
            }
            $update['foto'] = $upload_res['file_name'];
        }

        $this->Kandidat_model->update_pengawas($nik, $update);
        $this->_json_response('success', 'Data kandidat pengawas berhasil diperbarui.');
    }

    /**
     * AJAX: Hapus Kandidat Ketua (POST -> JSON)
     */
    public function hapus_ketua($nik)
    {
        $kandidat = $this->Kandidat_model->get_ketua_by_nik($nik);
        if (!$kandidat) {
            $this->_json_response('error', 'Data kandidat ketua tidak ditemukan.');
        }

        if ($kandidat->foto && file_exists('./assets/uploads/kandidat/' . $kandidat->foto)) {
            @unlink('./assets/uploads/kandidat/' . $kandidat->foto);
        }

        $this->Kandidat_model->delete_ketua($nik);
        $this->_json_response('success', 'Data kandidat ketua berhasil dihapus.');
    }

    /**
     * AJAX: Hapus Kandidat Pengawas (POST -> JSON)
     */
    public function hapus_pengawas($nik)
    {
        $kandidat = $this->Kandidat_model->get_pengawas_by_nik($nik);
        if (!$kandidat) {
            $this->_json_response('error', 'Data kandidat pengawas tidak ditemukan.');
        }

        if ($kandidat->foto && file_exists('./assets/uploads/kandidat/' . $kandidat->foto)) {
            @unlink('./assets/uploads/kandidat/' . $kandidat->foto);
        }

        $this->Kandidat_model->delete_pengawas($nik);
        $this->_json_response('success', 'Data kandidat pengawas berhasil dihapus.');
    }

    /**
     * Helper Upload Foto
     */
    private function _upload_foto()
    {
        $config['upload_path']   = './assets/uploads/kandidat/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['foto']['name']);

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto')) {
            return array('status' => true, 'file_name' => $this->upload->data('file_name'));
        }

        return array('status' => false, 'error' => $this->upload->display_errors('', ''));
    }
}
