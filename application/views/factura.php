<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <h2 class="text-center">Factura</h2>
    <table class="table table-hover">
        <tr>
            <th>Producte</th><th>Categoria</th><th>Quantitat</th><th>Preu</th>
        </tr>
        <?php
        foreach ($detalls as $value) {
            ?>
        <tr>
            <td><?php echo $value['nom'] ?></td>
            <td><?php echo $value['categoria'] ?></td>
            <td><?php echo $value['quantitat'] ?></td>
            <td><?php echo $value['preu'] ?> €</td>
        </tr>
            <?php
        }
        ?>
        <tr style="font-weight: bold; border-top: 2px solid black;">
            <td>Total:</td><td></td><td></td><td><?php echo $total ?> €</td>
        </tr>
    </table>
    <p><b>Data:</b> <?php echo $data ?></p>
    <a href="<?php echo site_url("cobrar/facturapdf/$comanda_id") ?>" class="btn btn-success" target="_blank">Veure en pdf</a>
    <br><br>
    <a href="<?php echo site_url("cobrar/historic") ?>" class="btn btn-success">Tornar a l'històric</a>
    

</div>