let ansicht = "gAnsicht";
let projectsView = function () {
    this.$projectstable = $('#projectsTable');
    this.$dropdown = $('.dropdown-menu');
};

projectsView.prototype.initGuiEvents = function () {

    let self = this;

    $('#dropdownMenuButton').on('click', function () {
        self.getProjects();
    });

    $('#navCreate').on('click', function () {
        document.getElementById("outputTable").style.display = "none";
        document.getElementById("createProject").style.display = "block";
    });

    $('#navSelect').on('click', function () {
        document.getElementById("outputTable").style.display = "block";
        document.getElementById("createProject").style.display = "none";
    });

    $('#btnCreateProject').on('click', function () {
        self.createProject();
    });

    $('#btnAnsicht').on('click', function () {
        $('#projectsTable').find('tbody').empty();
        if (document.getElementById("ansichtTxt").textContent == "Gebäude Ansicht") {
            document.getElementById("ansichtTxt").textContent = "E-Ansicht";
            ansicht = "eAnsicht";

        } else {
            document.getElementById("ansichtTxt").textContent = "Gebäude Ansicht";
            ansicht = "gAnsicht";
        }
    });

    document.getElementsByClassName("close")[0].onclick = function () {
        document.getElementById("modal").style.display = "none";
        $('#modalForm').empty();
    }
};

projectsView.prototype.getProjects = function () {

    let self = this;

    $.ajax({
        url: "api/?action=get-projects",
        type: "GET",

        success: function (response) {
            self.fillDropdownProjects(response);
        },

        error: function (error) {
            console.log(error);
        }
    });
};

projectsView.prototype.createProject = function () {

    let projektId = document.getElementById("projektId").value;
    let bezeichnung = document.getElementById("bezeichnung").value;
    let vorname = document.getElementById("vorname").value;
    let nachname = document.getElementById("nachname").value;
    let adresse = document.getElementById("adresse").value;
    let notizen = document.getElementById("notizen").value;

    $.ajax({
        url: "api/?action=create-project",
        type: "POST",
        data: {"projektId": projektId,
            "bezeichnung": bezeichnung,
            "vorname": vorname,
            "nachname": nachname,
            "adresse": adresse,
            "notizen": notizen},

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }
    });
};

projectsView.prototype.fillDropdownProjects = function (response) {

    this.$dropdown.find("a").remove();

    for (let i in response.projekt) {
        let project = response.projekt[i].bezeichnung;

        let $items = $('<a class="dropdown-item" id="' + response.projekt[i].projektId + '" href="#">' + project + '</a>');
        this.$dropdown.append($items);

    }
    this.initProjectBtnEvent();
};

projectsView.prototype.initProjectBtnEvent = function () {

    let self = this;

    $('a.dropdown-item').click(function () {
        projectId = $(this).attr('id');
        self.getGebaeude(projectId);
    });
};

projectsView.prototype.getGebaeude = function (projectId) {

    let self = this;

    $.ajax({
        url: "api/?action=get-gebaeude&projectId=" + projectId,
        type: "GET",

        success: function (response) {
            self.fillGebaeudeTable(response, projectId);
        },

        error: function (error) {
            console.log(error);
        }
    });
};

projectsView.prototype.fillGebaeudeTable = function (response, projectId) {
    this.$projectstable.find('tbody').empty();

    for (let i in response.gebaeude) {
        let gebaeude = response.gebaeude[i];

        let $tr = $('<tr><td>' + response.gebaeude[i].gebaeudeId + '</td><td><a class="gebaeude" id="' + response.gebaeude[i].gebaeudeId + ' " href="#"> ' + gebaeude.bezeichnung + '</a></td><td>' + '<button class="btnGebaeudeEdit" id="' + response.gebaeude[i].gebaeudeId + '">edit</button>' + '</td><td>' + '<button class="btnGebaeudeLoeschen" id="' + response.gebaeude[i].gebaeudeId + '">löschen</button>' + '</td><td>' + '<button class="btnGebaeudeDetails" id="' + i + '">Details</button>' + '</td></tr>');
        this.$projectstable.append($tr);
    }
    this.$projectstable.append('<tr><td><button class="btn btn-primary" id="addGebaeude">add</button></td></tr>');
    this.initGebaeudeEvent(projectId, response);
};

