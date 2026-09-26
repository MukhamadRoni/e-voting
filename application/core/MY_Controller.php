<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin_Controller
 *
 * Base controller untuk semua halaman admin.
 * Otomatis cek session admin — redirect ke login jika belum login.
 */
class Admin_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Cek apakah admin sudah login
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth');
        }
    }
}
