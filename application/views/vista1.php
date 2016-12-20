<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>


</head>
<body>

<h1>  Hola <?php echo $nom . ". Pocs dies i $data" ?></h1>
<a href="<?php echo site_url('welcome/hola/pepito/palotes') ?>">link</a>

<form name="f1" method="post" action="<?php echo site_url('welcome/patata') ?>">
Nom:<input type="text" name="nom">
<input type="submit">
</form>
</body>
</html>