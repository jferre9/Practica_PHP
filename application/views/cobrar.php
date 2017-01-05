<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <form name="f1" id="f1" method="post" action="<?php echo site_url('/cobrar') ?>">
        Taula:
        <?php
        echo form_dropdown('taula', $taules, '', array("onchange" => "this.form.submit()"));
        ?>
    </form>
</div>


<div class="container">

</div>

