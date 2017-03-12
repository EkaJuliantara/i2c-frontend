<?php
  ob_start();
  session_start();
  if ($_SESSION['i2c_teams']['id']) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>I2C - Area Peserta</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/admin.css">

    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <!--<link rel="icon" type="image/png" href="images/favicon.png">-->
  </head>
  <body>
    <section id="header">
        <div class="container">
            <div class="row">
                <div class="twelve columns">
                  <a href="http://ifest-uajy.com/i2c" class="logo">
                      <img class="i2c-logo" src="img/logo.png" alt="" />
                  </a>
                  <a class="btn logout" href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </section>

    <section ng-app="i2c2App" ng-init="idTeam=<?php echo $_SESSION['i2c_teams']['id']; ?>; categoryTeam=<?php echo $_SESSION['i2c_teams']['i2c_category_id']; ?>" id="main">
      <div ng-controller="dataTeamCtrl" class="container">
        <div class="row">
          <div class="eight columns">
            <div class="box">
              <div class="box-body">

              <div>
                <h5>Data Tim</h5>
                <form ng-show="dataTeamLoaded" ng-submit="updateTeam()">
                  <table>
                    <tr>
                      <th>Nama Tim</th>
                      <td><input ng-model="dataTeam.name" type="text" name="name" required /></td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td><input ng-model="dataTeam.email" type="email" name="email" required /></td>
                    </tr>
                    <tr>
                      <th>No. HP</th>
                      <td><input ng-model="dataTeam.phone" type="text" name="phone" required /></td>
                    </tr>
                    <tr ng-show="categoryTeam == 1">
                      <th>Asal Sekolah</th>
                      <td><input ng-model="dataTeam.origin" type="text" name="origin" /></td>
                    </tr>
                    <tr>
                      <th>Kategori Lomba</th>
                      <td>{{ dataTeam.category.name }}</td>
                    </tr>
                  </table>
                  <button type="submit" class="btn">{{ button }}</button>
                </form>
              
                <p ng-hide="dataTeamLoaded">Sedang mengambil data dari server. Mohon tunggu sebentar ya...</p>
                </div>

                <br>

                <div ng-controller="dataDetailCtrl">
                <h5>Detail</h5>
                <table ng-show="dataDetailsLoaded" class="table">
                  <thead>
                    <tr>
                      <th ng-show="categoryTeam == 1">
                        Proposal
                      </th>
                      <th>
                        Bukti Pembayaran
                      </th>
                      <th>
                        Status
                      </th>
                      <th>
                        
                      </th>
                    </tr>
                  </thead>
                  <tbody id="detail-list">
                    <tr ng-repeat="data in dataDetails">
                      <td ng-show="categoryTeam == 1"><a href="http://api.ifest-uajy.com/storage/media/{{ data.document_name }}" target="_blank">Lihat</a></td>
                      <td>
                        <a ng-show="data.payment_id != NULL" href="http://api.ifest-uajy.com/storage/media/{{ data.payment_name }}" target="_blank">Lihat</a>
                        
                        <button ng-show="data.payment_id == NULL && categoryTeam == 1" type="file" ngf-select="uploadPayment($file, $invalidFiles, data.id)" accept="image/*" ngf-max-size="10MB" class="btn">Unggah</button> <span ng-show="data.payment_id == NULL && categoryTeam == 1" class="payment-info {{ data.id }}">Pilih file untuk diunggah</span>
                      </td>
                      <td>
                        <span ng-show="data.status == NULL">Menunggu verifikasi...</span>
                        <span ng-show="data.status == 0">Tidak lolos</span>
                        <span ng-show="data.status == 1">Lolos</span>
                      </td>
                      <td>
                        <button ng-show="data.payment_id == NULL && categoryTeam == 1" ng-click="updateDetail(data.id)" type="button" class="btn update-detail {{ data.id }}">Simpan</button>
                        <button ng-show="data.status == NULL" ng-click="destroyDetail(data.id)" type="button" class="btn delete-detail {{ data.id }}">Hapus</button>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <p ng-hide="dataDetailsLoaded">Sedang mengambil data dari server. Mohon tunggu sebentar ya...</p>
                </div>

                <br>

                <div ng-controller="dataMembersCtrl">
                <h5>Data Anggota</h5>
                <table ng-show="dataMembersLoaded" class="table">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Kartu Identitas</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="member-list">
                    <tr ng-repeat="data in dataMembers" class="member">
                      <td>
                        <input ng-show="hideMember == data.id" ng-model="data.full_name" type="text" required />
                        <span ng-hide="hideMember == data.id">{{ data.full_name }}</span>
                      </td>
                      <td>
                        <a href="http://api.ifest-uajy.com/storage/media/{{ data.media_name }}" target="_blank">Lihat</a>
                      </td>
                      <td>
                        <button ng-hide="hideMember == data.id" ng-click="hidingUpdateMember(data.id)" type="button" class="btn">Sunting</button> <button ng-show="hideMember == data.id" ng-click="updateMember(data)" type="button" class="btn">{{ btnUpdate }}</button> <button ng-click="destroyMember(data.id)" type="button" class="btn delete-member {{ data.id }}">Hapus</button>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <p ng-hide="dataMembersLoaded">Sedang mengambil data dari server. Mohon tunggu sebentar ya...</p>
                </div>

              </div>
            </div>
          </div>
          <div class="four columns">
            <div class="box">
              <div class="box-header">
                <h5>Pengumuman</h5>
              </div>
              <div class="box-body">
                <p>Kecepatan koneksi internet mempengaruhi cepatnya data ditampilkan. Apabila data belum tertampil, silakan muat ulang halaman.</p>
                <p>Kami menyarankan menggunakan browser Mozilla Firefox</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Document
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
 </body>
