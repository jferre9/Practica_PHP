<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">



    <div class="container">

        <table class="table table-hover">
            <tr>
                <th>Data</th><th>Import</th><th>Veure</th>
            </tr>

            <?php
            foreach ($historic as $value) {
                ?>
                <tr>
                    <td><?php echo $value['data_pagament']; ?></td>
                    <td><?php echo $value['preu_final'] . " €"; ?></td>
                    <td><a class="btn btn-success" href="<?php echo site_url("/cobrar/factura/" . $value['id']); ?>">Veure</a></td>
                </tr>
                <?php
            }
            ?>

        </table>

        <div class="row">
            <div class="col-xs-6">
                <?php if ($pagina > 0) { ?>
                    <a class="btn btn-success" href="<?php echo site_url("cobrar/historic/" . ($pagina - 1)) ?>">Anterior</a>
                    <?php
                }
                ?>

            </div>
            <div class="col-xs-6 text-right">
                <?php
                if (count($historic) == $limit) {
                    ?>
                    <a class="btn btn-success" href="<?php echo site_url("cobrar/historic/" . ($pagina + 1)) ?>">Següent</a>

                    <?php
                }
                ?>
            </div>

        </div>
    </div>

