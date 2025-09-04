@php
// require "../function.php";
$gNow = date('Y-m-d H:i:s');
$date = "2025-06-20 09:00:00";
@endphp
@if($date <= $gNow)
<script>
	document.location.href="{{ url('/pendaftar') }}";
</script>
@endif
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>COMMING SOON</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Maundy - v2.0.0
  * Template URL: https://bootstrapmade.com/maundy-free-coming-soon-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex flex-column align-items-center">

      <h1>PORTAL DAFTAR ULANG</h1>
      <h2>CALON MURID BARU</h2>
      <h2>TAHUN PELAJARAN 2025/2026</h2>
      <h4>Dapat di buka dalam :</h4>
      <div class="countdown d-flex justify-content-center" data-count="2025/06/20 09:00:00">
        <div>
          <h3>%D</h3>
          <h4>Hari</h4>
        </div>
        <div>
          <h3>%H</h3>
          <h4>Jam</h4>
        </div>
        <div>
          <h3>%M</h3>
          <h4>Menit</h4>
        </div>
        <div>
          <h3>%S</h3>
          <h4>Detik</h4>
        </div>
      </div>
    </div>
  </header><!-- End #header -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>SMK Negeri 1 Garut</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/maundy-free-coming-soon-bootstrap-theme/ -->
        Designed by <a href="https://smknegeri1garut.sch.id/">SMK Negeri 1 Garut</a>
      </div>
    </div>
  </footer><!-- End #footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/jquery-countdown/jquery.countdown.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/maincd.js"></script>

</body>

</html>