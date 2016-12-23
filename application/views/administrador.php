<!--?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>Welcome to CodeIgniter</title>

</head>
<body-->


<a href="<?php echo site_url('administrador/afegir') ?>">Afegir usuari</a>


<div>
    <table>
        <tr>
            <th>Email</th><th>Nom</th><th>Cuiner</th><th>Cambrer</th><th>Cobrar</th><th>Editar</th><th>Borrar</th>
        </tr>
        <?php
        foreach ($usuaris as $u) {
            ?>
            <tr>
                <td><?php echo $u['email'] ?></td>
                <td><?php echo $u['nom'] ?></td>
                <td><?php
        if ($u['cuiner']) {
            echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
        } else {
            echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
        }
            ?></td>
                <td><?php
                    if ($u['cambrer']) {
                        echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    } else {
                        echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    }
                    ?></td>
                <td><?php
                    if ($u['cobrar']) {
                        echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    } else {
                        echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    }
                    ?></td>
                <td>
                    <a href="<?php echo site_url("administrador/editar/".$u['id']) ?>">Editar</a>
                </td>
                <td>
                    <a href="<?php echo site_url("administrador/borrar/".$u['id']) ?>">Borrar</a>
                </td>
            </tr>
            <?php
        }
        ?>

    </table>
</div>


<!--/body>
</html-->