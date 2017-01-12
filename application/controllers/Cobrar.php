<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cobrar extends CI_Controller {

    public function __construct() {
        parent::__construct();

        permisos('cobrar', 'cobrar');
        $this->load->model('comanda');
        $this->load->model('detall');
        $this->load->helper('xmldatabase');
        $this->load->helper('form');
    }

    public function index() {

        if ($this->input->post('taula')) {
            $taula = $this->input->post('taula');
            if ($taula != '0') {
                redirect(site_url("/cobrar/taula/$taula"));
                return;
            }
        }

        $xml = simplexml_load_file('public/frankfurt.xml');

        $taules = get_taules_ocupades($xml);
        $data['taules'] = $taules;
        $data['taula_id'] = '';


        $data['vista'] = 'cobrar';
        $this->load->view('template', $data);
    }

    public function taula($taula_id = NULL) {
        if ($taula_id == NULL) {
            redirect(site_url('/cobrar'));
            return;
        }

        $xml = simplexml_load_file('public/frankfurt.xml');

        $taules = get_taules_ocupades($xml);

        if (!$this->comanda->get_estat_taula($taula_id)) {
            redirect(site_url('/cobrar'));
            return;
        }
        $comanda = $this->comanda->get_comanda_activa($taula_id);

        $data['comanda'] = $comanda;


        $data['taules'] = $taules;

        $detalls = get_detalls_taula($xml, $taula_id);
        $data['detalls'] = $detalls;

        $total = 0;
        foreach ($detalls as $value) {
            $total += floatval($value["preu"]);
        }
        $data['total'] = $total;


        $data['productes'] = get_productes($xml);
        $data['taula_id'] = $taula_id;


        $data['vista'] = 'cobrar';
        $this->load->view('template', $data);
    }

    public function afegir($taula_id, $producte_id) {
        $xml = simplexml_load_file('public/frankfurt.xml');

        if (!$this->comanda->get_estat_taula($taula_id)) {
            redirect(site_url('/cobrar'));
            return;
        }
        $comanda = $this->comanda->get_comanda_activa($taula_id);


        $producte = get_producte($xml, $producte_id);
        if (!$producte) {
            $this->session->set_flashdata('error', "No existeix el producte");
            redirect(site_url("/cobrar/$taula_id"));
            return;
        }
        $res = $this->detall->afegir($comanda['id'], $producte_id, $producte['preu'], 0);
        if (!$res) {
            $this->session->set_flashdata('error', "Error al afegir el producte;");
            redirect(site_url("/cobrar/$taula_id"));
            return;
        }

        redirect(site_url("/cobrar/taula/$taula_id"));
    }

    public function eliminar($taula_id, $detall_id) {

        if (!$this->detall->eliminar($detall_id)) {
            $this->session->set_flashdata('error', "Error al eliminar el detall");
        }

        redirect(site_url("/cobrar/taula/$taula_id"));
    }

    public function finalitzar($comanda_id = NULL) {
        if ($comanda_id == NULL) {
            redirect(site_url("/cobrar"));
            return;
        }

        $res = $this->comanda->finalitzar($comanda_id);
        if (!$res) {
            $this->session->set_flashdata('error', "Error al finalitzar la comanda");
            redirect(site_url("/cobrar"));
        } else {
            redirect(site_url("/cobrar/factura/$comanda_id"));
        }
    }

    public function factura($comanda_id = NULL) {
        if ($comanda_id == NULL) {
            redirect(site_url("/cobrar"));
            return;
        }

        $detalls = $this->comanda->get_detalls_comanda($comanda_id);

        if (count($detalls) == 0) {
            redirect(site_url("/cobrar"));
            return;
        }

        $xml = simplexml_load_file('public/frankfurt.xml');
        dades_producte_cambrer($xml, $detalls);

        $data['detalls'] = $detalls;


        $comanda = $this->comanda->get_comanda($comanda_id);
        $data['total'] = $comanda['preu_final'];
        $data['data'] = $comanda['data_pagament'];

        $data['comanda_id'] = $comanda_id;

        $data['vista'] = 'factura';
        $this->load->view('template', $data);
    }

    public function facturapdf($comanda_id = NULL) {
        if ($comanda_id == NULL) {
            redirect(site_url("/cobrar"));
            return;
        }

        $detalls = $this->comanda->get_detalls_comanda($comanda_id);

        if (count($detalls) == 0) {
            redirect(site_url("/cobrar"));
            return;
        }

        $xml = simplexml_load_file('public/frankfurt.xml');
        dades_producte_cambrer($xml, $detalls);




        $comanda = $this->comanda->get_comanda($comanda_id);
        $total = $comanda['preu_final'];

        $this->load->library('pdf');

        //*******************************

        $this->pdf = new Pdf();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Factura $comanda_id");
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200, 200, 200);

        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 9);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        
        $this->pdf->Cell(40,7,'Data: '.$comanda['data_pagament'],'',0,'',0);
        $this->pdf->Ln(20);

        $this->pdf->Cell(40, 7, 'Producte', 'TBL', 0, 'L', '1');
        $this->pdf->Cell(40, 7, 'Categoria', 'TB', 0, 'L', '1');
        $this->pdf->Cell(40, 7, 'Quantitat', 'TB', 0, 'L', '1');
        $this->pdf->Cell(40, 7, 'Preu', 'TBR', 0, 'L', '1');
//        $this->pdf->Cell(40, 7, 'FECHA DE NACIMIENTO', 'TB', 0, 'C', '1');
//        $this->pdf->Cell(25, 7, 'GRADO', 'TB', 0, 'L', '1');
//        $this->pdf->Cell(25, 7, 'GRUPO', 'TBR', 0, 'C', '1');
        $this->pdf->Ln(7);
        // La variable $x se utiliza para mostrar un número consecutivo
        $x = 1;
        foreach ($detalls as $alumno) {
            // se imprime el numero actual y despues se incrementa el valor de $x en uno
            //$this->pdf->Cell(15, 5, $x++, 'BL', 0, 'C', 0);
            // Se imprimen los datos de cada alumno
            $this->pdf->Cell(40, 6, utf8_decode($alumno['nom']), 'B', 0, 'L', 0);
            $this->pdf->Cell(40, 6, utf8_decode($alumno['categoria']), 'B', 0, 'L', 0);
            $this->pdf->Cell(40, 6, $alumno['quantitat'], 'B', 0, 'L', 0);
            $this->pdf->Cell(40, 6, $alumno['preu'] . " ".chr(128), 'B', 0, 'L', 0);
            //Se agrega un salto de linea
            $this->pdf->Ln(5);
            $x++;
        }
        $this->pdf->Cell(40, 6, "Total: ", 'TBL', 0, 'L', 1);
            $this->pdf->Cell(40, 6, "", 'TB', 0, 'L', 1);
            $this->pdf->Cell(40, 6, "", 'TB', 0, 'L', 1);
            $this->pdf->Cell(40, 6, $total. " ".chr(128), 'TBR', 0, 'L', 1);
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Lista de alumnos.pdf", 'I');
    }

    public function historic($pagina = 0) {
        $pagina = intval($pagina);
        $data['pagina'] = $pagina;
        $limit = 10;
        $data['limit'] = $limit;
        $historic = $this->comanda->get_historic($pagina, $limit);
        $data['historic'] = $historic;

        $data['vista'] = 'historic';
        $this->load->view('template', $data);
    }

}
