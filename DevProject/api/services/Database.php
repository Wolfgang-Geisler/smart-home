<?php

/**
 * Description of Database
 *
 * @author helmuth
 */
class Database {

    private $pdo;
    public $lastInsertedId;

    public function __construct($dbHost, $dbName, $dbUser, $dpPass) {
        $this->pdo = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName . ";charset=utf8", $dbUser, $dpPass);
    }

    public function query($sql) {
        $resultTable = array();

        try {
            foreach ($this->pdo->query($sql) as $row) {
                $resultTable[] = $row;
            }
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
            return $resultTable;
        }

        return $resultTable;
    }

    public function prepare($projektId, $bezeichnung, $vorname, $nachname, $adresse, $notizen, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':projektId', $projektId);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->bindParam(':vorname', $vorname);
            $stmt->bindParam(':nachname', $nachname);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':notizen', $notizen);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function prepareGebaeude($gebaeudeId, $adresse, $bezeichnung, $projektId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':gebaeudeId', $gebaeudeId);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->bindParam(':projektId', $projektId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function updateGebaeude($gebaeudeId, $adresse, $bezeichnung, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':gebaeudeId', $gebaeudeId);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function deleteGebaeude($gebaeudeId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':gebaeudeId', $gebaeudeId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function prepareStockwerk($stockwerkId, $bezeichnung, $gebaeudeId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':stockwerkId', $stockwerkId);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->bindParam(':gebaeudeId', $gebaeudeId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function updateStockwerk($stockwerkId, $bezeichnung, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':stockwerkId', $stockwerkId);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function deleteStockwerk($stockwerkId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':stockwerkId', $stockwerkId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function prepareRaum($raumId, $bezeichnung, $stockwerkId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':raumId', $raumId);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->bindParam(':stockwerkId', $stockwerkId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function updateRaum($raumId, $bezeichnung, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':raumId', $raumId);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function deleteRaum($raumId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':raumId', $raumId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function prepareInstallation($installationId, $bezeichnung, $installationRelaisId, $raumId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':installationId', $installationId);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->bindParam(':relaisId', $installationRelaisId);
            $stmt->bindParam(':raumId', $raumId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function updateInstallation($installationId, $bezeichnung, $installationRelaisId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':installationId', $installationId);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->bindParam(':relaisId', $installationRelaisId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function deleteInstallation($installationId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':installationId', $installationId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function prepareSchaltschrank($schaltschrankId, $bezeichnung, $position, $gebaeudeId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':schaltschrankId', $schaltschrankId);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':gebaeudeId', $gebaeudeId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function updateSchaltschrank($schaltschrankId, $bezeichnung, $position, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':schaltschrankId', $schaltschrankId);
            $stmt->bindParam(':bezeichnung', $bezeichnung);
            $stmt->bindParam(':position', $position);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function deleteSchaltschrank($schaltschrankId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':schaltschrankId', $schaltschrankId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function prepareFi($fiId, $hersteller, $spannung, $schaltschrankId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':fiId', $fiId);
            $stmt->bindParam(':hersteller', $hersteller);
            $stmt->bindParam(':spannung', $spannung);
            $stmt->bindParam(':schaltschrankId', $schaltschrankId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function updateFi($fiId, $hersteller, $spannung, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':fiId', $fiId);
            $stmt->bindParam(':hersteller', $hersteller);
            $stmt->bindParam(':spannung', $spannung);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function deleteFi($fiId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':fiId', $fiId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function prepareSicherung($sicherungId, $hersteller, $ausloesestrom, $spannung, $pole, $fiId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':sicherungId', $sicherungId);
            $stmt->bindParam(':hersteller', $hersteller);
            $stmt->bindParam(':ausloesestrom', $ausloesestrom);
            $stmt->bindParam(':spannung', $spannung);
            $stmt->bindParam(':pole', $pole);
            $stmt->bindParam(':fiId', $fiId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function updateSicherung($sicherungId, $hersteller, $ausloesestrom, $spannung, $pole, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':sicherungId', $sicherungId);
            $stmt->bindParam(':hersteller', $hersteller);
            $stmt->bindParam(':ausloesestrom', $ausloesestrom);
            $stmt->bindParam(':spannung', $spannung);
            $stmt->bindParam(':pole', $pole);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function deleteSicherung($sicherungId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':sicherungId', $sicherungId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }
    
    public function prepareRelais($relaisId, $sicherungId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);
            
            $stmt->bindParam(':relaisId', $relaisId);
            $stmt->bindParam(':sicherungId', $sicherungId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function updateRelais($relaisId, $relaisIdNew, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':relaisId', $relaisId);
            $stmt->bindParam(':relaisIdNew', $relaisIdNew);
          
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

    public function deleteRelais($relaisId, $sql) {

        try {
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':relaisId', $relaisId);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage() . "\n" . $sql);
        }
    }

}
