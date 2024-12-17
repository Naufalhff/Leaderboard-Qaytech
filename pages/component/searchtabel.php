<?php
// Ambil nilai table_name dari query string jika ada
$table_name = isset($_GET['table_name']) ? $_GET['table_name'] : '';
?>

<nav class="navbar container-fluid navbar-light bg-white position-sticky top-0">
    <div class=""><i class="fal fa-caret-circle-down h5 d-none d-md-block menutoggle fa-rotate-90"></i>
        <i class="fas fa-bars h4 d-md-none"></i>
    </div>
    <div class="d-flex align-items-center gap-4">
        <form id="searchForm" class="d-flex align-items-center">
            <input type="text" name="table_name" class="form-control mr-2" placeholder="Masukkan Nama Event"
                value="<?php echo htmlspecialchars($table_name); ?>" required>
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
                url: 'component/aksisearchtabel.php',
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