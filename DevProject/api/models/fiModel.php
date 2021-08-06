<?php

class fiModel{
    private $dbGateway;
    
    public function fiModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function getFi($schaltschrankId){
        $query = "SELECT * FROM fi WHERE schaltschrankID = $schaltschrankId";
        
        $getFi = $this->dbGateway->query($query);
        return $getFi;
    }
    
    public function createFi($fiId, $hersteller, $spannung, $schaltschrankId) {

        $sql = "INSERT INTO fi(`fiId`,`hersteller`, `spannung`, `schaltschrankId`) VALUES (:fiId, :hersteller, :spannung, :schaltschrankId)";
        $createSucessfull = $this->dbGateway->prepareFi($fiId, $hersteller, $spannung, $schaltschrankId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Neuer Fi erstellt!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function updateFi($fiId, $hersteller, $spannung) {

        $sql = "UPDATE `fi` SET `hersteller` = :hersteller, `spannung` = :spannung WHERE `fiId` = :fiId";
        $createSucessfull = $this->dbGateway->updateFi($fiId, $hersteller, $spannung, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Fi wurde bearbeitet!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function deleteFi($fiId) {

        $sql = "DELETE FROM `fi` WHERE `fiId` = :fiId";
        $createSucessfull = $this->dbGateway->deleteFi($fiId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Fi wurde gelöscht!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
}
