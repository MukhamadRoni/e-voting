<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/SimpleXLSXGen.php';

use Shuchkin\SimpleXLSXGen;

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
        
        $totalSuara = 0;
        foreach ($data['rekap'] as $r) {
            $totalSuara += (int)$r->total_suara;
        }
        $data['total_suara']   = $totalSuara;
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
        
        $totalSuara = 0;
        foreach ($data['rekap'] as $r) {
            $totalSuara += (int)$r->total_suara;
        }
        $data['total_suara']   = $totalSuara;
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
     * Export Log Audit Trace Back ke Excel (.xlsx) Sesuai Kolom DataTable
     */
    public function export_trace_back()
    {
        $search = $this->input->get('search', TRUE);
        $trace  = $this->Laporan_model->get_trace_back($search);

        $excelData = array();

        // Header kolom sesuai persis dengan tabel pada trace_back.php
        $excelData[] = array(
            '<b>No</b>',
            '<b>Waktu Voting</b>',
            '<b>NIK Pemilih</b>',
            '<b>Nama Pemilih</b>',
            '<b>Departemen</b>',
            '<b>Pilihan Ketua</b>',
            '<b>Pilihan Pengawas</b>'
        );

        $no = 1;
        foreach ($trace as $row) {
            $waktu = date('d M Y, H:i:s', strtotime($row->created_at));
            $pilihanKetua = $row->nama_ketua ? $row->nama_ketua . ' (NIK: ' . $row->ketua_nik . ')' : 'Tidak memilih';
            $pilihanPengawas = $row->nama_pengawas ? $row->nama_pengawas . ' (NIK: ' . $row->pengawas_nik . ')' : 'Tidak memilih';

            $excelData[] = array(
                $no++,
                $waktu,
                "\0" . (string)$row->pemilih_nik,
                (string)($row->nama_pemilih ?: '-'),
                (string)($row->dept_pemilih ?: '-'),
                $pilihanKetua,
                $pilihanPengawas
            );
        }

        $filename = 'laporan_trace_back_' . date('Ymd_His') . '.xlsx';

        $xlsx = SimpleXLSXGen::fromArray($excelData, 'Trace Back Audit');
        $xlsx->downloadAs($filename);
        exit;
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
     * Export Data Peserta Undian Door Prize ke Excel (.xlsx) Sesuai Filter
     */
    public function export_peserta_undian()
    {
        $dept   = $this->input->get('dept', TRUE);
        $status = $this->input->get('status', TRUE);
        $search = $this->input->get('search', TRUE);

        $peserta = $this->Laporan_model->get_peserta_undian($dept, $status, $search);

        $excelData = array();

        // Header kolom persis sesuai urutan DataTable peserta_undian.php
        $excelData[] = array(
            '<b>No</b>',
            '<b>NIK</b>',
            '<b>Nama Anggota</b>',
            '<b>Departemen</b>',
            '<b>Status Hak Suara</b>',
            '<b>Doorprize Dimenangkan</b>'
        );

        $no = 1;
        foreach ($peserta as $p) {
            $hadiahInfo = 'Belum Menang';
            if (!empty($p->nama_hadiah)) {
                $hadiahInfo = $p->nama_hadiah;
                if (!empty($p->tanggal_menang)) {
                    $hadiahInfo .= ' (Dimenangkan: ' . date('d M Y, H:i', strtotime($p->tanggal_menang)) . ')';
                }
            }

            $excelData[] = array(
                $no++,
                "\0" . (string)$p->nik,
                (string)$p->nama,
                (string)$p->dept,
                'Sudah Memilih (Sah)',
                $hadiahInfo
            );
        }

        // Tentukan nama file yang informatif sesuai filter yang dipilih
        $fileParts = array('peserta_undian');
        if (!empty($dept)) {
            $cleanDept = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($dept));
            $fileParts[] = $cleanDept;
        }
        if (!empty($status)) {
            $cleanStatus = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($status));
            $fileParts[] = $cleanStatus;
        }
        $fileParts[] = date('Ymd_His');

        $filename = implode('_', $fileParts) . '.xlsx';

        $xlsx = SimpleXLSXGen::fromArray($excelData, 'Peserta Undian');
        $xlsx->downloadAs($filename);
        exit;
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
