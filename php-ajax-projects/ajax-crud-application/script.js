
$(document).ready(function () {

    function loadTableData(page) {
        let dataObject = { page_no: page };

        $.ajax({
            type: "POST",
            url: "ajax-numeric-pagination.php",
            dataType: "html",
            data: dataObject,
            success: insertTableHTML
        });
    }

    loadTableData();

    function insertTableHTML(response) {
        if (response != "") {
            $("#table").html(response).removeClass("custom-border-bottom");
        }
        else {
            $("#table").html(`<p style="font-size: xx-large; text-align: center; margin-bottom: 30px; font-weight: bolder;">Noting to Show Here. No Record is Found</p>`).addClas("custom-border-bottom");
        }
    }

    $("#insert-data").on("click", function (event) {
        event.preventDefault();

        if (!$("#name").val())
            return false;

        else if (!$("#phone").val())
            return false;

        else if (!$("#address").val())
            return false;

        let dataObject = {
            name: $("#name").val(),
            phone: $("#phone").val(),
            address: $("#address").val()
        };

        $.ajax({
            type: "POST",
            url: "ajax-insert.php",
            data: dataObject,
            success: insertData
        });

        function insertData(response) {
            (response) ? loadTableData() : alert("Record Cannot Inserted Successfully. Some Error Occured");
        }

        $('#form').trigger("reset");
    })

    $(document).on("click", ".delete-btn", function () {
        let id = $(this).data("id");
        let dataObject = { studentId: id };

        $.ajax({
            type: "POST",
            url: "ajax-delete.php",
            data: dataObject,
            success: function (response) {
                (response) ? loadTableData() : alert("Record Cannot Deleted Successfully. Some Error Occured");
            }
        });
    });

    $(document).on("click", ".edit-btn", function () {
        let id = $(this).data("id");
        let dataObject = { studentId: id };

        $.ajax({
            type: "POST",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            url: "ajax-form-load.php",
            data: dataObject,
            dataType: "html",
            success: insertFormHTML
        });

        function insertFormHTML(response) {
            if (response != "") {
                $(".modal-body").html(response);
            }
            else {
                $(".modal-body").html(`<p style="font-size: xx-large; text-align: center; margin-bottom: 30px;">Noting to Show Here. Some Error Occured</p>`);
            }
        }
    });

    $(document).on("click", "#update-btn", function (event) {
        event.preventDefault();

        if (!$("#updateName").val())
            return false;

        else if (!$("#updatePhone").val())
            return false;

        else if (!$("#updateAddress").val())
            return false;

        let dataObject = {
            id: $("#updateId").val(),
            name: $("#updateName").val(),
            phone: $("#updatePhone").val(),
            address: $("#updateAddress").val()
        };

        $.ajax({
            type: "POST",
            url: "ajax-update.php",
            data: dataObject,
            dataType: "json",
            success: function (response) {
                if (response) {
                    loadTableData();
                    $('#updateModal').modal('hide');
                }
                else
                    alert("Record Cannot Updated Successfully. Some Error Occured");
            }
        });
    });

    $("#search").on("keyup", function () {
        let searchTerm = $(this).val();
        let dataObject = {search: searchTerm};

        $.ajax({
            type: "POST",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",  // Datatype of Sending Data
            dataType: "html",   // Datatype of Receiving Data From Server
            url: "ajax-search.php",
            data: dataObject,
            success: insertTableHTML
        });
    })

    $(document).on("click", ".pagination span", function () {
        let page = $(this).attr("id");
        loadTableData(page);
    })
});

