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
        $sql = "SELECT id, username FROM admin WHERE username = ? AND password = ? LIMIT 1";
        $query = $this->db->query($sql, array($username, md5($password)));
        return $query->row();
    }
}
