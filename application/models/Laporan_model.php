<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Rekapitulasi suara kandidat ketua (diurutkan suara terbanyak)
     */
    public function get_rekap_ketua()
    {
        $this->db->select('k.nik, k.nama, k.foto, k.visi_misi, COUNT(h.id) AS total_suara');
        $this->db->from('kandidat_ketua k');
        $this->db->join('hasil h', 'k.nik = h.ketua_nik', 'left');
        $this->db->group_by(array('k.nik', 'k.nama', 'k.foto', 'k.visi_misi'));
        $this->db->order_by('total_suara', 'DESC');
        $this->db->order_by('k.nama', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Rekapitulasi suara kandidat pengawas (diurutkan suara terbanyak)
     */
    public function get_rekap_pengawas()
    {
        $this->db->select('k.nik, k.nama, k.foto, k.visi_misi, COUNT(h.id) AS total_suara');
        $this->db->from('kandidat_pengawas k');
        $this->db->join('hasil h', 'k.nik = h.pengawas_nik', 'left');
        $this->db->group_by(array('k.nik', 'k.nama', 'k.foto', 'k.visi_misi'));
        $this->db->order_by('total_suara', 'DESC');
        $this->db->order_by('k.nama', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Total suara masuk untuk ketua
     */
    public function get_total_suara_ketua()
    {
        $this->db->where('ketua_nik IS NOT NULL');
        $this->db->where('ketua_nik !=', '');
        return $this->db->count_all_results('hasil');
    }

    /**
     * Total suara masuk untuk pengawas
     */
    public function get_total_suara_pengawas()
    {
        $this->db->where('pengawas_nik IS NOT NULL');
        $this->db->where('pengawas_nik !=', '');
        return $this->db->count_all_results('hasil');
    }

    /**
     * Total semua pemilih terdaftar
     */
    public function get_total_pemilih()
    {
        return $this->db->count_all('pemilih');
    }

    /**
     * Total pemilih yang sudah menggunakan hak suara (pilih = 'T')
     */
    public function get_total_sudah_memilih()
    {
        $this->db->where('pilih', 'T');
        return $this->db->count_all_results('pemilih');
    }

    /**
     * Trace Back data voting (audit trail lengkap)
     */
    public function get_trace_back()
    {
        $this->db->select('h.id, h.pemilih_nik, p.nama AS nama_pemilih, p.dept AS dept_pemilih, h.ketua_nik, kk.nama AS nama_ketua, h.pengawas_nik, kp.nama AS nama_pengawas, h.created_at');
        $this->db->from('hasil h');
        $this->db->join('pemilih p', 'h.pemilih_nik = p.nik', 'left');
        $this->db->join('kandidat_ketua kk', 'h.ketua_nik = kk.nik', 'left');
        $this->db->join('kandidat_pengawas kp', 'h.pengawas_nik = kp.nik', 'left');
        $this->db->order_by('h.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Daftar pemilih yang berhak ikut undian / doorprize (pilih = 'T')
     * Dilengkapi informasi doorprize yang berhasil dimenangkan
     */
    public function get_peserta_undian($dept = null)
    {
        $this->db->select("p.nik, p.rfid, p.nama, p.dept, p.pilih, GROUP_CONCAT(u.nama_hadiah SEPARATOR ', ') AS nama_hadiah, MAX(u.created_at) AS tanggal_menang");
        $this->db->from('pemilih p');
        $this->db->join('pemenang_undian u', "p.nik = u.pemilih_nik AND u.status = 'valid'", 'left');
        $this->db->where('p.pilih', 'T');
        if (!empty($dept)) {
            $this->db->where('p.dept', $dept);
        }
        $this->db->group_by(array('p.nik', 'p.rfid', 'p.nama', 'p.dept', 'p.pilih'));
        $this->db->order_by('p.nama', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Daftar unik departemen untuk filter peserta undian
     */
    public function get_daftar_departemen()
    {
        $this->db->distinct();
        $this->db->select('dept');
        $this->db->from('pemilih');
        $this->db->where('pilih', 'T');
        $this->db->order_by('dept', 'ASC');
        return $this->db->get()->result();
    }
}
