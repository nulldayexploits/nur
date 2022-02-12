<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style>
		body{
			font-family: sans-serif;
			background: #f7f8f8;
		}

		h1{
			text-align: center;
			/*ketebalan font*/
			font-weight: 300;
		}

		.tulisan_login{
			text-align: center;
			/*membuat semua huruf menjadi kapital*/
			text-transform: uppercase;
		}

		.kotak_login{
			width: 350px;
			background: white;
			/*meletakkan form ke tengah*/
			margin: 80px auto;
			padding: 30px 20px;
			border-radius: 10px;
		}

		label{
			font-size: 11pt;
		}

		.form_login{
			/*membuat lebar form penuh*/
			box-sizing : border-box;
			width: 100%;
			padding: 10px;
			font-size: 11pt;
			margin-bottom: 20px;
		}

		.tombol_login{
			background: #46de4b;
			color: white;
			font-size: 11pt;
			width: 100%;
			border: none;
			border-radius: 3px;
			padding: 10px 20px;
		}

		.link{
			color: #232323;
			text-decoration: none;
			font-size: 10pt;
		}
	</style>
</head>
<body>

	<div class="kotak_login">
		<p class="tulisan_login">Login</p>

		<form action="proses-login.php" method="POST"> 
			<label>Username</label>
			<input type="text" name="username" class="form_login" placeholder="Username atau email ..">

			<label>Password</label>
			<input type="text" name="password" class="form_login" placeholder="Password ..">

			<input type="submit" class="tombol_login" value="LOGIN">

			<br/>
			<br/>
		</form>
		
	</div>


</body>
</html>