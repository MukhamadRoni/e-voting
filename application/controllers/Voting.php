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
        // Jika pemilih sedang dalam proses voting, arahkan ke halaman pemilihan
        if ($this->session->userdata('voter')) {
            redirect('voting/pilih');
            return;
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

        redirect('voting/pilih');
    }

    /**
     * Menu Utama Pemilihan: 1 Page untuk Memilih Ketua (Row 1) & Pengawas (Row 2)
     */
    public function pilih()
    {
        $voter = $this->session->userdata('voter');
        if (!$voter) {
            redirect('voting');
            return;
        }

        $data['title']            = 'Bilik Suara - Pilih Calon Ketua & Calon Pengawas';
        $data['voter']            = $voter;
        $data['kandidat_ketua']    = $this->Voting_model->get_all_ketua();
        $data['kandidat_pengawas'] = $this->Voting_model->get_all_pengawas();
        $data['step']             = 1;
        $data['terpilih_ketua']    = $this->session->userdata('pilihan_ketua') ?: '';
        $data['terpilih_pengawas'] = $this->session->userdata('pilihan_pengawas') ?: '';

        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/pilih', $data);
        $this->load->view('voting/template_footer');
    }

    /**
     * Backward-compatible alias untuk ketua -> arahkan ke halaman pilih
     */
    public function ketua()
    {
        redirect('voting/pilih');
    }

    /**
     * Backward-compatible alias untuk pengawas -> arahkan ke halaman pilih
     */
    public function pengawas()
    {
        redirect('voting/pilih');
    }

    /**
     * Backward-compatible alias untuk konfirmasi -> arahkan ke halaman pilih
     */
    public function konfirmasi()
    {
        redirect('voting/pilih');
    }

    /**
     * Final Submit: Kirim Suara ke Database
     */
    public function kirim_suara()
    {
        $voter        = $this->session->userdata('voter');
        $nik_ketua    = $this->input->post('ketua_nik', TRUE) ?: $this->session->userdata('pilihan_ketua');
        $nik_pengawas = $this->input->post('pengawas_nik', TRUE) ?: $this->session->userdata('pilihan_pengawas');

        if (!$voter || !$nik_ketua || !$nik_pengawas) {
            $this->session->set_flashdata('error', 'Silakan tentukan 1 Calon Ketua dan 1 Calon Pengawas sebelum mengirim suara.');
            redirect('voting/pilih');
            return;
        }

        // Validasi keberadaan kandidat
        $ketua    = $this->Voting_model->get_ketua_by_nik($nik_ketua);
        $pengawas = $this->Voting_model->get_pengawas_by_nik($nik_pengawas);

        if (!$ketua || !$pengawas) {
            $this->session->set_flashdata('error', 'Kandidat yang Anda pilih tidak valid.');
            redirect('voting/pilih');
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
        $data['step']  = 2;

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
