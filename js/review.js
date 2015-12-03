(function(ms){
    ms.review = {};
    ms.review.reviewGrid = jQuery('#reviewGrid');
    ms.review.reviewGrid.header = jQuery('#reviewGridHeader');
    ms.review.reviewGrid.body = jQuery('#reviewGridBody');
    ms.review.reviewGrid.footer = jQuery('#reviewGrid');
    ms.review.backBtn = jQuery('#backBtn');
    ms.review.forwardBtn = jQuery('#forwardBtn');
    ms.review.backBtn2 = jQuery('#backBtn2');
    ms.review.forwardBtn2 = jQuery('#forwardBtn2');

    ms.review.reviewGrid.pages = {
            offset:0,//last record served
            totalRows: 0,
            pageUp: function(){
                if (ms.review.reviewGrid.pages.offset < ms.review.reviewGrid.pages.totalRows) {
                    var start = ms.review.reviewGrid.pages.offset;
                    ms.review.reviewGrid.getEntries({start: start, limit: ms.config.paging, operation: 'forward'});
                }
                else {
                    //show error modal
                }
            },
            pageDown: function(){
                if (ms.review.reviewGrid.pages.offset > ms.config.paging) {
                    var start = ms.review.reviewGrid.pages.offset - (ms.config.paging * 2);
                    if (start < 0) {
                        start = 0;
                    }
                    ms.review.reviewGrid.getEntries({start: start, limit: ms.config.paging, operation: 'backward'});
                }
                else {
                    //show error modal
                }
            }
    };
    ms.review.reviewGrid.getEntries = function(params) {
        ms.modal.toggleWaiting();

        var getEntriesComplete = function(){

        };

        var getEntriesFail = function(){

        };

        var createTableRows = function(data, tableBody) {
            var rows = '';

            var makeRow = function(cell, row) {
                var rowHtml = '';

                switch (cell) {
                case 'email':
                    rowHtml = '<td>' + row[cell] + '</td>';
                    break;
                case 'note':
                    break;
                case 'subscribed':
                    if (parseFloat(row[cell]) === 1) {
                        rowHtml = '<td class="hidden-xs">yes</td>';
                    } else {
                        rowHtml = '<td class="hidden-xs">no</td>';
                    }
                    break;
                default:
                    rowHtml = '<td class="hidden-xs">' + row[cell] + '</td>';
                    break;
                }
                return rowHtml;
            };

            jQuery.each(data, function(index, row) {
                rows += '<tr>';
                for ( var cell in row) {
                    rows += makeRow(cell, row);
                }
                rows += '</tr>';
            });

            tableBody.html(rows);
        };

        var createTableHeader = function(dataRow, tableHeader) {
            var header = '<tr>';
            var colName = null;
            for (colName in dataRow) {
                switch (colName) {
                case 'email':
                    header += '<td><strong>' + colName.capitalize()
                            + '</strong></td>';
                    break;
                case 'note':
                    break;
                default:
                    var headerText = colName.replace('_', ' ');
                    var headerTextCaps = headerText.capitalize();

                    if (headerText != colName) {
                        headerTextCaps = '';
                        headerText = colName.split('_');
                        var i = null;
                        for (i = 0; i < headerText.length; i++) {
                            headerTextCaps += headerText[i].capitalize();
                            if (i < (headerText.length - 1)) {
                                headerTextCaps += ' ';
                            }
                        }

                    }
                    header += '<td class="hidden-xs"><strong>' + headerTextCaps
                            + '</strong></td>';
                }
            }
            header += '</tr>';
            tableHeader.html(header);
        };

        var getEntriesSuccess = function(data, status, request) {
            ms.review.reviewGrid.pages.totalRows = parseFloat(data.meta.total_rows);
            if (params.operation === 'forward') {
                ms.review.reviewGrid.pages.offset += ms.config.paging;
            }
            else {
                ms.review.reviewGrid.pages.offset -= ms.config.paging;
                if (ms.review.reviewGrid.pages.offset < ms.config.paging) {
                    ms.review.reviewGrid.pages.offset = ms.config.paging;
                }
            }
            createTableHeader(data.data[0], ms.review.reviewGrid.header);
            createTableRows(data.data, ms.review.reviewGrid.body);
            setTimeout(function(){
                ms.modal.modal('hide');
            }, 100);

        };

        jQuery.ajax({
            data : params,
            dataType : 'json',
            complete : getEntriesComplete,
            error : getEntriesFail,
            success : getEntriesSuccess,
            type : 'POST',
            url : 'core/entries-service.php'
        });
    };

    ms.review.forwardBtn.click(function(e){
        ms.review.reviewGrid.pages.pageUp();
        e.preventDefault();
    });

    ms.review.backBtn.click(function(e){
        ms.review.reviewGrid.pages.pageDown();
        e.preventDefault();
    });

    ms.review.forwardBtn2.click(function(e){
        ms.review.reviewGrid.pages.pageUp();
        e.preventDefault();
    });

    ms.review.backBtn2.click(function(e){
        ms.review.reviewGrid.pages.pageDown();
        e.preventDefault();
    });

    ms.review.reviewGrid.getEntries({start: 0, limit: ms.config.paging, operation: 'forward'});
})(mantisScribe);