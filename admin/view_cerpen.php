<?php 

  include('config/connect-db.php'); 
  include('template/atas.php'); 

?>
  
   


    
  <!-- Login -->
  <div class="w3-container" id="login" style="margin-top:75px"> 
    <h1 class="w3-xxxlarge judul-content"><b>Kelola Cerpen</b></h1>
    <hr class="w3-round garis-judul-content">
      
      <a href="tambah_cerpen.php" class="w3-button w3-padding-large w3-red w3-margin-bottom">Tambah Data</a>
      <br><br>

      <table border=1 width="100%" style="border-collapse: collapse;">
        <tr class="w3-red">
          <th>No</th>
          <th>Judul Cerpen</th>
          <th>Isi Cerpen</th>
          <th>Aksi</th>
        </tr>
        

        <?php
          $no = 1;
          $result = mysqli_query($mysqli, "SELECT * FROM tb_cerpen");
          while($data = mysqli_fetch_array($result)) { 
        ?>
        <tr>
          <td><center><?php echo $no; ?></td>
          <td><?php echo $data['judul']; ?></td>
          <td><?php echo substr($data['isi_cerpen'],0,30).'...'; ?></td>
          <td><center>
            <a href="edit_cerpen.php?id=<?php echo $data['id']; ?>" class="btn btn-danger waves-effect">EDIT</a>
            <a href="hapus_cerpen.php?id=<?php echo $data['id']; ?>" class="btn btn-danger waves-effect" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Ini?');">HAPUS</a>
          </td>
        </tr>
        <?php $no++; } ?>


      </table>

  </div>


  
  
<!-- End page content -->
</div>


<br><br><br><br>

<?php 
   
  include('template/bawah.php'); 


?>

