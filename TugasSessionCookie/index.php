<?php 

session_start();

if(!isset($_SESSION['login'])){
	header("Location:login.php");
	exit;
}



// ------AWAL FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------

// masuk ke database
$conn = mysqli_connect("localhost", "root","", "belajarphp"); //hostname, username, password, databasename

// fungsi untuk query database
function query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
 }


// data diambil dalam bentuk array untuk ditampilkan pada halaman index
//$karyawan = query("SELECT * FROM karyawan ORDER BY id DESC");
$users = query("SELECT * FROM users ORDER BY id DESC");

// ------AKHIR FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------


 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">


</head>
<body>

<div class="container">
	<div class="row">
		<div class="col">
			
			<div class="container">
				<div class="row mt-4 text-center">
					<div class="col">
						<h3>Account List</h3>
					</div>
				</div>
			</div>
			
			<a href="registrasi.php"><button type="button" class="btn btn-primary">Add Data</button></a>

			<br><br>

			<form action="" method="post">
				<input type="text" name="keyword" size="40" autofocus placeholder="type keywords.." autocomplete="off" id="keyword">
				<button type="submit" name="cari" id="tombol-cari">Cari</button>
				<br><br>
			</form>

		</div>
	</div>
</div>


 <!---------------- AWAL TABEL  ---------------------> 

<div class="container">
	<div class="card">
	  <div class="card-header bg-primary text-white">
	    Employees
	  </div>
	<div class="card-body" id="container">
		<table class="table table-striped text-center">
			<tr align="center">
				<th>No.</th>
				<th>Action</th>
				
				<th>ID</th>
				<th>Name</th>

			</tr>


			<?php $i = 1; ?>
			<?php foreach ($users as $orang) :
			?>
			<tr>
				<td><?php echo $i ?></td>
				<td>
					<a href="ubah.php?id=<?php echo $orang["id"]; ?>">Edit</a> |
					<a href="hapus.php?id=<?php echo $orang["id"]; ?>" onclick="return confirm('Anda yakin ingin menghapus?');">Delete</a>
				</td>
				
				<td><?php echo $orang["id"]; ?></td>
				<td><?php echo $orang["username"]; ?></td>

			</tr>
			<?php $i++; ?>
			<?php endforeach; ?>
		</table>
	</div>
</div>

 <!---------------- AKHIR TABEL  ---------------------> 

<div class="container">
	<div class="row mt-3 mb-5">
		<div class="col">
			<a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
		</div>
	</div>
</div>

</div>

<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>
