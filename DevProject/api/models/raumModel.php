<?php


class raumModel{
    private $dbGateway;
    
    public function raumModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function getRaum($stockwerkId){
        $query = "SELECT * FROM raum WHERE StockwerkID = $stockwerkId";
        
        $getRaum = $this->dbGateway->query($query);
        return $getRaum;
    }
    
    public function createRaum($raumId, $bezeichnung, $stockwerkId) {

        $sql = "INSERT INTO raum(`raumId`,`bezeichnung`, `stockwerkId`) VALUES (:raumId,:bezeichnung, :stockwerkId)";
        $createSucessfull = $this->dbGateway->prepareRaum($raumId, $bezeichnung, $stockwerkId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Neuer Raum erstellt!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
    public function updateRaum($raumId, $bezeichnung) {

        $sql = "UPDATE `raum` SET `bezeichnung` = :bezeichnung WHERE `raumId` = :raumId";
        $createSucessfull = $this->dbGateway->updateRaum($raumId, $bezeichnung, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Raum wurde bearbeitet!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
     public function deleteRaum($raumId) {

        $sql = "DELETE FROM `raum` WHERE `raumId` = :raumId";
        $createSucessfull = $this->dbGateway->deleteRaum($raumId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Raum wurde gelöscht!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
}

