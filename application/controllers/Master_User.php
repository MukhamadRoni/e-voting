<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/SimpleXLSX.php';
require_once APPPATH . 'libraries/SimpleXLSXGen.php';

use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;

class Master_User extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pemilih_model');
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
     * Hanya me-render kerangka tampilan. Seluruh data pemilih diisi secara asinkron via AJAX.
     */
    public function index()
    {
        $data['title']    = 'Data Pemilih';
        $data['username'] = $this->session->userdata('admin_username');

        $this->load->view('templates/header', $data);
        $this->load->view('master_user/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * AJAX: Ambil seluruh data pemilih beserta ringkasan status voting (JSON)
     */
    public function get_data()
    {
        $pemilih = $this->Pemilih_model->get_all();
        $total   = count($pemilih);
        $sudah   = 0;
        $belum   = 0;

        foreach ($pemilih as $p) {
            if ($p->pilih === 'T') {
                $sudah++;
            } else {
                $belum++;
            }
        }

        $this->_json_response('success', 'Data pemilih berhasil dimuat.', array(
            'pemilih' => $pemilih,
            'summary' => array(
                'total' => $total,
                'sudah' => $sudah,
                'belum' => $belum
            )
        ));
    }

    /**
     * AJAX: Ambil detail 1 pemilih berdasarkan NIK (JSON)
     */
    public function get_pemilih($nik)
    {
        $pemilih = $this->Pemilih_model->get_by_nik($nik);
        if (!$pemilih) {
            $this->_json_response('error', 'Data pemilih tidak ditemukan.');
        }

        $this->_json_response('success', 'Data pemilih ditemukan.', $pemilih);
    }

    /**
     * AJAX: Tambah Pemilih Baru (POST -> JSON)
     */
    public function tambah()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|is_unique[pemilih.nik]', array(
            'required'  => 'NIK wajib diisi.',
            'is_unique' => 'NIK sudah terdaftar dalam sistem.'
        ));
        $this->form_validation->set_rules('rfid', 'RFID', 'required|trim|is_unique[pemilih.rfid]', array(
            'required'  => 'Nomor RFID wajib diisi.',
            'is_unique' => 'Nomor RFID sudah terdaftar dalam sistem.'
        ));
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', array(
            'required' => 'Nama lengkap wajib diisi.'
        ));
        $this->form_validation->set_rules('dept', 'Department', 'required|trim', array(
            'required' => 'Department wajib diisi.'
        ));

        if ($this->form_validation->run() == FALSE) {
            $this->_json_response('error', validation_errors('<div>', '</div>'));
        }

        $insert = array(
            'nik'   => $this->input->post('nik', TRUE),
            'rfid'  => $this->input->post('rfid', TRUE),
            'nama'  => $this->input->post('nama', TRUE),
            'dept'  => $this->input->post('dept', TRUE),
            'pilih' => 'F'
        );

        $this->Pemilih_model->insert($insert);
        $this->_json_response('success', 'Data pemilih baru berhasil ditambahkan.');
    }

    /**
     * AJAX: Edit/Update Pemilih (POST -> JSON)
     */
    public function edit($nik)
    {
        $pemilih = $this->Pemilih_model->get_by_nik($nik);
        if (!$pemilih) {
            $this->_json_response('error', 'Data pemilih tidak ditemukan.');
        }

        $rfid_rule = 'required|trim';
        if ($this->input->post('rfid') !== $pemilih->rfid) {
            $rfid_rule .= '|is_unique[pemilih.rfid]';
        }

        $this->form_validation->set_rules('rfid', 'RFID', $rfid_rule, array(
            'required'  => 'Nomor RFID wajib diisi.',
            'is_unique' => 'Nomor RFID sudah digunakan oleh pemilih lain.'
        ));
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', array(
            'required' => 'Nama lengkap wajib diisi.'
        ));
        $this->form_validation->set_rules('dept', 'Department', 'required|trim', array(
            'required' => 'Department wajib diisi.'
        ));

        if ($this->form_validation->run() == FALSE) {
            $this->_json_response('error', validation_errors('<div>', '</div>'));
        }

        $update = array(
            'rfid' => $this->input->post('rfid', TRUE),
            'nama' => $this->input->post('nama', TRUE),
            'dept' => $this->input->post('dept', TRUE),
        );

        $this->Pemilih_model->update($nik, $update);
        $this->_json_response('success', 'Data pemilih berhasil diperbarui.');
    }

    /**
     * AJAX: Hapus Pemilih (POST -> JSON)
     */
    public function hapus($nik)
    {
        $pemilih = $this->Pemilih_model->get_by_nik($nik);
        if (!$pemilih) {
            $this->_json_response('error', 'Data pemilih tidak ditemukan.');
        }

        $this->Pemilih_model->delete($nik);
        $this->_json_response('success', 'Data pemilih berhasil dihapus.');
    }

    // ─── FITUR IMPORT EXCEL ─────────────────────────────────────────

    /**
     * Halaman Form Import & Pratinjau Data Pemilih dari Excel
     */
    public function import()
    {
        $previewData    = $this->session->userdata('import_preview_data');
        $previewSummary = $this->session->userdata('import_preview_summary');
        $fileName       = $this->session->userdata('import_file_name');

        $data['title']           = 'Import Data Pemilih via Excel';
        $data['username']        = $this->session->userdata('admin_username');
        $data['is_preview']      = !empty($previewData);
        $data['preview_rows']    = $previewData ?: array();
        $data['preview_summary'] = $previewSummary ?: array('total' => 0, 'valid' => 0, 'invalid' => 0);
        $data['file_name']       = $fileName ?: '';

        $this->load->view('templates/header', $data);
        $this->load->view('master_user/import', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Download Template Resmi Excel (.xlsx)
     */
    public function download_template()
    {
        $templateData = array(
            array('NIK', 'RFID', 'Nama', 'Departemen'),
            array('10026', 'RFID-001026', 'Dimas Prayoga', 'Produksi'),
            array('10027', 'RFID-001027', 'Anisa Rahma', 'Keuangan'),
            array('10028', 'RFID-001028', 'Bambang Haryono', 'Logistik'),
        );

        $xlsx = SimpleXLSXGen::fromArray($templateData);
        $xlsx->downloadAs('template_import_pemilih.xlsx');
        exit;
    }

    /**
     * Proses Upload, Parsing, dan Validasi untuk Menampilkan Pratinjau
     */
    public function proses_import()
    {
        if (empty($_FILES['file_excel']['name'])) {
            $this->session->set_flashdata('error', 'Silakan pilih file Excel (.xlsx) terlebih dahulu.');
            redirect('master_user/import');
            return;
        }

        $ext = strtolower(pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION));
        if ($ext !== 'xlsx') {
            $this->session->set_flashdata('error', 'Format file tidak diizinkan. Sistem hanya menerima file berekstensi <strong>.xlsx</strong>.');
            redirect('master_user/import');
            return;
        }

        $maxSize = 5 * 1024 * 1024;
        if ($_FILES['file_excel']['size'] > $maxSize) {
            $this->session->set_flashdata('error', 'Ukuran file melebihi batas maksimal 5MB.');
            redirect('master_user/import');
            return;
        }

        $tmpPath = $_FILES['file_excel']['tmp_name'];
        $xlsx = SimpleXLSX::parse($tmpPath);

        if (!$xlsx) {
            $this->session->set_flashdata('error', 'File Excel rusak atau tidak dapat dibaca: ' . html_escape(SimpleXLSX::parseError()));
            redirect('master_user/import');
            return;
        }

        $rows = $xlsx->rows();
        if (count($rows) < 2) {
            $this->session->set_flashdata('error', 'File Excel kosong atau tidak memiliki baris data pemilih.');
            redirect('master_user/import');
            return;
        }

        $actualHeaders = array_map(function($val) {
            return strtolower(trim((string)$val));
        }, array_slice($rows[0], 0, 4));

        if (count($actualHeaders) < 4 ||
            $actualHeaders[0] !== 'nik' ||
            $actualHeaders[1] !== 'rfid' ||
            $actualHeaders[2] !== 'nama' ||
            ($actualHeaders[3] !== 'departemen' && $actualHeaders[3] !== 'dept')) {

            $this->session->set_flashdata('error', 'Struktur kolom Excel tidak sesuai!<br><br>' .
                '<strong>Header yang terdeteksi:</strong> ' . html_escape(implode(', ', $actualHeaders)) . '<br>' .
                '<strong>Header yang diwajibkan:</strong> NIK, RFID, Nama, Departemen.<br><br>' .
                'Silakan unduh dan gunakan <em>Template Resmi Excel</em> yang telah disediakan.');
            redirect('master_user/import');
            return;
        }

        $existingNiks  = $this->Pemilih_model->get_all_niks();
        $existingRfids = $this->Pemilih_model->get_all_rfids();

        $previewRows     = array();
        $validData       = array();
        $seenNiksInFile  = array();
        $seenRfidsInFile = array();

        for ($i = 1; $i < count($rows); $i++) {
            $excelRowNumber = $i + 1;
            $row = $rows[$i];

            $nik   = isset($row[0]) ? trim((string)$row[0]) : '';
            $rfid  = isset($row[1]) ? trim((string)$row[1]) : '';
            $nama  = isset($row[2]) ? trim((string)$row[2]) : '';
            $dept  = isset($row[3]) ? trim((string)$row[3]) : '';

            if ($nik === '' && $rfid === '' && $nama === '' && $dept === '') {
                continue;
            }

            $rowErrors = array();

            if ($nik === '') {
                $rowErrors[] = 'NIK wajib diisi';
            } elseif (strlen($nik) > 20) {
                $rowErrors[] = 'NIK melebihi 20 karakter';
            } elseif (isset($seenNiksInFile[$nik])) {
                $prevRow = $seenNiksInFile[$nik];
                $rowErrors[] = "NIK duplikat di baris {$prevRow}";
            } elseif (isset($existingNiks[$nik])) {
                $rowErrors[] = 'NIK sudah ada di database';
            }

            if ($rfid === '') {
                $rowErrors[] = 'RFID wajib diisi';
            } elseif (strlen($rfid) > 50) {
                $rowErrors[] = 'RFID melebihi 50 karakter';
            } elseif (isset($seenRfidsInFile[$rfid])) {
                $prevRow = $seenRfidsInFile[$rfid];
                $rowErrors[] = "RFID duplikat di baris {$prevRow}";
            } elseif (isset($existingRfids[$rfid])) {
                $rowErrors[] = 'RFID sudah ada di database';
            }

            if ($nama === '') {
                $rowErrors[] = 'Nama wajib diisi';
            } elseif (strlen($nama) > 100) {
                $rowErrors[] = 'Nama melebihi 100 karakter';
            }

            if ($dept === '') {
                $rowErrors[] = 'Departemen wajib diisi';
            } elseif (strlen($dept) > 50) {
                $rowErrors[] = 'Departemen melebihi 50 karakter';
            }

            $isValid = empty($rowErrors);

            if ($nik !== '' && !isset($seenNiksInFile[$nik])) {
                $seenNiksInFile[$nik] = $excelRowNumber;
            }
            if ($rfid !== '' && !isset($seenRfidsInFile[$rfid])) {
                $seenRfidsInFile[$rfid] = $excelRowNumber;
            }

            if ($isValid) {
                $validData[] = array(
                    'nik'   => $nik,
                    'rfid'  => $rfid,
                    'nama'  => $nama,
                    'dept'  => $dept,
                    'pilih' => 'F'
                );
            }

            $previewRows[] = array(
                'row'        => $excelRowNumber,
                'nik'        => $nik,
                'rfid'       => $rfid,
                'nama'       => $nama,
                'dept'       => $dept,
                'is_valid'   => $isValid,
                'keterangan' => $isValid ? 'Siap Diimpor' : implode(', ', $rowErrors)
            );
        }

        if (empty($previewRows)) {
            $this->session->set_flashdata('error', 'Tidak ada data pemilih yang ditemukan pada file Excel.');
            redirect('master_user/import');
            return;
        }

        $summary = array(
            'total'   => count($previewRows),
            'valid'   => count($validData),
            'invalid' => count($previewRows) - count($validData)
        );

        $this->session->set_userdata('import_preview_data', $previewRows);
        $this->session->set_userdata('import_valid_data', $validData);
        $this->session->set_userdata('import_preview_summary', $summary);
        $this->session->set_userdata('import_file_name', $_FILES['file_excel']['name']);

        redirect('master_user/import');
    }

    /**
     * Konfirmasi dan Simpan Data Valid ke Database
     */
    public function simpan_import()
    {
        $validData = $this->session->userdata('import_valid_data');

        if (empty($validData)) {
            $this->session->set_flashdata('error', 'Tidak ada data valid yang dapat disimpan.');
            redirect('master_user/import');
            return;
        }

        $this->db->trans_start();
        $this->Pemilih_model->insert_batch($validData);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan sistem saat menyimpan data ke database.');
            redirect('master_user/import');
            return;
        }

        $totalInserted = count($validData);
        $this->batal_import(false);

        $this->session->set_flashdata('success', "Berhasil mengimpor <strong>{$totalInserted} data pemilih</strong> baru ke dalam sistem!");
        redirect('master_user');
    }

    /**
     * Batalkan Pratinjau Import dan Reset Sesi
     */
    public function batal_import($redirect = true)
    {
        $this->session->unset_userdata('import_preview_data');
        $this->session->unset_userdata('import_valid_data');
        $this->session->unset_userdata('import_preview_summary');
        $this->session->unset_userdata('import_file_name');

        if ($redirect) {
            $this->session->set_flashdata('info', 'Pratinjau import data telah dibatalkan.');
            redirect('master_user/import');
        }
    }
}
