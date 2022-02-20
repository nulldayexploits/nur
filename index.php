<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Pencarian Cerpen</title>

    <!-- bootstrap 5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	
	<!-- data tables -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">


    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />

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


    <main>
      <div class="container mt-4">


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
          <div class='datatable'>
          <table id='example' class='table table-striped' style='width:100%'>
            <thead>
			<tr>
			  <th>No</th>
			  <th>Judul</th>
			  <th>Nilai VSM</th>
			  <th>Aksi</th>
			</tr>
			</thead>
			<tbody>";


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
    

    echo "</tbody>
          <tfoot>  
            <tr>
			  <th>No</th>
			  <th>Judul</th>
			  <th>Nilai VSM</th>
			  <th>Aksi</th>
			</tr>
		  </tfoot>
    	</table>
      </div>";



}

if(isset($_POST['submit'])){

  // jalankan fungsi
  pencarian($_POST['p'], $mysqli);

}


?>



    </main>
  </div>

  <!-- bootstrap js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
 
  <!-- data tables -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
  
  <script type="text/javascript">
  	
	$(document).ready(function() {
	    $('#example').DataTable( {
	        "order": [[ 2, "desc" ]]
	    });
    });

  </script>

</body>
</html>