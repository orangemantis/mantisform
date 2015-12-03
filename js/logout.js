(function(ms){
    ms.logout = {};
    ms.logout.logoutBtn = jQuery('#logoutBtn');

    if (ms.logout.logoutBtn.length) {
        ms.logout.logoutBtn.click(function(e){
            
            ms.modal.toggleWaiting();
            
            var logoutSuccessCallback = function(data, status, request) {
                ms.modal.body.html(data.message);
                
                ms.modal.footer.closeBtn.click(function(e){
                    window.open('index.php', '_self');
                    e.preventDefault();
                });
                
                ms.modal.header.show();
                ms.modal.footer.show();
            };

            var logoutFailCallback = function(request, status, error) {

            };

            var logoutCompleteCallback = function(request, status) {

            };

            var logoutData = {logout: 'true'};

            jQuery.ajax({
                data : logoutData,
                dataType : 'json',
                complete : logoutCompleteCallback,
                error : logoutFailCallback,
                success : logoutSuccessCallback,
                type : 'GET',
                url : 'core/auth-service.php'
            });
            
            e.preventDefault();
        });
    }
})(mantisScribe);