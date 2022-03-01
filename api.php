<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__."/VSMModule/Preprocessing.php";
include_once __DIR__."/VSMModule/VSM.php";
include 'admin/config/connect-db.php';

pencarian($_GET['p'], $mysqli);

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
            'id_doc' => $row['id'].' || '.$row['judul'].' || '.$row['sumber'],
            'dokumen' => implode(" ", $preprocess::preprocess($row['isi_cerpen']))
        ];
        array_push($arrayDokumen, $arrayDoc);
    }
    
    // STEP 4 == mendapatkan ranking dengan VSM
    $rank = $vsm::get_rank($query, $arrayDokumen);
    //var_dump($rank);


    #tampildata($katakunci, $rank);

    foreach($rank as $d){

    	if($d['ranking'] > 0)
    	{

			$id = explode(' || ', $d['id_doc']);
			$dx = $id[0];
			$nm = $id[1];
			$sm = $id[2];

			$datas[] = [
						 "id" => $dx,
						 "judul" => $nm.'<br><b>Sumber:</b> '.$sm,
						 "ranking" => $d['ranking'],
						 "btn" => "<a href='baca.php?id=$dx' class='button' target='_blank'>Baca Cerpen</a>"
					   ];

        }

    }

    // End clock time in seconds
	$end_time = microtime(true);
	  
	// Calculate script execution time
	$execution_time = ($end_time - $start_time);
	
	$response = [
					"query" => $katakunci,
					"waktu_eksekusi" => $execution_time,
					"hasil_ranking" => $datas
				  ];  
	

	echo json_encode($response);

    die();

}	




?>