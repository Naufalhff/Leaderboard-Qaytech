<?php
include '../conixion.php';

$response = array();
$table_name = isset($_GET['table_name']) ? $_GET['table_name'] : '';
$nama_anjing = isset($_GET['nama_anjing']) ? $_GET['nama_anjing'] : '';

if (!empty($table_name) && !empty($nama_anjing)) {
    try {
        // Sanitasi nama tabel untuk mencegah SQL Injection
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $table_name);

        // Cek tabel di database
        $checkTable = $conn->prepare("SHOW TABLES LIKE ?");
        $checkTable->execute([$table_name]);
        if ($checkTable->rowCount() == 0) {
            throw new Exception('Tabel tidak ditemukan');
        }

        // Cek kolom dalam tabel
        $checkColumns = $conn->prepare("SHOW COLUMNS FROM `$table_name` LIKE 'nama_anjing'");
        $checkColumns->execute();
        if ($checkColumns->rowCount() == 0) {
            throw new Exception('Kolom "nama_anjing" tidak ditemukan di tabel ' . htmlspecialchars($table_name));
        }

        // Query untuk mencari semua data dan menghitung rangking
        $stmt = $conn->prepare("SELECT * FROM `$table_name`");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) > 0) {
            // Urutkan berdasarkan result dari terkecil ke terbesar untuk menentukan rangking
            usort($data, function ($a, $b) {
                if ($a['result'] == 0)
                    return 1; // Tempatkan record dengan result 0 di akhir
                if ($b['result'] == 0)
                    return -1;
                return $a['result'] - $b['result']; // Urutkan dari terkecil ke terbesar
            });

            // Tetapkan rangking untuk semua peserta yang memiliki result > 0
            $rank = 1;
            foreach ($data as $key => $value) {
                if ($value['result'] > 0) {
                    $data[$key]['rangking'] = $rank;
                    $rank++;
                } else {
                    $data[$key]['rangking'] = 'Belum ditetapkan';
                }
            }

            // Temukan data berdasarkan nama_anjing dan ambil rangkingnya
            $found = null;
            foreach ($data as $item) {
                if ($item['nama_anjing'] === $nama_anjing) {
                    $found = $item;
                    break;
                }
            }

            if ($found) {
                $response['status'] = 'success';
                ob_start(); // Mulai output buffering
                ?>
                <h3>Hasil Pencarian</h3>
                <form method="POST" action="">
                    <div class="table-container">
                        <table class="table student_list table-borderless">
                            <thead>
                                <tr class="align-middle">
                                    <th>No Peserta</th>
                                    <th>Timestamp</th>
                                    <th>Nama Anjing</th>
                                    <th>Nama Pemilik</th>
                                    <th>Handler</th>
                                    <th>Size</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th>Waktu Tempuh</th>
                                    <th>Fault</th>
                                    <th>Refusal</th>
                                    <th>Result</th>
                                    <th>Rangking</th>
                                    <th class="opacity-0">list</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white align-middle">
                                    <td><?php echo htmlspecialchars($found['no_peserta']); ?></td>
                                    <td><?php echo htmlspecialchars($found['timestamp']); ?></td>
                                    <td><?php echo htmlspecialchars($found['nama_anjing']); ?></td>
                                    <td><?php echo htmlspecialchars($found['nama_pemilik']); ?></td>
                                    <td><?php echo htmlspecialchars($found['handler']); ?></td>
                                    <td><?php echo htmlspecialchars($found['size']); ?></td>
                                    <td><?php echo htmlspecialchars($found['kelas']); ?></td>
                                    <td><?php echo htmlspecialchars($found['status']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars(number_format((float) $found['waktu_tempuh'], 2)); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($found['fault']); ?></td>
                                    <td><?php echo htmlspecialchars($found['refusal']); ?></td>
                                    <td><?php
                                    $fault = floatval($found['fault']);
                                    $refusal = floatval($found['refusal']);

                                    $calculated_result = (($fault + $refusal) * 5) + $found['waktu_tempuh'];
                                    ?><?php echo htmlspecialchars(number_format($calculated_result, 2)); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($found['rangking']); ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </form>
                <?php
                $response['html'] = ob_get_clean(); // Simpan output buffered ke dalam respons HTML
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Data tidak ditemukan';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Tidak ada data ditemukan';
        }
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Terjadi kesalahan: ' . $e->getMessage();
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
    $conn = null;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Nama tabel atau Nama Anjing tidak diberikan';
}

// Jika ada HTML dalam respons, kirimkan HTML tersebut
if (isset($response['html'])) {
    echo $response['html'];
} else {
    // Jika ada pesan error, kirimkan pesan error dalam format HTML
    echo '<div class="alert alert-warning">' . htmlspecialchars($response['message']) . '</div>';
}
?>