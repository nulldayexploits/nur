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
	<form method="get">
		<input type="text" name="p" id="p" placeholder="Masukkan Kata Kunci....">
		<br>
		<br>
		<input type="submit" name="submit" id="btn1" class="button" value="CARI">
		<a href="login.php" class="button">LOGIN</a>
    </form>
</center>

<style type="text/css">
#loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>



    <main>
      <div class="container mt-4">


		<center><div id="loader" style="display: none;"></div></center>
    	<center><b>Waktu Eksekusi: <span id="waktu_eksekusi">0</span> Detik</b></center>
		  <b style='margin-left:10px;font-size:20px;'>Kata Kunci Yang Dimasukkan: <i><u id="query"></u></i></b>
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
			<tbody id="example_tbody">
			
			</tbody>
           <tfoot>  
            <tr>
			  <th>No</th>
			  <th>Judul</th>
			  <th>Nilai VSM</th>
			  <th>Aksi</th>
			</tr>
		  </tfoot>
    	</table>

      </div>


    </main>
  </div>

  <!-- bootstrap js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
 
  <!-- data tables -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
  
  <script type="text/javascript">
  	
  	

    $('#btn1').on('click', function (e) {
    	
      e.preventDefault();


      table=$('#example').on('preXhr.dt', function ( e, settings, data ) {
        
      $('#loader').attr('style', "display: block;");
      $('#btn1').attr('value', "Mohon Tunggu...");
      document.getElementById('btn1').disabled = true;

       }).DataTable({

        ajax: {
          url: "api.php?p="+$('#p').val(),
          dataSrc: 'hasil_ranking'
        },
          "columnDefs": [
            {
             "searchable": false,
             "orderable": false,
             "targets": 0
            }
          ],
          "order": [
            [2, 'desc']
          ],
        "columns": [
          { "data": null },
          { "data": "judul" },
          { "data": "ranking" },
          { "data": "btn" }
        ],
        retrieve: true,
        paging: true,
		"initComplete": function(settings, json) {
			$('#query').html(json.query);
      		$('#waktu_eksekusi').html(json.waktu_eksekusi);
			$('#loader').attr('style', "display: none;");
            $('#btn1').attr('value', "CARI");
            document.getElementById('btn1').disabled = false;
		}
      });

      table.on('order.dt search.dt', function() {
        table.column(0, {
          search: 'applied',
          order: 'applied'
        }).nodes().each(function(cell, i) {
          cell.innerHTML = i + 1;
        });
      }).draw();

    });

  </script>

</body>
</html>