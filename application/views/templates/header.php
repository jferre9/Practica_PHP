<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta accesskey="author" content="Joan Ferré">
        <meta charset="utf-8">
        <title><?php
            if (isset($titol))
                echo $titol;
            else
                echo "Frankfurt"
                ?></title>

        <!-- Bootstrap >
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="estil.css"-->
        <link href="<?php echo base_url('public/estils/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('public/estils/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('public/estils/estil.css') ?>">

    </head>
    <body>

        <header>
            <nav class="navbar navbar-inverse navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                        
                        </button>
                        <a class="navbar-brand" href="#">Frankfurt</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li <?php if (strcasecmp($this->router->class, 'home') == 0) echo 'class="active"'; ?>><a href="<?php echo site_url('home') ?>">Home</a></li>
                            <?php
                            if (strcasecmp($this->router->class, 'login') != 0) {
                                if ($this->session->userdata('cuiner')) {
                                    ?>
                                    <li <?php if (strcasecmp($this->router->class, 'Cuiner') == 0) echo 'class="active"'; ?>><a href="<?php echo site_url('cuiner') ?>">Cuniner</a></li>
                                    <?php
                                }
                                if ($this->session->userdata('cambrer')) {
                                    ?>
                                    <li <?php if (strcasecmp($this->router->class, 'Cambrer') == 0) echo 'class="active"'; ?>><a href="<?php echo site_url('cambrer') ?>">Cambrer</a></li>
                                    <?php
                                }
                                if ($this->session->userdata('cobrar')) {
                                    ?>
                                    <li <?php if (strcasecmp($this->router->class, 'cobrar') == 0) echo 'class="active"'; ?>><a href="<?php echo site_url('cobrar') ?>">Cobrar</a></li>
                                    <?php
                                }
                                if ($this->session->userdata('email') === 'admin') {
                                    ?>
                                    <li <?php if (strcasecmp($this->router->class, 'administrador') == 0) echo 'class="active"'; ?>><a href="<?php echo site_url('administrador') ?>">Administrar</a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <?php if (strcasecmp($this->router->class, 'login') != 0) { ?>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?php echo site_url('login'); ?>"><span class="glyphicon glyphicon-log-out"></span> Tancar sessió</a></li>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </nav>



        </header>
