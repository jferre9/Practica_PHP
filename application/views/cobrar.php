<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <form name="f1" id="f1" method="post" action="<?php echo site_url('/cobrar') ?>">
        Taula:
        <?php
        echo form_dropdown('taula', $taules, $taula_id, array("onchange" => "this.form.submit()"));
        ?>
    </form>
</div>


<div class="container">
    <?php
    if (isset($detalls)) {
        ?>
        <table>
            <tr>
                <th>Producte</th><th>Categoria</th><th>Preu</th><th>Eliminar</th>
            </tr>
            <?php
            foreach ($detalls as $prod) {
                ?>
                <tr>
                    <td><?php echo $prod["nom"]; ?></td>
                    <td><?php echo $prod["categoria"]; ?></td>
                    <td><?php echo $prod["preu"]; ?> €</td>
                    <td><a href="<?php echo site_url("/cobrar/eliminar/$taula_id/".$prod["id"]) ?>">Eliminar</a></td>
                </tr>

                <?php
            }
            
            ?>
                <tr style="font-weight: bold">
                    <td>Total:</td><td></td><td><?php echo $total; ?> €</td><td></td>
                </tr>
        </table>
        <a href="<?php echo site_url("/cobrar/finalitzar/".$comanda['id']) ?>">Generar factura</a>

        <table>
            <tr>
                <th>Nom</th><th>Preu</th><th>Categoria</th><th>Afegir</th>
            </tr>
            <?php
            foreach ($productes as $producte) {
                ?>
                <tr>
                    <td><?php echo $producte["nom"]; ?></td>
                    <td><?php echo $producte["categoria"]; ?></td>
                    <td><?php echo $producte["preu"] . " €"; ?></td>
                    <td><a href="<?php echo site_url("/cobrar/afegir/$taula_id/" . $producte["id"]); ?>">Afegir</a></td>
                </tr>
                <?php
            }
            ?>

        </table>
        <?php
    }
    ?>
</div>

