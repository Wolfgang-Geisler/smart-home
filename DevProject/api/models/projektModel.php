<?php

class projektModel {

    private $dbGateway;

    public function __construct() {
        $this->dbGateway = new pdoDBGateway();
    }

    public function getProjects() {
        $query = "SELECT * FROM projekt ";
        $projects = $this->dbGateway->query($query);

        return $projects;
    }

    public function createProject($projektId, $bezeichnung, $vorname, $nachname, $adresse, $notizen) {

        $sql = "INSERT INTO projekt(`projektId`,`bezeichnung`, `vorname`, `nachname`, `adresse`, `notizen`) VALUES (:projektId, :bezeichnung, :vorname, :nachname, :adresse, :notizen)";
        $createSucessfull = $this->dbGateway->prepare($projektId, $bezeichnung, $vorname, $nachname, $adresse, $notizen, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "New project created!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }


}
