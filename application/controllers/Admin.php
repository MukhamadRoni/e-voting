<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Dashboard utama admin
     */
    public function index()
    {
        $data['title'] = 'Dashboard - E-Voting Koperasi';
        $data['username'] = $this->session->userdata('admin_username');
        $this->load->view('templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }
}
