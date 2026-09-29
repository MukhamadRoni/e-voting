<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kandidat_model extends CI_Model {

    /**
     * Ambil semua kandidat ketua
     */
    public function get_all_ketua()
    {
        return $this->db->query("SELECT nik, nama, foto, visi_misi FROM kandidat_ketua ORDER BY nama ASC")->result();
    }

    /**
     * Ambil semua kandidat pengawas
     */
    public function get_all_pengawas()
    {
        return $this->db->query("SELECT nik, nama, foto, visi_misi FROM kandidat_pengawas ORDER BY nama ASC")->result();
    }

    /**
     * Ambil kandidat ketua berdasarkan NIK
     */
    public function get_ketua_by_nik($nik)
    {
        return $this->db->query("SELECT nik, nama, foto, visi_misi FROM kandidat_ketua WHERE nik = ? LIMIT 1", array($nik))->row();
    }

    /**
     * Ambil kandidat pengawas berdasarkan NIK
     */
    public function get_pengawas_by_nik($nik)
    {
        return $this->db->query("SELECT nik, nama, foto, visi_misi FROM kandidat_pengawas WHERE nik = ? LIMIT 1", array($nik))->row();
    }

    /**
     * Tambah kandidat ketua baru
     */
    public function insert_ketua($data)
    {
        $sql = "INSERT INTO kandidat_ketua (nik, nama, foto, visi_misi) VALUES (?, ?, ?, ?)";
        return $this->db->query($sql, array($data['nik'], $data['nama'], $data['foto'], $data['visi_misi']));
    }

    /**
     * Tambah kandidat pengawas baru
     */
    public function insert_pengawas($data)
    {
        $sql = "INSERT INTO kandidat_pengawas (nik, nama, foto, visi_misi) VALUES (?, ?, ?, ?)";
        return $this->db->query($sql, array($data['nik'], $data['nama'], $data['foto'], $data['visi_misi']));
    }

    /**
     * Update kandidat ketua berdasarkan NIK
     */
    public function update_ketua($nik, $data)
    {
        $fields = array();
        $values = array();
        foreach ($data as $col => $val) {
            $fields[] = "`{$col}` = ?";
            $values[] = $val;
        }
        $values[] = $nik;
        $sql = "UPDATE kandidat_ketua SET " . implode(', ', $fields) . " WHERE nik = ? LIMIT 1";
        return $this->db->query($sql, $values);
    }

    /**
     * Update kandidat pengawas berdasarkan NIK
     */
    public function update_pengawas($nik, $data)
    {
        $fields = array();
        $values = array();
        foreach ($data as $col => $val) {
            $fields[] = "`{$col}` = ?";
            $values[] = $val;
        }
        $values[] = $nik;
        $sql = "UPDATE kandidat_pengawas SET " . implode(', ', $fields) . " WHERE nik = ? LIMIT 1";
        return $this->db->query($sql, $values);
    }

    /**
     * Hapus kandidat ketua berdasarkan NIK
     */
    public function delete_ketua($nik)
    {
        return $this->db->query("DELETE FROM kandidat_ketua WHERE nik = ? LIMIT 1", array($nik));
    }

    /**
     * Hapus kandidat pengawas berdasarkan NIK
     */
    public function delete_pengawas($nik)
    {
        return $this->db->query("DELETE FROM kandidat_pengawas WHERE nik = ? LIMIT 1", array($nik));
    }

    /**
     * Hitung total kandidat ketua
     */
    public function count_ketua()
    {
        $row = $this->db->query("SELECT COUNT(*) AS total FROM kandidat_ketua")->row();
        return $row ? (int)$row->total : 0;
    }

    /**
     * Hitung total kandidat pengawas
     */
    public function count_pengawas()
    {
        $row = $this->db->query("SELECT COUNT(*) AS total FROM kandidat_pengawas")->row();
        return $row ? (int)$row->total : 0;
    }
}
