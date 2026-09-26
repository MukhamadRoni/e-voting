<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voting extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Voting_model');
    }

    /**
     * Halaman Awal Bilik Suara: Standby Layar Tap RFID / Input NIK
     */
    public function index()
    {
        // Jika pemilih sedang dalam proses voting, arahkan ke step berikutnya
        if ($this->session->userdata('voter')) {
            if (!$this->session->userdata('pilihan_ketua')) {
                redirect('voting/ketua');
                return;
            } elseif (!$this->session->userdata('pilihan_pengawas')) {
                redirect('voting/pengawas');
                return;
            } else {
                redirect('voting/konfirmasi');
                return;
            }
        }

        $data['title'] = 'Bilik Suara - E-Voting Koperasi';
        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/identifikasi', $data);
        $this->load->view('voting/template_footer');
    }

    /**
     * Proses Identifikasi Pemilih via RFID atau NIK
     */
    public function identifikasi()
    {
        $input = trim($this->input->post('input_identitas', TRUE));

        if (empty($input)) {
            $this->session->set_flashdata('error', 'Silakan tempelkan kartu RFID atau ketikkan NIK Anda.');
            redirect('voting');
            return;
        }

        $pemilih = $this->Voting_model->find_pemilih($input);

        if (!$pemilih) {
            $this->session->set_flashdata('error', 'Kartu RFID atau NIK <strong>' . html_escape($input) . '</strong> tidak terdaftar dalam Daftar Pemilih Tetap (DPT).');
            redirect('voting');
            return;
        }

        // Cek apakah sudah pernah voting
        if ($pemilih->pilih === 'T') {
            $this->session->set_flashdata('error', 'Anggota <strong>' . html_escape($pemilih->nama) . '</strong> (NIK: ' . $pemilih->nik . ') sudah menggunakan hak suara sebelumnya. Hak suara hanya dapat digunakan 1 kali.');
            redirect('voting');
            return;
        }

        // Set session pemilih
        $this->session->set_userdata('voter', array(
            'nik'  => $pemilih->nik,
            'nama' => $pemilih->nama,
            'dept' => $pemilih->dept,
            'rfid' => $pemilih->rfid
        ));

        // Bersihkan riwayat pilihan sebelumnya
        $this->session->unset_userdata('pilihan_ketua');
        $this->session->unset_userdata('pilihan_pengawas');

        redirect('voting/ketua');
    }

    /**
     * Step 1: Pemilihan Calon Ketua
     */
    public function ketua()
    {
        $voter = $this->session->userdata('voter');
        if (!$voter) {
            redirect('voting');
            return;
        }

        $data['title']     = 'Pilih Calon Ketua - E-Voting';
        $data['voter']     = $voter;
        $data['kandidat']  = $this->Voting_model->get_all_ketua();
        $data['step']      = 1;
        $data['terpilih']  = $this->session->userdata('pilihan_ketua');

        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/pilih_ketua', $data);
        $this->load->view('voting/template_footer');
    }

    /**
     * Proses Simpan Pilihan Ketua ke Session
     */
    public function pilih_ketua_proses()
    {
        $voter = $this->session->userdata('voter');
        if (!$voter) {
            redirect('voting');
            return;
        }

        $nik_ketua = $this->input->post('ketua_nik', TRUE);
        $kandidat  = $this->Voting_model->get_ketua_by_nik($nik_ketua);

        if (!$kandidat) {
            $this->session->set_flashdata('error', 'Kandidat ketua tidak valid.');
            redirect('voting/ketua');
            return;
        }

        $this->session->set_userdata('pilihan_ketua', $nik_ketua);
        redirect('voting/pengawas');
    }

    /**
     * Step 2: Pemilihan Calon Pengawas
     */
    public function pengawas()
    {
        $voter = $this->session->userdata('voter');
        if (!$voter) {
            redirect('voting');
            return;
        }

        if (!$this->session->userdata('pilihan_ketua')) {
            redirect('voting/ketua');
            return;
        }

        $data['title']     = 'Pilih Calon Pengawas - E-Voting';
        $data['voter']     = $voter;
        $data['kandidat']  = $this->Voting_model->get_all_pengawas();
        $data['step']      = 2;
        $data['terpilih']  = $this->session->userdata('pilihan_pengawas');

        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/pilih_pengawas', $data);
        $this->load->view('voting/template_footer');
    }

    /**
     * Proses Simpan Pilihan Pengawas ke Session
     */
    public function pilih_pengawas_proses()
    {
        $voter = $this->session->userdata('voter');
        if (!$voter || !$this->session->userdata('pilihan_ketua')) {
            redirect('voting');
            return;
        }

        $nik_pengawas = $this->input->post('pengawas_nik', TRUE);
        $kandidat     = $this->Voting_model->get_pengawas_by_nik($nik_pengawas);

        if (!$kandidat) {
            $this->session->set_flashdata('error', 'Kandidat pengawas tidak valid.');
            redirect('voting/pengawas');
            return;
        }

        $this->session->set_userdata('pilihan_pengawas', $nik_pengawas);
        redirect('voting/konfirmasi');
    }

    /**
     * Step 3: Konfirmasi Pilihan Sebelum Kirim
     */
    public function konfirmasi()
    {
        $voter = $this->session->userdata('voter');
        $nik_ketua = $this->session->userdata('pilihan_ketua');
        $nik_pengawas = $this->session->userdata('pilihan_pengawas');

        if (!$voter || !$nik_ketua || !$nik_pengawas) {
            redirect('voting');
            return;
        }

        $data['title']    = 'Konfirmasi Pilihan Suara - E-Voting';
        $data['voter']    = $voter;
        $data['ketua']    = $this->Voting_model->get_ketua_by_nik($nik_ketua);
        $data['pengawas'] = $this->Voting_model->get_pengawas_by_nik($nik_pengawas);
        $data['step']     = 3;

        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/konfirmasi', $data);
        $this->load->view('voting/template_footer');
    }

    /**
     * Final Submit: Kirim Suara ke Database
     */
    public function kirim_suara()
    {
        $voter        = $this->session->userdata('voter');
        $nik_ketua    = $this->session->userdata('pilihan_ketua');
        $nik_pengawas = $this->session->userdata('pilihan_pengawas');

        if (!$voter || !$nik_ketua || !$nik_pengawas) {
            redirect('voting');
            return;
        }

        $sukses = $this->Voting_model->simpan_suara($voter['nik'], $nik_ketua, $nik_pengawas);

        if ($sukses) {
            $nama_pemilih = $voter['nama'];

            // Bersihkan session voting
            $this->session->unset_userdata('voter');
            $this->session->unset_userdata('pilihan_ketua');
            $this->session->unset_userdata('pilihan_pengawas');

            $this->session->set_flashdata('nama_selesai', $nama_pemilih);
            redirect('voting/selesai');
        } else {
            $this->session->unset_userdata('voter');
            $this->session->unset_userdata('pilihan_ketua');
            $this->session->unset_userdata('pilihan_pengawas');

            $this->session->set_flashdata('error', 'Gagal memproses suara. Hak suara mungkin telah digunakan.');
            redirect('voting');
        }
    }

    /**
     * Halaman Sukses: Terima Kasih & Auto Countdown
     */
    public function selesai()
    {
        $data['title'] = 'Suara Berhasil Terkirim - E-Voting';
        $data['nama']  = $this->session->flashdata('nama_selesai') ?: 'Anggota';

        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/selesai', $data);
        $this->load->view('voting/template_footer');
    }

    /**
     * Batal Sesi Pemilih (Reset)
     */
    public function batal()
    {
        $this->session->unset_userdata('voter');
        $this->session->unset_userdata('pilihan_ketua');
        $this->session->unset_userdata('pilihan_pengawas');
        redirect('voting');
    }
}