projectsView.prototype.initGebaeudeEvent = function (projectId, response) {

    let self = this;
    if (ansicht == "gAnsicht") {
        $('a.gebaeude').click(function () {
            gebauedeId = $(this).attr('id');
            self.getStockwerke(gebauedeId);
        });
    } else if (ansicht == "eAnsicht") {
        $('a.gebaeude').click(function () {
            gebauedeId = $(this).attr('id');
            self.getSchaltschrank(gebauedeId);

        });
    }

    $('#addGebaeude').click(function () {
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Gebäude erstellen:</h4><div class="input-group mb-3"><input id="gebaeudeId" type="text" class="form-control" placeholder="Id"></div><div class="input-group mb-3"><input id="gebaeudeAdresse" type="text" class="form-control" placeholder="Adresse"></div></div><div class="input-group mb-3"><input id="gebaeudeBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"></div><button type="button" class="btn btn-secondary" id="btnCreateGebaeude">Erstellen</button>');
        $('#btnCreateGebaeude').on('click', function () {
            self.createGebaeude(projectId);
        });
    });


    $('button.btnGebaeudeEdit').click(function () {
        gebaeudeId = $(this).attr('id');
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Gebäude ' + gebaeudeId + ' bearbeiten:</h4><div class="input-group mb-3"></div><div class="input-group mb-3"><input id="gebaeudeAdresse" type="text" class="form-control" placeholder="Adresse"></div></div><div class="input-group mb-3"><input id="gebaeudeBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"></div><button type="button" class="btn btn-secondary" id="btnUpdateGebaeude">Bearbeiten</button>');
        $('#btnUpdateGebaeude').on('click', function () {
            self.updateGebaeude(gebaeudeId);
        });
    });

    $('button.btnGebaeudeLoeschen').click(function () {
        gebaeudeId = $(this).attr('id');
        self.deleteGebaeude(gebaeudeId);
    });

    $('button.btnGebaeudeDetails').click(function () {
        id = $(this).attr('id');
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<div><h4>Adresse: </h4><a>' + response.gebaeude[id].adresse + '</a></div>');
    });


};

projectsView.prototype.createGebaeude = function (projectId) {

    let gebaeudeId = document.getElementById("gebaeudeId").value;
    let bezeichnung = document.getElementById("gebaeudeBezeichnung").value;
    let adresse = document.getElementById("gebaeudeAdresse").value;
    let projektId = projectId;

    $.ajax({
        url: "api/?action=create-gebaeude",
        type: "POST",
        data: {"gebaeudeId": gebaeudeId,
            "bezeichnung": bezeichnung,
            "adresse": adresse,
            "projektId": projektId
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }

    });
};

projectsView.prototype.updateGebaeude = function (gebaeudeId) {

    let id = gebaeudeId;
    let bezeichnung = document.getElementById("gebaeudeBezeichnung").value;
    let adresse = document.getElementById("gebaeudeAdresse").value;

    $.ajax({
        url: "api/?action=update-gebaeude",
        type: "POST",
        data: {"gebaeudeId": id,
            "bezeichnung": bezeichnung,
            "adresse": adresse
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }

    });
};

projectsView.prototype.deleteGebaeude = function (gebaeudeId) {

    let id = gebaeudeId;

    $.ajax({
        url: "api/?action=delete-gebaeude",
        type: "POST",
        data: {"gebaeudeId": id
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }

    });
};

projectsView.prototype.getStockwerke = function (gebaeudeId) {

    let self = this;

    $.ajax({
        url: "api/?action=get-stockwerk&gebaeudeId=" + gebaeudeId,
        type: "GET",

        success: function (response) {
            self.fillStockwerkTable(response, gebaeudeId);
        },

        error: function (error) {
            console.log(error);
        }
    });
};


projectsView.prototype.fillStockwerkTable = function (response, gebaeudeId) {
    this.$projectstable.find('tbody').empty();

    for (let i in response.stockwerk) {
        let stockwerk = response.stockwerk[i];

        let $tr = $('<tr><td>' + stockwerk.stockwerkId + '</td><td><a class="stockwerk" id="' + stockwerk.stockwerkId + '" href="#"> ' + stockwerk.bezeichnung + '</a></td><td>' + '<button class="btnStockwerkEdit" id="' + stockwerk.stockwerkId + '">edit</button>' + '</td><td>' + '<button class="btnStockwerkLoeschen" id="' + stockwerk.stockwerkId + '">löschen</button>' + '</td></tr>');
        this.$projectstable.append($tr);

    }
    this.$projectstable.append('<tr><td><button class="btn btn-primary" id="addStockwerk">add</button></td></tr>');
    this.initStockwerkEvent(gebaeudeId);
};


