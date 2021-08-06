<?php


class installationModel{
    private $dbGateway;
    
    public function installationModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function getInstallation($raumId){
        
        $query = "SELECT * FROM installation WHERE raumId = $raumId";
        
        $getInstallation = $this->dbGateway->query($query);
        return $getInstallation;
    }

    public function createInstallation($installationId, $bezeichnung, $installationRelaisId, $raumId) {

        $sql = "INSERT INTO installation(`installationId`,`bezeichnung`, `relaisId`, `raumId`) VALUES (:installationId,:bezeichnung, :relaisId, :raumId)";
        $createSucessfull = $this->dbGateway->prepareInstallation($installationId, $bezeichnung, $installationRelaisId, $raumId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Neue Installation erstellt!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function updateInstallation($installationId, $bezeichnung, $installationRelaisId) {

        $sql = "UPDATE `installation` SET `bezeichnung` = :bezeichnung, `relaisId` = :relaisId WHERE `installationId` = :installationId";
        $createSucessfull = $this->dbGateway->updateInstallation($installationId, $bezeichnung, $installationRelaisId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Installation wurde bearbeitet!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function deleteInstallation($installationId) {

        $sql = "DELETE FROM `installation` WHERE `installationId` = :installationId";
        $createSucessfull = $this->dbGateway->deleteInstallation($installationId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Installation wurde gelöscht!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }
    
        public function getRelaisInstallation($relaisId){
        
        $query = "SELECT * FROM installation WHERE relaisId = $relaisId";
        
        $getInstallation = $this->dbGateway->query($query);
        return $getInstallation;
    }

}



