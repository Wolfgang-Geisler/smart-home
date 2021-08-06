<?php

class gebaeudeModel{
    private $dbGateway;
    
    public function gebaeudeModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function getGebaeude($projectId){
        $query = "SELECT * FROM gebaeude WHERE projektId = $projectId";
        $getGebaeude = $this->dbGateway->query($query);
        return $getGebaeude;
    }
    
    public function createGebaeude($gebaeudeId, $adresse, $bezeichnung, $projektId) {

        $sql = "INSERT INTO gebaeude(`gebaeudeId`,`adresse`, `bezeichnung`, `projektId`) VALUES (:gebaeudeId, :adresse, :bezeichnung, :projektId)";
        $createSucessfull = $this->dbGateway->prepareGebaeude($gebaeudeId, $adresse, $bezeichnung, $projektId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Neues Gebäude erstellt!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
    public function updateGebaeude($gebaeudeId, $adresse, $bezeichnung) {

        $sql = "UPDATE `gebaeude` SET `adresse` = :adresse, `bezeichnung` = :bezeichnung WHERE `gebaeudeId` = :gebaeudeId";
        $createSucessfull = $this->dbGateway->updateGebaeude($gebaeudeId, $adresse, $bezeichnung, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Gebäude wurde bearbeitet!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
    public function deleteGebaeude($gebaeudeId) {

        $sql = "DELETE FROM `gebaeude` WHERE `gebaeudeId` = :gebaeudeId";
        $createSucessfull = $this->dbGateway->deleteGebaeude($gebaeudeId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Gebäude wurde gelöscht!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
}

