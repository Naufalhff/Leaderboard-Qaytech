<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PERKIN</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/script.js"></script>
  <script>
    $(document).ready(function () {
      function fetchTables() {
        $.ajax({
          url: "pages/fetch_tabel.php", // URL untuk mengambil data tabel
          method: "GET",
          success: function (data) {
            $("#table-container").html(data); // Memperbarui kontainer dengan data baru
          },
          error: function () {
            console.error("Error fetching table data");
          },
        });
      }

      // Auto-refresh setiap 3 detik
      setInterval(fetchTables, 3000);
      fetchTables(); // Panggil fungsi untuk pertama kali saat halaman dimuat
    });
  </script>
</head>

<body class="bg-content">
  <main class="dashboard d-flex">
    <div class="container-fluid px-4" style="margin-top: 20px;"> <!-- Tambahkan margin-top di sini -->
      <div class="student-list-header d-flex justify-content-between align-items-center py-2">
        <div class="title h6 fw-bold">PERKIN</div>
        <div class="btn-add d-flex gap-3 align-items-center">
          <div class="short">
            <i class="far fa-sort"></i>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <div class="container mt-4">
          <div id="table-container">
            <!-- Data tabel akan dimuat di sini -->
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="../js/script.js"></script>
  <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>