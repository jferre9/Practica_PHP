<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta accesskey="author" content="Joan Ferré">
        <meta charset="utf-8">
        <title><?php if (isset($titol)) echo $titol;
        else echo "Frankfurt"?></title>

        <!-- Bootstrap >
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="estil.css"-->
        <link href="<?php echo base_url('public/estils/css/bootstrap.min.css')?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('public/estils/css/font-awesome.min.css')?>">
        <link rel="stylesheet" href="<?php echo base_url('public/estils/estil.css')?>">

    </head>
    <body>

        <header>
            <a href="<?php echo site_url('cuiner') ?>">Cuiner</a>
            <a href="<?php echo site_url('cambrer') ?>">Cambrer</a>
            <a href="<?php echo site_url('cobrar') ?>">Cobrar</a>
            <a href="<?php echo site_url('administrador') ?>">Administrador</a>
        </header>
