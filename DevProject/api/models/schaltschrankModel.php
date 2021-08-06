<?php


class schaltschrankModel{
    private $dbGateway;
    
    public function schaltschrankModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function getSchaltschrank($gebaeudeId){
        $query = "SELECT * FROM schaltschrank WHERE gebaeudeId = $gebaeudeId";
        
        $getSchaltschrank = $this->dbGateway->query($query);
        return $getSchaltschrank;
    }
    
    public function createSchaltschrank($schaltschrankId, $bezeichnung, $position, $gebaeudeId) {

        $sql = "INSERT INTO schaltschrank(`schaltschrankId`,`bezeichnung`, `position`, `gebaeudeId`) VALUES (:schaltschrankId, :bezeichnung, :position, :gebaeudeId)";
        $createSucessfull = $this->dbGateway->prepareSchaltschrank($schaltschrankId, $bezeichnung, $position, $gebaeudeId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Neuer Schaltschrank erstellt!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function updateSchaltschrank($schaltschrankId, $bezeichnung, $position) {

        $sql = "UPDATE `schaltschrank` SET `bezeichnung` = :bezeichnung, `position` = :position WHERE `schaltschrankId` = :schaltschrankId";
        $createSucessfull = $this->dbGateway->updateSchaltschrank($schaltschrankId, $bezeichnung, $position, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Schaltschrank wurde bearbeitet!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function deleteSchaltschrank($schaltschrankId) {

        $sql = "DELETE FROM `schaltschrank` WHERE `schaltschrankId` = :schaltschrankId";
        $createSucessfull = $this->dbGateway->deleteSchaltschrank($schaltschrankId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Schaltschrank wurde gelöscht!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
}

