<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Real_Count extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
    }

    /**
     * Halaman Utama Real Count 3D Interactive Single Page
     */
    public function index()
    {
        $kategori = $this->input->get('kategori', TRUE) ?: 'ketua';
        if ($kategori !== 'pengawas') {
            $kategori = 'ketua';
        }

        $data['title']       = 'Real Count 3D Interactive - E-Voting RAT Koperasi';
        $data['kategori']    = $kategori;
        $data['total_dpt']   = $this->Laporan_model->get_total_pemilih();
        $data['total_suara'] = ($kategori === 'ketua') 
                                ? $this->Laporan_model->get_total_suara_ketua() 
                                : $this->Laporan_model->get_total_suara_pengawas();

        $this->load->view('real_count/index', $data);
    }

    /**
     * Endpoint JSON Real Count untuk Auto-Update 10 Detik
     */
    public function data_ajax()
    {
        $kategori = $this->input->get('kategori', TRUE) ?: 'ketua';
        if ($kategori !== 'pengawas') {
            $kategori = 'ketua';
        }

        $totalDpt = (int)$this->Laporan_model->get_total_pemilih();

        if ($kategori === 'ketua') {
            $rawKandidat = $this->Laporan_model->get_rekap_ketua();
        } else {
            $rawKandidat = $this->Laporan_model->get_rekap_pengawas();
        }

        // Hitung total suara langsung dari agregasi kandidat tanpa perlu query hitung ulang
        $totalSuara = 0;
        foreach ($rawKandidat as $k) {
            $totalSuara += (int)$k->total_suara;
        }

        $kandidatList = array();
        $rank = 1;

        foreach ($rawKandidat as $k) {
            $suara = (int)$k->total_suara;
            $persen = ($totalSuara > 0) ? round(($suara / $totalSuara) * 100, 1) : 0.0;

            // Cek file foto
            $fotoUrl = '';
            if (!empty($k->foto) && file_exists(FCPATH . 'assets/uploads/kandidat/' . $k->foto)) {
                $fotoUrl = base_url('assets/uploads/kandidat/' . $k->foto);
            } else {
                $fotoUrl = base_url('assets/img/logo.svg');
            }

            $kandidatList[] = array(
                'id'          => $k->nik,
                'nik'         => $k->nik,
                'nama'        => $k->nama,
                'foto'        => $k->foto,
                'foto_url'    => $fotoUrl,
                'visi_misi'   => $k->visi_misi,
                'total_suara' => $suara,
                'persentase'  => $persen,
                'rank'        => $rank++
            );
        }

        $persenPartisipasi = ($totalDpt > 0) ? round(($totalSuara / $totalDpt) * 100, 1) : 0.0;

        echo json_encode(array(
            'status'             => 'success',
            'kategori'           => $kategori,
            'total_dpt'          => $totalDpt,
            'total_suara'        => $totalSuara,
            'persen_partisipasi' => $persenPartisipasi,
            'kandidat'           => $kandidatList,
            'updated_at'         => date('H:i:s') . ' WIB'
        ));
    }
}
