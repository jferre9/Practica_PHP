<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>


</head>
<body>


<form name="f1" method="post" action="<?php echo site_url('welcome/login') ?>">
Nom:<input type="text" name="nom">
Contrasenya:<input type="password" name="pass">
<input type="submit" name="enviar">
</form>
</body>
</html>