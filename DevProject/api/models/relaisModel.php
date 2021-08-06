<?php

class relaisModel{
    private $dbGateway;
    
    public function relaisModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function getRelais($sicherungId){
        $query = "SELECT * FROM relais WHERE sicherungId = $sicherungId";
        
        $getRelais = $this->dbGateway->query($query);
        return $getRelais;
    }
    
    public function createRelais($relaisId, $sicherungId) {

        $sql = "INSERT INTO relais(`relaisId`, `sicherungId`) VALUES (:relaisId, :sicherungId)";
        $createSucessfull = $this->dbGateway->prepareRelais($relaisId, $sicherungId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Neues Relais erstellt!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function updateRelais($relaisId, $relaisIdNew) {

        $sql = "UPDATE `relais` SET `relaisId` = :relaisIdNew WHERE `relaisId` = :relaisId";
        $createSucessfull = $this->dbGateway->updateRelais($relaisId, $relaisIdNew, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Relais wurde bearbeitet!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function deleteRelais($relaisId) {

        $sql = "DELETE FROM `relais` WHERE `relaisId` = :relaisId";
        $createSucessfull = $this->dbGateway->deleteRelais($relaisId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Relais wurde gelöscht!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
}

