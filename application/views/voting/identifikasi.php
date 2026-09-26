<style>
.kiosk-welcome-card {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    border-radius: 24px;
    padding: 48px 36px;
    max-width: 620px;
    margin: 40px auto;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
}

.rfid-icon-circle {
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, #1a1a1a 0%, #374151 100%);
    border-radius: 50%;
    margin: 0 auto 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    animation: pulseGlow 2.5s infinite;
}

@keyframes pulseGlow {
    0% { box-shadow: 0 0 0 0 rgba(26,26,26,0.2); }
    70% { box-shadow: 0 0 0 16px rgba(26,26,26,0); }
    100% { box-shadow: 0 0 0 0 rgba(26,26,26,0); }
}

.rfid-icon-circle svg {
    width: 44px;
    height: 44px;
    stroke: #ffffff;
}

.kiosk-welcome-card h2 {
    font-size: 26px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
}

.kiosk-welcome-card p {
    font-size: 15px;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 32px;
}

.input-rfid-kiosk {
    width: 100%;
    height: 56px;
    border-radius: 14px;
    border: 2px solid #e5e5e5;
    padding: 0 20px;
    font-family: 'DM Sans', sans-serif;
    font-size: 17px;
    font-weight: 500;
    text-align: center;
    color: #1a1a1a;
    outline: none;
    transition: all 0.2s ease;
    margin-bottom: 16px;
}

.input-rfid-kiosk:focus {
    border-color: #1a1a1a;
    box-shadow: 0 0 0 4px rgba(26, 26, 26, 0.08);
}

.badge-info-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f5f5f7;
    color: #4b5563;
    padding: 6px 14px;
    border-radius: 9999px;
    font-size: 13px;
    margin-top: 20px;
}
</style>

<div class="kiosk-welcome-card">
    <div class="rfid-icon-circle">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
            <line x1="2" y1="10" x2="22" y2="10"></line>
            <circle cx="7" cy="15" r="1"></circle>
        </svg>
    </div>

    <h2>Selamat Datang di Bilik Suara</h2>
    <p>Silakan <strong>tempelkan kartu RFID</strong> Anda pada sensor reader, atau ketikkan nomor <strong>NIK</strong> Anda secara manual di bawah ini.</p>

    <form method="post" action="<?= site_url('voting/identifikasi'); ?>" id="formIdentifikasi">
        <input 
            type="text" 
            name="input_identitas" 
            id="inputIdentitas" 
            class="input-rfid-kiosk" 
            placeholder="Scan RFID / Masukkan NIK..." 
            autocomplete="off" 
            autofocus 
            required
        >

        <button type="submit" class="btn btn-primary" style="width: 100%; height: 52px; font-size: 16px;">
            Mulai Memilih →
        </button>
    </form>

    <div class="badge-info-pill">
        🔒 Suara Anda bersifat LUBERJURDIL (Langsung, Umum, Bebas, Rahasia, Jujur, Adil)
    </div>
</div>

<script>
// Auto focus kembali ke input RFID jika pemilih klik di luar
document.addEventListener('click', function(e) {
    var input = document.getElementById('inputIdentitas');
    if (input && e.target.tagName !== 'BUTTON' && e.target.tagName !== 'A') {
        input.focus();
    }
});
</script>
