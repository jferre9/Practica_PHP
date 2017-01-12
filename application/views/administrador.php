<!--?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>Welcome to CodeIgniter</title>

</head>
<body-->





<div class="container">
    <table class="table table-hover">
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
            echo '<span style="color:green" class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
        } else {
            echo '<span style="color:red" class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
        }
            ?></td>
                <td><?php
                    if ($u['cambrer']) {
                        echo '<span style="color:green" class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    } else {
                        echo '<span style="color:red" class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    }
                    ?></td>
                <td><?php
                    if ($u['cobrar']) {
                        echo '<span style="color:green" class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    } else {
                        echo '<span style="color:red" class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    }
                    ?></td>
                <td>
                    <a class="btn btn-success" href="<?php echo site_url("administrador/editar/".$u['id']) ?>">Editar</a>
                </td>
                <td>
                    <a class="btn btn-danger" href="<?php echo site_url("administrador/borrar/".$u['id']) ?>"><i class="fa fa-trash" aria-hidden="true"></i> Borrar</a>
                </td>
            </tr>
            <?php
        }
        ?>

    </table>
    
    <a class="btn btn-success" href="<?php echo site_url('administrador/afegir') ?>">Afegir usuari</a>
</div>


<!--/body>
</html-->