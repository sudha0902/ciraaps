// Begin Login Code
var attemptLogin = function(input){
    var params = {
        "action": "login",
    };
    
    input.forEach(function(value, index, array){
        params[value.name] = value.value;
    });
    
    var getAction = JSON.stringify(params);
    
    $.ajax({
        url: './actions/user.php', type: 'POST', data: getAction,
        contentType: 'application/json; charset=utf-8', dataType: 'json',
        async: true,
        success: function(data){
            if(data.success){
            window.location.assign(data.url);
            }else{
                var notice = new PNotify({
                    title: 'Error',
                    text: data.msg,
                    type: 'error',
                    delay: 2000,
                    buttons: {
                        closer: false,
                        sticker: false
                    }
                });
                notice.get().click(function() {
                    notice.remove();
                });
            }
        }
    });
}

$('#login_form').on('submit', function(e){
    e.preventDefault();
    var input = $(this).serializeArray();
    attemptLogin(input);
});
// End Login Code


// Begin Lock Screen Code

window.LockScreen.events =  function() {

    $( '[data-lock-screen="true"]' ).on( 'click', function( e ) {
        e.preventDefault();
        window.LockScreen.show();
    });
};

window.LockScreen.formEvents = function( $selector ) {
    // locking screen
    
    var getAction = JSON.stringify({
            "action": "lockScreen"
        });
        
    $.ajax({
        url: './actions/user.php', type: 'POST', data: getAction,
        contentType: 'application/json; charset=utf-8', dataType: 'json',
        async: true,
        success: function(data){
            if(data.success){
            }else{
                window.location.replace("./logout.php");
            }
        }
    });    
    
    
    $form = $($selector);
    
    $form.on( 'submit', function( e ) {
        e.preventDefault();
        
        var params = {
                "action": "unlockScreen"
            }
            
        var input = $(this).serializeArray();
            input.forEach(function(value, index, array){
                params[value.name] = value.value;
            });
        
        var getAction = JSON.stringify(params);

        // unlocking screen
        $.ajax({
            url: './actions/user.php', type: 'POST', data: getAction,
            contentType: 'application/json; charset=utf-8', dataType: 'json',
            async: true,
            success: function(data){
                if(data.success){
                    $.magnificPopup.close();
                }else{
                    window.location.replace("./logout.php");
                }
            }
        }); 
        
    });
  
};

window.LockScreen.show = function() {
    //console.log('Show()');
    
    $('body').addClass( 'show-lock-screen' );

    $.magnificPopup.open({
        items: {
            src: './display/LockScreen.php',
            type: 'ajax'
        },
        modal: true,
        mainClass: 'mfp-lock-screen',
        callbacks: {
            ajaxContentAdded: function() {
                window.LockScreen.formEvents( '#frmLockScreen' );
            }
        }
    });

};
// End Lock Screen Code
