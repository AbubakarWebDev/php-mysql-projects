$(document).ready(function () {

    // Function to Read All Records On Database
    function readData() {
        $.ajax({
            type: "GET",
            url: "rest-fetch-all.php",
            success: function (response) {
                if (response.status == false) {
                    $(".table-responsive").html(`<p style="font-size: xx-large; text-align: center; margin-bottom: 30px; font-weight: bolder;" class="border-dark border-bottom pb-4">Noting to Show Here. No Record is Found</p>`);
                }
                else {
                    let html = `
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Select</th>
                                <th>Sr.</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">`;

                    $.each(response, function (key, value) {
                        html +=
                            `<tr>
                            <td>
                                <input class="form-control" value='${value.ID}' type="checkbox">
                            </td>
                            <td>${key + 1}</td>
                            <td>${value.name}</td>
                            <td>${value.phone}</td>
                            <td>${value.address}</td>
                            <td>
                                <button data-id="${value.ID}" type="button" data-toggle="modal" data-target="#crudModal" class="edit-btn font-weight-bolder w-100 btn btn-dark">Edit</button>
                            </td>
                            <td>
                                <button data-id="${value.ID}" type="button" data-toggle="modal" data-target="#crudModal" class="delete-btn font-weight-bolder w-100 btn btn-dark">Delete</button>
                            </td>
                        </tr>`;
                    });
                    html += `<tr>
                                <td colspan="8"><button id='delete-multiple-btn' type="button" class="font-weight-bolder w-100 btn btn-lg btn-dark">Delete Selected</button></td>
                            </tr>
                        </tbody>
                    </table>`;
                    $(".table-responsive").html(html);
                }
            }
        });
    }

    // Function to Insert Single Records On Database
    function insertData(name, phone, address) {

        let dataObject = {
            name: name,
            phone: phone,
            address: address
        };

        dataObject = JSON.stringify(dataObject);

        $.ajax({
            type: "POST",
            url: "rest-insert-single.php",
            contentType: "application/json",    // Datatype of Sending Data
            dataType: "json",   // Datatype of Receiving Data
            data: dataObject,
            success: function (response) {
                if (response.status == false) {
                    $('#message').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong> Your Records is Not Inserted. ${response.message} Please Try Again.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }
                else {
                    readData();
                }
            }
        })
    }

    // Function to Update Single Records On Database
    function updateData(id, name, phone, address) {
        let dataObject = {
            id: id,
            name: name,
            phone: phone,
            address: address
        }

        dataObject = JSON.stringify(dataObject);

        $.ajax({
            type: "PUT",
            url: "rest-update-single.php",
            data: dataObject,
            dataType: "json",
            contentType: "application/json",
            success: function (response) {
                if (response.status == false) {
                    $('#message').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong> Your Records is Not Updated. ${response.message} Please Try Again.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                    $('#crudModal').modal('hide');
                }
                else {
                    readData();
                    $('#crudModal').modal('hide');
                }
            }
        });
    }

    // Function to Delete Single Records On Database
    function deleteData(id) {
        let dataObject = { id: id };
        dataObject = JSON.stringify(dataObject);

        $.ajax({
            type: "DELETE",
            contentType: "application/json",
            dataType: "json",
            url: "rest-delete-single.php",
            data: dataObject,
            success: function (response) {
                if (response.status == false) {
                    $('#message').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error! </strong> Your Record is Not Deleted. ${response.message} Please Try Again.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`);
                    $('#crudModal').modal('hide');
                }
                else {
                    readData();
                    $('#crudModal').modal('hide');
                }
            }
        });
    }

    // Function to Delete Multiple Records On Database
    function deleteMultipleRecords(dataObject) {
        $.ajax({
            type: "DELETE",
            contentType: "application/json",
            dataType: "json",
            url: "rest-delete-multiple.php",
            data: dataObject,
            success: function (response) {
                if (response.status == false) {
                    $('#message').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error! </strong> Your Record is Not Deleted. ${response.message} Please Try Again.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`);
                    $('#crudModal').modal('hide');
                }
                else {
                    readData();
                    $('#crudModal').modal('hide');
                }
            }
        })
    }

    // Function to Search Multiple Records On Database w.r.t name
    function searchRecords(searchTerm) {
        $.ajax({
            type: "GET",
            dataType: "json",   // Datatype of Receiving Data From Server
            url: `rest-search.php?search=${searchTerm}`,
            success: function (response) {
                if (response.status == false) {
                    $(".table-responsive").html(`<p style="font-size: xx-large; text-align: center; margin-bottom: 30px; font-weight: bolder;" class="border-dark border-bottom pb-4">Noting to Show Here. No Record is Found</p>`);
                }
                else {
                    let html = `
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Select</th>
                                <th>Sr.</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">`;

                    $.each(response, function (key, value) {
                        html +=
                            `<tr>
                            <td>
                                <input class="form-control" value='${value.ID}' type="checkbox">
                            </td>
                            <td>${key + 1}</td>
                            <td>${value.name}</td>
                            <td>${value.phone}</td>
                            <td>${value.address}</td>
                            <td>
                                <button data-id="${value.ID}" type="button" data-toggle="modal" data-target="#crudModal" class="edit-btn font-weight-bolder w-100 btn btn-dark">Edit</button>
                            </td>
                            <td>
                                <button data-id="${value.ID}" type="button" data-toggle="modal" data-target="#crudModal" class="delete-btn font-weight-bolder w-100 btn btn-dark">Delete</button>
                            </td>
                        </tr>`;
                    });
                    html += `<tr>
                                <td colspan="8"><button id='delete-multiple-btn' type="button" class="font-weight-bolder w-100 btn btn-lg btn-dark">Delete Selected</button></td>
                            </tr>
                        </tbody>
                    </table>`;
                    $(".table-responsive").html(html);
                }
            }
        });
    }

    // Add Event on Button For Inserting Data on database using insertData function
    $("#insert-data").on("click", function (event) {
        event.preventDefault();

        if (!$("#name").val())
            return false;

        else if (!$("#phone").val())
            return false;

        else if (!$("#address").val())
            return false;

        insertData($("#name").val(), $("#phone").val(), $("#address").val());

        $("#form").trigger("reset");
    });

    // Add Event on Button For Inserting HTML Form on Popup
    $(document).on("click", ".edit-btn", function (event) {
        event.preventDefault();
        let id = $(this).data("id");
        let dataObject = { id: id };
        dataObject = JSON.stringify(dataObject);

        $.ajax({
            type: "POST",
            url: "rest-fetch-single.php",
            data: dataObject,
            dataType: "json",
            contentType: "application/json",
            success: function (response) {
                if (response.status == false) {
                    $('#message').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong> Your Records is Not Updated. ${response.message} Please Try Again.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }
                else {
                    $("#modal-body").html(`
                    <input id="updateId" type="hidden" value="${response[0].ID}">

                    <div class="form-group">
                        <label for="updateName">Name</label>
                        <input type="text" class="form-control" id="updateName" placeholder="Enter Name" required value="${response[0].name}">
                    </div>
                    <div class="form-group">
                        <label for="updatePhone">Phone</label>
                        <input type="text" class="form-control" id="updatePhone" placeholder="Enter Phone" required value="${response[0].phone}">
                    </div>
                    <div class="form-group">
                        <label for="updateAddress">Address</label>
                        <input type="text" class="form-control" id="updateAddress" placeholder="Enter Address" required value="${response[0].address}">
                    </div>`);

                    $("#modal-submit-btn").html("Update Data");
                }
            }
        });
    });

    // Add Event on Button For Inserting HTML For Confirmation delete Button On Popup
    $(document).on("click", ".delete-btn", function () {
        let id = $(this).data("id");
        $("#modal-body").html("Are You Sure You Want To Delete this Record!");
        $("#modal-submit-btn").html("Yes");
        $("#modal-submit-btn").attr("data-multiple", "false");
        $("#modal-submit-btn").attr("data-id", `${id}`);
        $("#modal-close-btn").html("No");
        $("#crudModalLabel").html("Delete Your Data");
    });

    // Add Event on Button For Inserting HTML For Confirmation multiple delete Button On Popup
    $(document).on("click", "#delete-multiple-btn", function () {
        if ($("input[type='checkbox']:checked").length != 0) {
            let id = [];
            $.each($("input[type='checkbox']:checked"), function () {
                id.push({ id: $(this).val() });
            });
            id = JSON.stringify(id);

            $("#modal-body").html("Are You Sure You Want To Delete All these Record!");
            $("#modal-submit-btn").html("Yes");
            $("#modal-submit-btn").attr("data-id", `${id}`);
            $("#modal-submit-btn").attr("data-multiple", "true");
            $("#modal-close-btn").html("No");
            $("#crudModalLabel").html("Delete Multiple Data");
            $('#crudModal').modal('show');
        }
    });

    // Add Event on Button For Updating Data, Deleting Single and Multiple Data on database using updateData, deleteData and deleteMultipleRecords function
    $(document).on("click", "#modal-submit-btn", function (event) {
        event.preventDefault();

        if ($(this).html() == "Yes" && $(this).attr("data-multiple") == "false") {
            deleteData($(this).attr("data-id"));
        }
        else if ($(this).html() == "Yes" && $(this).attr("data-multiple") == "true") {
            deleteMultipleRecords($(this).attr("data-id"));
        }
        else if ($(this).html() == "Update Data") {
            if (!$("#updateName").val())
                return false;

            else if (!$("#updatePhone").val())
                return false;

            else if (!$("#updateAddress").val())
                return false;

            updateData($("#updateId").val(), $("#updateName").val(), $("#updatePhone").val(), $("#updateAddress").val());
        }
    });

    // Add Event on Button For Searching Data on database using searchData function
    $("#search").on("keyup", function (event) {
        event.preventDefault();
        let searchTerm = $(this).val();
        searchRecords(searchTerm);
    })

    readData();
});