projectsView.prototype.initStockwerkEvent = function (gebaeudeId) {

    let self = this;

    $('a.stockwerk').click(function () {
        stockwerkId = $(this).attr('id');
        self.getRaeume(stockwerkId);
    });

    $('#addStockwerk').click(function () {
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Stockwerk erstellen:</h4><div class="input-group mb-3"><input id="stockwerkId" type="text" class="form-control" placeholder="Id"></div><div class="input-group mb-3"><input id="stockwerkBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"></div><button type="button" class="btn btn-secondary" id="btnCreateStockwerk">Erstellen</button>');
        $('#btnCreateStockwerk').on('click', function () {
            self.createStockwerk(gebaeudeId);
        });
    });

    $('button.btnStockwerkEdit').click(function () {
        stockwerkId = $(this).attr('id');
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Stockwerk ' + stockwerkId + ' bearbeiten:</h4><div class="input-group mb-3"><input id="stockwerkBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"></div><button type="button" class="btn btn-secondary" id="btnUpdateStockwerk">Bearbeiten</button>');
        $('#btnUpdateStockwerk').on('click', function () {
            self.updateStockwerk(stockwerkId);
        });
    });

    $('button.btnStockwerkLoeschen').click(function () {
        stockwerkId = $(this).attr('id');
        self.deleteStockwerk(stockwerkId);
    });
};

projectsView.prototype.createStockwerk = function (gebId) {

    let stockwerkId = document.getElementById("stockwerkId").value;
    let bezeichnung = document.getElementById("stockwerkBezeichnung").value;
    let gebaeudeId = gebId;

    $.ajax({
        url: "api/?action=create-stockwerk",
        type: "POST",
        data: {"stockwerkId": stockwerkId,
            "bezeichnung": bezeichnung,
            "gebaeudeId": gebaeudeId
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }
    });
};

projectsView.prototype.updateStockwerk = function (stockwerkId) {

    let id = stockwerkId;
    let bezeichnung = document.getElementById("stockwerkBezeichnung").value;

    $.ajax({
        url: "api/?action=update-stockwerk",
        type: "POST",
        data: {"stockwerkId": id,
            "bezeichnung": bezeichnung
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }

    });
};

projectsView.prototype.deleteStockwerk = function (stockwerkId) {

    let id = stockwerkId;

    $.ajax({
        url: "api/?action=delete-stockwerk",
        type: "POST",
        data: {"stockwerkId": id
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }

    });
};


projectsView.prototype.getRaeume = function (stockwerkId) {

    let self = this;

    $.ajax({
        url: "api/?action=get-raum&stockwerkId=" + stockwerkId,
        type: "GET",

        success: function (response) {
            self.fillRaumTable(response, stockwerkId);
        },

        error: function (error) {
            console.log(error);
        }
    });
};


projectsView.prototype.fillRaumTable = function (response, stockwerkId) {
    this.$projectstable.find('tbody').empty();

    for (let i in response.raum) {
        let raum = response.raum[i];

        let $tr = $('<tr><td>' + raum.raumId + '</td><td><a class="raum" id="' + raum.raumId + '" href="#"> ' + raum.bezeichnung + '</a></td><td>' + '<button class="btnRaumEdit" id="' + raum.raumId + '">edit</button>' + '</td><td>' + '<button class="btnRaumLoeschen" id="' + raum.raumId + '">löschen</button>' + '</td></tr>');
        this.$projectstable.append($tr);
    }
    this.$projectstable.append('<tr><td><button class="btn btn-primary" id="addRaum">add</button></td></tr>');
    this.initRaumEvent(stockwerkId);
};

projectsView.prototype.initRaumEvent = function (stockwerkId) {

    let self = this;

    $('a.raum').click(function () {
        raumId = $(this).attr('id');
        self.getInstallation(raumId);
    });

    $('#addRaum').click(function () {
        raumId = $(this).attr('id');
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Raum erstellen:</h4><div class="input-group mb-3"><input id="raumId" type="text" class="form-control" placeholder="Id"></div><div class="input-group mb-3"><input id="raumBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"></div><button type="button" class="btn btn-secondary" id="btnCreateRaum">Erstellen</button>');
        $('#btnCreateRaum').on('click', function () {
            self.createRaum(stockwerkId);
        });
    });

    $('button.btnRaumEdit').click(function () {
        raumId = $(this).attr('id');

        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Raum ' + raumId + ' bearbeiten:</h4><div class="input-group mb-3"><input id="raumBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"></div><button type="button" class="btn btn-secondary" id="btnUpdateRaum">Bearbeiten</button>');
        $('#btnUpdateRaum').on('click', function () {
            self.updateRaum(raumId);
        });
    });

    $('button.btnRaumLoeschen').click(function () {
        raumId = $(this).attr('id');
        self.deleteRaum(raumId);
    });
};

