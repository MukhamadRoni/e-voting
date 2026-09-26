<!-- Form Tambah Pemilih -->
<div class="card" style="max-width: 640px;">
    <div class="card-header">
        <h3>Tambah Pemilih Baru</h3>
    </div>

    <?= form_open('master_user/tambah'); ?>

        <div class="form-group">
            <label for="nik">NIK <span style="color:#dc2626;">*</span></label>
            <input type="text" name="nik" id="nik" placeholder="Masukkan NIK" value="<?= set_value('nik'); ?>" maxlength="20">
            <?= form_error('nik', '<p class="error-text">', '</p>'); ?>
        </div>

        <div class="form-group">
            <label for="rfid">RFID <span style="color:#dc2626;">*</span></label>
            <input type="text" name="rfid" id="rfid" placeholder="Masukkan kode RFID" value="<?= set_value('rfid'); ?>" maxlength="50">
            <?= form_error('rfid', '<p class="error-text">', '</p>'); ?>
        </div>

        <div class="form-group">
            <label for="nama">Nama Lengkap <span style="color:#dc2626;">*</span></label>
            <input type="text" name="nama" id="nama" placeholder="Masukkan nama lengkap" value="<?= set_value('nama'); ?>" maxlength="100">
            <?= form_error('nama', '<p class="error-text">', '</p>'); ?>
        </div>

        <div class="form-group">
            <label for="dept">Department <span style="color:#dc2626;">*</span></label>
            <input type="text" name="dept" id="dept" placeholder="Masukkan department" value="<?= set_value('dept'); ?>" maxlength="50">
            <?= form_error('dept', '<p class="error-text">', '</p>'); ?>
        </div>

        <div style="display:flex; gap:12px; margin-top:28px;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('master_user'); ?>" class="btn btn-secondary">Batal</a>
        </div>

    <?= form_close(); ?>
</div>
