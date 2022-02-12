<?php
include_once __DIR__."/VSMModule/Preprocessing.php";
include_once __DIR__."/VSMModule/VSM.php";

function pencarian($katakunci)
{
    // == STEP 1 inisialisasi
    $preprocess = new Preprocessing();
    $vsm = new VSM();

    // == STEP 2 mendapatkan kata dasar
    $query = $preprocess::preprocess($katakunci);

    // == STEP 3 medapatkan dokumen ke array
    $connect = mysqli_query(mysqli_connect('localhost', 'root', 'palaguna_maria_33', '21_information_retrieval','3370'), "SELECT * FROM tb_cerpen");
    $arrayDokumen = [];
    while ($row = mysqli_fetch_assoc($connect)) {
        $arrayDoc = [
            'id_doc' => $row['id'],
            'dokumen' => implode(" ", $preprocess::preprocess($row['isi_cerpen']))
        ];
        array_push($arrayDokumen, $arrayDoc);
    }
    
    // STEP 4 == mendapatkan ranking dengan VSM
    $rank = $vsm::get_rank($query, $arrayDokumen);
    var_dump($rank);
    die();

}

// jalankan fungsi
pencarian('perang krisis era pandemi');
