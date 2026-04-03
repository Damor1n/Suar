<?php
session_start();
if (!isset($_SESSION['nama_akun'])) {
    header('Location: login_page.html');
    exit();
}
$namaAkun = htmlspecialchars($_SESSION['nama_akun'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Isi Pesan - SUAR</title>
  <style>
    :root {
      --bg: #fffbf0;
      --card: #ffffff;
      --text: #234e70;
      --muted: #4a5568;
      --primary: #f59e0b;
      --accent: #ec4899;
      --highlight: #10b981;
      --shadow: 0 12px 30px rgba(224, 87, 129, 0.14);
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Inter', 'Segoe UI', Roboto, Arial, sans-serif;
      background: linear-gradient(135deg, #fef3c7 0%, #fce7f3 44%, #dbeafe 100%);
      color: var(--text);
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 24px;
    }

    .container {
      width: min(900px, 100%);
      padding: 20px;
      background: var(--card);
      border-radius: 20px;
      box-shadow: var(--shadow);
      border: 1px solid #e2e8f0;
      aspect-ratio: 16 / 9;
      display: flex;
      flex-direction: column;
    }

    .top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
      gap: 12px;
      flex-wrap: wrap;
    }

    .back-btn {
      border: 1px solid #e2e8f0;
      border-radius: 999px;
      background: #ffffff;
      color: var(--text);
      padding: 8px 14px;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 6px 14px rgba(15, 23, 42, 0.08);
      transition: transform 0.12s ease, border-color 0.2s ease, background 0.2s ease;
      text-decoration: none;
    }

    .back-btn:hover {
      border-color: var(--primary);
      background: #fef3c7;
      transform: translateY(-1px);
    }

    h1 {
      margin: 0;
      font-size: 1.95rem;
      line-height: 1.1;
      color: #0f172a;
    }

    p.subtitle {
      color: var(--muted);
      margin: 10px 0 24px;
      font-size: 0.99rem;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .account-data {
      margin-bottom: 16px;
      padding: 10px 14px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      font-weight: 600;
      color: #334155;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: var(--text);
    }

    textarea {
      width: 100%;
      padding: 14px;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      font-family: inherit;
      font-size: 1rem;
      resize: vertical;
      min-height: 360px;
      box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 6px 18px rgba(245, 158, 11, 0.2);
    }

    .media-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .media-group {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .media-btn {
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      background: #ffffff;
      padding: 12px 16px;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
      transition: transform 0.12s ease, border-color 0.2s ease, background 0.2s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .media-btn:hover {
      border-color: var(--accent);
      background: #fce7f3;
      transform: translateY(-1px);
    }

    .submit-btn {
      width: auto;
      min-width: 180px;
      padding: 12px 20px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      font-size: 1.05rem;
      cursor: pointer;
      box-shadow: 0 6px 18px rgba(245, 158, 11, 0.3);
      transition: transform 0.12s ease, box-shadow 0.2s ease;
      display: inline-flex;
      margin: 0;
      align-items: center;
      justify-content: center;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
    }

    @media (max-width: 520px) {
      .container { padding: 20px; }
      h1 { font-size: 1.58rem; }
      .media-options { gap: 10px; }
      .media-btn { padding: 10px 14px; }
    }
  </style>
</head>
<body>
  <main class="container">
    <div class="top-row">
      <h1>Isi Pesan</h1>
      <a href="main_menu_user.html" class="back-btn">← Kembali</a>
    </div>
    <p class="subtitle">Tulis pesan Anda di bawah ini. Anda juga bisa menambahkan voice atau foto jika diperlukan.</p>

    <form action="simpan_pesan.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <div class="account-data">Nama Akun: <strong><?php echo $namaAkun; ?></strong></div>
        <input type="hidden" name="username" value="<?php echo $namaAkun; ?>" />

        <label for="message">Pesan Anda</label>
        <textarea id="message" name="message" placeholder="Tulis pesan Anda di sini..." required></textarea>
      </div>

      <input type="hidden" name="local_time" id="local_time" value="" />
      <div class="media-options">
        <div class="media-group">
          <button type="button" class="media-btn" onclick="alert('Fitur suara belum tersedia. Gunakan textarea untuk menulis pesan.')">
            🎤 Suara
          </button>
          <label for="photo" class="media-btn">
            📷 Foto
            <input type="file" id="photo" name="photo" accept="image/*" style="display: none;">
          </label>
        </div>
        <button type="submit" class="submit-btn">Kirim Pesan</button>
      </div>
    </form>

    <script>
      const form = document.querySelector('form');
      const inputLocalTime = document.getElementById('local_time');

      function formatTwoDigits(value) {
        return value.toString().padStart(2, '0');
      }

      function getLocalDateTime() {
        const now = new Date();
        const day = formatTwoDigits(now.getDate());
        const month = formatTwoDigits(now.getMonth() + 1);
        const year = now.getFullYear();
        const hours = formatTwoDigits(now.getHours());
        const minutes = formatTwoDigits(now.getMinutes());
        const seconds = formatTwoDigits(now.getSeconds());
        return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
      }

      form.addEventListener('submit', () => {
        inputLocalTime.value = getLocalDateTime();
      });
    </script>
  </main>
</body>
</html>