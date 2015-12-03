(function(ms){
    ms.login = {};
    ms.login.loginForm = jQuery('#loginForm');

    ms.login.submitLoginForm = function(frm){
        ms.modal.toggleWaiting();
        var loginData = frm.serialize();
        
    var loginCompleteCB = function(){
            
        };

        var loginFailCB = function(){
            
        };

        var loginSuccessCB = function(data, status, request){
            ms.modal.body.html(data.message);
            ms.modal.header.show();
            ms.modal.footer.show();
        };
        
        jQuery.ajax({
            data: loginData,
            dataType: 'json',
            complete: loginCompleteCB,
            error: loginFailCB,
            success: loginSuccessCB,
            type: 'POST',
            url: 'core/auth-service.php'
        });
    };

    ms.login.submitBtn = jQuery('#loginBtn').click(function(e){
        ms.login.submitLoginForm(ms.login.loginForm);
        e.preventDefault();
    });
})(mantisScribe);