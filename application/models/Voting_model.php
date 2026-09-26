<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voting_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Cari pemilih berdasarkan NIK atau nomor kartu RFID
     */
    public function find_pemilih($keyword)
    {
        $this->db->group_start();
        $this->db->where('nik', $keyword);
        $this->db->or_where('rfid', $keyword);
        $this->db->group_end();
        return $this->db->get('pemilih')->row();
    }

    /**
     * Ambil pemilih berdasarkan NIK
     */
    public function get_pemilih_by_nik($nik)
    {
        return $this->db->get_where('pemilih', array('nik' => $nik))->row();
    }

    /**
     * Ambil seluruh calon ketua
     */
    public function get_all_ketua()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('kandidat_ketua')->result();
    }

    /**
     * Ambil seluruh calon pengawas
     */
    public function get_all_pengawas()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('kandidat_pengawas')->result();
    }

    /**
     * Ambil data calon ketua berdasarkan NIK
     */
    public function get_ketua_by_nik($nik)
    {
        return $this->db->get_where('kandidat_ketua', array('nik' => $nik))->row();
    }

    /**
     * Ambil data calon pengawas berdasarkan NIK
     */
    public function get_pengawas_by_nik($nik)
    {
        return $this->db->get_where('kandidat_pengawas', array('nik' => $nik))->row();
    }

    /**
     * Simpan hasil suara voting dengan database transaction
     * 1. Validasi pemilih belum pernah voting (pilih = 'F')
     * 2. Insert ke tabel hasil
     * 3. Update status pemilih menjadi pilih = 'T'
     */
    public function simpan_suara($pemilih_nik, $ketua_nik, $pengawas_nik)
    {
        $this->db->trans_start();

        // 1. Cek ulang status pemilih
        $pemilih = $this->db->get_where('pemilih', array('nik' => $pemilih_nik))->row();
        if (!$pemilih || $pemilih->pilih === 'T') {
            $this->db->trans_rollback();
            return false;
        }

        // 2. Insert ke tabel hasil
        $data_hasil = array(
            'pemilih_nik'  => $pemilih_nik,
            'ketua_nik'    => $ketua_nik,
            'pengawas_nik' => $pengawas_nik,
            'created_at'   => date('Y-m-d H:i:s')
        );
        $this->db->insert('hasil', $data_hasil);

        // 3. Update status pemilih
        $this->db->where('nik', $pemilih_nik);
        $this->db->update('pemilih', array('pilih' => 'T'));

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
