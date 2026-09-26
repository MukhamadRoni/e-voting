<!-- Form Edit Pemilih -->
<div class="card" style="max-width: 640px;">
    <div class="card-header">
        <h3>Edit Pemilih</h3>
    </div>

    <?= form_open('master_user/edit/' . $pemilih->nik); ?>

        <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" id="nik" value="<?= $pemilih->nik; ?>" disabled style="background:#f5f5f7; color:#6b7280;">
        </div>

        <div class="form-group">
            <label for="rfid">RFID <span style="color:#dc2626;">*</span></label>
            <input type="text" name="rfid" id="rfid" placeholder="Masukkan kode RFID" value="<?= set_value('rfid', $pemilih->rfid); ?>" maxlength="50">
            <?= form_error('rfid', '<p class="error-text">', '</p>'); ?>
        </div>

        <div class="form-group">
            <label for="nama">Nama Lengkap <span style="color:#dc2626;">*</span></label>
            <input type="text" name="nama" id="nama" placeholder="Masukkan nama lengkap" value="<?= set_value('nama', $pemilih->nama); ?>" maxlength="100">
            <?= form_error('nama', '<p class="error-text">', '</p>'); ?>
        </div>

        <div class="form-group">
            <label for="dept">Department <span style="color:#dc2626;">*</span></label>
            <input type="text" name="dept" id="dept" placeholder="Masukkan department" value="<?= set_value('dept', $pemilih->dept); ?>" maxlength="50">
            <?= form_error('dept', '<p class="error-text">', '</p>'); ?>
        </div>

        <div style="display:flex; gap:12px; margin-top:28px;">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="<?= site_url('master_user'); ?>" class="btn btn-secondary">Batal</a>
        </div>

    <?= form_close(); ?>
</div>
