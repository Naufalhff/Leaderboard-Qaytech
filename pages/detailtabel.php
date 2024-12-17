<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERKIN</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-content">
    <main class="dashboard d-flex">
        <!-- start content page -->
        <div class="container-fluid px-4">
            <?php include "component/header.php"; ?>
            <div class="student-list-header d-flex justify-content-between align-items-center py-2">
                <div class="title h6 fw-bold">Data Sementara</div>
                <div class="btn-add d-flex gap-3 align-items-center">
                    <div class="short">
                        <i class="far fa-sort"></i>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div id="searchResults" class="container mt-4">
                    <!-- Hasil pencarian akan muncul di sini -->
                </div>
                <!-- data tabel -->
                <div class="container mt-4">
                    <div class="table-responsive">
                        <?php
                        if (isset($_GET['table_name']) && !empty($_GET['table_name'])) {
                            $table_name = $_GET['table_name'];
                            ?>
                            <form method="POST" action="">
                                <div class="">
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
                                            </tr>
                                        </thead>
                                        <tbody id="c4ytable">
                                            <!-- Data akan dimuat secara dinamis oleh JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            <?php
                        } else {
                            echo "<div class='alert alert-warning'>Nama tabel tidak didefinisikan dalam URL.</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function () {
            function fetchData() {
                var tableName = new URLSearchParams(window.location.search).get('table_name');
                if (!tableName) {
                    console.error('Nama tabel tidak ditemukan dalam URL.');
                    return;
                }

                $.ajax({
                    url: "fetch_data.php",
                    type: "GET",
                    data: { table_name: tableName },
                    success: function (data) {
                        $("#c4ytable").html(data); // Update the table body with new data
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching data: ", error);
                    },
                });
            }

            // Panggil fetchData setiap 5 detik (5000 ms)
            setInterval(fetchData, 5000);

            // Panggil fetchData pertama kali ketika halaman dimuat
            fetchData();
        });
    </script>
</body>

</html>