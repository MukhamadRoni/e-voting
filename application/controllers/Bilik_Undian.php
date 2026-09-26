<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bilik_Undian extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Undian_model');
        $this->load->model('Auth_model');
    }

    /**
     * Halaman Utama Bilik Undian (Stage / Presentation Kiosk)
     * Dilindungi dengan autentikasi Admin
     */
    public function index()
    {
        // Cek apakah sudah terautentikasi khusus untuk bilik undian
        $isUndianAuth = $this->session->userdata('undian_authenticated');

        if (!$isUndianAuth) {
            $data['title'] = 'Akses Masuk Bilik Undian - Autentikasi Admin';
            $this->load->view('bilik_undian/auth_gate', $data);
            return;
        }

        $dept = $this->input->get('dept', TRUE);

        $data['title']            = 'Bilik Undian Door Prize - RAT Koperasi';
        $data['admin_name']       = $this->session->userdata('undian_admin_name') ?: $this->session->userdata('admin_username') ?: 'Admin';
        $data['total_tersisa']    = $this->Undian_model->count_peserta_tersisa($dept);
        $data['daftar_pemenang']  = $this->Undian_model->get_all_pemenang();
        $data['daftar_dept']      = $this->Undian_model->get_daftar_departemen();
        $data['dept_terpilih']    = $dept;

        $this->load->view('bilik_undian/index', $data);
    }

    /**
     * Proses Autentikasi Admin untuk Masuk ke Bilik Undian
     */
    public function auth_proses()
    {
        $username = trim($this->input->post('username', TRUE));
        $password = trim($this->input->post('password', TRUE));

        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username dan password admin wajib diisi.');
            redirect('bilik_undian');
            return;
        }

        $admin = $this->Auth_model->login($username, $password);

        if ($admin) {
            $this->session->set_userdata('undian_authenticated', TRUE);
            $this->session->set_userdata('undian_admin_name', $admin->username);
            $this->session->set_flashdata('success', 'Autentikasi berhasil. Selamat datang di Bilik Undian RAT!');
            redirect('bilik_undian');
        } else {
            $this->session->set_flashdata('error', 'Username atau password admin yang Anda masukkan salah.');
            redirect('bilik_undian');
        }
    }

    /**
     * Endpoint AJAX untuk Mengacak Calon Pemenang dari Peserta yang Tersisa
     */
    public function acak_ajax()
    {
        $dept = $this->input->get('dept', TRUE);
        $peserta = $this->Undian_model->get_peserta_berhak($dept);

        if (empty($peserta)) {
            echo json_encode(array(
                'status'  => 'empty',
                'message' => 'Tidak ada peserta yang memenuhi syarat. Seluruh anggota mungkin sudah memenangkan undian atau belum menggunakan hak suara.'
            ));
            return;
        }

        // Ambil 1 kandidat pemenang secara acak
        $index = array_rand($peserta);
        $calon = $peserta[$index];

        // Buat sample pool nama untuk animasi putar slot
        $pool = array();
        foreach ($peserta as $p) {
            $pool[] = array(
                'nik'  => $p->nik,
                'nama' => $p->nama,
                'dept' => $p->dept
            );
        }

        echo json_encode(array(
            'status' => 'success',
            'data'   => array(
                'nik'  => $calon->nik,
                'nama' => $calon->nama,
                'dept' => $calon->dept,
                'rfid' => $calon->rfid
            ),
            'pool'         => $pool,
            'sisa_peserta' => count($peserta)
        ));
    }

    /**
     * Endpoint AJAX untuk Menyimpan Pemenang Sah ke Database
     */
    public function simpan_pemenang_ajax()
    {
        $nik         = trim($this->input->post('nik', TRUE));
        $nama_hadiah = trim($this->input->post('nama_hadiah', TRUE)) ?: 'Door Prize Utama';
        $status      = trim($this->input->post('status', TRUE)) ?: 'valid';

        if (empty($nik)) {
            echo json_encode(array('status' => 'error', 'message' => 'NIK pemenang tidak valid.'));
            return;
        }

        $sukses = $this->Undian_model->simpan_pemenang($nik, $nama_hadiah, $status);

        if ($sukses) {
            $dept = $this->input->post('dept', TRUE);
            $sisa = $this->Undian_model->count_peserta_tersisa($dept);

            echo json_encode(array(
                'status'       => 'success',
                'message'      => 'Pemenang undian berhasil disimpan secara permanen.',
                'sisa_peserta' => $sisa
            ));
        } else {
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'Anggota ini sudah tercatat sebagai pemenang undian sebelumnya.'
            ));
        }
    }

    /**
     * Endpoint AJAX untuk Menghapus / Membatalkan Pemenang
     */
    public function hapus_pemenang_ajax($id)
    {
        $sukses = $this->Undian_model->hapus_pemenang($id);
        if ($sukses) {
            echo json_encode(array('status' => 'success', 'message' => 'Catatan pemenang berhasil dihapus.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus catatan pemenang.'));
        }
    }

    /**
     * Reset Seluruh Daftar Pemenang Undian
     */
    public function reset_semua()
    {
        $this->Undian_model->reset_semua_undian();
        $this->session->set_flashdata('success', 'Seluruh data pemenang undian telah direset.');
        redirect('bilik_undian');
    }

    /**
     * Keluar dari Bilik Undian / Kunci Layar
     */
    public function logout()
    {
        $this->session->unset_userdata('undian_authenticated');
        $this->session->unset_userdata('undian_admin_name');
        redirect('bilik_undian');
    }
}
