<?php 

session_start();

// ------AWAL FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------

// masuk ke database - urutan parameter hostname, username, password, databasename
$conn = mysqli_connect("localhost", "root","", "belajarphp"); 


// ------AKHIR FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------

#2
// cek cookie berdasarkan id dan username
if (isset($_COOKIE['info']) && isset($_COOKIE['key'])){

	$id = $_COOKIE['info'];
	$key = $_COOKIE['username'];

	// ambil username dari database berdasarkan id
	$result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");

	// username berbentuk array associative
	$row = mysqli_fetch_assoc($result);

	// jika cookie username masukan yang sudah diacak sama dengan username dari database setelah di enkripsi, maka buat session (bernama login) 
	if ($key === hash('sha224', $row['username']) ){
		$_SESSION['login'] = true;
	}

}

// jika session login sudah true, maka arahkan ke halaman index.php
if (isset($_SESSION["login"])) {
	header("Location:index.php");
	exit;

}

#1
/* jika tombol sign in ditekan, 
tangkap data username dan password yang disubmit via method post
*/
if (isset($_POST["login"])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	// cari di database, adakah username yang didalam database yang sama dengan diinputkan via HTML form
	$result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

	// var_dump(mysqli_fetch_assoc($result));
	// die();


	//jika ada username yang dikembalikan
	if (mysqli_num_rows($result) === 1) {

		// ambil semua data user yang pernah registrasi per kolom (i.e., username, password, id) dari database berdasarkan query dan simpan dalam variabel $row (array associative) 
		$row = mysqli_fetch_assoc($result);

		// jika password hash yang didatabase apakah sama dengan password yang dimasukkan user, maka buat session login
		if (password_verify($password, $row["password"])){
			$_SESSION['login'] = true;

			// tambah pengecekan apakah checkbox remember me dicentang?
			if (isset($_POST['remember'])){
				//buat cookie berdasarkan 
				setcookie('info', $row['id']);
				setcookie('key', hash('sha224', $row['username']));
			}

			header("Location: index.php");
			exit;
		}

	}
	$error = true;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<title>Halaman Login</title>
</head>
<body>
	<div class="container">
		<div class="row mt-4 text-center">
			<div class="col">
				<h3>Please Sign In</h3>
			</div>
		</div>
	</div>

	<?php if (isset($error)) : ?>
		<div class="container">
			<div class="row">
				<div class="col">
					<p class="text-center" style="color:red; font-style: bold italic;">Wrong username / password!</p>
				</div>
			</div>
		</div>
	<?php endif; ?>


 <!---------------- AWAL HTML FROM ---------------------> 

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
				  	<div class="mb-3 form-check">
					    <input type="checkbox" name="remember" class="form-check-input" id="remember">
					    <label class="form-check-label" for="remember">Remember Me</label>
				  	</div>
				  <button type="submit" name="login" class="btn btn-primary">Sign In</button>
				  <a href="registrasi.php"><button type="button" name="register" class="btn btn-success">Sign Up</button></a>
				</form>
			</div>
		</div>
	</div>

 <!---------------- AKHIR HTML FROM ---------------------> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>