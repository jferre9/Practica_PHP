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
    
    
    if (isset($productes)) {
        
        
    ?>
    
    <br>
    <p><b>Taula:</b> <?= $taula_nom ?><br>
        <b>Estat:</b> <?= $taula_estat ?></p>
    
    <div class="row">
        <div class="col-md-6">
            <div class="text-center">
                <h2>Productes</h2>
                <table>
                    <tr>
                        <th>Nom</th><th>Preu</th><th>Categoria</th><th>Afegir</th>
                    </tr>
                    <?php
                    foreach ($productes as $producte) {
                        ?>
                        <tr>
                            <td><?php echo $producte["nom"]; ?></td>
                            <td><?php echo $producte["preu"]. " €"; ?></td>
                            <td><?php echo $producte["categoria"]; ?></td>
                            <td><a href="<?php echo site_url("/cambrer/afegir/$taula_id/".$producte["id"]); ?>">afegir</a></td>
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
                        <th>Nom</th><th>Preu</th><th>Categoria</th><th>Eliminar</th>
                    </tr>
                    <?php
                    foreach ($productes_demanats as $producte) {
                        ?>
                        <tr>
                            <td><?php echo $producte["nom"]; ?></td>
                            <td><?php echo $producte["preu"]. " €"; ?></td>
                            <td><?php echo $producte["categoria"]; ?></td>
                            <td><a href="<?php echo site_url("/cambrer/eliminar/$taula_id/".$producte["id"]); ?>">Eliminar</a></td>
                        </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>
<?php
    }
    ?>

</div>

