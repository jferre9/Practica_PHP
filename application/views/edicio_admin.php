<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    
    <?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open('',array('class' => 'form')); ?>
    Email:<input type="text" name="email" value="<?php echo set_value('email',$usuari['email']) ?>">
    Nom:<input type="text" name="nom" value="<?php echo set_value('nom',$usuari['nom']) ?>">
    Cognoms:<input type="text" name="cognoms" value="<?php echo set_value('cognoms',$usuari['cognoms']) ?>">
    Contrasenya:<input type="text" name="pass" ><!-- TODO type password -->
    Confirma la contrasenya:<input type="text" name="passconf" >
    <hr>
    Cuiner:<input type="checkbox" name="cuiner" value="1" <?php echo set_checkbox('cuiner', '1',(bool)$usuari['cuiner']); ?>>
    Cambrer:<input type="checkbox" name="cambrer" value="1" <?php echo set_checkbox('cambrer', '1',(bool)$usuari['cambrer']); ?>>
    Cobrar:<input type="checkbox" name="cobrar" value="1" <?php echo set_checkbox('cobrar', '1',(bool)$usuari['cobrar']); ?>>
    <input type="submit" name="enviar" value="Enviar">
</form>
<!--/body>
</html-->