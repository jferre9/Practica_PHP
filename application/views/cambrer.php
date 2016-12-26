<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <form name="f1" id="f1" method="post" action="<?php echo site_url('/cambrer') ?>">
        Taula:
        <?php
        echo form_dropdown('taula', $taules, '', array("onchange" => "this.form.submit()"));
        ?>
    </form>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="text-center">
                <h2>Productes</h2>
            </div>

        </div>
        <div class="col-md-6">
            <div class="text-center">
                <h2>Productes demanats</h2>

            </div>
        </div>
    </div>


</div>