projectsView.prototype.createRaum = function (stockId) {

    let raumId = document.getElementById("raumId").value;
    let bezeichnung = document.getElementById("raumBezeichnung").value;
    let stockwerkId = stockId;

    $.ajax({
        url: "api/?action=create-raum",
        type: "POST",
        data: {"raumId": raumId,
            "bezeichnung": bezeichnung,
            "stockwerkId": stockwerkId
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }
    });
};

projectsView.prototype.updateRaum = function (raumId) {

    let id = raumId;
    let bezeichnung = document.getElementById("raumBezeichnung").value;

    $.ajax({
        url: "api/?action=update-raum",
        type: "POST",
        data: {"raumId": id,
            "bezeichnung": bezeichnung
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }

    });
};

projectsView.prototype.deleteRaum = function (raumId) {

    let id = raumId;

    $.ajax({
        url: "api/?action=delete-raum",
        type: "POST",
        data: {"raumId": id
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }

    });
};

projectsView.prototype.getSchaltschrank = function (gebaeudeId) {

    let self = this;

    $.ajax({
        url: "api/?action=get-schaltschrank&gebaeudeId=" + gebaeudeId,
        type: "GET",

        success: function (response) {
            self.fillSchaltschrankTable(response, gebaeudeId);
        },

        error: function (error) {
            console.log(error);
        }
    });
};


projectsView.prototype.fillSchaltschrankTable = function (response, gebaeudeId) {
    this.$projectstable.find('tbody').empty();

    for (let i in response.schaltschrank) {
        let schaltschrank = response.schaltschrank[i];

        let $tr = $('<tr><td>' + schaltschrank.schaltschrankId + '</td><td><a class="schaltschrank" id="' + schaltschrank.schaltschrankId + '" href="#"> ' + schaltschrank.bezeichnung + ' </a></td><td>' + '<button class="btnSchaltschrankionEdit" id="' + schaltschrank.schaltschrankId + '">edit</button>' + '</td><td>' + '<button class="btnSchaltschrankLoeschen" id="' + schaltschrank.schaltschrankId + '">löschen</button>' + '</td><td>' + '<button class="btnSchaltschrankDetails" id="' + i + '">Details</button>' + '</td></tr>');
        this.$projectstable.append($tr);

    }
    this.$projectstable.append('<tr><td><button class="btn btn-primary" id="addSchaltschrank">add</button></td></tr>');
    this.initSchaltschrankEvent(response, gebaeudeId);
};


projectsView.prototype.initSchaltschrankEvent = function (response, gebaeudeId) {

    let self = this;

    let schaltschrankId = $(this).attr('id');

    $('a.schaltschrank').click(function () {
        schaltschrankId = $(this).attr('id');
        self.getFi(schaltschrankId);
    });

    $('button.btnSchaltschrankDetails').click(function () {
        id = $(this).attr('id');
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<div><h4>Position: </h4><a>' + response.schaltschrank[id].position + '</a></div>');
    });

    $('#addSchaltschrank').click(function () {
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Schaltschrank erstellen:</h4><div class="input-group mb-3"><input id="schaltschrankId" type="text" class="form-control" placeholder="Id"></div><div class="input-group mb-3"><input id="schaltschrankBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"></div><div class="input-group mb-3"><input id="schaltschrankPosition" type="text" class="form-control" placeholder="Position"></div><button type="button" class="btn btn-secondary" id="btnCreateSchaltschrank">Erstellen</button>');
        $('#btnCreateSchaltschrank').on('click', function () {
            self.createSchaltschrank(gebaeudeId);
        });
    });

    $('button.btnSchaltschrankionEdit').click(function () {
        schaltschrankId = $(this).attr('id');
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Schaltschrank ' + schaltschrankId + ' bearbeiten:</h4><div class="input-group mb-3"><input id="schaltschrankBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"></div><div class="input-group mb-3"><input id="schaltschrankPosition" type="text" class="form-control" placeholder="Position"></div><button type="button" class="btn btn-secondary" id="btnUpdateInstallation">Bearbeiten</button>');
        $('#btnUpdateInstallation').on('click', function () {
            self.updateSchaltschrank(schaltschrankId);

        });
    });

    $('button.btnSchaltschrankLoeschen').click(function () {
        schaltschrankId = $(this).attr('id');
        self.deleteSchaltschrank(schaltschrankId);
    });
};

projectsView.prototype.createSchaltschrank = function (gebId) {

    let schaltschrankId = document.getElementById("schaltschrankId").value;
    let bezeichnung = document.getElementById("schaltschrankBezeichnung").value;
    let position = document.getElementById("schaltschrankPosition").value;
    let gebaeudeId = gebId;

    $.ajax({
        url: "api/?action=create-schaltschrank",
        type: "POST",
        data: {"schaltschrankId": schaltschrankId,
            "bezeichnung": bezeichnung,
            "position": position,
            "gebaeudeId": gebaeudeId
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }
    });
};

