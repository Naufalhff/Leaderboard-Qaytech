<?php
include "../conixion.php";

// Ambil nilai dari query string
$table_name = isset($_GET['table_name']) ? $_GET['table_name'] : '';

if ($table_name) {
    try {
        $stmt = $conn->prepare("SHOW TABLES LIKE ?");
        $stmt->execute(["%$table_name%"]);
        $results = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($results) {
            echo "<div class='row'>";
            foreach ($results as $table) {
                echo "
                <div class='col-md-4 mb-3'>
                    <div class='card shadow-sm border-0'>
                        <div class='card-body'>
                            <div class='d-flex justify-content-between align-items-center mb-3'>
                                <h1 class='card-title h4'>" . htmlspecialchars($table) . "</h1>
                            </div>
                            <p class='card-text text-muted fs-6'>
                                Temukan informasi mendetail dan eksplorasi data di tabel " . htmlspecialchars($table_name) . ".
                            </p>
                            <div class='d-flex justify-content-end'>
                                <a href='detailtabel.php?table_name=" . urlencode($table_name) . "' class='btn btn-primary'>
                                    <i class='fas fa-arrow-right'></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
            echo "</div>";
        } else {
            echo "<div class='alert alert-warning'>Tidak ada tabel yang cocok dengan nama \"$table_name\".</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-warning'>Masukkan nama tabel untuk mencari.</div>";
}

$conn = null;
?>