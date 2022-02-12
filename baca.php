<!DOCTYPE html>
<?php  
    include 'admin/config/connect-db.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerpen</title>
    <style>
        body {
            text-align: center;
            padding: 50px 90px;
        }
        body .isi_cerpen {
            text-align: justify;
        }
    </style>
</head>
<?php 
    $ID = $_GET['id'];
    $qry = mysqli_query($mysqli, "SELECT * FROM tb_cerpen WHERE id = $ID");
    $data = mysqli_fetch_array($qry);
?>
<body>
    <h1><?php echo $data['judul']; ?></h1>
    <div class="isi_cerpen">
        <?php echo $data['isi_cerpen']; ?>
    </div>
</body>
</html>