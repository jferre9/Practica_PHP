<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <table class="table table-hover">
        <tr>
            <th>Producte</th><th>Categoria</th><th>Preu</th>
        </tr>
        <?php
        foreach ($detalls as $value) {
            ?>
        <tr>
            <th><?php echo $value['nom'] ?></th>
            <th><?php echo $value['categoria'] ?></th>
            <th><?php echo $value['preu'] ?> €</th>
        </tr>
            <?php
        }
        ?>
        <tr style="font-weight: bold">
            <td>Total:</td><td></td><td><?php echo $total ?> €</td>
        </tr>
    </table>
    <a href="<?php echo site_url("cobrar/facturapdf/$comanda_id") ?>" class="btn btn-success">Veure en pdf</a>

</div>