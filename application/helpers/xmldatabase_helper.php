<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function get_categories(&$xml) {
    $xpath = $xml->xpath("//categoria");

    $categories = array('0' => "Selecciona una categoria");
    foreach ($xpath as $value) {
        //var_dump($value);
        //echo "<br>value= ".(string)$value['id']."<br>";
        $categories[(string) $value['id']] = (string) $value['nom'];
    }
    return $categories;
}

/**
 * 
 * @param type $xml
 * @param type $productes
 * @param type $categories
 * @param type $id_categoria Filtre
 */
function dades_producte(&$xml, &$productes, &$categories, $id_categoria = NULL) {
    for ($i = 0; $i < count($productes);) {
        $producte_xml = $xml->xpath("//producte[@id='" . $productes[$i]['producte_id'] . "']");//[0];
        $producte_xml = $producte_xml[0];
        if ($id_categoria != NULL && isset($categories[$id_categoria])) { //amb SQL seria molt mes senzill
            if ($producte_xml["categoria"] != $id_categoria) {

                array_splice($productes, $i, 1); //borro el producte si s'està filtrant
                continue;
            }
        }

        $productes[$i]["nom"] = (string) $producte_xml["nom"];
        $taula = $xml->xpath("//taula[@id='" . $productes[$i]['taula_id'] . "']/@nom");
        $productes[$i]["taula"] = $taula[0] . "";
        $productes[$i]["categoria"] = $categories[(string) $producte_xml["categoria"]];
        $i++;
    }
}

function get_productes(&$xml) {
    $productes = array();

    $productes_xml = $xml->xpath('//producte');
    foreach ($productes_xml as $producte) {
        //$productes[(string)$producte["id"]] = (string)$producte["nom"];
        $prod["id"] = (string) $producte["id"];
        $prod["nom"] = (string) $producte["nom"];
        $prod['preu'] = ((string) $producte["preu"]);
        $cat = $xml->xpath("//categoria[@id='" . (string) $producte['categoria'] . "']/@nom");
        $prod['categoria'] = $cat[0] . "";//[0];
        $productes[] = $prod;
    }
    return $productes;
}

function get_producte(&$xml, $producte_id) {
    $producte_xml = $xml->xpath("//producte[@id='" . $producte_id . "']");

    if (count($producte_xml) == 0)
        return FALSE;

    $producte_xml = $producte_xml[0];

    $producte["id"] = $producte_id;
    $producte["nom"] = (string) $producte_xml["nom"];
    $producte["preu"] = (string) $producte_xml["preu"];
    $producte["categoria"] = (string) $xml->xpath("//categoria[@id='" . (string) $producte_xml["categoria"] . "']/@nom");//[0];

    return $producte;
}

function dades_producte_cambrer(&$xml, &$productes_demanats) {
    for ($i = 0; $i < count($productes_demanats); $i++) {
        //echo "<br>id = ".$productes_demanats[$i]['id']."<br>";
        $producte = $xml->xpath("//producte[@id='" . $productes_demanats[$i]['producte_id'] . "']");//[0];
        $producte = $producte[0];
        $productes_demanats[$i]["nom"] = (string) $producte['nom'];
        $cat = $xml->xpath("//categoria[@id='" . (string) $producte['categoria'] . "']/@nom");
        $cat = $cat[0];
        $productes_demanats[$i]['categoria'] = $cat . ""; //[0];
    }
}

function get_taules(&$xml, $primer = FALSE) {
    $taules_xml = $xml->xpath('//taula');


    $taules = array();
    if ($primer) {
        $taules['0'] = "Selecciona una taula";
    }
    foreach ($taules_xml as $taula) {
        $taules[(string) $taula["id"]] = (string) $taula["nom"];
    }
    return $taules;
}

function get_taules_ocupades(&$xml) {
    $CI = & get_instance();
    $taules = get_taules($xml);

    $taules_ocupades = $CI->comanda->taules_ocupades();

    $data = array('0' => "Selecciona una taula");

    foreach ($taules_ocupades as $id_taula) {
        $data[$id_taula] = $taules[$id_taula];
    }
    return $data;
}

function get_detalls_taula(&$xml, $taula_id) {
    $CI = & get_instance();

    $detalls = $CI->comanda->get_detalls_taula($taula_id);

    for ($i = 0; $i < count($detalls); ++$i) {
        $producte = $xml->xpath("//producte[@id='" . $detalls[$i]['producte_id'] . "']");//[0];
        $producte = $producte[0];

        $detalls[$i]['nom'] = (string) $producte['nom'];
        $cat = $xml->xpath("//categoria[@id='" . (string) $producte['categoria'] . "']/@nom");
        $detalls[$i]['categoria'] = $cat[0]. "";//[0];
    }
    return $detalls;
}
