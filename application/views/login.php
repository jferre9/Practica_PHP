<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>


</head>
<body>

<?php if ($error) echo $error; ?>
<form name="f1" method="post" action="<?php echo site_url('login') ?>">
Email:<input type="text" name="email">
Contrasenya:<input type="password" name="pass" required="">
<input type="submit" name="enviar" value="Enviar" required="">
</form>
</body>
</html>