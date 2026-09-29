<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Rekapitulasi suara kandidat ketua (diurutkan suara terbanyak)
     * Menggunakan correlated subquery untuk menghindari GROUP BY pada tipe data TEXT (visi_misi)
     * dan memanfaatkan index fk_hasil_ketua secara optimal tanpa temporary table on disk.
     */
    public function get_rekap_ketua()
    {
        $sql = "SELECT 
                    k.nik, 
                    k.nama, 
                    k.foto, 
                    k.visi_misi, 
                    (SELECT COUNT(*) FROM hasil h WHERE h.ketua_nik = k.nik) AS total_suara
                FROM kandidat_ketua k
                ORDER BY total_suara DESC, k.nama ASC";
        return $this->db->query($sql)->result();
    }

    /**
     * Rekapitulasi suara kandidat pengawas (diurutkan suara terbanyak)
     * Menggunakan correlated subquery dengan index fk_hasil_pengawas tanpa disk temporary table.
     */
    public function get_rekap_pengawas()
    {
        $sql = "SELECT 
                    k.nik, 
                    k.nama, 
                    k.foto, 
                    k.visi_misi, 
                    (SELECT COUNT(*) FROM hasil h WHERE h.pengawas_nik = k.nik) AS total_suara
                FROM kandidat_pengawas k
                ORDER BY total_suara DESC, k.nama ASC";
        return $this->db->query($sql)->result();
    }

    /**
     * Total suara masuk untuk ketua
     */
    public function get_total_suara_ketua()
    {
        $row = $this->db->query("SELECT COUNT(*) AS total FROM hasil WHERE ketua_nik != '' AND ketua_nik IS NOT NULL")->row();
        return $row ? (int)$row->total : 0;
    }

    /**
     * Total suara masuk untuk pengawas
     */
    public function get_total_suara_pengawas()
    {
        $row = $this->db->query("SELECT COUNT(*) AS total FROM hasil WHERE pengawas_nik != '' AND pengawas_nik IS NOT NULL")->row();
        return $row ? (int)$row->total : 0;
    }

    /**
     * Total semua pemilih terdaftar
     */
    public function get_total_pemilih()
    {
        $row = $this->db->query("SELECT COUNT(*) AS total FROM pemilih")->row();
        return $row ? (int)$row->total : 0;
    }

    /**
     * Total pemilih yang sudah menggunakan hak suara (pilih = 'T')
     * Memanfaatkan indeks idx_pemilih_pilih untuk pencarian instan
     */
    public function get_total_sudah_memilih()
    {
        $row = $this->db->query("SELECT COUNT(*) AS total FROM pemilih WHERE pilih = 'T'")->row();
        return $row ? (int)$row->total : 0;
    }

    /**
     * Trace Back data voting (audit trail lengkap)
     * Memanfaatkan urutan PRIMARY KEY id DESC untuk mencegah filesort
     */
    public function get_trace_back()
    {
        $sql = "SELECT 
                    h.id, 
                    h.pemilih_nik, 
                    p.nama AS nama_pemilih, 
                    p.dept AS dept_pemilih, 
                    h.ketua_nik, 
                    kk.nama AS nama_ketua, 
                    h.pengawas_nik, 
                    kp.nama AS nama_pengawas, 
                    h.created_at
                FROM hasil h
                INNER JOIN pemilih p ON h.pemilih_nik = p.nik
                LEFT JOIN kandidat_ketua kk ON h.ketua_nik = kk.nik
                LEFT JOIN kandidat_pengawas kp ON h.pengawas_nik = kp.nik
                ORDER BY h.id DESC";
        return $this->db->query($sql)->result();
    }

    /**
     * Daftar pemilih yang berhak ikut undian / doorprize (pilih = 'T')
     * Menggunakan direct index-backed LEFT JOIN ke pemenang_undian tanpa agregasi berat
     */
    public function get_peserta_undian($dept = null)
    {
        $params = array();
        $whereDept = "";
        if (!empty($dept)) {
            $whereDept = " AND p.dept = ? ";
            $params[] = $dept;
        }

        $sql = "SELECT 
                    p.nik, 
                    p.rfid, 
                    p.nama, 
                    p.dept, 
                    p.pilih, 
                    u.nama_hadiah, 
                    u.created_at AS tanggal_menang
                FROM pemilih p
                LEFT JOIN pemenang_undian u ON p.nik = u.pemilih_nik AND u.status = 'valid'
                WHERE p.pilih = 'T' {$whereDept}
                ORDER BY p.nama ASC";

        return $this->db->query($sql, $params)->result();
    }

    /**
     * Daftar unik departemen untuk filter peserta undian
     * Memanfaatkan indeks komposit idx_pemilih_pilih_dept
     */
    public function get_daftar_departemen()
    {
        $sql = "SELECT DISTINCT dept FROM pemilih WHERE pilih = 'T' ORDER BY dept ASC";
        return $this->db->query($sql)->result();
    }
}
