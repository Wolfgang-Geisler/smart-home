<?php

class passengersModel{
    private $dbGateway;
    
    public function passengersModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function getPassengers(){
        $query = "SELECT flights_id, lastname, firstname FROM passengers ORDER BY lastname";
        
        $getPassengers = $this->dbGateway->query($query);
        return $getPassengers;   
    }
    
}