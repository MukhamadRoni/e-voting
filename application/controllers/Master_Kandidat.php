<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_Kandidat extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kandidat_model');
        $this->load->library('form_validation');
    }

    /**
     * Halaman Daftar Kandidat (Tab: Ketua & Pengawas)
     */
    public function index()
    {
        $data['title']    = 'Data Kandidat';
        $data['username'] = $this->session->userdata('admin_username');
        $data['ketua']    = $this->Kandidat_model->get_all_ketua();
        $data['pengawas'] = $this->Kandidat_model->get_all_pengawas();

        $this->load->view('templates/header', $data);
        $this->load->view('master_kandidat/index', $data);
        $this->load->view('templates/footer');
    }

    // ─── Upload Foto Helper ─────────────────────────────────────────
    private function _upload_foto()
    {
        $config['upload_path']   = './assets/uploads/kandidat/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = time() . '_' . $_FILES['foto']['name'];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
            return $this->upload->data('file_name');
        }

        return false;
    }

    // ─── TAMBAH KETUA ───────────────────────────────────────────────
    public function tambah_ketua()
    {
        $data['title']    = 'Tambah Kandidat Ketua';
        $data['username'] = $this->session->userdata('admin_username');

        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|is_unique[kandidat_ketua.nik]',
            array('is_unique' => 'NIK sudah terdaftar sebagai kandidat ketua.')
        );
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('visi_misi', 'Visi & Misi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('master_kandidat/tambah_ketua', $data);
            $this->load->view('templates/footer');
        } else {
            $foto = $this->_upload_foto();
            if (!$foto && !empty($_FILES['foto']['name'])) {
                $this->session->set_flashdata('error', 'Gagal upload foto. Pastikan format sesuai dan ukuran maks 2MB.');
                redirect('master_kandidat/tambah_ketua');
                return;
            }

            $insert = array(
                'nik'       => $this->input->post('nik', TRUE),
                'nama'      => $this->input->post('nama', TRUE),
                'foto'      => $foto ? $foto : '',
                'visi_misi' => $this->input->post('visi_misi'),
            );

            $this->Kandidat_model->insert_ketua($insert);
            $this->session->set_flashdata('success', 'Data kandidat ketua berhasil ditambahkan.');
            redirect('master_kandidat');
        }
    }

    // ─── TAMBAH PENGAWAS ────────────────────────────────────────────
    public function tambah_pengawas()
    {
        $data['title']    = 'Tambah Kandidat Pengawas';
        $data['username'] = $this->session->userdata('admin_username');

        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|is_unique[kandidat_pengawas.nik]',
            array('is_unique' => 'NIK sudah terdaftar sebagai kandidat pengawas.')
        );
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('visi_misi', 'Visi & Misi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('master_kandidat/tambah_pengawas', $data);
            $this->load->view('templates/footer');
        } else {
            $foto = $this->_upload_foto();
            if (!$foto && !empty($_FILES['foto']['name'])) {
                $this->session->set_flashdata('error', 'Gagal upload foto. Pastikan format sesuai dan ukuran maks 2MB.');
                redirect('master_kandidat/tambah_pengawas');
                return;
            }

            $insert = array(
                'nik'       => $this->input->post('nik', TRUE),
                'nama'      => $this->input->post('nama', TRUE),
                'foto'      => $foto ? $foto : '',
                'visi_misi' => $this->input->post('visi_misi'),
            );

            $this->Kandidat_model->insert_pengawas($insert);
            $this->session->set_flashdata('success', 'Data kandidat pengawas berhasil ditambahkan.');
            redirect('master_kandidat');
        }
    }

    // ─── EDIT KETUA ─────────────────────────────────────────────────
    public function edit_ketua($nik)
    {
        $data['title']    = 'Edit Kandidat Ketua';
        $data['username'] = $this->session->userdata('admin_username');
        $data['kandidat'] = $this->Kandidat_model->get_ketua_by_nik($nik);

        if (!$data['kandidat']) {
            $this->session->set_flashdata('error', 'Data kandidat ketua tidak ditemukan.');
            redirect('master_kandidat');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('visi_misi', 'Visi & Misi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('master_kandidat/edit_ketua', $data);
            $this->load->view('templates/footer');
        } else {
            $update = array(
                'nama'      => $this->input->post('nama', TRUE),
                'visi_misi' => $this->input->post('visi_misi'),
            );

            // Upload foto baru jika ada
            if (!empty($_FILES['foto']['name'])) {
                $foto = $this->_upload_foto();
                if ($foto) {
                    // Hapus foto lama
                    if ($data['kandidat']->foto && file_exists('./assets/uploads/kandidat/' . $data['kandidat']->foto)) {
                        unlink('./assets/uploads/kandidat/' . $data['kandidat']->foto);
                    }
                    $update['foto'] = $foto;
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload foto. Pastikan format sesuai dan ukuran maks 2MB.');
                    redirect('master_kandidat/edit_ketua/' . $nik);
                    return;
                }
            }

            $this->Kandidat_model->update_ketua($nik, $update);
            $this->session->set_flashdata('success', 'Data kandidat ketua berhasil diperbarui.');
            redirect('master_kandidat');
        }
    }

    // ─── EDIT PENGAWAS ──────────────────────────────────────────────
    public function edit_pengawas($nik)
    {
        $data['title']    = 'Edit Kandidat Pengawas';
        $data['username'] = $this->session->userdata('admin_username');
        $data['kandidat'] = $this->Kandidat_model->get_pengawas_by_nik($nik);

        if (!$data['kandidat']) {
            $this->session->set_flashdata('error', 'Data kandidat pengawas tidak ditemukan.');
            redirect('master_kandidat');
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('visi_misi', 'Visi & Misi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('master_kandidat/edit_pengawas', $data);
            $this->load->view('templates/footer');
        } else {
            $update = array(
                'nama'      => $this->input->post('nama', TRUE),
                'visi_misi' => $this->input->post('visi_misi'),
            );

            // Upload foto baru jika ada
            if (!empty($_FILES['foto']['name'])) {
                $foto = $this->_upload_foto();
                if ($foto) {
                    // Hapus foto lama
                    if ($data['kandidat']->foto && file_exists('./assets/uploads/kandidat/' . $data['kandidat']->foto)) {
                        unlink('./assets/uploads/kandidat/' . $data['kandidat']->foto);
                    }
                    $update['foto'] = $foto;
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload foto. Pastikan format sesuai dan ukuran maks 2MB.');
                    redirect('master_kandidat/edit_pengawas/' . $nik);
                    return;
                }
            }

            $this->Kandidat_model->update_pengawas($nik, $update);
            $this->session->set_flashdata('success', 'Data kandidat pengawas berhasil diperbarui.');
            redirect('master_kandidat');
        }
    }

    // ─── HAPUS KETUA ────────────────────────────────────────────────
    public function hapus_ketua($nik)
    {
        $kandidat = $this->Kandidat_model->get_ketua_by_nik($nik);

        if (!$kandidat) {
            $this->session->set_flashdata('error', 'Data kandidat ketua tidak ditemukan.');
        } else {
            // Hapus file foto
            if ($kandidat->foto && file_exists('./assets/uploads/kandidat/' . $kandidat->foto)) {
                unlink('./assets/uploads/kandidat/' . $kandidat->foto);
            }
            $this->Kandidat_model->delete_ketua($nik);
            $this->session->set_flashdata('success', 'Data kandidat ketua berhasil dihapus.');
        }

        redirect('master_kandidat');
    }

    // ─── HAPUS PENGAWAS ─────────────────────────────────────────────
    public function hapus_pengawas($nik)
    {
        $kandidat = $this->Kandidat_model->get_pengawas_by_nik($nik);

        if (!$kandidat) {
            $this->session->set_flashdata('error', 'Data kandidat pengawas tidak ditemukan.');
        } else {
            // Hapus file foto
            if ($kandidat->foto && file_exists('./assets/uploads/kandidat/' . $kandidat->foto)) {
                unlink('./assets/uploads/kandidat/' . $kandidat->foto);
            }
            $this->Kandidat_model->delete_pengawas($nik);
            $this->session->set_flashdata('success', 'Data kandidat pengawas berhasil dihapus.');
        }

        redirect('master_kandidat');
    }
}
