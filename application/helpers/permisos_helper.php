<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('permisos')) {

    function loguejat($controlador = 'home') {
        //no es pot fer servir el $this a un helper
        $CI = & get_instance();
        $loguejat = $CI->session->userdata('loguejat');
        if ($loguejat == NULL || !$loguejat) {
            $CI->session->set_flashdata('controlador', $controlador);
            $CI->session->set_flashdata('error', "No estàs loguejat");
            redirect(site_url('login'));
            return false;
        }
        return true;
    }

    /**
     * 
     * @param type $permis
     * @param type $controlador
     * @param type $accio
     */
    function permisos($permis, $controlador) {
        //no es pot fer servir el $this a un helper
        $CI = & get_instance();
        if (!loguejat($controlador))
            return;
        if ($permis === 'admin') {
            if ($CI->session->userdata('email') !== 'admin') {
                $CI->session->set_flashdata('error', "No tens permisos per accedir a la pagina $controlador.");
                redirect('');
            }
        } else {
            $tePermis = $CI->session->userdata($permis);
            if ($tePermis == NULL || !$tePermis) {
                $CI->session->set_flashdata('error', "No tens permisos per accedir a la pagina $controlador.");
                redirect('');
            }
        }
    }

}
