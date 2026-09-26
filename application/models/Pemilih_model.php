<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemilih_model extends CI_Model {

    private $table = 'pemilih';

    /**
     * Ambil semua data pemilih
     */
    public function get_all()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Ambil data pemilih berdasarkan NIK
     */
    public function get_by_nik($nik)
    {
        return $this->db->get_where($this->table, array('nik' => $nik))->row();
    }

    /**
     * Cek apakah NIK sudah ada (untuk validasi unik)
     */
    public function is_nik_exists($nik)
    {
        return $this->db->get_where($this->table, array('nik' => $nik))->num_rows() > 0;
    }

    /**
     * Tambah data pemilih baru
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update data pemilih berdasarkan NIK
     */
    public function update($nik, $data)
    {
        $this->db->where('nik', $nik);
        return $this->db->update($this->table, $data);
    }

    /**
     * Hapus data pemilih berdasarkan NIK
     */
    public function delete($nik)
    {
        $this->db->where('nik', $nik);
        return $this->db->delete($this->table);
    }

    /**
     * Insert batch banyak pemilih sekaligus
     */
    public function insert_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }

    /**
     * Ambil daftar seluruh NIK yang sudah ada untuk validasi cepat
     */
    public function get_all_niks()
    {
        $this->db->select('nik');
        $query = $this->db->get($this->table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[$row->nik] = true;
        }
        return $result;
    }

    /**
     * Ambil daftar seluruh RFID yang sudah ada untuk validasi cepat
     */
    public function get_all_rfids()
    {
        $this->db->select('rfid');
        $query = $this->db->get($this->table);
        $result = array();
        foreach ($query->result() as $row) {
            $result[$row->rfid] = true;
        }
        return $result;
    }
}
