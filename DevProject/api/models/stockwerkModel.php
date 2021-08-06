<?php


class stockwerkModel{
    private $dbGateway;
    
    public function stockwerkModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function getStockwerk($gebaeudeId){
        $query = "SELECT * FROM stockwerk WHERE gebaeudeId = $gebaeudeId";
        
        $getStockwerk = $this->dbGateway->query($query);
        return $getStockwerk;
    }   
    
    public function createStockwerk($stockwerkId, $bezeichnung, $gebaeudeId) {

        $sql = "INSERT INTO stockwerk(`stockwerkId`,`bezeichnung`, `gebaeudeId`) VALUES (:stockwerkId,:bezeichnung, :gebaeudeId)";
        $createSucessfull = $this->dbGateway->prepareStockwerk($stockwerkId, $bezeichnung, $gebaeudeId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Neues Stockwerk erstellt!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
    public function updateStockwerk($stockwerkId, $bezeichnung) {

        $sql = "UPDATE `stockwerk` SET `bezeichnung` = :bezeichnung WHERE `stockwerkId` = :stockwerkId";
        $createSucessfull = $this->dbGateway->updateStockwerk($stockwerkId, $bezeichnung, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Stockerk wurde bearbeitet!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
     public function deleteStockwerk($stockwerkId) {

        $sql = "DELETE FROM `stockwerk` WHERE `stockwerkId` = :stockwerkId";
        $createSucessfull = $this->dbGateway->deleteStockwerk($stockwerkId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Stockwerk wurde gelöscht!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
}    
    

