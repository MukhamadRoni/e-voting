<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
    }

    /**
     * Halaman Login Admin (GET & POST)
     */
    public function index()
    {
        // Jika sudah login, redirect ke dashboard admin
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }

        $data['title'] = 'Login Admin - E-Voting Koperasi';
        $this->load->view('auth/login', $data);
    }

    /**
     * Proses validasi login
     */
    public function process()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login Admin - E-Voting Koperasi';
            $this->load->view('auth/login', $data);
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $admin = $this->Auth_model->login($username, $password);

        if ($admin) {
            // Set session admin
            $session_data = array(
                'admin_id'         => $admin->id,
                'admin_username'   => $admin->username,
                'admin_logged_in'  => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('admin');
        } else {
            $this->session->set_flashdata('error', 'Username atau Password salah!');
            redirect('auth');
        }
    }

    /**
     * Logout dan hapus session
     */
    public function logout()
    {
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('admin_username');
        $this->session->unset_userdata('admin_logged_in');
        $this->session->sess_destroy();
        redirect('auth');
    }
}
