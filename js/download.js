(function(ms){
    ms.download = {};
    ms.download.csvbox = jQuery('#csvbox');
    ms.download.fetchBtn = jQuery('#fetchBtn');
    ms.download.csvbox.hide();

    ms.download.fetchSubscribers = function(params){
        
        if(!params) {
            params = {};
        }

        var downloadCompleteCB = function(){
            
        };

        var downloadFailCB = function(){
            
        };

        var downloadSuccessCB = function(data, status, request){
            ms.modal.body.html('Fetching data...');
            
            var subscribers = data.data;
            if (subscribers.length > 0) {
                var csv = '';
                //make header
                for(col in subscribers[0]) {
                    csv += col + ',';
                }
                csv = csv.substr(0, (csv.length - 1));
                csv += '\r\n';
                for(var i = 0; i < subscribers.length; i++){
                    var line = '';
                    for(col2 in subscribers[i]) {
                        line += subscribers[i][col2] + ',';
                    }
                    line = line.substr(0, (line.length - 1));
                    line += '\r\n';
                    csv += line;
                }
                csv = csv.trim();
                
                ms.download.csvbox.html(csv);
                ms.download.csvbox.show();
            }
        };

        jQuery.ajax({
            data: params,
            dataType: 'json',
            complete: downloadCompleteCB,
            error: downloadFailCB,
            success: downloadSuccessCB,
            type: 'GET',
            url: 'core/download-service.php'
        });
    };

    ms.download.fetchBtn.click(function(e){
        ms.download.fetchSubscribers({format: 'json'});
        e.preventDefault();
    });
})(mantisScribe);