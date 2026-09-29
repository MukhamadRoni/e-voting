<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Undian_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ambil peserta yang berhak ikut undian:
     * - Sudah menggunakan hak suara (pilih = 'T')
     * - BELUM PERNAH memenangkan undian yang berstatus 'valid'
     * Menggunakan LEFT JOIN anti-pattern (u.id IS NULL) untuk early-termination index lookup.
     */
    public function get_peserta_berhak($dept = null)
    {
        $params = array();
        $whereDept = "";
        if (!empty($dept)) {
            $whereDept = " AND p.dept = ? ";
            $params[] = $dept;
        }

        $sql = "SELECT p.nik, p.rfid, p.nama, p.dept, p.pilih
                FROM pemilih p
                LEFT JOIN pemenang_undian u ON p.nik = u.pemilih_nik AND u.status = 'valid'
                WHERE p.pilih = 'T' AND u.id IS NULL {$whereDept}
                ORDER BY p.nama ASC";

        return $this->db->query($sql, $params)->result();
    }

    /**
     * Total peserta tersisa yang belum memenangkan undian
     */
    public function count_peserta_tersisa($dept = null)
    {
        $params = array();
        $whereDept = "";
        if (!empty($dept)) {
            $whereDept = " AND p.dept = ? ";
            $params[] = $dept;
        }

        $sql = "SELECT COUNT(*) AS total
                FROM pemilih p
                LEFT JOIN pemenang_undian u ON p.nik = u.pemilih_nik AND u.status = 'valid'
                WHERE p.pilih = 'T' AND u.id IS NULL {$whereDept}";

        $row = $this->db->query($sql, $params)->row();
        return $row ? (int)$row->total : 0;
    }

    /**
     * Ambil seluruh riwayat pemenang undian
     * Diurutkan dari PRIMARY KEY id DESC untuk menghindari filesort
     */
    public function get_all_pemenang()
    {
        $sql = "SELECT u.id, u.pemilih_nik, p.nama, p.dept, p.rfid, u.nama_hadiah, u.status, u.created_at
                FROM pemenang_undian u
                LEFT JOIN pemilih p ON u.pemilih_nik = p.nik
                ORDER BY u.id DESC";
        return $this->db->query($sql)->result();
    }

    /**
     * Simpan pemenang undian ke database
     */
    public function simpan_pemenang($nik, $nama_hadiah = 'Door Prize Utama', $status = 'valid')
    {
        // Pastikan tidak duplikat jika status valid
        if ($status === 'valid') {
            $check = $this->db->query(
                "SELECT 1 FROM pemenang_undian WHERE pemilih_nik = ? AND status = 'valid' LIMIT 1",
                array($nik)
            )->row();

            if ($check) {
                return false;
            }
        }

        $sql = "INSERT INTO pemenang_undian (pemilih_nik, nama_hadiah, status, created_at) VALUES (?, ?, ?, ?)";
        return $this->db->query($sql, array($nik, $nama_hadiah, $status, date('Y-m-d H:i:s')));
    }

    /**
     * Hapus / batalkan catatan pemenang undian tertentu
     */
    public function hapus_pemenang($id)
    {
        return $this->db->query("DELETE FROM pemenang_undian WHERE id = ? LIMIT 1", array((int)$id));
    }

    /**
     * Reset / Kosongkan seluruh daftar pemenang undian secara instan
     */
    public function reset_semua_undian()
    {
        return $this->db->query("TRUNCATE TABLE pemenang_undian");
    }

    /**
     * Daftar departemen untuk opsi filter
     */
    public function get_daftar_departemen()
    {
        $sql = "SELECT DISTINCT dept FROM pemilih WHERE pilih = 'T' ORDER BY dept ASC";
        return $this->db->query($sql)->result();
    }
}
