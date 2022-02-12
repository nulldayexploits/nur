<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Pencarian Cerpen</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<style type="text/css">
		
		body{
			font-family: calibri;
		}
		
		input[type=text], select {
		  width: 50%;
		  padding: 12px 20px;
		  margin: 8px 0;
		  display: inline-block;
		  border: 1px solid #ccc;
		  border-radius: 4px;
		  box-sizing: border-box;
		}


		.button {
		  background-color: #4CAF50; /* Green */
		  border: none;
		  color: white;
		  padding: 15px 32px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 16px;
		}

	</style>
</head>
<body>

<center>
	<h1 style="font-size:50px">Pencarian Cerpen</h1>
	<br>
	<form method="post">
		<input type="text" name="p" placeholder="Masukkan Kata Kunci....">
		<br>
		<br>
		<input type="submit" name="submit" class="button" value="CARI">
		<a href="login.php" class="button">LOGIN</a>
    </form>
</center>


<?php
include_once __DIR__."/VSMModule/Preprocessing.php";
include_once __DIR__."/VSMModule/VSM.php";
include 'admin/config/connect-db.php';

function pencarian($katakunci, $mysqli)
{
    // == STEP 1 inisialisasi
    $preprocess = new Preprocessing();
    $vsm = new VSM();

    // == STEP 2 mendapatkan kata dasar
    $query = $preprocess::preprocess($katakunci);

    // == waktu mulai 
    $start_time = microtime(true);
    $a=1;

    // == STEP 3 medapatkan dokumen ke array
    $connect = mysqli_query($mysqli, "SELECT * FROM tb_cerpen");
    $arrayDokumen = [];
    while ($row = mysqli_fetch_assoc($connect)) {
        $arrayDoc = [
            'id_doc' => $row['id'].' || '.$row['judul'],
            'dokumen' => implode(" ", $preprocess::preprocess($row['isi_cerpen']))
        ];
        array_push($arrayDokumen, $arrayDoc);
    }
    
    // STEP 4 == mendapatkan ranking dengan VSM
    $rank = $vsm::get_rank($query, $arrayDokumen);
    //var_dump($rank);
    tampildata($katakunci, $rank);

    // End clock time in seconds
	$end_time = microtime(true);
	  
	// Calculate script execution time
	$execution_time = ($end_time - $start_time);
	  
	echo "<br><b>Waktu Eksekusi: ".$execution_time." Detik</b>";

    die();

}

function tampildata($query, $data)
{
	$no = 1;
    ksort($data);

    echo "<br><br>
		  <b style='margin-left:150px;font-size:20px;'>Kata Kunci Yang Dimasukkan: <i><u>$query</u></i></b>
		  <center>
		  <table class='w3-table-all' style='width:80%'>
			<tr class='w3-green'>
			  <th>No</th>
			  <th>Judul</th>
			  <th>Nilai VSM</th>
			  <th>Aksi</th>
			</tr>";


    foreach($data as $d){

    	if($d['ranking'] > 0)
    	{

			$id = explode(' || ', $d['id_doc']);
			$dx = $id[0];
			$nm = $id[1];

		    echo "<tr>
				  <td>".$no."</td>
				  <td>".$id[1]."</td>
				  <td>".$d['ranking']."</td>
				  <td><a href='baca.php?id=".$dx."' class='button'>Baca Cerpen</a></td>
				</tr>";

    	    $no++;
        }

    }
    

    echo "</table>";


}

if(isset($_POST['submit'])){

  // jalankan fungsi
  pencarian($_POST['p'], $mysqli);

}


?>
</body>
</html>