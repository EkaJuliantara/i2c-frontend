var base_url = "http://api.ifest-uajy.com/v1/i2c";
var media_url = "http://api.ifest-uajy.com/v1/media";

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

var registerApp = angular.module("registerApp", [])
  .factory('httpInterceptor', httpInterceptor)
  .config(function($httpProvider) {
    $httpProvider.interceptors.push('httpInterceptor');
  });

registerApp.controller("registerCtrl", function($scope, $http, $window) {

  $scope.formData = {};
  $scope.errors = {};

  $scope.button = "DAFTAR";

  $scope.registerSubmit = function () {

    $scope.errors = {};

    $scope.button = "MENDAFTAR...";

    $http({
      method  : 'POST',
      url     : base_url,
      data    : $.param($scope.formData),
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
    .then(function(response) {
      switch (response.status) {
        case 400:
          $scope.errors = response.data.errors;
          $scope.button = "DAFTAR";
        break;
        case 500:
          $scope.errors.ise = "Mohon maaf terdapat kesalahan di bagian server.";
          $scope.button = "DAFTAR";
          break;
        default:
          $window.location.href = 'pendaftaran-berhasil.html';
          $scope.button = "DAFTAR";
      }
    });
  }
});

var loginApp = angular.module("loginApp", [])
  .factory('httpInterceptor', httpInterceptor)
  .config(function($httpProvider) {
    $httpProvider.interceptors.push('httpInterceptor');
  });

loginApp.controller("loginCtrl", function($scope, $http, $window) {

  $scope.formData = {};
  $scope.errors = "";

  $scope.button = "MASUK";

  $scope.loginSubmit = function () {

    $scope.errors = "";

    $scope.button = "MASUK...";

    $http({
      method  : 'POST',
      url     : base_url+'/'+'login',
      data    : $.param($scope.formData),
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
    .then(function(response) {
      switch (response.status) {
        case 400:
          $scope.errors = response.data.errors;
          $scope.button = "MASUK";
        break;
        case 500:
          $scope.errors.ise = "Mohon maaf terdapat kesalahan di bagian server.";
          $scope.button = "MASUK";
          break;
        default:
          $scope.button = "MASUK...";

          $http({
            method  : 'POST',
            url     : 'proses-login.php',
            data    : $.param({ id: response.data.data.id, i2c_category_id: response.data.data.i2c_category_id }),
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
          }).then(function(data) {
            $window.location.href = 'area-peserta.php';
          });
      }
    });
  }
});

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

  $scope.dataTeamLoaded = 0;
  $scope.dataMembersLoaded = 0;
  $scope.dataDetailsLoaded = 0;

  $scope.getTeam = function() {

    $http.get(base_url+'/'+$scope.idTeam).then(function (response) {

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

    //$scope.dataTeam['status'] = 0;
    $scope.errors = {};
    $scope.button = "Menyimpan...";

    $http({
      method  : 'PATCH',
      url     : base_url+'/'+$scope.idTeam,
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
    $http.get(base_url+'/'+$scope.idTeam+'/details').then(function (response) {
      if (response.data.data) {
        $scope.dataDetails = response.data.data;
      }else{
        $scope.dataDetails = 0;
      }

      $scope.dataDetailsLoaded = 1;

      angular.forEach($scope.dataDetails, function(value, key) {
        if (value.document_id) {
          $http.get(media_url+'/'+value.document_id).then(function (response) {
            value.document_name = response.data.data.file_name;
          });
        }
        if (value.payment_id) {
          $http.get(media_url+'/'+value.payment_id).then(function (response) {
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
      url     : base_url+'/'+$scope.idTeam+'/detail',
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
          url     : base_url+'/'+$scope.idTeam+'/detail/'+id,
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

    $http.delete(base_url+'/'+$scope.idTeam+'/detail/'+id).then(function (response) {
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
    $http.get(base_url+'/'+$scope.idTeam+'/members').then(function (response) {
      if (response.data.data) {
        $scope.dataMembers = response.data.data;
      }else{
        $scope.dataMembers = 0;
      }
      $scope.dataMembersLoaded = 1;

      angular.forEach($scope.dataMembers, function(value, key) {
        $http.get(media_url+'/'+value.media_id).then(function (response) {
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
            url     : base_url+'/'+$scope.idTeam+'/members',
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
      url     : base_url+'/'+$scope.idTeam+'/members/'+data.id,
      data    : $.param(data),
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
     })
    .then(function(data) {
      $scope.hideMember = false;
      $scope.btnUpdate = "Simpan";
    });
  }

  $scope.updateVegetarian = function(data) {
    if(data.vegetarian == 0){
      data.vegetarian = 1;
    } else {
      data.vegetarian = 0;
    }
    $http({
      method : 'PATCH',
      url     : base_url+'/'+$scope.idTeam+'/members/'+data.id,
      data    : $.param(data),
      headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
    });
  }

  $scope.hidingUpdateMember = function(id) {
    $scope.hideMember = id;
  }

  $scope.destroyMember = function(id) {

    $('.btn.delete-member.'+id).text('Menghapus...');

    $http.delete(base_url+'/'+$scope.idTeam+'/members/'+id).then(function (response) {
      $scope.getMembers();
    })
    .then(function(data) {
      $('.btn.delete-member.'+id).text('Terhapus');
      $timeout(function() { $('.btn.delete-member.'+id).text('Hapus'); }, 1000);
    });
  }

  $scope.getMembers();

});
