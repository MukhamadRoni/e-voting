<style>
.success-screen-card {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    border-radius: 24px;
    padding: 56px 36px;
    max-width: 600px;
    margin: 40px auto;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
}

.success-icon-circle {
    width: 90px;
    height: 90px;
    background: #dcfce7;
    border-radius: 50%;
    margin: 0 auto 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #15803d;
    font-size: 42px;
    font-weight: 700;
    box-shadow: 0 8px 20px rgba(22, 163, 74, 0.15);
    animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes popIn {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.success-screen-card h2 {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
}

.success-screen-card p {
    font-size: 15px;
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 24px;
}

.doorprize-notice {
    background: #fdf4ff;
    border: 1px solid #f0abfc;
    color: #86198f;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 14px;
    margin-bottom: 32px;
}

.countdown-box {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 24px;
}

.countdown-box strong {
    color: #1a1a1a;
    font-size: 18px;
}
</style>

<div class="success-screen-card">
    <div class="success-icon-circle">✓</div>

    <h2>Suara Berhasil Disimpan!</h2>
    <p>Terima kasih, <strong><?= html_escape($nama); ?></strong>. Hak suara Anda telah berhasil dicatat ke dalam sistem bilik suara E-Voting Koperasi.</p>

    <div class="doorprize-notice">
        🎉 <strong>SELAMAT:</strong> Anda kini resmi terdaftar sebagai peserta yang berhak mengikuti <strong>Undian Door Prize RAT Koperasi</strong>!
    </div>

    <div class="countdown-box">
        Layar akan kembali otomatis ke halaman awal dalam <strong id="timerDisplay">6</strong> detik...
    </div>

    <a href="<?= site_url('voting'); ?>" class="btn btn-primary" style="padding:12px 32px; font-size:15px;">
        Selesai &bull; Kembali Sekarang
    </a>
</div>

<script>
var timeLeft = 6;
var timerDisplay = document.getElementById('timerDisplay');

var countdownInterval = setInterval(function() {
    timeLeft--;
    if (timerDisplay) {
        timerDisplay.innerText = timeLeft;
    }

    if (timeLeft <= 0) {
        clearInterval(countdownInterval);
        window.location.href = "<?= site_url('voting'); ?>";
    }
}, 1000);
</script>
