<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doc_capture extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Pemilih_model');
        $this->load->model('Kandidat_model');
        $this->load->model('Voting_model');
        $this->load->model('Undian_model');
        $this->load->model('Laporan_model');
    }

    public function login()
    {
        $data['title'] = 'Login Admin - E-Voting Koperasi';
        $this->load->view('auth/login', $data);
    }

    public function dashboard()
    {
        $data['title'] = 'Dashboard - E-Voting Koperasi';
        $data['username'] = 'Administrator RAT';
        $this->load->view('templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function master_pemilih()
    {
        $data['title']    = 'Data Pemilih (DPT)';
        $data['username'] = 'Administrator RAT';
        $data['pemilih']  = $this->Pemilih_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('master_user/index', $data);
        $this->load->view('templates/footer');
    }

    public function master_kandidat()
    {
        $data['title']    = 'Data Kandidat';
        $data['username'] = 'Administrator RAT';
        $data['ketua']    = $this->Kandidat_model->get_all_ketua();
        $data['pengawas'] = $this->Kandidat_model->get_all_pengawas();
        $this->load->view('templates/header', $data);
        $this->load->view('master_kandidat/index', $data);
        $this->load->view('templates/footer');
    }

    public function voting_identifikasi()
    {
        $data['title'] = 'Bilik Suara - E-Voting Koperasi';
        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/identifikasi', $data);
        $this->load->view('voting/template_footer');
    }

    public function voting_ketua()
    {
        $data['title'] = 'Bilik Suara - Pemilihan Ketua';
        $data['step']  = 1;
        $data['voter'] = array(
            'nik'  => '3271012304890001',
            'nama' => 'Budi Santoso, S.E.',
            'dept' => 'Divisi Operasional',
            'rfid' => 'E28011606000020488'
        );
        $data['kandidat'] = $this->Voting_model->get_all_ketua();
        $data['terpilih'] = !empty($data['kandidat']) ? $data['kandidat'][0]->nik : null;
        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/pilih_ketua', $data);
        $this->load->view('voting/template_footer');
    }

    public function voting_konfirmasi()
    {
        $data['title'] = 'Konfirmasi Pilihan Suara - E-Voting';
        $data['step']  = 3;
        $data['voter'] = array(
            'nik'  => '3271012304890001',
            'nama' => 'Budi Santoso, S.E.',
            'dept' => 'Divisi Operasional',
            'rfid' => 'E28011606000020488'
        );
        $ketua = $this->Voting_model->get_all_ketua();
        $pengawas = $this->Voting_model->get_all_pengawas();
        $data['ketua'] = !empty($ketua) ? $ketua[0] : null;
        $data['pengawas'] = !empty($pengawas) ? $pengawas[0] : null;
        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/konfirmasi', $data);
        $this->load->view('voting/template_footer');
    }

    public function bilik_undian()
    {
        $data['title']            = 'Bilik Undian Door Prize - RAT Koperasi';
        $data['admin_name']       = 'Administrator RAT';
        $data['total_tersisa']    = $this->Undian_model->count_peserta_tersisa();
        $data['daftar_pemenang']  = $this->Undian_model->get_all_pemenang();
        $data['daftar_dept']      = $this->Undian_model->get_daftar_departemen();
        $data['dept_terpilih']    = '';
        $this->load->view('bilik_undian/index', $data);
    }

    public function laporan_pemenang()
    {
        $data['title']         = 'Laporan Pemenang Ketua';
        $data['username']      = 'Administrator RAT';
        $data['rekap']         = $this->Laporan_model->get_rekap_ketua();
        $data['total_suara']   = $this->Laporan_model->get_total_suara_ketua();
        $data['total_pemilih'] = $this->Laporan_model->get_total_pemilih();
        $data['sudah_memilih'] = $this->Laporan_model->get_total_sudah_memilih();
        $this->load->view('templates/header', $data);
        $this->load->view('laporan/pemenang_ketua', $data);
        $this->load->view('templates/footer');
    }

    public function trace_back()
    {
        $data['title']         = 'Trace Back Suara';
        $data['username']      = 'Administrator RAT';
        $data['trace']         = $this->Laporan_model->get_trace_back();
        $data['total_suara']   = count($data['trace']);
        $this->load->view('templates/header', $data);
        $this->load->view('laporan/trace_back', $data);
        $this->load->view('templates/footer');
    }
}