projectsView.prototype.updateSchaltschrank = function (schaltschrankId) {

    let id = schaltschrankId;
    let bezeichnung = document.getElementById("schaltschrankBezeichnung").value;
    let position = document.getElementById("schaltschrankPosition").value;

    $.ajax({
        url: "api/?action=update-schaltschrank",
        type: "POST",
        data: {"schaltschrankId": id,
            "bezeichnung": bezeichnung,
            "position": position
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }

    });
};

projectsView.prototype.deleteSchaltschrank = function (schaltschrankId) {

    let id = schaltschrankId;

    $.ajax({
        url: "api/?action=delete-schaltschrank",
        type: "POST",
        data: {"schaltschrankId": id
        },

        success: function (response) {
            alert(response);
        },

        error: function (error) {
            console.log(error);
        }

    });
};


projectsView.prototype.getFi = function (schaltschrankId) {

    let self = this;

    $.ajax({
        url: "api/?action=get-fi&schaltschrankId=" + schaltschrankId,
        type: "GET",

        success: function (response) {
            self.fillFiTable(response, schaltschrankId);
        },

        error: function (error) {
            console.log(error);
        }
    });
};


projectsView.prototype.fillFiTable = function (response, schaltschrankId) {
    this.$projectstable.find('tbody').empty();

    for (let i in response.fi) {
        let fi = response.fi[i];

        let $tr = $('<tr><td>' + fi.fiId + '</td><td><a class="fi" id="' + fi.fiId + '" href="#"> ' + fi.hersteller + '</a></td><td>' + '<button class="btnFiEdit" id="' + fi.fiId + '">edit</button>' + '</td><td>' + '<button class="btnFiLoeschen" id="' + fi.fiId + '">löschen</button>' + '</td><td>' + '<button class="btnFiDetails" id="' + i + '">Details</button>' + '</td></tr>');
        this.$projectstable.append($tr);
    }
    this.$projectstable.append('<tr><td><button class="btn btn-primary" id="addFi">add</button></td></tr>');
    this.initFiEvent(response, schaltschrankId);
};

