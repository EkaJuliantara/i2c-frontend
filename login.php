<?php
  error_reporting(0);
  ob_start();
  session_start();
  if (!$_SESSION['i2c_teams']['id']) {
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>I2C</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <!--Skeleton -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <!--Flexlide -->
  <link rel="stylesheet" href="bower_components/flexslider/flexslider.css">
  <!--Vertical-Timeline-->
  <link rel="stylesheet" href="vertical-timeline/css/style.css">
  <!--FancyBox-->
  <link rel="stylesheet" href="bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
  <!--Style -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->



</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <a href="http://ifest-uajy.com">
    <section id="header">
      <div class="container">
        <div class="row">
          <div class="twelve columns">
            <div class="ifest-header">
              <img class="ifest-logo" src="logo-ifest.png" alt="" />
              <h1 class="header-text">Informatics Festival</h1>
            </div>
          </div>
        </div>
      </div>
    </section>
  </a>

  <section id="menu">
    <div class="container">
      <div class="row">
        <div class="twelve columns">
            <a href="index.html#header" class="logo">
                <img class="i2c-logo" src="img/logo.png" alt="" />
            </a>
            <nav class="navigation">
                <ul>
                  <li class="nav"><a class="menu-link" href="#about"><span class="text-link">TENTANG I2C</span></a></li>
                  <li class="nav"><a class="menu-link" href="#category"><span class="text-link">KATEGORI LOMBA</span></a></li>
                  <!--ekajul<li class="nav"><a class="menu-link" href="#rule"><span class="text-link">KETENTUAN LOMBA</span></a></li>-->
                  <li class="nav"><a class="menu-link" href="#winner"><span class="text-link">HADIAH</span></a></li>
                  <li class="nav"><a class="menu-link" href="#timeline"><span class="text-link">JADWAL</span></a></li>
                  <!--ekajul<li class="nav"><a class="menu-link" href="#winner-profile"><span class="text-link">PEMENANG TAHUN LALU</span></a></li>-->
                  <li class="nav"><a class="menu-link" href="http://ifest-uajy.com/i2c/pendaftaran.html"><span class="text-link">PENDAFTARAN</span></a></li>
                  <li class="nav"><a class="menu-link" href="http://ifest-uajy.com/i2c/area-peserta.php"><span class="text-link">AREA PESERTA</span></a></li>
                </ul>
            </nav>
            <div class="dropdown">
                <button type="button" name="button" id="dropdown"><img src="img/menu-icon.png" alt=""></button>
                <ul class="dropdown-list">
                  <li class="dropdown-nav"><a class="menu-link" href="#about"><span class="text-link">TENTANG I2C</span></a></li>
                  <li class="dropdown-nav"><a class="menu-link" href="#category"><span class="text-link">KATEGORI LOMBA</span></a></li>
                  <!--ekajul<li class="dropdown-nav"><a class="menu-link" href="#rule"><span class="text-link">KETENTUAN LOMBA</span></a></li>-->
                  <li class="dropdown-nav"><a class="menu-link" href="#winner"><span class="text-link">HADIAH</span></a></li>
                  <li class="dropdown-nav"><a class="menu-link" href="#timeline"><span class="text-link">JADWAL</span></a></li>
                  <!--ekajul<li class="dropdown-nav"><a class="menu-link" href="#winner-profile"><span class="text-link">PEMENANG TAHUN LALU</span></a></li>-->
                  <li class="dropdown-nav"><a class="menu-link" href="http://ifest-uajy.com/i2c/pendaftaran.html"><span class="text-link">PENDAFTARAN</span></a></li>
                  <li class="dropdown-nav"><a class="menu-link" href="http://ifest-uajy.com/i2c/area-peserta.php"><span class="text-link">AREA PESERTA</span></a></li>
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>

  <section id="logo">
    <div class="container">
        <div class="row">
            <div class="twelve columns">
                <img class="i2c-logo" src="img/logo.png" alt="" />
            </div>
        </div>
    </div>
  </section>

  <section ng-app="loginApp" ng-controller="loginCtrl" id="form">
    <div class="container">
        <div class="twelve columns">
            <div id="login-form">
                  <form ng-submit="loginSubmit()" class="form-login">
                      <div class="form-row">
                          <label>Email</label>
                          <input ng-model="formData.email" type="email" name="email" value="" required="">
                      </div>
                      <div class="form-row">
                          <label>Kata Sandi</label>
                          <input ng-model="formData.password" type="password" name="password" value="" required="">
                      </div>
                      <div class="form-row">
                          <button ng-disabled="button == 'MASUK...'" type="submit">{{ button }}</button>
                      </div>
                      <span ng-show="errors">{{ errors }}</span>
                  </form>
                  
          </div>
        </div>
        <!--<div class="six columns">
            <h2>Syarat & Ketentuan</h2>
            <ol class="term-service">
              <li>Lorem ipsum dolor sit amet</li>
              <li>Lorem ipsum dolor sit amet</li>
              <li>Lorem ipsum dolor sit amet</li>
            </ol>
        </div>
      -->
    </div>
  </section>

  <section id="footer">
      <div class="container">
          <div class="row">
              <div class="six columns">
                  <h2>Contact Person</h2>
                  <p>+62 817 5066 108 (Andreas)</p>
                  <p>+62 878 3992 2155 (Dio)</p>
              </div>
              <div class="six columns">
                  <h2>Follow Us</h2>
                  <a href="http://line.me/ti/p/~@ykb1847q"><img class="icon-img" src="img/line-icon.png" alt=""></a>
                  <a href="https://www.instagram.com/ifest_uajy/"><img class="icon-img" src="img/ig-icon.png" alt=""></a>
              </div>
          </div>
      </div>
  </section>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
<script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="bower_components/flexslider/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="vertical-timeline/js/main.js"></script>
<script type="text/javascript" src="vertical-timeline/js/modernizr.js"></script>
<script type="text/javascript" src="bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="bower_components/scrollreveal/dist/scrollreveal.min.js"></script>
<script type="text/javascript" src="bower_components/magnific-popup/dist/jquery.magnific-popup.js"></script>
<script type="text/javascript" src="js/animation.js"></script>

<script type="text/javascript" src="bower_components/angular/angular.min.js"></script>
<script>

var loginApp = angular.module("loginApp", []);
loginApp.controller("loginCtrl", function($scope, $http, $window) {

  $scope.formData = {};
  $scope.errors = "";

  $scope.button = "MASUK";

  $scope.loginSubmit = function () {

    $scope.errors = "";

    $scope.button = "MASUK...";

    $http({
      method  : 'POST',
      url     : 'http://api.ifest-uajy.com/v1/i2c/login',
      data    : $.param($scope.formData),
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
    .then(function(data) {
      if (data.data.status == 200) {

        $scope.button = "MASUK...";

        $http({
          method  : 'POST',
          url     : 'proses-login.php',
          data    : $.param({ id: data.data.data.id, i2c_category_id: data.data.data.i2c_category_id }),
          headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(data) {
          $window.location.href = 'area-peserta.php';
        });

      }else{
        $scope.errors = data.data.errors;
        $scope.button = "MASUK";
      }
    });
  }
});

</script>

</body>
</html>

<?php
  }else{
    header("location: area-peserta.php");
  }
?>