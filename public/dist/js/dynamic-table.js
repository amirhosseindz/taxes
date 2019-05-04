$(function () {
    $('table.dataTable, table[id^=sample_]').dataTable();
    $('table.table .group-checkable').livequery(function () {
        $(this).change(function () {
            var set = $(this).attr("data-set");
            var checked = $(this).is(":checked");
            $(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                } else {
                    $(this).removeAttr("checked");
                }
            });
            // $.uniform.update(set);
        });
    });
    $('table.table .group-checkable').livequery(function () {
        $(this).click(function (e) {
            e.stopPropagation();
        });
    });
    $('.dataTables_wrapper .dataTables_filter input').livequery(function () {
        $(this).addClass("form-control");
    }); // modify table search input
    $('.dataTables_wrapper .dataTables_length select').livequery(function () {
        $(this).addClass("form-control");
    }); // modify table per page dropdown
});
