/* Controller for lostPassword.php */
(function($){

var Lost = {
    user: "",
    question: "",
    events: function(){
        
        $("#pwResetUser").on('submit', function(e){
            e.preventDefault();
            
            // console.log("Begin"); 
            
            var input = $("#username").val();
            
            if(typeof input != "undefined" && input != ""){
                
                Lost.getSecurityQuestion(input);
                
            }
            
        });
        
        $("#pwResetQuestion").on('submit', function(e){
            e.preventDefault();
            
            // console.log("Submit"); 
            
            var input = $("#securityanswer").val();
            Lost.attemptLogin(input);
        });
        
    },    
    attemptLogin: function(answer){
        var params = {
            "action": "loginByQuestion",
            "user": Lost.user,
            "answer": answer
        };
        
        var getAction = JSON.stringify(params);
        
        $.ajax({
            url: '/users/loginByQuestion', type: 'POST', data: getAction,
            contentType: 'application/json; charset=utf-8', dataType: 'json',
            async: true,
            success: function(data){
                // console.dir(data);
                window.location.assign(data.url);
            }
        });
    },
    getSecurityQuestion: function(user){
        
        Lost.user = user;
        
        var payload = {
            "action": "getSecurityQuestion",
            "userName": user
        }
    
        $.ajax({
            url: '/users/lostpwd', type: 'POST', data: JSON.stringify(payload),
            contentType: 'application/json; charset=utf-8', dataType: 'json',
            async: true,
            success: function(data){
                if(data.success && data.question != null){
                    $("#pwResetUser").addClass('hidden');
                    $("#pwResetQuestion").removeClass('hidden');
                    $("#pwResetQuestion p").html(data.question);
                    // console.dir(data);
                }else{
                     console.log(data);
                    window.location.assign("./ContactAdmin.php");
                }
            }
        });
        
    },
    init: function(){
        
        // console.log("Lost.init()");
        Lost.events();
        
    }
};


if(location.pathname === "/users/lostpwd"){
    Lost.init();
}
    
})(jQuery);

/* Controller for UpdatePassword.php */
(function($){

    var Update = {
        pass: "",
        update: function(data){

            var params = {
                "action": "updatePassword",
                "data": data
            };
            
            var getAction = JSON.stringify(params);
            
            $.ajax({
                url: './actions/user.php', type: 'POST', data: getAction,
                contentType: 'application/json; charset=utf-8', dataType: 'json',
                async: true,
                success: function(data){
                    // console.dir(data);
                    window.location.assign(data.url);
                }
            }); 
        
        },
        checkPassword: function(pass){
            
            var test = false,
                hasDigit = /[0-9]/,
                hasLC = /[a-z]/,
                hasUC = /[A-Z]/,
                hasSpec = /[^a-zA-Z0-9]/;
             
            if(pass.length < 7){ return false; }
            
            if(!hasDigit.test(pass)){ return false; }
            
            if(!hasLC.test(pass)){ return false; }
            
            if(!hasUC.test(pass)){ return false; }
            
            if(!hasSpec.test(pass)){ return false; }
            
            return true;
        },
        events: function(){
            
            $("#newpassword").on('keyup', function(){
                
                Update.pass = $(this).val();
                
                if(Update.checkPassword(Update.pass)){
                    
                    $("#newpw i").removeClass("fa-exclamation");
                    $("#newpw i").addClass("fa-check");
                    $("#confirmpassword").prop( "disabled", false );
                    
                }else{
                
                    $("#newpw i").removeClass("fa-check");
                    $("#newpw i").addClass("fa-exclamation");
                    $("#confirmpassword").prop( "disabled", true );
                    
                }
                
            });
            
            $("#confirmpassword").on('keyup', function(){
                var test = $(this).val()
                
                if(test === Update.pass){
                    
                    $("#matchpw i").removeClass("fa-exclamation");
                    $("#matchpw i").addClass("fa-check");
                    $("#bttnUpdate button").removeAttr("disabled");
                    
                } else {
                
                    $("#matchpw i").removeClass("fa-check");
                    $("#matchpw i").addClass("fa-exclamation");
                    $("#bttnUpdate button").attr("disabled", "disabled");
                    
                }
            });
            
            
            $('#pwResetUser').on('submit', function(e){
                e.preventDefault();
                // console.log($("#newpassword").val());
                Update.update($("#newpassword").val());
            });
            
        },
        init: function(){
            
            Update.events();
            
        }
    };

    if(location.pathname === "/UpdatePassword.php"){ 
            
        // console.log("Update.init()");   
        Update.init(); 
        
    }
      
})(jQuery);

/* Controller for UpdateSecurityQuestion.php */
(function($){
    
    var SQuestion = {
        update: function(data){

            var params = {
                "action": "updateQuestion",
                "data": data
            };
            
            var getAction = JSON.stringify(params);
            
            $.ajax({
                url: './actions/user.php', type: 'POST', data: getAction,
                contentType: 'application/json; charset=utf-8', dataType: 'json',
                async: true,
                success: function(data){
                    
                    window.location.assign(data.url);
                    
                }
            });
        
        },
        events: function(){
            $("#pwSQuestion").on('submit', function(e){
                e.preventDefault();
                var input = $(this).serializeArray(),
                    data = {};
                
                input.forEach(function(value, index, array){
                    data[value.name] = value.value;
                });
                
                // console.dir(data);
                SQuestion.update(data);
            });
        },
        init: function(){
            
            SQuestion.events();
            
        }
    };
        
    if(location.pathname === "/UpdateSecurityQuestion.php"){ 
            
        console.log("SQuestion.init()");   
        SQuestion.init(); 
        
    }
      
})(jQuery); 