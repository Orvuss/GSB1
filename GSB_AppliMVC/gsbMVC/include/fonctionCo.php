<?php
    function connexion(){
        $bdd = new PDO('mysql:host=172.16.203.209;dbname=gsb_frais_structure;charset=utf8', 'sio', 'slam');
        return $bdd;
    }
?>