projectsView.prototype.initFiEvent = function (response, schaltschrankId) {

    let self = this;

    $('a.fi').click(function () {
        fiId = $(this).attr('id');
        self.getSicherung(fiId);
    });

    $('button.btnFiDetails').click(function () {
        id = $(this).attr('id');
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<div><h4>Hersteller: </h4><a>' + response.fi[id].hersteller + '</a><h4>Spannung: </h4><a>' + response.fi[id].spannung + ' V</a></div>');
    });

    $('#addFi').click(function () {
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Fi erstellen:</h4><div class="input-group mb-3"><input id="fiId" type="text" class="form-control" placeholder="Id"></div><div class="input-group mb-3"><input id="fiHersteller" type="text" class="form-control" placeholder="Hersteller"></div><div class="input-group mb-3"><input id="fiSpannung" type="text" class="form-control" placeholder="Spannung"></div><button type="button" class="btn btn-secondary" id="btnCreateFi">Erstellen</button>');
        $('#btnCreateFi').on('click', function () {
            self.createFi(schaltschrankId);
        });
    });

    $('button.btnFiEdit').click(function () {
        fiId = $(this).attr('id');
        document.getElementById("modal").style.display = "block";
        $('#modalForm').append('<h4>Fi ' + fiId + ' bearbeiten:</h4><div class="input-group mb-3"><input id="fiHersteller" type="text" class="form-control" placeholder="Hersteller"></div><div class="input-group mb-3"><input id="fiSpannung" type="text" class="form-control" placeholder="Spannung"></div><button type="button" class="btn btn-secondary" id="btnUpdateFi">Bearbeiten</button>');
        $('#btnUpdateFi').on('click', function () {
            self.updateFi(fiId);

        });
    });

    $('button.btnFiLoeschen').click(function () {
        fiId = $(this).attr('id');
        self.deleteFi(fiId);
    });
    };

    projectsView.prototype.createFi = function (schId) {

        let fiId = document.getElementById("fiId").value;
        let hersteller = document.getElementById("fiHersteller").value;
        let spannung = document.getElementById("fiSpannung").value;
        let schaltschrankId = schId;

        $.ajax({
            url: "api/?action=create-fi",
            type: "POST",
            data: {"fiId": fiId,
                "hersteller": hersteller,
                "spannung": spannung,
                "schaltschrankId": schaltschrankId
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }
        });
    };

    projectsView.prototype.updateFi = function (fiId) {

        let id = fiId;
        let hersteller = document.getElementById("fiHersteller").value;
        let spannung = document.getElementById("fiSpannung").value;

        $.ajax({
            url: "api/?action=update-fi",
            type: "POST",
            data: {"fiId": id,
                "hersteller": hersteller,
                "spannung": spannung
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }

        });
    };

    projectsView.prototype.deleteFi = function (fiId) {

        let id = fiId;

        $.ajax({
            url: "api/?action=delete-fi",
            type: "POST",
            data: {"fiId": id
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }

        });
    };

    projectsView.prototype.getInstallation = function (raumId) {

        let self = this;


        $.ajax({
            url: "api/?action=get-installation&raumId=" + raumId,
            type: "GET",

            success: function (response) {
                self.fillInstallationTable(response, raumId);
            },

            error: function (error) {
                console.log(error);
            }
        });
    };

    projectsView.prototype.fillInstallationTable = function (response, raumId) {
        this.$projectstable.find('tbody').empty();


        for (let i in response.installation) {
            let installation = response.installation[i];

            let $tr = $('<tr><td>' + installation.installationId + '</td><td><a class="installation" id="' + installation.installationId + '" href="#"> ' + installation.bezeichnung + '</a></td><td>' + '<button class="btnInstallationEdit" id="' + installation.installationId + '">edit</button>' + '</td><td>' + '<button class="btnInstallationLoeschen" id="' + installation.installationId + '">löschen</button>' + '</td></tr>');
            this.$projectstable.append($tr);
        }
        this.$projectstable.append('<tr><td><button class="btn btn-primary" id="addInstallation">add</button></td></tr>');
        this.initInstallationEvent(raumId);
    };

    projectsView.prototype.initInstallationEvent = function (raumId) {

        let self = this;

        $('a.installation').click(function () {
            installationId = $(this).attr('id');
            alert("START Installation: " + installationId);
        });

        $('#addInstallation').click(function () {
            document.getElementById("modal").style.display = "block";
            $('#modalForm').append('<h4>Installation erstellen:</h4><div class="input-group mb-3"><input id="installationId" type="text" class="form-control" placeholder="Id"></div><div class="input-group mb-3"><input id="installationBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"></div><div class="input-group mb-3"><input id="installationRelaisId" type="text" class="form-control" placeholder="Relais"></div><button type="button" class="btn btn-secondary" id="btnCreateInstallation">Erstellen</button>');
            $('#btnCreateInstallation').on('click', function () {
                self.createInstallation(raumId);
            });
        });

        $('button.btnInstallationEdit').click(function () {
            installationId = $(this).attr('id');

            document.getElementById("modal").style.display = "block";
            $('#modalForm').append('<h4>Installation ' + installationId + ' bearbeiten:</h4><div class="input-group mb-3"><input id="installationBezeichnung" type="text" class="form-control" placeholder="Bezeichnung"><div class="input-group mb-3"><input id="installationRelaisId" type="text" class="form-control" placeholder="Relais"></div></div><button type="button" class="btn btn-secondary" id="btnUpdateInstallation">Bearbeiten</button>');
            $('#btnUpdateInstallation').on('click', function () {
                self.updateInstallation(installationId);

            });
        });

        $('button.btnInstallationLoeschen').click(function () {
            installationId = $(this).attr('id');
            self.deleteInstallation(installationId);
        });
    };

    projectsView.prototype.createInstallation = function (raumId) {

        let installationId = document.getElementById("installationId").value;
        let bezeichnung = document.getElementById("installationBezeichnung").value;
        let installationRelaisId = document.getElementById("installationRelaisId").value;
        

        $.ajax({
            url: "api/?action=create-Installation",
            type: "POST",
            data: {"installationId": installationId,
                "bezeichnung": bezeichnung,
                "installationRelaisId": installationRelaisId,
                "raumId": raumId
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }
        });
    };

    projectsView.prototype.updateInstallation = function (installationId) {

        let bezeichnung = document.getElementById("installationBezeichnung").value;
        let installationRelaisId = document.getElementById("installationRelaisId").value;

        $.ajax({
            url: "api/?action=update-installation",
            type: "POST",
            data: {"installationId": installationId,
                "bezeichnung": bezeichnung,
                "installationRelaisId": installationRelaisId
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }

        });
    };

    projectsView.prototype.deleteInstallation = function (installationId) {

        let id = installationId;

        $.ajax({
            url: "api/?action=delete-installation",
            type: "POST",
            data: {"installationId": id
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }

        });
    };

    projectsView.prototype.getSicherung = function (fiId) {

        let self = this;


        $.ajax({
            url: "api/?action=get-sicherung&fiId=" + fiId,
            type: "GET",

            success: function (response) {
                self.fillSicherungTable(response, fiId);
            },

            error: function (error) {
                console.log(error);
            }
        });
    };

    projectsView.prototype.fillSicherungTable = function (response, fiId) {
        this.$projectstable.find('tbody').empty();

        for (let i in response.sicherung) {
            let sicherung = response.sicherung[i];

            let $tr = $('<tr><td>' + sicherung.sicherungId + '</td><td><a class="sicherung" id="' + sicherung.sicherungId + '" href="#"> ' + sicherung.hersteller + '</a></td><td>' + '<button class="btnSicherungEdit" id="' + sicherung.sicherungId + '">edit</button>' + '</td><td>' + '<button class="btnSicherungLoeschen" id="' + sicherung.sicherungId + '">löschen</button>' + '</td><td>' + '<button class="btnSicherungDetails" id="' + i + '">Details</button>' + '</td></tr>');
            this.$projectstable.append($tr);
        }
        this.$projectstable.append('<tr><td><button class="btn btn-primary" id="addSicherung">add</button></td></tr>');
        this.initSicherungEvent(response, fiId);
    };

    projectsView.prototype.initSicherungEvent = function (response) {

        let self = this;

        $('a.sicherung').click(function () {
            sicherungId = $(this).attr('id');
            self.getRelais(sicherungId);
        });

        $('button.btnSicherungDetails').click(function () {
            id = $(this).attr('id');
            document.getElementById("modal").style.display = "block";
            $('#modalForm').append('<div><h4>Hersteller: </h4><a>' + response.sicherung[id].hersteller + '</a><h4>Auslösestrom: </h4><a>' + response.sicherung[id].ausloesestrom + '</a><h4>Spannung: </h4><a>' + response.sicherung[id].spannung + ' V</a><h4>Pole: </h4><a>' + response.sicherung[id].pole + '</a></div>');
        });

        $('#addSicherung').click(function () {
            document.getElementById("modal").style.display = "block";
            $('#modalForm').append('<h4>Sicherung erstellen:</h4><div class="input-group mb-3"><input id="sicherungId" type="text" class="form-control" placeholder="Id"></div><div class="input-group mb-3"><input id="sicherungHersteller" type="text" class="form-control" placeholder="Hersteller"></div><div class="input-group mb-3"><div class="input-group mb-3"><input id="sicherungAuslösestrom" type="text" class="form-control" placeholder="Auslösestrom"><input id="sicherungSpannung" type="text" class="form-control" placeholder="Spannung"><div class="input-group mb-3"><input id="sicherungPole" type="text" class="form-control" placeholder="Pole"></div><button type="button" class="btn btn-secondary" id="btnCreateSicherung">Erstellen</button>');
            $('#btnCreateSicherung').on('click', function () {
                self.createSicherung(fiId);
            });
        });

        $('button.btnSicherungEdit').click(function () {
            sicherungId = $(this).attr('id');
            document.getElementById("modal").style.display = "block";
            $('#modalForm').append('<h4>Sicherung ' + sicherungId + ' bearbeiten:</h4><div class="input-group mb-3"><input id="sicherungHersteller" type="text" class="form-control" placeholder="Hersteller"></div><div class="input-group mb-3"><input id="sicherungAuslösestrom" type="text" class="form-control" placeholder="Auslösestrom"></div><div class="input-group mb-3"><input id="sicherungSpannung" type="text" class="form-control" placeholder="Spannung"><div class="input-group mb-3"><input id="sicherungPole" type="text" class="form-control" placeholder="Pole"><div class="input-group mb-3"></div><button type="button" class="btn btn-secondary" id="btnUpdateSicherung">Bearbeiten</button>');
            $('#btnUpdateSicherung').on('click', function () {
                self.updateSicherung(sicherungId);

            });
        });

        $('button.btnSicherungLoeschen').click(function () {
            sicherungId = $(this).attr('id');
            self.deleteSicherung(sicherungId);
        });
    };

    projectsView.prototype.createSicherung = function (fId) {

        let sicherungId = document.getElementById("sicherungId").value;
        let hersteller = document.getElementById("sicherungHersteller").value;
        let ausloesestrom = document.getElementById("sicherungAuslösestrom").value;
        let spannung = document.getElementById("sicherungSpannung").value;
        let pole = document.getElementById("sicherungPole").value;
        let fiId = fId;

        $.ajax({
            url: "api/?action=create-sicherung",
            type: "POST",
            data: {"sicherungId": sicherungId,
                "hersteller": hersteller,
                "ausloesestrom": ausloesestrom,
                "spannung": spannung,
                "pole": pole,
                "fiId": fiId
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }
        });
    };

    projectsView.prototype.updateSicherung = function (sicherungId) {

        let id = sicherungId;
        let hersteller = document.getElementById("sicherungHersteller").value;
        let ausloesestrom = document.getElementById("sicherungAuslösestrom").value;
        let spannung = document.getElementById("sicherungSpannung").value;
        let pole = document.getElementById("sicherungPole").value;

        $.ajax({
            url: "api/?action=update-sicherung",
            type: "POST",
            data: {"sicherungId": id,
                "hersteller": hersteller,
                "ausloesestrom": ausloesestrom,
                "spannung": spannung,
                "pole": pole
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }

        });
    };

    projectsView.prototype.deleteSicherung = function (sicherungId) {

        let id = sicherungId;

        $.ajax({
            url: "api/?action=delete-sicherung",
            type: "POST",
            data: {"sicherungId": id
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }

        });
    };

    projectsView.prototype.getRelais = function (sicherungId) {

        let self = this;


        $.ajax({
            url: "api/?action=get-relais&sicherungId=" + sicherungId,
            type: "GET",

            success: function (response) {
                self.fillRelaisTable(response, sicherungId);
            },

            error: function (error) {
                console.log(error);
            }
        });
    };

    projectsView.prototype.fillRelaisTable = function (response, sicherungId) {
        this.$projectstable.find('tbody').empty();

        for (let i in response.relais) {
            let relais = response.relais[i];

            let $tr = $('<tr><td>' + relais.relaisId + '</td><td><a class="relais" id="' + relais.relaisId + '" href="#">Relais ' + relais.relaisId + '</a></td><td>' + '<button class="btnRelaisEdit" id="' + relais.relaisId + '">edit</button>' + '</td><td>' + '<button class="btnRelaisLoeschen" id="' + relais.relaisId + '">löschen</button>' + '</td></tr>');
            this.$projectstable.append($tr);
        }
        this.$projectstable.append('<tr><td><button class="btn btn-primary" id="addRelais">add</button></td></tr>');
        this.initRelaisEvent(sicherungId);
    };

    projectsView.prototype.initRelaisEvent = function (sicherungId) {

        let self = this;

        $('a.relais').click(function () {
            relaisId = $(this).attr('id');
            self.getRelaisInstallation(relaisId);
        });

        $('#addRelais').click(function () {
            document.getElementById("modal").style.display = "block";
            $('#modalForm').append('<h4>Relais erstellen:</h4><div class="input-group mb-3"><input id="relaisId" type="text" class="form-control" placeholder="Id"></div><button type="button" class="btn btn-secondary" id="btnCreateRelais">Erstellen</button>');
            $('#btnCreateRelais').on('click', function () {
                self.createRelais(sicherungId);
            });
        });

        $('button.btnRelaisEdit').click(function () {
           relaisId = $(this).attr('id');
            document.getElementById("modal").style.display = "block";
            $('#modalForm').append('<h4>Relais ' + relaisId + ' bearbeiten:</h4><div class="input-group mb-3"><input id="relaisIdNew" type="text" class="form-control" placeholder="Id"></div><button type="button" class="btn btn-secondary" id="btnRelaisEdit">Bearbeiten</button>');
            $('#btnRelaisEdit').on('click', function () {
                self.updateRelais(relaisId);

            });
        });

        $('button.btnRelaisLoeschen').click(function () {
           relaisId = $(this).attr('id');
            self.deleteRelais(relaisId);
        });
    };

    projectsView.prototype.createRelais = function (sichId) {

        let relaisId = document.getElementById("relaisId").value;
        let sicherungId = sichId;

        $.ajax({
            url: "api/?action=create-relais",
            type: "POST",
            data: {"relaisId": relaisId,
                "sicherungId": sicherungId
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }
        });
    };

    projectsView.prototype.updateRelais = function (relaisId) {

        let id = relaisId;
        let idNew = document.getElementById("relaisIdNew").value;
        
        console.log(idNew);

        $.ajax({
            url: "api/?action=update-relais",
            type: "POST",
            data: {"relaisId": id,
                "relaisIdNew": idNew
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }

        });
    };

    projectsView.prototype.deleteRelais = function (relaisId) {

        let id = relaisId;

        $.ajax({
            url: "api/?action=delete-relais",
            type: "POST",
            data: {"relaisId": id
            },

            success: function (response) {
                alert(response);
            },

            error: function (error) {
                console.log(error);
            }

        });
    };

    projectsView.prototype.getRelaisInstallation = function (relaisId) {

        let self = this;

        $.ajax({
            url: "api/?action=get-relaisinstall&relaisId=" + relaisId,
            type: "GET",

            success: function (response) {
                self.fillInstallationTable(response);
            },

            error: function (error) {
                console.log(error);
            }
        });
    };
