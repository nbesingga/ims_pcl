$(document).ready(function () {
    $(".select").select2();
    $('#show-withdrawal-list tbody').on('click', 'tr', function (e) {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected')
        }
        else{
            $(this).addClass('selected');
        }
    });
});

$(document).on('click', '.create-dispatch', function (e) {
    e.preventDefault();
    $('#preloading').modal('show');
    setTimeout(function () {
        window.location = BASEURL+'dispatch/create';
    }, 300);
});

function addRow(val = "") {
    var newRow = `<tr>
        <td>
            <select class="form-select select2" required="required" id="truck_type" name="truck_type[]">
                <option value="">Select Truck Type</option>
            </select>
            <span class="text-danger error-msg truck_type_error"></span>
        </td>
        <td>
            <input type="text" class="form-control numeric" id="no_of_package"
                name="no_of_package[]" placeholder="Enter Quantity">
        </td>
        <td>
            <input type="text" class="form-control" id="plate_no"
                name="plate_no[]" placeholder="Enter Plate No.">
        </td>
        <td>
            <input type="text" class="form-control" id="driver"
                name="driver[]" placeholder="Enter Driver">
        </td>
        <td>
            <input type="text" class="form-control" id="contact"
                name="contact[]" placeholder="Enter Contact">
        </td>
        <td>
            <div class="text-center">
                <button type="button" class="remove-row btn btn-icon btn-danger remove-truck mx-2 waves-effect waves-light">
                    <i class="ri-delete-bin-5-fill"></i>
                </button>
            </div>
        </td>
    </tr>`;
    $("#truck-list tbody").append(newRow);
  }

  function removeRow() {
    $(this).closest("tr").remove();
  }

  $("#add-row").on("click", function () {
    addRow();
  });

  $(document).on("click", ".remove-row", function () {
    removeRow.call(this);
  });

$(document).on('click', '#find-withdrawal', function() {
    $('#show-withdrawal').modal('show');
    if ($.fn.DataTable.isDataTable("#show-withdrawal-list")) {
        $('#show-withdrawal-list').DataTable().clear().destroy();
    }
    withdrawal();
});

$(document).on('click', '#search-withdrawal', function() {
    if ($.fn.DataTable.isDataTable("#show-withdrawal-list")) {
        $('#show-withdrawal-list').DataTable().clear().destroy();
    }
    withdrawal();
});

function withdrawal(){
    var keyword = $("#keyword").val();
    var wd_list = document.querySelectorAll('input[name="wd_no[]"]');
    var wd_no = [];
    wd_list.forEach(input => {
        wd_no.push(input.value);
    });

    new DataTable("#show-withdrawal-list",{
        order: [[1, 'asc'],[4,'asc']],
        paging: true,
        columnDefs : [
            { targets: [4], className: 'dt-body-right' },
        ],
        ajax: {
            url : BASEURL+"settings/withdrawal_list",
            data : {
                keyword : keyword,
                status : "posted",
                wd_no : JSON.stringify(wd_no),
            },
            dataSrc:""
        },
        columns: [
            { data: 'id',  visible: false },
            { data: 'wd_no' },
            { data: 'client_name' },
            { data: 'deliver_to' },
            { data: 'no_of_package' , render: $.fn.dataTable.render.number( ',', '.', 2), class : 'text-center'},
            { data: 'order_no' },
            { data: 'order_date' },
            { data: 'dr_no' },
            { data: 'po_num' },
            { data: 'sales_invoice' },
        ],
    });
}

$(document).on("click", ".remove-withdrawal", function () {
    removeWithdrawal.call(this);
});

function removeWithdrawal() {
    $(this).closest("tr").remove();
    toastr.error('Withdrawal removed');
}

$(document).on('click', '#add-withdrawal', function() {
    var table = $('#show-withdrawal-list').DataTable();
    var data = ( table.rows('.selected').data());

    if(data.length > 0) {
        var total = 0;
        for(x=0; x<data.length; x++) {
            total += +data[x].no_of_package;
            var rowCount = $('#withdrawal-list tr').length;
            var idx = rowCount - 3;
            var btn = '<div class="text-center text-align-justify">';
            btn += '<button type="button" class="btn btn-danger mx-2 btn-icon waves-effect waves-light remove-withdrawal" data-id="'+(rowCount-1)+'"><i class="ri-delete-bin-5-fill"></i></button>';
            btn += '</div>'

            $('#withdrawal-list tbody').append('<tr id="rows_'+(rowCount-1)+'"> \
            <td class="text-start"> \
                <input type="hidden" name="wd_no[]" value="'+data[x].wd_no+'" /> \
            '+(rowCount-1)+' </td> \
            <td class="text-start  fs-14"> \
                '+data[x].wd_no+'\
            </td> \
            <td class="text-center ps-1 fs-13"> \
                '+ data[x].client_name +' \
            </td> \
            <td class="text-start fs-14"> \
                '+ data[x].deliver_to +' \
            </td> \
            <td class="text-center  fs-14"> \
                '+data[x].no_of_package+'\
            </td> \
            <td class="text-start  fs-14"> \
                '+data[x].order_no+'\
            </td> \
            <td class="text-start  fs-14"> \
                '+data[x].order_date+'\
            </td> \
            <td class="text-start  fs-14"> \
                '+data[x].dr_no+'\
            </td> \
            <td class="text-start  fs-14"> \
                '+data[x].po_num+'\
            </td> \
            <td class="text-start  fs-14"> \
                '+data[x].sales_invoice+'\
            </td> \
            <td>'+btn+'</td> \
            </tr>');
            toastr.success(data[x].wd_no + ' successfully added');
        }

        $("#total").text(total.toFixed(2));
    }

    $('#show-withdrawal-list tbody tr').removeClass('selected')
    $('#show-withdrawal').modal('hide');
});
