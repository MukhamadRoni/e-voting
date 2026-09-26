<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
    }

    /**
     * Halaman Laporan Pemenang Ketua
     */
    public function pemenang_ketua()
    {
        $data['title']         = 'Laporan Pemenang Ketua';
        $data['username']      = $this->session->userdata('admin_username');
        $data['rekap']         = $this->Laporan_model->get_rekap_ketua();
        $data['total_suara']   = $this->Laporan_model->get_total_suara_ketua();
        $data['total_pemilih'] = $this->Laporan_model->get_total_pemilih();
        $data['sudah_memilih'] = $this->Laporan_model->get_total_sudah_memilih();

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/pemenang_ketua', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Halaman Laporan Pemenang Pengawas
     */
    public function pemenang_pengawas()
    {
        $data['title']         = 'Laporan Pemenang Pengawas';
        $data['username']      = $this->session->userdata('admin_username');
        $data['rekap']         = $this->Laporan_model->get_rekap_pengawas();
        $data['total_suara']   = $this->Laporan_model->get_total_suara_pengawas();
        $data['total_pemilih'] = $this->Laporan_model->get_total_pemilih();
        $data['sudah_memilih'] = $this->Laporan_model->get_total_sudah_memilih();

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/pemenang_pengawas', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Halaman Trace Back (Audit Trail Suara)
     */
    public function trace_back()
    {
        $data['title']         = 'Trace Back Suara';
        $data['username']      = $this->session->userdata('admin_username');
        $data['trace']         = $this->Laporan_model->get_trace_back();
        $data['total_suara']   = count($data['trace']);

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/trace_back', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Halaman Peserta Undian (Door Prize Anggota yang Telah Memilih)
     */
    public function peserta_undian()
    {
        $dept = $this->input->get('dept', TRUE);

        $data['title']         = 'Peserta Undian Door Prize';
        $data['username']      = $this->session->userdata('admin_username');
        $data['peserta']       = $this->Laporan_model->get_peserta_undian($dept);
        $data['daftar_dept']   = $this->Laporan_model->get_daftar_departemen();
        $data['dept_terpilih'] = $dept;
        $data['total_peserta'] = count($data['peserta']);
        $data['total_pemilih'] = $this->Laporan_model->get_total_pemilih();

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/peserta_undian', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Endpoint JSON untuk mengundi pemenang secara acak (Kocok Door Prize)
     */
    public function kocok_undian_ajax()
    {
        $dept = $this->input->get('dept', TRUE);
        $peserta = $this->Laporan_model->get_peserta_undian($dept);

        if (empty($peserta)) {
            echo json_encode(array('status' => 'empty', 'message' => 'Tidak ada peserta undian yang memenuhi syarat.'));
            return;
        }

        // Ambil 1 acak
        $index = array_rand($peserta);
        $pemenang = $peserta[$index];

        echo json_encode(array(
            'status' => 'success',
            'data'   => array(
                'nik'  => $pemenang->nik,
                'nama' => $pemenang->nama,
                'dept' => $pemenang->dept,
                'rfid' => $pemenang->rfid
            )
        ));
    }
}
