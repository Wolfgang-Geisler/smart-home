<?php

class smartHomeController {

    private $jsonView;

    public function smartHomeController() {
        $this->jsonView = new JsonView();
    }

    public function route() {
        $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);

        switch (strtolower($action)) {
            case 'get-projects':
                $this->getProjects();
                break;
            case 'create-project':
                $this->createProjects();
                break;
            case 'get-gebaeude':
                $projectId = filter_input(INPUT_GET, 'projectId', FILTER_SANITIZE_NUMBER_INT);
                $this->getGebaeude($projectId);
                break;
            case 'create-gebaeude':
                $this->createGebaeude();
                break;
            case 'update-gebaeude':
                $this->updateGebaeude();
                break;
            case 'delete-gebaeude':
                $this->deleteGebaeude();
                break;
            case 'get-stockwerk':
                $gebaeudeId = filter_input(INPUT_GET, 'gebaeudeId', FILTER_SANITIZE_NUMBER_INT);
                $this->getStockwerk($gebaeudeId);
                break;
            case 'create-stockwerk':
                $this->createStockwerk();
                break;
            case 'update-stockwerk':
                $this->updateStockwerk();
                break;
            case 'delete-stockwerk':
                $this->deleteStockwerk();
                break;
            case 'get-raum':
                $stockwerkId = filter_input(INPUT_GET, 'stockwerkId', FILTER_SANITIZE_NUMBER_INT);
                $this->getRaum($stockwerkId);
                break;
            case 'create-raum':
                $this->createRaum();
                break;
            case 'update-raum':
                $this->updateRaum();
                break;
            case 'delete-raum':
                $this->deleteRaum();
                break;
            case 'get-installation':
                $raumId = filter_input(INPUT_GET, 'raumId', FILTER_SANITIZE_NUMBER_INT);
                $this->getInstallation($raumId);
                break;
            case 'create-installation':
                $this->createInstallation();
                break;
            case 'update-installation':
                $this->updateInstallation();
                break;
            case 'delete-installation':
                $this->deleteInstallation();
                break;
            case 'get-schaltschrank':
                $gebaeudeId = filter_input(INPUT_GET, 'gebaeudeId', FILTER_SANITIZE_NUMBER_INT);
                $this->getSchaltschrank($gebaeudeId);
                break;
            case 'create-schaltschrank':
                $this->createSchaltschrank();
                break;
            case 'update-schaltschrank':
                $this->updateSchaltschrank();
                break;
            case 'delete-schaltschrank':
                $this->deleteSchaltschrank();
                break;
            case 'get-fi':
                $schaltschrankId = filter_input(INPUT_GET, 'schaltschrankId', FILTER_SANITIZE_NUMBER_INT);
                $this->getFi($schaltschrankId);
                break;
            case 'create-fi':
                $this->createFi();
                break;
            case 'update-fi':
                $this->updateFi();
                break;
            case 'delete-fi':
                $this->deleteFi();
                break;
            case 'get-sicherung':
                $fiId = filter_input(INPUT_GET, 'fiId', FILTER_SANITIZE_NUMBER_INT);
                $this->getSicherung($fiId);
                break;
            case 'create-sicherung':
                $this->createSicherung();
                break;
            case 'update-sicherung':
                $this->updateSicherung();
                break;
            case 'delete-sicherung':
                $this->deleteSicherung();
                break;
            case 'get-relais':
                $sicherungId = filter_input(INPUT_GET, 'sicherungId', FILTER_SANITIZE_NUMBER_INT);
                $this->getRelais($sicherungId);
                break;
            case 'create-relais':
                $this->createRelais();
                break;
            case 'update-relais':
                $this->updateRelais();
                break;
            case 'delete-relais':
                $this->deleteRelais();
                break;
            case 'get-relaisinstall':
                $relaisId = filter_input(INPUT_GET, 'relaisId', FILTER_SANITIZE_NUMBER_INT);
                $this->getRelaisInstallation($relaisId);
                break;
            default:
                $this->jsonView->streamOutput(
                        [
                            "error" => "Interface not found.",
                ]);
                return false;
        }
    }

    private function getProjects() {

        $projektModel = new projektModel();
        $projektList = $projektModel->getProjects();

        $data = array(
            'projekt' => $projektList
        );

        $this->jsonView->streamOutput($data);
    }

    private function createProjects() {

        $projektModel = new projektModel();

        $projektId = $_POST['projektId'];
        $bezeichnung = $_POST['bezeichnung'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $adresse = $_POST['adresse'];
        $notizen = $_POST['notizen'];

        $data = $projektModel->createProject($projektId, $bezeichnung, $vorname, $nachname, $adresse, $notizen);

        $this->jsonView->streamOutput($data);
    }

    private function getGebaeude($projectId) {

        $gebaeudeModel = new gebaeudeModel();
        $gebaeudeList = $gebaeudeModel->getGebaeude($projectId);

        $data = array(
            'gebaeude' => $gebaeudeList
        );

        $this->jsonView->streamOutput($data);
    }

    private function createGebaeude() {

        $gebaeudeModel = new gebaeudeModel();

        $gebaeudeId = $_POST['gebaeudeId'];
        $adresse = $_POST['adresse'];
        $bezeichnung = $_POST['bezeichnung'];
        $projektId = $_POST['projektId'];

        $data = $gebaeudeModel->createGebaeude($gebaeudeId, $adresse, $bezeichnung, $projektId);

        $this->jsonView->streamOutput($data);
    }

    private function updateGebaeude() {

        $gebaeudeModel = new gebaeudeModel();

        $gebaeudeId = $_POST['gebaeudeId'];
        $adresse = $_POST['adresse'];
        $bezeichnung = $_POST['bezeichnung'];

        $data = $gebaeudeModel->updateGebaeude($gebaeudeId, $adresse, $bezeichnung);

        $this->jsonView->streamOutput($data);
    }

    private function deleteGebaeude() {

        $gebaeudeModel = new gebaeudeModel();

        $gebaeudeId = $_POST['gebaeudeId'];

        $data = $gebaeudeModel->deleteGebaeude($gebaeudeId);

        $this->jsonView->streamOutput($data);
    }

    private function getStockwerk($gebaeudeId) {

        $stockwerkModel = new stockwerkModel();
        $stockwerkList = $stockwerkModel->getStockwerk($gebaeudeId);

        $data = array(
            'stockwerk' => $stockwerkList
        );

        $this->jsonView->streamOutput($data);
    }

    private function createStockwerk() {

        $stockwerkModel = new stockwerkModel();

        $stockwerkId = $_POST['stockwerkId'];
        $bezeichnung = $_POST['bezeichnung'];
        $gebaeudeId = $_POST['gebaeudeId'];

        $data = $stockwerkModel->createStockwerk($stockwerkId, $bezeichnung, $gebaeudeId);

        $this->jsonView->streamOutput($data);
    }

    private function updateStockwerk() {

        $stockwerkModel = new stockwerkModel();

        $stockwerkId = $_POST['stockwerkId'];
        $bezeichnung = $_POST['bezeichnung'];

        $data = $stockwerkModel->updateStockwerk($stockwerkId, $bezeichnung);

        $this->jsonView->streamOutput($data);
    }

    private function deleteStockwerk() {

        $stockwerkModel = new stockwerkModel();

        $stockwerkId = $_POST['stockwerkId'];

        $data = $stockwerkModel->deleteStockwerk($stockwerkId);

        $this->jsonView->streamOutput($data);
    }

    private function getRaum($stockwerkId) {

        $raumModel = new raumModel();
        $raumList = $raumModel->getRaum($stockwerkId);

        $data = array(
            'raum' => $raumList
        );

        $this->jsonView->streamOutput($data);
    }

    private function createRaum() {

        $raumModel = new raumModel();

        $raumId = $_POST['raumId'];
        $bezeichnung = $_POST['bezeichnung'];
        $stockwerkId = $_POST['stockwerkId'];

        $data = $raumModel->createRaum($raumId, $bezeichnung, $stockwerkId);

        $this->jsonView->streamOutput($data);
    }

    private function updateRaum() {

        $raumModel = new raumModel();

        $raumId = $_POST['raumId'];
        $bezeichnung = $_POST['bezeichnung'];

        $data = $raumModel->updateRaum($raumId, $bezeichnung);

        $this->jsonView->streamOutput($data);
    }

    private function deleteRaum() {

        $raumModel = new raumModel();

        $raumId = $_POST['raumId'];

        $data = $raumModel->deleteRaum($raumId);

        $this->jsonView->streamOutput($data);
    }

    private function getInstallation($raumId) {

        $installationModel = new installationModel();
        $installationList = $installationModel->getInstallation($raumId);

        $data = array(
            'installation' => $installationList
        );

        $this->jsonView->streamOutput($data);
    }

    private function createInstallation() {

        $installationModel = new installationModel();

        $installationId = $_POST['installationId'];
        $bezeichnung = $_POST['bezeichnung'];
        $installationRelaisId = $_POST['installationRelaisId'];
        $raumId = $_POST['raumId'];

        $data = $installationModel->createInstallation($installationId, $bezeichnung, $installationRelaisId, $raumId);

        $this->jsonView->streamOutput($data);
    }

    private function updateInstallation() {

        $installationModel = new installationModel();

        $installationId = $_POST['installationId'];
        $bezeichnung = $_POST['bezeichnung'];
        $installationRelaisId = $_POST['installationRelaisId'];

        $data = $installationModel->updateInstallation($installationId, $bezeichnung, $installationRelaisId);

        $this->jsonView->streamOutput($data);
    }

    private function deleteInstallation() {

        $installationModel = new installationModel();

        $installationId = $_POST['installationId'];

        $data = $installationModel->deleteInstallation($installationId);

        $this->jsonView->streamOutput($data);
    }

    private function getSchaltschrank($gebaeudeId) {

        $schaltschrankModel = new schaltschrankModel();
        $schaltschrankList = $schaltschrankModel->getSchaltschrank($gebaeudeId);

        $data = array(
            'schaltschrank' => $schaltschrankList
        );

        $this->jsonView->streamOutput($data);
    }

    private function createSchaltschrank() {

        $schaltschrankModel = new schaltschrankModel();

        $schaltschrankId = $_POST['schaltschrankId'];
        $bezeichnung = $_POST['bezeichnung'];
        $position = $_POST['position'];
        $gebaeudeId = $_POST['gebaeudeId'];

        $data = $schaltschrankModel->createSchaltschrank($schaltschrankId, $bezeichnung, $position, $gebaeudeId);

        $this->jsonView->streamOutput($data);
    }

    private function updateSchaltschrank() {

        $schaltschrankModel = new schaltschrankModel();

        $schaltschrankId = $_POST['schaltschrankId'];
        $bezeichnung = $_POST['bezeichnung'];
        $position = $_POST['position'];

        $data = $schaltschrankModel->updateSchaltschrank($schaltschrankId, $bezeichnung, $position);

        $this->jsonView->streamOutput($data);
    }

    private function deleteSchaltschrank() {

        $schaltschrankModel = new schaltschrankModel();

        $schaltschrankId = $_POST['schaltschrankId'];

        $data = $schaltschrankModel->deleteSchaltschrank($schaltschrankId);

        $this->jsonView->streamOutput($data);
    }

    private function getFi($schaltschrankId) {

        $fiModel = new fiModel();
        $fiList = $fiModel->getFi($schaltschrankId);

        $data = array(
            'fi' => $fiList
        );

        $this->jsonView->streamOutput($data);
    }

    private function createFi() {

        $fiModel = new fiModel();

        $fiId = $_POST['fiId'];
        $hersteller = $_POST['hersteller'];
        $spannung = $_POST['spannung'];
        $schaltschrankId = $_POST['schaltschrankId'];

        $data = $fiModel->createFi($fiId, $hersteller, $spannung, $schaltschrankId);

        $this->jsonView->streamOutput($data);
    }

    private function updateFi() {

        $fiModel = new fiModel();

        $fiId = $_POST['fiId'];
        $hersteller = $_POST['hersteller'];
        $spannung = $_POST['spannung'];

        $data = $fiModel->updateFi($fiId, $hersteller, $spannung);

        $this->jsonView->streamOutput($data);
    }

    private function deleteFi() {

        $fiModel = new fiModel();

        $fiId = $_POST['fiId'];

        $data = $fiModel->deleteFi($fiId);

        $this->jsonView->streamOutput($data);
    }

    private function getSicherung($fiId) {

        $sicherungModel = new sicherungModel();
        $sicherungList = $sicherungModel->getSicherung($fiId);

        $data = array(
            'sicherung' => $sicherungList
        );

        $this->jsonView->streamOutput($data);
    }

    private function createSicherung() {

        $sicherungModel = new sicherungModel();

        $sicherungId = $_POST['sicherungId'];
        $hersteller = $_POST['hersteller'];
        $ausloesestrom = $_POST['ausloesestrom'];
        $spannung = $_POST['spannung'];
        $pole = $_POST['pole'];
        $fiId = $_POST['fiId'];

        $data = $sicherungModel->createSicherung($sicherungId, $hersteller, $ausloesestrom, $spannung, $pole, $fiId);

        $this->jsonView->streamOutput($data);
    }

    private function updateSicherung() {

        $sicherungModel = new sicherungModel();

        $sicherungId = $_POST['sicherungId'];
        $hersteller = $_POST['hersteller'];
        $ausloesestrom = $_POST['ausloesestrom'];
        $spannung = $_POST['spannung'];
        $pole = $_POST['pole'];

        $data = $sicherungModel->updateSicherung($sicherungId, $hersteller, $ausloesestrom, $spannung, $pole);

        $this->jsonView->streamOutput($data);
    }

    private function deleteSicherung() {

        $sicherungModel = new sicherungModel();

        $sicherungId = $_POST['sicherungId'];

        $data = $sicherungModel->deleteSicherung($sicherungId);

        $this->jsonView->streamOutput($data);
    }

    private function getRelais($sicherungId) {

        $relaisModel = new relaisModel();
        $relaisList = $relaisModel->getRelais($sicherungId);

        $data = array(
            'relais' => $relaisList
        );

        $this->jsonView->streamOutput($data);
    }

    private function createRelais() {

        $relaisModel = new relaisModel();

        $relaisId = $_POST['relaisId'];
        $sicherungId = $_POST['sicherungId'];

        $data = $relaisModel->createRelais($relaisId, $sicherungId);

        $this->jsonView->streamOutput($data);
    }

    private function updateRelais() {

        $relaisModel = new relaisModel();

        $relaisId = $_POST['relaisId'];
        $relaisIdNew = $_POST['relaisIdNew'];

        $data = $relaisModel->updateRelais($relaisId, $relaisIdNew);

        $this->jsonView->streamOutput($data);
    }

    private function deleteRelais() {

        $relaisModel = new relaisModel();

        $relaisId = $_POST['relaisId'];

        $data = $relaisModel->deleteRelais($relaisId);

        $this->jsonView->streamOutput($data);
    }

    private function getRelaisInstallation($relaisId) {

        $installationModel = new installationModel();
        $installationList = $installationModel->getRelaisInstallation($relaisId);

        $data = array(
            'installation' => $installationList
        );

        $this->jsonView->streamOutput($data);
    }

}
