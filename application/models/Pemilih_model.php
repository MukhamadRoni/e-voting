<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemilih_model extends CI_Model {

    private $table = 'pemilih';

    /**
     * Ambil semua data pemilih
     */
    public function get_all()
    {
        $sql = "SELECT nik, rfid, nama, dept, pilih FROM {$this->table} ORDER BY nama ASC";
        return $this->db->query($sql)->result();
    }

    /**
     * Ambil data pemilih berdasarkan NIK
     */
    public function get_by_nik($nik)
    {
        $sql = "SELECT nik, rfid, nama, dept, pilih FROM {$this->table} WHERE nik = ? LIMIT 1";
        return $this->db->query($sql, array($nik))->row();
    }

    /**
     * Cek apakah NIK sudah ada (untuk validasi unik)
     */
    public function is_nik_exists($nik)
    {
        $sql = "SELECT 1 FROM {$this->table} WHERE nik = ? LIMIT 1";
        $row = $this->db->query($sql, array($nik))->row();
        return !empty($row);
    }

    /**
     * Tambah data pemilih baru
     */
    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (nik, rfid, nama, dept, pilih) VALUES (?, ?, ?, ?, ?)";
        return $this->db->query($sql, array(
            $data['nik'],
            $data['rfid'],
            $data['nama'],
            $data['dept'],
            isset($data['pilih']) ? $data['pilih'] : 'F'
        ));
    }

    /**
     * Update data pemilih berdasarkan NIK
     */
    public function update($nik, $data)
    {
        $fields = array();
        $values = array();
        foreach ($data as $col => $val) {
            $fields[] = "`{$col}` = ?";
            $values[] = $val;
        }
        $values[] = $nik;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE nik = ? LIMIT 1";
        return $this->db->query($sql, $values);
    }

    /**
     * Hapus data pemilih berdasarkan NIK
     */
    public function delete($nik)
    {
        $sql = "DELETE FROM {$this->table} WHERE nik = ? LIMIT 1";
        return $this->db->query($sql, array($nik));
    }

    /**
     * Insert batch banyak pemilih sekaligus dengan single multi-row raw query
     */
    public function insert_batch($data)
    {
        if (empty($data)) {
            return false;
        }

        $placeholders = array();
        $values = array();

        foreach ($data as $row) {
            $placeholders[] = "(?, ?, ?, ?, ?)";
            $values[] = $row['nik'];
            $values[] = $row['rfid'];
            $values[] = $row['nama'];
            $values[] = $row['dept'];
            $values[] = isset($row['pilih']) ? $row['pilih'] : 'F';
        }

        $sql = "INSERT INTO {$this->table} (nik, rfid, nama, dept, pilih) VALUES " . implode(', ', $placeholders);
        return $this->db->query($sql, $values);
    }

    /**
     * Ambil daftar seluruh NIK yang sudah ada untuk validasi cepat
     */
    public function get_all_niks()
    {
        $query = $this->db->query("SELECT nik FROM {$this->table}");
        $result = array();
        foreach ($query->result_array() as $row) {
            $result[$row['nik']] = true;
        }
        return $result;
    }

    /**
     * Ambil daftar seluruh RFID yang sudah ada untuk validasi cepat
     */
    public function get_all_rfids()
    {
        $query = $this->db->query("SELECT rfid FROM {$this->table}");
        $result = array();
        foreach ($query->result_array() as $row) {
            $result[$row['rfid']] = true;
        }
        return $result;
    }

    /**
     * Ambil data pemilih berdasarkan filter status dan/atau pencarian
     *
     * @param string|null $status 'T' (Sudah Memilih), 'F' (Belum Memilih), atau null/all (Semua)
     * @param string|null $search Keyword pencarian
     * @return array
     */
    public function get_filtered($status = null, $search = null)
    {
        $this->db->select('nik, rfid, nama, dept, pilih');
        $this->db->from($this->table);

        if ($status === 'T' || $status === 'F') {
            $this->db->where('pilih', $status);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nik', $search);
            $this->db->or_like('rfid', $search);
            $this->db->or_like('nama', $search);
            $this->db->or_like('dept', $search);
            $this->db->group_end();
        }

        $this->db->order_by('nama', 'ASC');
        return $this->db->get()->result();
    }
}
