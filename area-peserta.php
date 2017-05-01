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
    <link rel="icon" type="image/png" href="img/favicon.png">
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
                    <tr>
                      <th>Vegetarian</th>
                      <td>
                        <input ng-model="dataTeam.vegetarian" type="radio" name="vegetarian" ng-value='"1"' /> Iya
                        <input ng-model="dataTeam.vegetarian" type="radio" name="vegetarian" ng-value='"0"' /> Tidak
                      </td>
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
                <p>Diberitahukan kepada seluruh perserta i2c kategori ide aplikasi mobile, bahwa batas pengumpulan proposal diundur sampai tanggal 8 April 2017. Bagi peserta yang sudah mendaftar jangan lupa juga untuk melengkapi data-data diri ya</p>
                <p>Untuk kategori FTI Promotional Video, batas pengumpulan video juga diundur sampai tanggal 28 April 2017. Pada tanggal 19-27 April 2017, peserta sudah diijinkan untuk mengambil video di seluruh Lab. FTI dengan membawa surat pernyataan peserta yang bisa diambil di stand iFest atau bisa meminta surat tersebut ke panitia iFest.</p>
                <p>Untuk mengambil surat pernyataan peserta ini, peserta harus melakukan pelunasan terlebih dahulu dan membawa bukti pembayarannya pada saat meminta surat.</p>
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
<script type="text/javascript" src="js/i2cApp.js"></script>

<?php
  }else{
    header("location: login.php");
  }
?>
