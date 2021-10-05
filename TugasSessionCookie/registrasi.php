<?php 

// ------AWAL FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------

// masuk ke database
$conn = mysqli_connect("localhost", "root","", "belajarphp"); //hostname, username, password, databasename

// query database
// function query($query){
// 	global $conn;
// 	$result = mysqli_query($conn, $query);
// 	$rows = [];
// 	while( $row = mysqli_fetch_assoc($result)){
// 		$rows[] = $row;
// 	}
// 	return $rows;
//  }

// ------AKHIR FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------


// -------------- AWAL FUNGSI REGISTRASI ---------------------

function registrasi($data){
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data['password']);
	$konfirmasi = mysqli_real_escape_string($conn, $data['konfirmasi']);

	// cek apakah form username dan password diisi
	if (empty($username) or empty($password)) {
		echo 
		"<script>
			alert('silahkan masukkan username / password');
		</script>";
	return false;
	}


	// cari username didatabase yang sama dengan yang dimasuukan user via form
	$result = mysqli_query($conn, "SELECT username FROM users WHERE username ='$username'");
	
	// cek apakah username sudah ada, jika sudah ada maka echo username sudah terdaftar
	if (mysqli_fetch_assoc($result)) {
		echo 
		"<script>
			alert('username is already registered!');
		</script>";

	// hentikan script
	return false;
	}

	// cek kesesuaian antara masukan password dengan masukan konfirmasi password
	if ($password !== $konfirmasi) {
		echo 
		"<script>
			alert('passwords do no match!');
		</script>";
	return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// jika semua proses diatas sesuai, maka tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");
	
	return mysqli_affected_rows($conn);

}
// koneksi dengan database dan fungsi-fungsi lainnya
// require 'functions.php';

// jika button post ditekan
// jika ada data (> 1) yang dikembalikan fungsi registrasi, maka echo berhasil
// jika tidak ada data yang dikembalikan, maka echo error

if (isset($_POST['register'])) {
	if (registrasi($_POST) > 0) {
		echo 
		"<script>
			alert('user baru berhasil ditambahkan');
		</script>";
	} else {
		echo mysqli_error($conn);
	}
}

// -------------- AKHIR FUNGSI REGISTRASI ---------------------

 ?>

 <!---------------- AKHIR HTML FROM ---------------------> 

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">


 	<title>Halaman Registrasi</title>
 	<style>
 		label{
 			display: block;
 		}
 	</style>

 </head>
 <body>

	<div class="container">
		<div class="row mt-4 text-center">
			<div class="col">
				<h3>Please Register</h3>
			</div>
		</div>
	</div>
 	

 	<div class="container">
		<div class="row justify-content-center">
		  	<div class="col-md-6">
		  		<form action="" method="post">
		  			<div class="mb-3">
					    <label for="username" class="form-label">Username</label>
					    <input type="text" name="username" class="form-control" id="username">
				  	</div>
				  	<div class="mb-3">
					    <label for="password" class="form-label">Password</label>
					    <input type="password" name="password" class="form-control" id="password">
				 	</div>
				 	<div class="mb-3">
					    <label for="konfirmasi" class="form-label">Konfirmasi Password</label>
					    <input type="password" name="konfirmasi" class="form-control" id="konfirmasi">
				 	</div>
				  	<div class="mb-3 form-check">
					    <input type="checkbox" name="remember" class="form-check-input" id="remember">
					    <label class="form-check-label" for="remember">Remember Me</label>
				  	</div>
				  <button type="submit" name="register" class="btn btn-primary">Sign Up</button>
				  <a href="login.php"><button type="button" name="login" class="btn btn-success">Sign In</button></a>
				</form>
			</div>
		</div>
	</div>

<!---------------- AKHIR HTML FROM ---------------------> 
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
 </body>
 </html>