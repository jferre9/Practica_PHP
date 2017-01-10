<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <?php
    if ($error)
        echo "<div id='error'>$error</div>";



    if (isset($ok)) {
        echo "<p>$ok</p>";
        echo "<a class='btn btn-success' href='" . site_url('login') . "'>Login</a>";
    } else {
        ?>




        <form class="form-horizontal" name="f1" method="post" >
            <div class="form-group">
                <label for="pass" class="control-label col-sm-2">Contrasenya:</label>
                <div class="col-sm-6">
                    <input type="password" name="pass" required="" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="pass" class="control-label col-sm-2">Repateix la contrasenya:</label>
                <div class="col-sm-6">
                    <input type="password" name="passconf" required="" class="form-control">
                </div>
            </div>
            <div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <input type="submit" name="enviar" value="Enviar" class="btn btn-primary">
                    </div>
                </div>
            </div>

        </form>

        <?php
    }
    ?>
</div>