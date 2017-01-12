<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <?php echo validation_errors('<div id="error">', '</div>'); ?>

    <?php echo form_open('', array('class' => 'form-horizontal')); ?>
    <div class="form-group">
        <label  class="col-sm-2 control-label">Email:</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="email" value="<?php echo set_value('email',$usuari['email']) ?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-2 control-label">Nom:</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="nom" value="<?php echo set_value('nom',$usuari['nom']) ?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-2 control-label">Cognoms:</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="cognoms" value="<?php echo set_value('cognoms',$usuari['cognoms']) ?>">
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-2 control-label">Contrasenya:</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="pass" ><!-- TODO type password -->
        </div>
    </div>
    <div class="form-group">
        <label  class="col-sm-2 control-label">Confirma la contrasenya:</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="passconf" >
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="cuiner" value="1" <?php echo set_checkbox('cuiner', '1',(bool)$usuari['cuiner']); ?>> Cuiner
                </label>
                <br>
                <br>
                <label>
                    <input type="checkbox" name="cambrer" value="1" <?php echo set_checkbox('cambrer', '1',(bool)$usuari['cambrer']); ?>> Cambrer<br>
                </label>
                <br>
                <br>
                <label>
                    <input type="checkbox" name="cobrar" value="1" <?php echo set_checkbox('cobrar', '1',(bool)$usuari['cobrar']); ?>> Cobrar
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input class="btn btn-default" type="submit" name="enviar" value="Enviar">
    </div>
  </div>
        </form>
</div>