(function(ms){
    ms.setting = {};
    ms.setting.settingsForm = jQuery('#settingsForm');
    ms.setting.operation = jQuery('#operation');

    ms.setting.submitSettingsForm = function(frm){
        ms.modal.toggleWaiting();
        var settingsData = frm.serialize();

        var settingsCompleteCB = function(){
            
        };

        var settingsFailCB = function(){
            
        };

        var settingsSuccessCB = function(data, status, request){
            ms.setting.operation.val('');
            ms.modal.body.html(data.message);
            ms.modal.header.show();
            ms.modal.footer.show();
        };

        jQuery.ajax({
            data: settingsData,
            dataType: 'json',
            complete: settingsCompleteCB,
            error: settingsFailCB,
            success: settingsSuccessCB,
            type: 'POST',
            url: 'core/settings-service.php'
        });
    };

    ms.setting.submitBtn = jQuery('#applyBtn').click(function(e){
        ms.setting.operation.val('update');
        ms.setting.submitSettingsForm(ms.setting.settingsForm);
        e.preventDefault();
    });
})(mantisScribe);