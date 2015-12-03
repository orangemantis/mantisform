mantisScribe.entryForm.validate = function(){
    var formElements = mantisScribe.entryForm[0].elements;
    var errorMessages = {
            itemCount: 0
    };

    jQuery.each(formElements, function(index, elem){

        var item = jQuery(elem);
        var fieldType = 'default';
        
        var emailFieldCheck = /email/i; // to see if email rule should be used
        if (elem.id.match(emailFieldCheck)) {
            fieldType = 'email';
        }
        var phoneFieldCheck = /phone/i;
        if (elem.id.match(phoneFieldCheck)) {
            fieldType = 'phone';
        }
        
        switch(fieldType){
            case 'email':
                if (item.hasClass('required')) {
                    var emailEx = /^([A-Za-z0-9-_\.]+)@([A-Za-z0-9-_]+)\.([A-Za-z]{2,})/;
                    var emailMatch = item.val().match(emailEx);
                    if (!emailMatch){
                        item.parent().parent().addClass('has-error');
                        errorMessages[elem.id] = elem.placeholder + ': The email address entered is invalid or missing.';
                        errorMessages.itemCount++;
                    }
                }
                break;
            case 'phone':
                var phoneNum = item.val().replace(/[A-Za-z-\.@#\*\+\^\(\)]/g, '');
                var phoneEx = /^([0-9]{7,})/;
                var phoneMatch = phoneNum.match(phoneEx);
                if (phoneNum){
                    if (!phoneMatch){
                        item.parent().parent().addClass('has-error');
                        errorMessages[elem.id] = elem.placeholder + ': The number entered is invalid or missing.';
                        errorMessages.itemCount++;
                    }
                }
                break;
            default:
                if (item.hasClass('required')) {
                    var itemValue = item.val().trim();
                    if (!itemValue) {
                        item.parent().parent().addClass('has-error');
                        errorMessages[elem.id] = elem.placeholder + ': This field is required.';
                        errorMessages.itemCount++;
                    }
                }
                break;
        }
    });

    if (errorMessages.itemCount > 0) {//obj will always have one property itemCount
        mantisScribe.entryForm.errors = errorMessages;
        console.log(errorMessages);
        return mantisScribe.util.showErrors(errorMessages);//will always return true
    }
};