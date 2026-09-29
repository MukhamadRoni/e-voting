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
        $sql = "SELECT nik, rfid, nama, dept, pilih 
                FROM pemilih 
                WHERE nik = ? OR rfid = ? 
                LIMIT 1";
        return $this->db->query($sql, array($keyword, $keyword))->row();
    }

    /**
     * Ambil pemilih berdasarkan NIK
     */
    public function get_pemilih_by_nik($nik)
    {
        $sql = "SELECT nik, rfid, nama, dept, pilih 
                FROM pemilih 
                WHERE nik = ? 
                LIMIT 1";
        return $this->db->query($sql, array($nik))->row();
    }

    /**
     * Ambil seluruh calon ketua
     */
    public function get_all_ketua()
    {
        $sql = "SELECT nik, nama, foto, visi_misi 
                FROM kandidat_ketua 
                ORDER BY nik ASC";
        return $this->db->query($sql)->result();
    }

    /**
     * Ambil seluruh calon pengawas
     */
    public function get_all_pengawas()
    {
        $sql = "SELECT nik, nama, foto, visi_misi 
                FROM kandidat_pengawas 
                ORDER BY nik ASC";
        return $this->db->query($sql)->result();
    }

    /**
     * Ambil data calon ketua berdasarkan NIK
     */
    public function get_ketua_by_nik($nik)
    {
        $sql = "SELECT nik, nama, foto, visi_misi 
                FROM kandidat_ketua 
                WHERE nik = ? 
                LIMIT 1";
        return $this->db->query($sql, array($nik))->row();
    }

    /**
     * Ambil data calon pengawas berdasarkan NIK
     */
    public function get_pengawas_by_nik($nik)
    {
        $sql = "SELECT nik, nama, foto, visi_misi 
                FROM kandidat_pengawas 
                WHERE nik = ? 
                LIMIT 1";
        return $this->db->query($sql, array($nik))->row();
    }

    /**
     * Simpan hasil suara voting dengan database transaction
     * 1. Validasi pemilih belum pernah voting (pilih = 'F') dengan lock row
     * 2. Insert ke tabel hasil
     * 3. Update status pemilih menjadi pilih = 'T'
     */
    public function simpan_suara($pemilih_nik, $ketua_nik, $pengawas_nik)
    {
        $this->db->trans_start();

        // 1. Cek ulang status pemilih dengan FOR UPDATE untuk mencegah double vote
        $pemilih = $this->db->query(
            "SELECT pilih FROM pemilih WHERE nik = ? LIMIT 1 FOR UPDATE", 
            array($pemilih_nik)
        )->row();

        if (!$pemilih || $pemilih->pilih === 'T') {
            $this->db->trans_rollback();
            return false;
        }

        // 2. Insert ke tabel hasil
        $now = date('Y-m-d H:i:s');
        $this->db->query(
            "INSERT INTO hasil (pemilih_nik, ketua_nik, pengawas_nik, created_at) VALUES (?, ?, ?, ?)",
            array($pemilih_nik, $ketua_nik, $pengawas_nik, $now)
        );

        // 3. Update status pemilih
        $this->db->query(
            "UPDATE pemilih SET pilih = 'T' WHERE nik = ? AND pilih = 'F'",
            array($pemilih_nik)
        );

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
