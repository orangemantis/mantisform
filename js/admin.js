(function(ms){
    ms.admin = {};
    ms.admin.adminForm = jQuery('#adminForm');
    ms.admin.adminForm.validate = function(){
        ms.admin.formElements = ms.admin.adminForm[0].elements;
        ms.admin.errorMessages = {
                itemCount: 0
        };
        ms.admin.passwords = [];

        jQuery.each(ms.admin.formElements, function(index, elem){

            var item = jQuery(elem);
            if (item.hasClass('required')) {
                var itemValue = item.val().trim();
                if (!itemValue) {
                    item.parent().parent().addClass('has-error');
                    ms.admin.errorMessages[elem.id] = elem.placeholder + ': This field is required.';
                    ms.admin.errorMessages.itemCount++;
                }
            }
            
            if (elem.id === 'newPassword') {
                ms.admin.passwords.push(item.val());
            }
            
            if (elem.id === 'confirmPassword') {
                ms.admin.passwords.push(item.val());
            }
            
        });
        
        if (ms.admin.passwords.length === 2) {
            if (ms.admin.passwords[0] !== ms.admin.passwords[1]) {
                ms.admin.errorMessages['newPassword'] = 'New passwords do not match.';
                ms.admin.errorMessages.itemCount++;
            }
        }
        

        if (ms.admin.errorMessages.itemCount > 0) {//obj will always have one property itemCount
            ms.admin.adminForm.errors = ms.admin.errorMessages;
            console.log(ms.admin.errorMessages);
            return ms.util.showErrors(ms.admin.errorMessages);//will always return true
        }
    };

    ms.admin.submitLoginForm = function(frm){
        if (frm.validate()) {
            frm[0].reset();
            return false;
        }
        
        ms.modal.toggleWaiting();
        var adminData = frm.serialize();
        
        var adminCompleteCB = function(){
            
        };

        var adminFailCB = function(){
            
        };
        var adminSuccessCB = function(data, status, request){
            frm[0].reset();
            ms.modal.body.html(data.message);
            ms.modal.header.show();
            ms.modal.footer.show();
        };
        
        jQuery.ajax({
            data: adminData,
            dataType: 'json',
            complete: adminCompleteCB,
            error: adminFailCB,
            success: adminSuccessCB,
            type: 'POST',
            url: 'core/change-password-service.php'
        });
    };

    ms.admin.submitBtn = jQuery('#adminBtn').click(function(e){
        ms.admin.submitLoginForm(ms.admin.adminForm);
        e.preventDefault();
    });
})(mantisScribe);