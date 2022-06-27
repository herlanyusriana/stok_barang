<?php
session_start();
// membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","stokbarang");

//menambah barang Baru
if(isset($_POST['addnewbarang'])){
  $namabarang = $_POST['namabarang'];
  $hargabarang = $_POST ['harga'];
  $kodeb = $_POST ['kodebarang'];
  $hasil_rupiah = "Rp " . number_format($hargabarang,2,',','.');
  $addtotable = mysqli_query($conn,"insert into databarang (kodebarang,namabarang,harga) values ('$kodeb','$namabarang','$hasil_rupiah')");
  if($addtotable){
    header ('location:barang.php');
  }else {
    echo 'Gagal';
    header('location:barang.php');
  }
}
//menambah barang Masuk
if (isset($_POST['barangmasuk'])){
  $barangnya = $_POST['barangnya'];
  $keterangan = $_POST['keterangan'];
  $qty = $_POST['qty'];
  $cekdatabarang = mysqli_query($conn,"select * from databarang where kodebarang='$barangnya'");
  $cekstoksekarang = mysqli_query($conn,"select * from stok where kodebarang='$barangnya'");
  $ambildatanya = mysqli_fetch_array($cekdatabarang);
  $ambilstoknya =mysqli_fetch_array($cekstoksekarang);
  $datasekarang = $ambildatanya['databarang'];
  $stoksekarang = $ambilstoknya['stok'];
  $addtomasuk = mysqli_query($conn,"insert into masuk (kodebarang,keterangan,qty) values ('$barangnya','$keterangan','$qty') ");
  if($stoksekarang<$qty){
  $addtoindex = mysqli_query($conn,"insert into stok (kodebarang,namabarang,stok) values ('$barangnya','$barangnya','$qty') ");
    header ('location:masuk.php');
  }
  else if($stoksekarang>=$qty) {
    $tambahkanstoksekarangdenganquantity = $stoksekarang+$qty;
    $updatestokmasuk = mysqli_query($conn,"update stok set stok='$tambahkanstoksekarangdenganquantity' where kodebarang = '$barangnya' ");
    header('location:masuk.php');
  }
}
//menambah barang keluar
if (isset($_POST['barangkeluar'])){
  $barangnya = $_POST['barangnya'];
  $penerima = $_POST['penerima'];
  $qty = $_POST['qty'];
  $cekdatabarang = mysqli_query($conn,"select * from databarang where kodebarang='$barangnya'");
  $cekstoksekarang = mysqli_query($conn,"select * from stok where kodebarang='$barangnya'");
  $ambildatanya = mysqli_fetch_array($cekdatabarang);
  $ambilstoknya =mysqli_fetch_array($cekstoksekarang);
  $datasekarang= $ambildatanya ['databarang'];
  $stoksekarang = $ambilstoknya ['stok'];
  $kurangkanstoksekarangdenganquantity = $stoksekarang-$qty;
  $addtokeluar = mysqli_query($conn,"insert into keluar (kodebarang,penerima,qty) values ('$barangnya','$penerima','$qty') ");
  $updatestokkeluar = mysqli_query($conn,"update stok set stok='$kurangkanstoksekarangdenganquantity' where kodebarang = '$barangnya' ");
  if($addtokeluar&&$updatestokkeluar){
    header ('location:keluar.php');
  }else {
    echo 'Gagal';
    header('location:keluar.php');
  }
}
//update info barang
if(isset($_POST['updatebarang'])){
  $namabarang = $_POST ['namabarang'];
  $hargabarang = $_POST ['harga'];
  $kodeb = $_POST['kodebarang'];
  $hasil_rupiah = "Rp " . number_format($hargabarang,2,',','.');
  $update = mysqli_query($conn,"update databarang set namabarang='$namabarang', harga='$hasil_rupiah' where kodebarang='$kodeb'");
  if ($update){
    header ('location:barang.php');
  }else {
    echo 'Gagal';
    header('location:barang.php');
  }
  }
  //menghapus barang
  if(isset($_POST['hapusbarang'])){
    $kodeb = $_POST ['kodebarang'];
    $hapus = mysqli_query($conn,"delete from databarang where kodebarang = '$kodeb'");
    if ($hapus){
      header ('location:barang.php');
    }else {
      echo 'Gagal';
      header('location:barang.php');
    }
  }
  //update info barang Stok
  if(isset($_POST['updatebarangstok'])){
    $namabarang = $_POST ['namabarang'];
    $deskripsi = $_POST ['deskripsi'];
    $stok = $_POST ['stok'];
    $kodeb = $_POST['kodebarang'];
    $update = mysqli_query($conn,"update stok set namabarang = '$namabarang',deskripsi='$deskripsi',stok='$stok' where kodebarang = '$kodeb'");
    if ($update){
      header ('location:index.php');
    } else {
      echo 'Gagal';
      header('location:index.php');
    }
    }
    //menghapus barang stok
    if(isset($_POST['hapusbarangstok'])){
      $kodeb = $_POST ['kodebarang'];
      $hapus = mysqli_query($conn,"delete from stok where kodebarang = '$kodeb'");
      if ($hapus){
        header ('location:index.php');
      }else {
        echo 'Gagal';
        header('location:index.php');
      }
    }

//mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
  $kodeb = $_POST['kodebarang'];
  $idm = $_POST['idmasuk'];
  $keterangan = $_POST ['keterangan'];
  $qty = $_POST ['qty'];

  $lihatstok = mysqli_query($conn,"select * from stok where kodebarang = '$kodeb'");
  $stoknya = mysqli_fetch_array($lihatstok);
  $stokskrg = $stoknya['stok'];
  $qtyskrg = mysqli_query ($conn,"select * from masuk where idmasuk = '$idm'");
  $qtynya = mysqli_fetch_array($qtyskrg);
  $qtyskrg= $qtynya ['qty'];
  if ($qty>$qtyskrg) {
    $selisih = $qty-$qtyskrg;
    $kurangin = $stokskrg + $selisih;
    $kurangistoknya = mysqli_query($conn,"update stok set stok='$kurangin' where kodebarang = '$kodeb'");
    $updatenya = mysqli_query($conn,"update masuk set qty = '$qty',keterangan='$keterangan' where idmasuk = '$idm'");
    if($kurangistoknya&&$updatenya){
      header ('location:masuk.php');
    }else {
      echo 'Gagal';
      header('location:masuk.php');
    }
    }
    else {
    $selisih = $qtyskrg-$qty;
    $kurangin = $stokskrg - $selisih;
    $kurangistoknya = mysqli_query($conn,"update stok set stok='$kurangin' where kodebarang='$kodeb'");
    $updatenya = mysqli_query($conn,"update masuk set qty = '$qty',keterangan='$keterangan' where idmasuk = '$idm'");
    if($kurangistoknya&&$updatenya){
      header ('location:masuk.php');
    }else {
      echo 'Gagal';
      header('location:masuk.php');
    }
    }
  }
//menghapus barang masuk
if(isset ($_POST['hapusbarangmasuk'])){
  $kodeb = $_POST ['kodebarang'];
  $qty = $_POST ['qty'];
  $idm = $_POST ['idm'];
  $getdatastok = mysqli_query($conn,"select * from stok where kodebarang = '$kodeb'");
  $data = mysqli_fetch_array($getdatastok);
  $stok = $data ['stok'];
  $selisih = $stok-$qty;
  $update = mysqli_query($conn,"update stok set stok = '$selisih' where kodebarang ='$kodeb'");
  $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk= '$idm' ");

  if ($update&&$hapusdata){
    header ('location:masuk.php');
  }
  else{
    header ('location:masuk.php');
  }
}
// update barang Keluar
if(isset($_POST['updatebarangkeluar'])){
  $kodeb = $_POST['kodebarang'];
  $idk = $_POST['idkeluar'];
  $penerima = $_POST ['penerima'];
  $qty = $_POST ['qty'];

  $lihatstok = mysqli_query($conn,"select * from stok where kodebarang = '$kodeb'");
  $stoknya = mysqli_fetch_array($lihatstok);
  $stokskrg = $stoknya['stok'];
  $qtyskrg = mysqli_query ($conn,"select * from keluar where idkeluar = '$idk'");
  $qtynya = mysqli_fetch_array($qtyskrg);
  $qtyskrg= $qtynya ['qty'];
  if ($qty>$qtyskrg) {
    $selisih = $qty-$qtyskrg;
    $kurangin = $stokskrg - $selisih;
    $kurangistoknya = mysqli_query($conn,"update stok set stok='$kurangin' where kodebarang = '$kodeb'");
    $updatenya = mysqli_query($conn,"update keluar set qty = '$qty',penerima='$penerima' where idkeluar = '$idk'");
    if($kurangistoknya&&$updatenya){
      header ('location:keluar.php');
    }else {
      echo 'Gagal';
      header('location:keluar.php');
    }
    }
    else {
    $selisih = $qtyskrg-$qty;
    $kurangin = $stokskrg + $selisih;
    $kurangistoknya = mysqli_query($conn,"update stok set stok='$kurangin' where kodebarang='$kodeb'");
    $updatenya = mysqli_query($conn,"update keluar set qty = '$qty',penerima='$penerima' where idkeluar = '$idk'");
    if($kurangistoknya&&$updatenya){
      header ('location:keluar.php');
    }else {
      echo 'Gagal';
      header('location:keluar.php');
    }
    }
  }
//menghapus barang keluar
if(isset ($_POST['hapusbarangkeluar'])){
  $kodeb = $_POST ['kodebarang'];
  $qty = $_POST ['qty'];
  $idk = $_POST ['idk'];
  $getdatastok = mysqli_query($conn,"select * from stok where kodebarang = '$kodeb'");
  $data = mysqli_fetch_array($getdatastok);
  $stok = $data ['stok'];
  $selisih = $stok + $qty;
  $update = mysqli_query($conn,"update stok set stok = '$selisih' where kodebarang ='$kodeb'");
  $hapusdata = mysqli_query($conn,"delete from keluar where idkeluar= '$idk' ");

  if ($update&&$hapusdata){
    header ('location:keluar.php');
  }
  else{
    header ('location:keluar.php');
  }
}
//menambah admin
if(isset($_POST['addadmin'])){
  $email = $_POST['email'];
  $pw = $_POST ['password'];
  $addtotable = mysqli_query($conn,"insert into login (email,password) values ('$email','$pw')");

  if($addtotable){

    header ('location:admin.php');
  }else {
    echo 'Gagal';
    header('location:admin.php');
  }
}
// update info Admin
if(isset($_POST['updateadmin'])){
  $id = $_POST ['iduser'];
  $email = $_POST ['email'];
  $password = $_POST['password'];
  $update = mysqli_query($conn,"update login set email='$email', password='$password' where iduser='$id'");
  if ($update){
    header ('location:admin.php');
  }else {
    echo 'Gagal';
    header('location:admin.php');
  }
  }

  //menghapus admin
  if(isset($_POST['hapusadmin'])){
    $id = $_POST ['iduser'];
    $hapus = mysqli_query($conn,"delete from login where iduser = '$id'");
    if ($hapus){
      header ('location:admin.php');
    }else {
      echo 'Gagal';
      header('location:admin.php');
    }
  }

 ?>
