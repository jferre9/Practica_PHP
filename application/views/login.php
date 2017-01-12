<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
    if (isset($error)) {
        echo "<div id='error'>$error</div>";
    }
    ?>
<div class="container">
    <form class="form-horizontal" name="f1" method="post" action="<?php echo site_url('login') ?>">
        <div class="form-group">
            <label for="email" class="control-label col-sm-2">Email:</label>
            <div class="col-sm-6">
                <input type="text" name="email" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="pass" class="control-label col-sm-2">Contrasenya:</label>
            <div class="col-sm-6">
                <input type="password" name="pass" required="" class="form-control">
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
    <div class="row">
        <div class="col-sm-offset-2">
            <a href="<?php echo site_url('login/recuperar') ?>" style="margin-left: 10px;">Has oblidat la contrasenya?</a>
        </div>
    </div>
</div>