</html>

<script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="bower_components/angular/angular.min.js"></script>
<script type="text/javascript" src="bower_components/ng-file-upload-shim/ng-file-upload-shim.min.js"></script>
<script type="text/javascript" src="bower_components/ng-file-upload/ng-file-upload.min.js"></script>

<script>
  function httpInterceptor() {
    return {
      request: function(config) {
        return config;
      },

      requestError: function(config) {
        return config;
      },

      response: function(res) {
        return res;
      },

      responseError: function(res) {
        return res;
      }
    }
  }

  var app = angular.module('i2c2App', ['ngFileUpload'])
    .factory('httpInterceptor', httpInterceptor)
    .config(function($httpProvider) {
      $httpProvider.interceptors.push('httpInterceptor');
    });

  app.controller('dataTeamCtrl', function($scope, $http, $timeout, Upload) {

    $scope.dataTeam = {};
    $scope.errors = {};
    $scope.status = "";
    $scope.button = "Simpan";
    $scope.dataTeam = {};

    $scope.dataTeamLoaded = 0;
    $scope.dataMembersLoaded = 0;
    $scope.dataDetailsLoaded = 0;

    $scope.getTeam = function() {

      $http.get("http://api.ifest-uajy.com/v1/i2c/"+$scope.idTeam).then(function (response) {

        $scope.dataTeamLoaded = 0;
        $scope.dataTeam = response.data.data;
        $scope.dataTeamLoaded = 1;
        if ($scope.dataTeam.status == 0) {
          $scope.status = "Tidak Aktif";
        }else{
          $scope.status = "Aktif";
        }

      });
    }

    $scope.getTeam();

    $scope.updateTeam = function () {

      $scope.dataTeam['status'] = 0;
      $scope.errors = {};
      $scope.button = "Menyimpan..."

      $http({
        method  : 'PATCH',
        url     : 'http://api.ifest-uajy.com/v1/i2c/'+$scope.idTeam,
        data    : $.param($scope.dataTeam),
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
       })
      .then(function(response) {
        switch (response.status) {
          case 400:
            $scope.errors = response.data.errors;
            $scope.button = "Simpan";
          break;
          case 500:
            $scope.errors.ise = "Mohon maaf terdapat kesalahan di bagian server.";
            $scope.button = "DAFTAR";
            break;
          default:
            $scope.button = "Tersimpan";
            $timeout(function() { $scope.button = "Simpan"; }, 1000);
        }
      });
    }

  });

  app.controller('dataDetailCtrl', function($scope, $http, $compile, $timeout, Upload) {

    $scope.infoDocument = "Pilih file untuk diunggah.";
    $scope.infoPayment = "Pilih file untuk diunggah.";
    $scope.btnSave = "Simpan";

    $scope.dataDetail = {};

    $scope.uploadDocument = function(file, errFiles) {
      $scope.document = file;
      $scope.errDocument = errFiles && errFiles[0];
      $scope.infoDocument = $scope.document.name;
    }

    $scope.uploadPayment = function(file, errFiles, id) {
      $scope.payment = file;
      $scope.errPayment = errFiles && errFiles[0];

      if (id) {
        $('.payment-info.'+id).text($scope.payment.name);
      }else{
        $scope.infoPayment = $scope.payment.name;
      }
    }

    $scope.getDetail = function() {
      $scope.dataDetailsLoaded = 0;
      $http.get("http://api.ifest-uajy.com/v1/i2c/"+$scope.idTeam+'/details').then(function (response) {
        if (response.data.data) {
          $scope.dataDetails = response.data.data;
        }else{
          $scope.dataDetails = 0;
        }
        
        $scope.dataDetailsLoaded = 1;

        angular.forEach($scope.dataDetails, function(value, key) {
          if (value.document_id) {
            $http.get("http://api.ifest-uajy.com/v1/media/"+value.document_id).then(function (response) {
              value.document_name = response.data.data.file_name;
            });
          }
          if (value.payment_id) {
            $http.get("http://api.ifest-uajy.com/v1/media/"+value.payment_id).then(function (response) {
              value.payment_name = response.data.data.file_name;
            });
          }
        });

        $('.new-details').remove();

        var count = $scope.dataDetails.length;

        var row = angular.element('<tr class="new-details"><td ng-show="categoryTeam == 1"><button type="file" ngf-select="uploadDocument($file, $invalidFiles)" accept="image/*" ngf-max-size="10MB" class="btn">Unggah</button> <span>{{ infoDocument }}</span></td><td ng-show="categoryTeam == 2"><button type="file" ngf-select="uploadPayment($file, $invalidFiles)" accept="image/*" ngf-max-size="10MB" class="btn">Unggah</button> <span>{{ infoPayment }}</span></td><td ng-show="categoryTeam == 1"></td><td></td><td><button ng-click="addDetail()" type="button" class="btn">{{ btnSave }}</button></td></tr>');

        $('#detail-list').append(row);

        if ($scope.categoryTeam == 2 && count >= 1) {
          $('.new-details').remove();
        }

        $compile(row)($scope);

      });
    }

    $scope.addDetail = function() {

      if ($scope.categoryTeam == 1) {

        if ($scope.document) {

          $scope.btnSave = "Menyimpan...";

          $scope.document.upload = Upload.upload({
              url: 'http://api.ifest-uajy.com/v1/media',
              data: { media: $scope.document }
          }).then(function (response) {

            $scope.infoDocument = "Upload";
            $timeout(function() { $scope.infoDocument = "Pilih file untuk diunggah." }, 1000);
            $scope.dataDetail['document_id'] = response.data.data.id;
            $scope.addDetailProcess();
            $scope.document = "";
          });
        }else{
            $scope.infoDocument = "Unggah proposal terlebih dahulu";
            $scope.btnSave = "Simpan";
        }

      }

      if ($scope.categoryTeam == 2) {

        if ($scope.payment) {

          $scope.btnSave = "Menyimpan...";

          $scope.payment.upload = Upload.upload({
              url: 'http://api.ifest-uajy.com/v1/media',
              data: { media: $scope.payment }
          }).then(function (response) {

            $scope.infoPayment = "Upload";
            $timeout(function() { $scope.infoPayment = "Pilih file untuk diunggah." }, 1000);
            $scope.dataDetail['payment_id'] = response.data.data.id;
            $scope.addDetailProcess();
            $scope.payment = "";
          });

        }else{
            $scope.infoPayment = "Unggah bukti pembayaran terlebih dahulu";
            $scope.btnSave = "Simpan";
        }

      }

    }

    $scope.addDetailProcess = function() {
      $scope.dataDetail['i2c_team_id'] = $scope.idTeam;

      $http({
        method  : 'POST',
        url     : 'http://api.ifest-uajy.com/v1/i2c/'+$scope.idTeam+'/detail',
        data    : $.param($scope.dataDetail),
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
       })
      .then(function(data) {
        $scope.btnSave = "Simpan";
        $scope.getDetail();
      });
    }

    $scope.updateDetail = function(id) {

      if ($scope.payment) {

        $('.btn.update-detail.'+id).text('Menyimpan...');

        $scope.payment.upload = Upload.upload({
            url: 'http://api.ifest-uajy.com/v1/media',
            data: { media: $scope.payment }
        }).then(function (response) {

          $scope.dataDetail['payment_id'] = response.data.data.id;
          
          $http({
            method  : 'PATCH',
            url     : 'http://api.ifest-uajy.com/v1/i2c/'+$scope.idTeam+'/detail/'+id,
            data    : $.param($scope.dataDetail),
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
           })
          .then(function(data) {
            $('.btn.update-detail.'+id).text('Simpan');
            $('.payment-info.'+id).text('Pilih file untuk diunggah');
            $scope.getDetail();
            $scope.payment = "";
          });
        });

      }
    }

    $scope.destroyDetail = function(id) {

      $('.btn.delete-detail.'+id).text('Menghapus...');

      $http.delete('http://api.ifest-uajy.com/v1/i2c/'+$scope.idTeam+'/detail/'+id).then(function (response) {
        $scope.getDetail();
      })
      .then(function(data) {
        $('.btn.delete-detail.'+id).text('Terhapus');
        $timeout(function() { $('.btn.delete-detail.'+id).text('Hapus'); }, 1000);
      });
    }

    $scope.getDetail();

  });

  app.controller('dataMembersCtrl', function($scope, $http, $compile, $timeout, Upload) {

    $scope.dataMembers = {};
    $scope.newMembers = {};
    $scope.hideMember = false;
    $scope.errors = {};
    $scope.btnSave = "Simpan";
    $scope.btnUpdate = "Simpan";
    $scope.btnDelete = "Hapus";

    $scope.infoFullName = ""
    $scope.infoMedia = "Pilih file untuk diunggah.";


    $scope.uploadFiles = function(file, errFiles) {
        $scope.media = file;
        $scope.errMedia = errFiles && errFiles[0];
        $scope.infoMedia = $scope.media.name; 
    }

    $scope.getMembers = function() {

      $scope.dataMembersLoaded = 0;
      $http.get("http://api.ifest-uajy.com/v1/i2c/"+$scope.idTeam+'/members').then(function (response) {        
        if (response.data.data) {
          $scope.dataMembers = response.data.data;
        }else{
          $scope.dataMembers = 0;
        }
        $scope.dataMembersLoaded = 1;

        angular.forEach($scope.dataMembers, function(value, key) {
          $http.get("http://api.ifest-uajy.com/v1/media/"+value.media_id).then(function (response) {
            value.media_name = response.data.data.file_name;
          });
        });

        $('.new-member').remove();

        var count = $scope.dataMembers.length;

        if (count != 5) {
          var row = angular.element('<tr class="new-member"><td><input ng-model="newMembers.members[0][\'full_name\']" type="text" required="" /><br><span>{{ infoFullName }}</span></td><td><button type="file" ngf-select="uploadFiles($file, $invalidFiles)" accept="image/*" ngf-max-size="10MB" class="btn">Unggah</button><br><span>{{ infoMedia }}</span></td><td><button ng-click="addMembers()" type="button" class="btn">{{ btnSave }}</button></tr>');
          $('#member-list').append(row);
          $compile(row)($scope);
        }
      });
    }

    $scope.addMembers = function() {

      if ($scope.newMembers.members) {

        $scope.infoFullName = "";

        if ($scope.media) {

          $scope.btnSave = "Menyimpan...";

          $scope.media.upload = Upload.upload({
              url: 'http://api.ifest-uajy.com/v1/media',
              data: {media: $scope.media}
          });

          $scope.media.upload.then(function (response) {

            $scope.newMembers.members[0]["media_id"] = response.data.data.id;

            $http({
              method  : 'POST',
              url     : 'http://api.ifest-uajy.com/v1/i2c/'+$scope.idTeam+'/members',
              data    : $.param($scope.newMembers),
              headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
             })
            .then(function(response) {
              switch (response.status) {
                case 400:
                  $scope.errors = response.data.errors;
                  $scope.btnSave = "Simpan";
                break;
                case 500:
                  $scope.errors.ise = "Mohon maaf terdapat kesalahan di bagian server.";
                  $scope.button = "DAFTAR";
                  break;
                default:
                  $scope.newMembers = {};
                  $scope.btnSave = "Simpan";
                  $scope.getMembers();
                  $scope.infoMedia = "Pilih file untuk diunggah.";
              }
            });            
          });

        }else{
          $scope.infoMedia = "Unggah kartu identitas!";
        }

      }else{
        $scope.infoFullName = "Isi nama lengkap!";
      }
    }

    $scope.updateMember = function(data) {

      $scope.btnUpdate = "Menyimpan...";

      $http({
        method  : 'PATCH',
        url     : 'http://api.ifest-uajy.com/v1/i2c/'+$scope.idTeam+'/members/'+data.id,
        data    : $.param(data),
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
       })
      .then(function(data) {
        $scope.hideMember = false;
        $scope.btnUpdate = "Simpan";
      });
    }

    $scope.hidingUpdateMember = function(id) {
      $scope.hideMember = id;
    }

    $scope.destroyMember = function(id) {

      $('.btn.delete-member.'+id).text('Menghapus...');

      $http.delete('http://api.ifest-uajy.com/v1/i2c/'+$scope.idTeam+'/members/'+id).then(function (response) {
        $scope.getMembers();
      })
      .then(function(data) {
        $('.btn.delete-member.'+id).text('Terhapus');
        $timeout(function() { $('.btn.delete-member.'+id).text('Hapus'); }, 1000);
      });
    }

    $scope.getMembers();

  });

</script>

<?php
  }else{
    header("location: login.php");
  }
?>