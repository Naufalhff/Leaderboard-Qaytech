<?php
require_once 'conixion.php'; // This file should establish the PDO connection using $conn

// Ambil nama tabel dari parameter query
$table_name = isset($_GET['table_name']) ? $_GET['table_name'] : null;

if ($table_name) {
  try {
    // Siapkan query SQL menggunakan nama tabel dinamis
    $query1 = "SELECT * FROM `$table_name`";
    $stmt = $conn->query($query1);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($data)) {
      // Jika tidak ada data, tampilkan pesan
      echo '<tr><td colspan="13" class="text-center">Tidak ada data</td></tr>';
    } else {
      if (count($data) > 1) {
        // Urutkan berdasarkan result dari terkecil ke terbesar untuk menentukan rangking
        usort($data, function ($a, $b) {
          if ($a['result'] == 0)
            return 1; // Place records with result 0 at the end
          if ($b['result'] == 0)
            return -1;
          return $a['result'] - $b['result'];
        });

        // Tetapkan rangking untuk semua peserta yang memiliki result > 0
        $rank = 1; // Inisialisasi peringkat awal
        foreach ($data as $key => $value) {
          if ($value['result'] > 0) {
            $data[$key]['rangking'] = $rank;
            $rank++;
          } else {
            $data[$key]['rangking'] = 'Belum ditetapkan';
          }
        }
      } else {
        // Tetapkan rangking untuk satu peserta jika result > 0
        if ($data[0]['result'] > 0) {
          $data[0]['rangking'] = 1;
        } else {
          $data[0]['rangking'] = 'Belum ditetapkan';
        }
      }

      // Tampilkan data
      foreach ($data as $value) {
        echo '<tr class="bg-white align-middle">';
        echo '<td>' . htmlspecialchars($value['no_peserta']) . '</td>';
        echo '<td>' . htmlspecialchars($value['timestamp']) . '</td>';
        echo '<td>' . htmlspecialchars($value['nama_anjing']) . '</td>';
        echo '<td>' . htmlspecialchars($value['nama_pemilik']) . '</td>';
        echo '<td>' . htmlspecialchars($value['handler']) . '</td>';
        echo '<td>' . htmlspecialchars($value['size']) . '</td>';
        echo '<td>' . htmlspecialchars($value['kelas']) . '</td>';
        echo '<td>' . htmlspecialchars($value['status']) . '</td>';
        echo '<td>' . htmlspecialchars(number_format((float) $value['waktu_tempuh'], 2)) . '</td>';
        echo '<td>' . htmlspecialchars($value['fault']) . '</td>';
        echo '<td>' . htmlspecialchars($value['refusal']) . '</td>';
        echo '<td>' . htmlspecialchars(number_format($value['result'], 2)) . '</td>';
        echo '<td>' . htmlspecialchars($value['rangking']) . '</td>';
        echo '</tr>';
      }
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
  }
} else {
  echo "Error: Nama tabel tidak didefinisikan. Silakan berikan nama tabel yang valid dalam URL.";
  exit;
}
?>