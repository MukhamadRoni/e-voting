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
     */
    public function get_peserta_berhak($dept = null)
    {
        $this->db->select('p.nik, p.rfid, p.nama, p.dept, p.pilih');
        $this->db->from('pemilih p');
        $this->db->where('p.pilih', 'T');

        // Subquery: kecualikan yang sudah memenangkan undian valid
        $this->db->where("p.nik NOT IN (SELECT pemilih_nik FROM pemenang_undian WHERE status = 'valid')", NULL, FALSE);

        if (!empty($dept)) {
            $this->db->where('p.dept', $dept);
        }

        $this->db->order_by('p.nama', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Total peserta tersisa yang belum memenangkan undian
     */
    public function count_peserta_tersisa($dept = null)
    {
        $this->db->where('pilih', 'T');
        $this->db->where("nik NOT IN (SELECT pemilih_nik FROM pemenang_undian WHERE status = 'valid')", NULL, FALSE);
        if (!empty($dept)) {
            $this->db->where('dept', $dept);
        }
        return $this->db->count_all_results('pemilih');
    }

    /**
     * Ambil seluruh riwayat pemenang undian
     */
    public function get_all_pemenang()
    {
        $this->db->select('u.id, u.pemilih_nik, p.nama, p.dept, p.rfid, u.nama_hadiah, u.status, u.created_at');
        $this->db->from('pemenang_undian u');
        $this->db->join('pemilih p', 'u.pemilih_nik = p.nik', 'left');
        $this->db->order_by('u.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Simpan pemenang undian ke database
     */
    public function simpan_pemenang($nik, $nama_hadiah = 'Door Prize Utama', $status = 'valid')
    {
        // Pastikan tidak duplikat jika status valid
        if ($status === 'valid') {
            $exists = $this->db->get_where('pemenang_undian', array(
                'pemilih_nik' => $nik,
                'status'      => 'valid'
            ))->num_rows();

            if ($exists > 0) {
                return false;
            }
        }

        $data = array(
            'pemilih_nik' => $nik,
            'nama_hadiah' => $nama_hadiah,
            'status'      => $status,
            'created_at'  => date('Y-m-d H:i:s')
        );

        return $this->db->insert('pemenang_undian', $data);
    }

    /**
     * Hapus / batalkan catatan pemenang undian tertentu
     */
    public function hapus_pemenang($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('pemenang_undian');
    }

    /**
     * Reset / Kosongkan seluruh daftar pemenang undian
     */
    public function reset_semua_undian()
    {
        return $this->db->empty_table('pemenang_undian');
    }

    /**
     * Daftar departemen untuk opsi filter
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
