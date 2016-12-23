<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!--DOCTYPE html>
<!--html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>


</head>
<body-->
    
    <?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open('',array('class' => 'form')); ?>
    Email:<input type="text" name="email" value="<?php echo set_value('email') ?>">
    Nom:<input type="text" name="nom" value="<?php echo set_value('nom') ?>">
    Cognoms:<input type="text" name="cognoms" value="<?php echo set_value('cognoms') ?>">
    Contrasenya:<input type="text" name="pass" ><!-- TODO type password -->
    Confirma la contrasenya:<input type="text" name="passconf" >
    <hr>
    Cuiner:<input type="checkbox" name="cuiner" value="1" <?php echo set_checkbox('cuiner', '1'); ?>>
    Cambrer:<input type="checkbox" name="cambrer" value="1" <?php echo set_checkbox('cambrer', '1'); ?>>
    Cobrar:<input type="checkbox" name="cobrar" value="1" <?php echo set_checkbox('cobrar', '1'); ?>>
    <input type="submit" name="enviar" value="Enviar">
</form>
<!--/body>
</html-->