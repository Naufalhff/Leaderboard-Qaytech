$(document).ready(function () {
  function fetchTables() {
    $.ajax({
      url: "fetch_tabel.php", // URL to fetch the table data
      method: "GET",
      success: function (data) {
        $("#table-container").html(data); // Update the container with new data
      },
      error: function () {
        console.error("Error fetching table data");
      },
    });
  }

  // Auto-refresh every 5 seconds
  setInterval(fetchTables, 3000);
});
