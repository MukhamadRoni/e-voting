<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    /**
     * Validasi login admin berdasarkan username dan password (MD5)
     *
     * @param string $username
     * @param string $password
     * @return object|null Data admin jika valid, null jika tidak
     */
    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $query = $this->db->get('admin');

        if ($query->num_rows() == 1) {
            return $query->row();
        }

        return null;
    }
}
