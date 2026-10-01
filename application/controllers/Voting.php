<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voting extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Voting_model');
        $this->_ensure_voting_params();
    }

    /**
     * Memastikan parameter tablet dan autofs selalu ada dan tampil di URL pada saat membuka bilik suara
     */
    private function _ensure_voting_params()
    {
        $currentMethod = $this->router->fetch_method();
        if (in_array($currentMethod, array('identifikasi', 'kirim_suara', 'get_kandidat'))) {
            return;
        }

        // Hanya untuk request browser non-AJAX dengan method GET
        if (!$this->input->is_ajax_request() && $this->input->get('ajax') !== '1' && $this->input->method() === 'get') {
            $tablet = $this->input->get('tablet', TRUE);
            $autofs = $this->input->get('autofs', TRUE);

            $needsRedirect = false;
            $params = $this->input->get(null, TRUE) ?: array();

            // 1. Pastikan parameter tablet selalu ada di URL
            if ($tablet === null || $tablet === '') {
                $savedTablet = $this->session->userdata('voting_tablet');
                $tablet = !empty($savedTablet) ? $savedTablet : '1';
                $params['tablet'] = $tablet;
                $needsRedirect = true;
            }

            // Simpan ke session bilik suara
            $this->session->set_userdata('voting_tablet', $tablet);

            // 2. Pastikan parameter autofs selalu ada di URL
            if ($autofs === null || $autofs === '') {
                $params['autofs'] = '1';
                $needsRedirect = true;
            }

            if ($needsRedirect) {
                // Susun urutan parameter: tablet terlebih dahulu, lalu autofs
                $orderedParams = array(
                    'tablet' => $params['tablet'],
                    'autofs' => $params['autofs']
                );
                unset($params['tablet'], $params['autofs']);
                $orderedParams = array_merge($orderedParams, $params);

                $uri = uri_string() ?: 'voting';
                redirect($uri . '?' . http_build_query($orderedParams));
                exit;
            }
        }
    }

    /**
     * Helper menyusun query string default bilik suara (memastikan parameter tablet dan autofs selalu ada)
     */
    private function _build_query_string($extra = array())
    {
        $tablet = $this->_get_tablet();
        $params = array(
            'tablet' => $tablet ?: '1',
            'autofs' => '1'
        );
        if (!empty($extra)) {
            $params = array_merge($params, $extra);
        }
        return '?' . http_build_query($params);
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
     * Helper mendeteksi dan menyimpan nomor tablet dari URL (?tablet=1) / Session
     */
    private function _get_tablet()
    {
        // 1. Cek dari parameter GET
        $tablet = $this->input->get('tablet', TRUE);

        // 2. Cek jika dikirim via Header HTTP (AJAX Kiosk SPA)
        if (($tablet === null || $tablet === '') && isset($_SERVER['HTTP_X_VOTING_TABLET'])) {
            $tablet = trim($_SERVER['HTTP_X_VOTING_TABLET']);
        }

        // 3. Simpan ke session CI jika ada nilai baru agar awet antar pemilih
        if ($tablet !== null && $tablet !== '') {
            $this->session->set_userdata('voting_tablet', $tablet);
        } else {
            $tablet = $this->session->userdata('voting_tablet');
        }

        return $tablet ?: '1';
    }

    /**
     * Halaman Awal Bilik Suara: Standby Layar Tap RFID / Input NIK (View Shell)
     */
    public function index()
    {
        $tablet = $this->_get_tablet();
        $data['tablet'] = $tablet;

        // Jika pemilih sedang dalam proses voting aktif, arahkan langsung ke bilik pemilihan
        if ($this->session->userdata('voter')) {
            redirect('voting/pilih' . $this->_build_query_string());
            return;
        }

        // Jika request via AJAX untuk kiosk seamless transition
        if ($this->input->is_ajax_request() || $this->input->get('ajax') === '1') {
            $data['title'] = 'Bilik Suara - E-Voting Koperasi';
            $this->_json_response('success', 'Layar standby dimuat.', array(
                'step'   => null,
                'voter'  => null,
                'tablet' => $tablet,
                'title'  => $data['title'],
                'html'   => $this->load->view('voting/identifikasi', $data, TRUE)
            ));
            return;
        }

        $data['title'] = 'Bilik Suara - E-Voting Koperasi';
        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/identifikasi', $data);
        $this->load->view('voting/template_footer', $data);
    }

    /**
     * AJAX: Proses Identifikasi Pemilih via RFID atau NIK (JSON)
     */
    public function identifikasi()
    {
        $input = trim($this->input->post('input_identitas', TRUE));

        if (empty($input)) {
            $this->_json_response('error', 'Silakan tempelkan kartu RFID atau ketikkan NIK Anda.');
        }

        $pemilih = $this->Voting_model->find_pemilih($input);

        if (!$pemilih) {
            $this->_json_response('error', 'Kartu RFID atau NIK <strong>' . html_escape($input) . '</strong> tidak terdaftar dalam Daftar Pemilih Tetap (DPT).');
        }

        // Cek apakah sudah pernah voting
        if ($pemilih->pilih === 'T') {
            $this->_json_response('error', 'Anggota <strong>' . html_escape($pemilih->nama) . '</strong> (NIK: ' . $pemilih->nik . ') sudah menggunakan hak suara sebelumnya. Hak suara hanya dapat digunakan 1 kali.');
        }

        // Set session pemilih
        $voterData = array(
            'nik'  => $pemilih->nik,
            'nama' => $pemilih->nama,
            'dept' => $pemilih->dept,
            'rfid' => $pemilih->rfid
        );
        $this->session->set_userdata('voter', $voterData);

        // Bersihkan riwayat pilihan sebelumnya jika ada
        $this->session->unset_userdata('pilihan_ketua');
        $this->session->unset_userdata('pilihan_pengawas');

        $this->_json_response('success', 'Identifikasi berhasil. Selamat datang, <strong>' . html_escape($pemilih->nama) . '</strong>.', array(
            'redirect' => site_url('voting/pilih' . $this->_build_query_string()),
            'voter'    => $voterData
        ));
    }

    /**
     * Menu Utama Pemilihan: Halaman Pemilihan Ketua & Pengawas (View Shell)
     */
    public function pilih()
    {
        $voter = $this->session->userdata('voter');
        if (!$voter) {
            redirect('voting' . $this->_build_query_string());
            return;
        }

        $tablet                   = $this->_get_tablet();
        $data['tablet']           = $tablet;
        $data['title']            = 'Bilik Suara - Pilih Calon Ketua & Calon Pengawas';
        $data['voter']            = $voter;
        $data['kandidat_ketua']    = $this->Voting_model->get_all_ketua();
        $data['kandidat_pengawas'] = $this->Voting_model->get_all_pengawas();
        $data['step']             = 1;
        $data['terpilih_ketua']    = $this->session->userdata('pilihan_ketua') ?: '';
        $data['terpilih_pengawas'] = $this->session->userdata('pilihan_pengawas') ?: '';

        // Jika request via AJAX untuk kiosk seamless transition (mencegah browser keluar fullscreen)
        if ($this->input->is_ajax_request() || $this->input->get('ajax') === '1') {
            $this->_json_response('success', 'Halaman bilik pemilihan dimuat.', array(
                'voter'  => $voter,
                'step'   => 1,
                'tablet' => $tablet,
                'title'  => $data['title'],
                'html'   => $this->load->view('voting/pilih', $data, TRUE)
            ));
            return;
        }

        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/pilih', $data);
        $this->load->view('voting/template_footer', $data);
    }

    /**
     * AJAX: Ambil Seluruh Data Kandidat (JSON)
     */
    public function get_kandidat()
    {
        $ketua    = $this->Voting_model->get_all_ketua();
        $pengawas = $this->Voting_model->get_all_pengawas();

        $this->_json_response('success', 'Data kandidat berhasil dimuat.', array(
            'ketua'    => $ketua,
            'pengawas' => $pengawas
        ));
    }

    /**
     * Backward-compatible aliases
     */
    public function ketua()      { redirect('voting/pilih'); }
    public function pengawas()   { redirect('voting/pilih'); }
    public function konfirmasi() { redirect('voting/pilih'); }

    /**
     * AJAX: Simpan Suara ke Database (JSON)
     */
    public function kirim_suara()
    {
        $voter        = $this->session->userdata('voter');
        $nik_ketua    = $this->input->post('ketua_nik', TRUE) ?: $this->session->userdata('pilihan_ketua');
        $nik_pengawas = $this->input->post('pengawas_nik', TRUE) ?: $this->session->userdata('pilihan_pengawas');
        $tablet       = $this->input->post('tablet', TRUE);
        if ($tablet === null || $tablet === '') {
            $tablet = $this->_get_tablet();
        }

        if (!$voter) {
            $this->_json_response('error', 'Sesi pemilihan Anda telah berakhir atau belum terdaftar. Silakan scan kartu kembali.', array(
                'redirect' => site_url('voting')
            ));
        }

        if (!$nik_ketua || !$nik_pengawas) {
            $this->_json_response('error', 'Silakan tentukan 1 Calon Ketua dan 1 Calon Pengawas sebelum mengirim suara.');
        }

        // Validasi keberadaan kandidat
        $ketua    = $this->Voting_model->get_ketua_by_nik($nik_ketua);
        $pengawas = $this->Voting_model->get_pengawas_by_nik($nik_pengawas);

        if (!$ketua || !$pengawas) {
            $this->_json_response('error', 'Kandidat yang Anda pilih tidak valid atau tidak terdaftar.');
        }

        $sukses = $this->Voting_model->simpan_suara($voter['nik'], $nik_ketua, $nik_pengawas, $tablet);

        if ($sukses) {
            $nama_pemilih = $voter['nama'];

            // Bersihkan session voting setelah sukses (jangan hapus voting_tablet agar tablet tetap teridentifikasi)
            $this->session->unset_userdata('voter');
            $this->session->unset_userdata('pilihan_ketua');
            $this->session->unset_userdata('pilihan_pengawas');
            $this->session->set_flashdata('nama_selesai', $nama_pemilih);

            $this->_json_response('success', 'Suara Anda berhasil dicatat secara resmi ke dalam sistem!', array(
                'redirect' => site_url('voting' . $this->_build_query_string()),
                'nama'     => $nama_pemilih
            ));
        } else {
            $this->session->unset_userdata('voter');
            $this->session->unset_userdata('pilihan_ketua');
            $this->session->unset_userdata('pilihan_pengawas');

            $this->_json_response('error', 'Gagal memproses suara. Hak suara mungkin telah digunakan sebelumnya.', array(
                'redirect' => site_url('voting' . $this->_build_query_string())
            ));
        }
    }

    /**
     * Halaman Sukses: Terima Kasih & Auto Countdown (View Shell)
     */
    public function selesai()
    {
        $tablet        = $this->_get_tablet();
        $data['tablet'] = $tablet;
        $data['title'] = 'Suara Berhasil Terkirim - E-Voting';
        $data['nama']  = $this->session->flashdata('nama_selesai') ?: 'Anggota';
        $data['step']  = 2;

        // Jika request via AJAX untuk kiosk seamless transition
        if ($this->input->is_ajax_request() || $this->input->get('ajax') === '1') {
            $this->_json_response('success', 'Halaman terima kasih dimuat.', array(
                'step'   => 2,
                'voter'  => null,
                'tablet' => $tablet,
                'title'  => $data['title'],
                'html'   => $this->load->view('voting/selesai', $data, TRUE)
            ));
            return;
        }

        $this->load->view('voting/template_header', $data);
        $this->load->view('voting/selesai', $data);
        $this->load->view('voting/template_footer', $data);
    }

    /**
     * AJAX: Batal Sesi Pemilih (JSON)
     */
    public function batal()
    {
        $this->session->unset_userdata('voter');
        $this->session->unset_userdata('pilihan_ketua');
        $this->session->unset_userdata('pilihan_pengawas');

        $redirectUrl = site_url('voting' . $this->_build_query_string());

        // Jika request via AJAX
        if ($this->input->is_ajax_request() || $this->input->method() === 'post') {
            $this->_json_response('success', 'Sesi pemilihan berhasil dibatalkan.', array(
                'redirect' => $redirectUrl
            ));
        }

        redirect($redirectUrl);
    }
}
