<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="container">
    
    <?php
    
    if ($error) {
        echo "<div id='error'>$error</div>";
    }
    
    ?>
    
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
                        <th>Nom</th><th>Categoria</th><th>Taula</th><th>Iniciar</th>
                    </tr>
                    <?php
                    foreach ($productes as $producte) {
                        ?>
                        <tr>
                            <td><?php echo $producte["nom"]; ?></td>
                            <td><?php echo $producte["categoria"]; ?></td>
                            <td><?php echo $producte["taula"]; ?></td>
                            <td><a href="<?php echo site_url("/cuiner/iniciar/".$producte["id"]); ?>">Iniciar</a></td>
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
                    foreach ($productes_iniciats as $producte) {
                        ?>
                        <tr>
                            <td><?php echo $producte["nom"]; ?></td>
                            <td><?php echo $producte["categoria"]; ?></td>
                            <td><?php echo $producte["taula"]; ?></td>
                            <td><a href="<?php echo site_url("/cuiner/acabar/".$producte["id"]); ?>">Acabar</a></td>
                        </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>
    
</div>


