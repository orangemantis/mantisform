jQuery(document).ready(function(){
	//debug formifier
	
	if (mantisScribe.config.debug) {
		$('#firstName').val('Zaphod');
		$('#middleInitial').val('G');
		$('#lastName').val('BeebleBrox');
		$('#email').val('Zaphod@bb.net');
		$('#homePhone').val('2165771241');
		$('#mobilePhone').val('4402132399');
		$('#address1').val('42 Heart Of Gold Lane');
		$('#address2').val('Ship 2');
		$('#city').val('Millie Way');
		$('#state').val(35);
		$('#zip').val('44119');
		$('#notes').val('He is the president of the galaxy and has 2 heads.');
	}
	
    mantisScribe.util = {};
    
    var scribeForm = jQuery('#scribeForm');
    var subscribeBtn = jQuery('#subscribeBtn');
    var noSubscribeBtn = jQuery('#noSubscribeBtn');
    var quickSubscribeBtn = jQuery('#quickSubscribeBtn');
    var quickNoSubscribeBtn = jQuery('#quickNoSubscribeBtn');
    var quickResetBtn = jQuery('#quickResetBtn');
    var subscribed = jQuery('#subscribed');
    var scribeModal = jQuery('#scribeModal');
    var scribeModalHeader = jQuery('#scribeModalHeader');
    var scribeModalBody = jQuery('#scribeModalBody');
    var scribeModalFooter = jQuery('#scribeModalFooter');
    var scribeModalCloseBtn = jQuery('#scribeModalCloseBtn');
    
    mantisScribe.modal = scribeModal;
    mantisScribe.modal.header = scribeModalHeader;
    mantisScribe.modal.body = scribeModalBody;
    mantisScribe.modal.footer = scribeModalFooter;
    mantisScribe.modal.footer.closeBtn = scribeModalCloseBtn;
    mantisScribe.modal.defaults = {
            show: true,
            keyboard: false,
            backdrop: 'static'
       };
    
    mantisScribe.entryForm = scribeForm;
    
    var toggleWaiting = function(){
        var defWaitMsg = '<img src="images/spinner.gif"> Please wait.';

           scribeModalHeader.hide();
           scribeModalFooter.hide();
           if (scribeModalBody.html() !== defWaitMsg) {
               scribeModalBody.html(defWaitMsg);
           }
           scribeModal.modal(mantisScribe.modal.defaults);
    };
    
    mantisScribe.modal.toggleWaiting = toggleWaiting;
    
    var submitForm = function(frm){
        if (mantisScribe.entryForm.validate()) {
            return false;
        }
        toggleWaiting();
        
        var formData = frm.serialize();

        var successCallback = function(data, status, request){
            scribeModalBody.html(data.message);
            scribeModalHeader.show();
            scribeModalFooter.show();
            frm[0].reset();
            var errors = mantisScribe.entryForm.errors || null;
            
            if (errors) {
                for(item in errors){
                    if (item != 'itemCount') {//you may need to move this into a method that just delete this item before processing
                        var itemId = '#' + item;
                        jQuery(itemId).parent().parent().removeClass('has-error');
                    }
                }
                delete mantisScribe.entryForm.errors;
            }
            
        };
        
        var failCallback = function(request, status, error){

        };
        
        var completeCallback = function(request, status){
            
        };
        
        var request = jQuery.ajax({
            data: formData,
            dataType: 'json',
            complete: completeCallback,
            error: failCallback,
            success: successCallback,
            type: 'POST',
            url: 'core/scribe-service.php'
        });
    };
    
    subscribeBtn.click(function(e){
        var subVal = jQuery(this).val();
        subscribed.val(subVal);
        submitForm(scribeForm);
        e.preventDefault();
    });
    
    quickSubscribeBtn.click(function(e){
        var subVal = jQuery(this).val();
        subscribed.val(subVal);
        submitForm(scribeForm);
        e.preventDefault();
    });
    
    noSubscribeBtn.click(function(e){
        var subVal = jQuery(this).val();
        subscribed.val(subVal);
        submitForm(scribeForm);
        e.preventDefault();
    });
    
    quickNoSubscribeBtn.click(function(e){
        var subVal = jQuery(this).val();
        subscribed.val(subVal);
        submitForm(scribeForm);
        e.preventDefault();
    });
    
    quickResetBtn.click(function(e){
        scribeForm[0].reset();
        e.preventDefault();
    });
    
    //load scripts for individual pages here, index page included in main function
    var scriptLoader = function(scr, callback){
        var script = mantisScribe.config.script || '';
        if (scr) {
            script = scr;
        }
        if (script) {
            jQuery.getScript(script, callback);
        } 
    };
    
    mantisScribe.scriptLoader = scriptLoader;
    
    scriptLoader(null, function(data, status, request){
        
    });
    
    var formatHtmlList = function(msgObj){
        //each object passed should have an itemCount similar to Array.length convenience to see if obj is empty
        var itemCount = msgObj.itemCount || 0;
        if (itemCount > 0){
            var list = '<ul>[LIST]</ul>';
            var lineTpl = '<li>[ITEM]</li>';
            var listItems = '';
            for(item in msgObj){
                if (item != 'itemCount') {
                    listItems += lineTpl.replace(/\[ITEM\]/,msgObj[item]);
                }
            }
            list = list.replace(/\[LIST\]/, listItems);
            return list;
            
        }
        return false;
    };
    
    mantisScribe.util.formatHtmlList = formatHtmlList;
    
    var showErrors = function(msg){
        var errors = mantisScribe.util.formatHtmlList(msg);
        mantisScribe.modal.body.html(errors);
        mantisScribe.modal.modal(mantisScribe.modal.defaults);
        return true;//send back return val, to prevent form from submitting, if this is called there is an error
    };
    mantisScribe.util.showErrors = showErrors;
    
    //load logout functonality
    mantisScribe.scriptLoader('js/logout.js',function(){});
    
});