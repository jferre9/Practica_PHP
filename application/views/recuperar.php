<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <h2 >Recuperar contrasenya</h2>
    <?php
    if (isset($error)) {
        echo "<div id='error'>$error</div>";
    }
    ?>
    <form method="post" class="form-inline">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" >
        </div>
        <input type="submit" name="enviar" value="Enviar" class="btn btn-default">
    </form>
</div>