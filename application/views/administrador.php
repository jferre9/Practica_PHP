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
    <h2 class="text-center">Llistat d'usuaris</h2>
    <table class="table table-hover">
        <tr>
            <th>Email</th><th>Nom</th><th class="text-center">Cuiner</th><th class="text-center">Cambrer</th><th class="text-center">Cobrar</th><th class="text-center">Editar</th><th class="text-center">Borrar</th>
        </tr>
        <?php
        foreach ($usuaris as $u) {
            ?>
            <tr>
                <td><?php echo $u['email'] ?></td>
                <td><?php echo $u['nom'] ?></td>
                <td class="text-center"><?php
        if ($u['cuiner']) {
            echo '<span style="color:green" class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
        } else {
            echo '<span style="color:red" class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
        }
            ?></td>
                <td class="text-center"><?php
                    if ($u['cambrer']) {
                        echo '<span style="color:green" class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    } else {
                        echo '<span style="color:red" class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    }
                    ?></td>
                <td class="text-center"><?php
                    if ($u['cobrar']) {
                        echo '<span style="color:green" class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                    } else {
                        echo '<span style="color:red" class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                    }
                    ?></td>
                <td class="text-center">
                    <a class="btn btn-success" href="<?php echo site_url("administrador/editar/".$u['id']) ?>">Editar</a>
                </td>
                <td class="text-center">
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