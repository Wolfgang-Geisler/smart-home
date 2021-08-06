<?php

class sicherungModel {

    private $dbGateway;

    public function sicherungModel() {
        $this->dbGateway = new pdoDBGateway();
    }

    public function getSicherung($fiId) {
        $query = "SELECT * FROM sicherung WHERE fiId = $fiId";

        $getSicherung = $this->dbGateway->query($query);
        return $getSicherung;
    }

    public function createSicherung($sicherungId, $hersteller, $ausloesestrom, $spannung, $pole, $fiId) {

        $sql = "INSERT INTO sicherung(`sicherungId`, `hersteller`, `ausloesestrom`, `spannung`, `pole`, `fiId`) VALUES (:sicherungId, :hersteller, :ausloesestrom, :spannung, :pole, :fiId)";
        $createSucessfull = $this->dbGateway->prepareSicherung($sicherungId, $hersteller, $ausloesestrom, $spannung, $pole, $fiId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Neue Sicherung erstellt!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function updateSicherung($sicherungId, $hersteller, $ausloesestrom, $spannung, $pole) {

        $sql = "UPDATE `sicherung` SET `sicherungId` = :sicherungId, `hersteller` = :hersteller, `ausloesestrom` = :ausloesestrom, `spannung` = :spannung, `pole` = :pole WHERE `sicherungId` = :sicherungId";
        $createSucessfull = $this->dbGateway->updateSicherung($sicherungId, $hersteller, $ausloesestrom, $spannung, $pole, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Sicherung wurde bearbeitet!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

    public function deleteSicherung($sicherungId) {

        $sql = "DELETE FROM `sicherung` WHERE `sicherungId` = :sicherungId";
        $createSucessfull = $this->dbGateway->deleteSicherung($sicherungId, $sql);
        if ($createSucessfull) {
            $this->state = "OK";
            $message = "Sicherung wurde gelöscht!";
            return $message;
        } else {
            $this->state = "ERROR";
            $message = "Something went wrong!";
            return $message;
        }
    }

}
