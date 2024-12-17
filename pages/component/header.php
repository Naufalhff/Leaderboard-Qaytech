<?php
// Ambil nilai table_name dari query string jika ada
$table_name = isset($_GET['table_name']) ? $_GET['table_name'] : '';
?>
<nav class="navbar container-fluid navbar-light bg-white position-sticky top-0 d-flex justify-content-between"
    style="margin-top: 20px;">
    <div class="d-flex align-items-center gap-4">
        <a href="../index.php" class="btn btn-secondary">
            Back
        </a> <!-- Tombol Back dengan ikon panah -->

    </div>
    <div class="d-flex align-items-center gap-4">
        <form id="searchForm" class="d-flex align-items-center">
            <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($table_name); ?>">
            <input type="text" name="nama_anjing" placeholder="Masukkan Nama Anjing" aria-label="Search" required
                class="form-control mr-2">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <i class="fal fa-bell"></i>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#searchForm').on('submit', function (event) {
            event.preventDefault(); // Mencegah formulir dikirim secara default

            // Kosongkan hasil pencarian sebelumnya di detailtable.php
            $('#searchResults').html(''); // Gunakan html('') untuk mengosongkan konten

            $.ajax({
                url: 'component/search.php',
                type: 'GET',
                data: $(this).serialize(),
                success: function (response) {
                    // Memuat hasil pencarian ke elemen dengan ID 'searchResults'
                    $('#searchResults').html(response);
                },
                error: function (xhr, status, error) {
                    $('#searchResults').html('<div class="alert alert-danger">Terjadi kesalahan: ' + error + '</div>');
                }
            });
        });
    });
</script>