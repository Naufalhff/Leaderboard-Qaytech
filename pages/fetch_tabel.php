<?php
include 'conixion.php';

try {
    // Ambil daftar tabel dari database
    $tables_result = $conn->query("SHOW TABLES");
    echo '<div class="row">'; // Mulai baris baru
    while ($row = $tables_result->fetch(PDO::FETCH_NUM)) {
        $table_name = $row[0];
        // Sembunyikan tabel dengan nama 'login'
        if ($table_name !== 'login') {
            ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title h4"><?php echo htmlspecialchars($table_name); ?></h1>
                        </div>
                        <p class="card-text text-muted fs-6">
                            Temukan informasi mendetail dan eksplorasi data di tabel
                            <?php echo htmlspecialchars($table_name); ?>.
                        </p>

                        <div class="d-flex justify-content-end">
                            <a href="pages/detailtabel.php?table_name=<?php echo urlencode($table_name); ?>"
                                class="btn btn-primary">
                                <i class="fas fa-arrow-right"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    echo '</div>'; // Tutup baris
} catch (PDOException $e) {
    echo "<div class='col-12'><div class='alert alert-danger'>Tidak bisa mendapatkan daftar tabel: " . $e->getMessage() . "</div></div>";
}
?>