<?php

include "controller/smartHomeController.php";
include "services/Database.php";
include "models/pdoDBGateway.php";
include "models/fiModel.php";
include "models/gebaeudeModel.php";
include "models/kundenModel.php";
include "models/projektModel.php";
include "models/raumModel.php";
include "models/relaisModel.php";
include "models/schaltschrankModel.php";
include "models/sicherungModel.php";
include "models/stockwerkModel.php";
include "models/installationModel.php";
include "views/JsonView.php";

define("DBHost", "localhost");
define("DBName", "project");
define("DBPassword", "");
define("DBUsername", "root");
