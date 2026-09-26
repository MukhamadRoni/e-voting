<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kandidat_model extends CI_Model {

    /**
     * Ambil semua kandidat ketua
     */
    public function get_all_ketua()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('kandidat_ketua')->result();
    }

    /**
     * Ambil semua kandidat pengawas
     */
    public function get_all_pengawas()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->get('kandidat_pengawas')->result();
    }

    /**
     * Ambil kandidat ketua berdasarkan NIK
     */
    public function get_ketua_by_nik($nik)
    {
        return $this->db->get_where('kandidat_ketua', array('nik' => $nik))->row();
    }

    /**
     * Ambil kandidat pengawas berdasarkan NIK
     */
    public function get_pengawas_by_nik($nik)
    {
        return $this->db->get_where('kandidat_pengawas', array('nik' => $nik))->row();
    }

    /**
     * Tambah kandidat ketua baru
     */
    public function insert_ketua($data)
    {
        return $this->db->insert('kandidat_ketua', $data);
    }

    /**
     * Tambah kandidat pengawas baru
     */
    public function insert_pengawas($data)
    {
        return $this->db->insert('kandidat_pengawas', $data);
    }

    /**
     * Update kandidat ketua berdasarkan NIK
     */
    public function update_ketua($nik, $data)
    {
        $this->db->where('nik', $nik);
        return $this->db->update('kandidat_ketua', $data);
    }

    /**
     * Update kandidat pengawas berdasarkan NIK
     */
    public function update_pengawas($nik, $data)
    {
        $this->db->where('nik', $nik);
        return $this->db->update('kandidat_pengawas', $data);
    }

    /**
     * Hapus kandidat ketua berdasarkan NIK
     */
    public function delete_ketua($nik)
    {
        $this->db->where('nik', $nik);
        return $this->db->delete('kandidat_ketua');
    }

    /**
     * Hapus kandidat pengawas berdasarkan NIK
     */
    public function delete_pengawas($nik)
    {
        $this->db->where('nik', $nik);
        return $this->db->delete('kandidat_pengawas');
    }

    /**
     * Hitung total kandidat ketua
     */
    public function count_ketua()
    {
        return $this->db->count_all('kandidat_ketua');
    }

    /**
     * Hitung total kandidat pengawas
     */
    public function count_pengawas()
    {
        return $this->db->count_all('kandidat_pengawas');
    }
}
