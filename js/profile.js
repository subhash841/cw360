

$(function () {
    // this section is used for load more history
    $('#walletnav a[data-toggle="tab"]').on('click', function (e) {
        window.localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = window.localStorage.getItem('activeTab');
    if (activeTab) {
        $('#walletnav a[href="' + activeTab + '"]').tab('show');
    } else {

        $('#walletnav a[href="#wallet"]').tab('show');
    }
    loadwallet();
    function loadwallet(offset = 0) {


        $.ajax({
            url: base_url + "Wallet/users_point_history",
            method: "POST",
            data: {offset: offset}
        }).done(function (result) {
            if (result.points_history.length > 0)
                buildHtmlTable($(".pointhistory table"), result.points_history, {ignore: true, ignoreid: ["id", "choice_id", "points", "post_id", "user_id"]}, offset > 100)

            $(".pointhistory").find(".load-btn-holder").remove();
            $(".pointhistory")
                    .append($("<div />", {class: "col-12 load-btn-holder my-4 d-none"})
                            .append($("<button />", {class: "btn btn-outline-primary readmore rounded-btn mx-auto d-block load-more-voice-list"})
                                    .html("Load more")
                                    .click(function (e) {
                                        e.preventDefault();
                                        loadwallet(offset + 100)
                                    })))
        });
    }


    function buildHtmlTable(sel, myList, btndata, append) {
        if (!append)
            sel.html('');
        myList = typeof myList == "object" ? myList : [];
        var columns = addAllColumnHeaders(myList[0], sel, btndata, append);
        if (!append)
            selector = $('<tbody>');
        else
            selector = $('tbody', sel);
        for (var i = 0; i < myList.length; i++) {

            var row$ = $('<tr/>', {'data-item': JSON.stringify(myList[i])});
            for (var colIndex = 0; colIndex < columns.length; colIndex++) {
                var cellValue = myList[i][columns[colIndex].replace(" ", "_")];
                if (cellValue == null)
                    cellValue = "";
                row$.append($('<td/>', {class: columns[colIndex].replace(" ", "_") + " bg-white text-center special-cell"}).html(cellValue));
            }
            if (btndata && btndata.modal)
            {
                row$.append($('<td/>', {class: 'actions'}).html('<button type="button" data-toggle="modal" data-target="#' + btndata.target + '" data-id="' + myList[i][btndata.uniqid] + '" class="btn btn-sm btn-primary  ' + btndata.target + '">' + btndata.btntxt + '</button>'));
            } else if (btndata && btndata.modal == false)
            {
                row$.append($('<td/>', {class: 'actions'}).html('<button type="button" data-id="' + myList[i][btndata.uniqid] + '" class="btn btn-sm btn-primary ' + btndata.target + '">' + btndata.btntxt + '</button>'));
            }
            selector.append(row$);
        }
        sel.append(selector);
    }

    function addAllColumnHeaders(myList, selector, btndata, append) {
        var columnSet = [];
        var thead = $('<thead>', {class: 'thead'});
        var headerTr = $('<tr/>');
        for (var key in myList) {
            if (btndata)
                if (btndata.ignore && $.inArray(key, btndata.ignoreid) !== -1)
                {
                    continue;
                }
            if ($.inArray(key, columnSet) == -1) {
                columnSet.push(key.replace('_', ' '));
                headerTr.append($('<th/>').html(key.replace('_', ' ')));
            }
        }

        if (btndata.action && myList)
        {
            headerTr.append($('<th/>').html('Actions'));
        }
        if (!append)
            selector.append(thead.append(headerTr));
        return columnSet;
    }
});