<!DOCTYPE html>
<html lang="en">
<?php
foreach (glob("orm/*.php") as $filename) {
	include $filename;
}
?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Log in</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<b>PT. PRIMA KIMIA SURYATAMA</b>
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Sign in to start your session</p>

				<form action="login.php" method="post">
					<div class="input-group mb-3">
						<input type="email" class="form-control" placeholder="Email" name="email">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" placeholder="Password" name="password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- /.col -->
						<div class="col-12">
							<button type="submit" value="login" name="login" class="btn btn-primary btn-block">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>


			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
</body>


<?php
if (isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	// $people = ORM::for_table('person')
	//         ->where(array(
	//             'name' => 'Fred',
	//             'age' => 20
	//         ))
	//         ->find_many();
	$account = UserORM::where(array(
		'email' => $email,
		'password' => hash('sha256', $password)
	))->find_one();

	if ($account) {

		// id
		// nama_user
		// email
		// password
		// level
		// set session 

		// delete all session
		session_destroy();

		// buat session baru
		session_start();

		// set session
		$_SESSION['id'] = $account->id;
		$_SESSION['nama_user'] = $account->nama_user;
		$_SESSION['email'] = $account->email;
		$_SESSION['password'] = $account->password;
		$_SESSION['level'] = $account->level;
		$_SESSION['login'] = true;

		
		// redirect to dashboard
		header('Location: index.php');
	} else {
		echo '<script>alert("Wrong email or password")</script>';
	}
}
?>

</html>