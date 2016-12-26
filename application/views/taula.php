<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">



    <form name="f1" id="f1" method="post" action="<?php echo site_url('/cambrer') ?>">
        Taula:
        <?php
        echo form_dropdown('taula', $taules, $taula_id, array("onchange" => "this.form.submit()"));
        ?>
    </form>
</div>


<div class="container">
    <?php
    if (isset($error)) {
        ?>
        <div id="error">
            <?php echo $error ?>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="text-center">
                <h2>Productes</h2>
                <table>
                    <tr>
                        <th>Nom</th><th>Afegir</th>
                    </tr>
                    <?php
                    foreach ($productes as $id => $nom) {
                        ?>
                        <tr>
                            <td><?php echo $nom; ?></td><td><a href="<?php echo site_url("/cambrer/afegir/$id"); ?>">afegir</a></td>
                        </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>

        </div>
        <div class="col-md-6">
            <div class="text-center">
                <h2>Productes demanats</h2>
                <table>
                    <tr>
                        <th>Nom</th><th>Treure</th>
                    </tr>
                    <?php
                    foreach ($productes_demanats as $producte) {
                        ?>
                        <tr>
                            <td><?php echo $producte["nom"]; ?></td><td><a href="<?php echo site_url("/cambrer/afegir/".$producte["id"]); ?>">afegir</a></td>
                        </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>


</div>

