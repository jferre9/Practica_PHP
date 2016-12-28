<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="container">
    <form method="post" action="<?php echo site_url("/cuiner") ?>">
        Filtre: 
    <?php 
    echo form_dropdown('categoria',$categories, $id_categoria, array("onchange" => "this.form.submit()"));
    
    ?>
    </form>
    
    <div class="row">
        <div class="col-md-6">
            <div class="text-center">
                <h2>Pendents</h2>
                <table>
                    <tr>
                        <th>Nom</th><th>Categoria</th><th>Taula</th><th>Començar</th>
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
                <h2>Cuinant</h2>
                <table>
                    <tr>
                        <th>Nom</th><th>Categoria</th><th>Taula</th><th>Acabar</th>
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
    
</div>


