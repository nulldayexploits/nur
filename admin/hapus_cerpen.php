<?php


  include('config/connect-db.php');
  include('config/base-url.php');  

	 
	  $id     = $_GET['id'];

    $delete = mysqli_query($mysqli, "DELETE FROM tb_cerpen WHERE id = '$id' ");

	if($delete){		 
     echo '<script language="javascript"> window.location.href = "'.$base_url_back.'/view_cerpen.php" </script>';
    }else{
    	echo mysqli_error($mysqli);
    }

	

?>
