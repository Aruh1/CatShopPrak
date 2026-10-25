<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pemesanan Produk</title>
    <style>
      * {
        box-sizing: border-box;
      }
      body {
        background-color: #dde8ec;
        font-family: "Segoe UI", Arial, sans-serif;
        color: #14263a;
      }
      h1 {
        margin-bottom: 30px;
      }
      .container {
        display: flex;
        flex-direction: column;
        background-color: white;
        width: 35%;
        margin: 40px auto;
        padding: 20px;
        justify-content: center;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(20, 38, 58, 0.15);
      }
      .input {
        display: flex;
        flex-direction: column;
        margin: 10px 0;
      }
      label {
        margin-bottom: 5px;
        font-weight: 600;
      }
      input {
        width: 100%;
        padding: 8px;
        border: 2px solid #c3d1d9;
        border-radius: 8px;
      }
      input:focus {
        outline: none;
        border-color: #2457f5;
      }
      .button {
        width: 100%;
        margin: 10px 0;
        padding: 10px;
        background: #14263a;
        border-radius: 8px;
        cursor: pointer;
        border: none;
        color: white;
        font-weight: bold;
      }
      .button:hover {
        background-color: #2457f5;
      }
      .error {
        margin-top: 15px;
        background: #ffe5e5;
        color: #a12828;
        padding: 10px;
        border: 2px solid #f4b0b0;
        border-radius: 8px;
        font-weight: 600;
      }
      .hasil {
        margin-top: 15px;
        background: #f4f8fa;
        padding: 10px;
        border: 2px dashed #c3d1d9;
        border-radius: 8px;
        text-align: left;
      }
      .hasil table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
      }
      .hasil th, .hasil td {
        padding: 8px;
        border: 1px solid #c3d1d9;
        text-align: left;
      }
      .hasil th {
        background: #e8f1f5;
      }
      .hasil b {
        background: #ffd84d;
        padding: 2px 6px;
      }
    </style>
  </head>

  <body>
    <center>
      <h1>Form Pemesanan Produk</h1>
      <div class="container">
        <form action="" method="POST">
          <div class="input">
            <label for="produk">Nama Produk</label>
            <input type="text" name="produk" id="produk" value="<?php echo isset($_POST['produk']) ? htmlspecialchars($_POST['produk']) : ''; ?>" />
          </div>

          <div class="input">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" value="<?php echo isset($_POST['jumlah']) ? htmlspecialchars($_POST['jumlah']) : ''; ?>" />
          </div>

          <div class="input">
            <label for="harga">Harga Satuan (Rp)</label>
            <input type="number" name="harga" id="harga" value="<?php echo isset($_POST['harga']) ? htmlspecialchars($_POST['harga']) : ''; ?>" />
          </div>

          <input type="submit" class="button" name="btn_proses" value="Hitung Total" />
          <input type="reset" class="button" value="Hapus" />

          <div class="hasil">
            <?php
              function hitungTotalHarga(int $jumlah, float $harga): array {
                  $subtotal = $jumlah * $harga;
                  $diskon = 0;

                  if ($subtotal > 100000) {
                      $diskon = $subtotal * 0.10;
                  }

                  $totalBayar = $subtotal - $diskon;

                  return [
                      'subtotal' => $subtotal,
                      'diskon' => $diskon,
                      'total' => $totalBayar,
                  ];
              }

              if (isset($_POST['btn_proses'])) {
                  $produk = trim($_POST['produk'] ?? '');
                  $jumlah = $_POST['jumlah'] ?? '';
                  $harga = $_POST['harga'] ?? '';

                  if (empty($produk)) {
                      echo "<div class='error'>Nama produk wajib diisi.</div>";
                  } elseif (!is_numeric($jumlah) || $jumlah <= 0) {
                      echo "<div class='error'>Jumlah harus diisi dan tidak boleh bernilai negatif atau nol.</div>";
                  } elseif (!is_numeric($harga) || $harga <= 0) {
                      echo "<div class='error'>Harga satuan harus diisi dan tidak boleh bernilai negatif atau nol.</div>";
                  } else {
                      $jumlah = (int) $jumlah;
                      $harga = (float) $harga;
                      $hasil = hitungTotalHarga($jumlah, $harga);

                      echo "<table>
                              <tr>
                                <th>Detail</th>
                                <th>Nilai</th>
                              </tr>
                              <tr>
                                <td>Produk</td>
                                <td><b>" . htmlspecialchars($produk) . "</b></td>
                              </tr>
                              <tr>
                                <td>Jumlah</td>
                                <td><b>" . $jumlah . "</b></td>
                              </tr>
                              <tr>
                                <td>Harga Satuan</td>
                                <td><b>Rp " . number_format($harga, 0, ',', '.') . "</b></td>
                              </tr>
                              <tr>
                                <td>Subtotal</td>
                                <td><b>Rp " . number_format($hasil['subtotal'], 0, ',', '.') . "</b></td>
                              </tr>
                              <tr>
                                <td>Diskon</td>
                                <td><b>Rp " . number_format($hasil['diskon'], 0, ',', '.') . "</b></td>
                              </tr>
                              <tr>
                                <td>Total Bayar</td>
                                <td><b>Rp " . number_format($hasil['total'], 0, ',', '.') . "</b></td>
                              </tr>
                            </table>";
                  }
              } else {
                  echo "Hasil perhitungan akan tampil di sini.";
              }
            ?>
          </div>
        </form>
      </div>
    </center>
  </body>
</html>
