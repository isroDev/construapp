
$(document).ready(function () {
    $.ajax({
        type    :   "POST",
        url     :   'controllers/controller.php',
        dataType: "JSON",
        data    :   {action: "check_login"},
        success: function(response) 
        {
           
            if(response["login"] == true)
            {
                window.location.href = "requests/requests.html";
                

            }
            else
            {
                $("#loginDiv").show();
            }
            
            
            

            
        }
        
    });
    
  $("#login_form").validate({
    // initialize the plugin
    rules: 
    {
        email_Input: 
        {
            required: true,
            email: true,
        },
        password_Input: 
        {
            required: true,
           
        },
    },
    messages:
    {
        email_Input: 
        {
            required: "Email is required",
            email:    "Invalid Email",
        },
        password_Input: 
        {
            required: "Password is required",
        
        },


    },
    errorPlacement: function(error, element) {
        var placement = $(element).attr("id");
        if(placement == "email_Input")
        {
            $("#email_error").text($(error).text());
        }
        if(placement == "password_Input")
        {
            $("#password_error").text($(error).text());
        }
        
      },
      success: function(element) {  
        $(element).closest('small').text("");       
    },
    
  });


  $("#login_form").on("submit", function(e){
    $("#div_err").hide();
    e.preventDefault();
    if($("#login_form").valid() == true)
    {
      $.ajax({
        type    :   "POST",
        url     :   'controllers/controller.php',
        data    :   {action: "login", email: $("#email_Input").val(), password: $("#password_Input").val() },
        success: function(response) 
        {
            var decoded_response        =       JSON.parse(response);
            var user_role               =       parseInt(decoded_response["user_role"]);
            var request_users           =       [10, 11, 14];
            //  for administrator de obra
            if(decoded_response["login"] == true && user_role == 4)
            {
                window.location.href = "requests/constructions.html";
                

            }
            // For Role Bodeguero
            if(decoded_response["login"] == true && $.inArray(user_role, request_users) !== -1)
            {
                window.location.href = "requests/requests.html";
                

            }
            // For Role Supervisor
            if(decoded_response["login"] == true && user_role == 11)
            {
                window.location.href = "requests/material-deliveries.html";
                

            }
            if(decoded_response["login"] == true && user_role == 15)
            {
                window.location.href = "requests/user-modules.html";
                

            }
            if(decoded_response["login"] == true && user_role == 16)
            {
                window.location.href = "Inspeccion/progress-list.html";
                

            }
            if(decoded_response["login"] == true && user_role == 6)
            {
                window.location.href = "rrhh/workers-list.html";
                

            }
            if(decoded_response["login"] == false)
            {
                $("#div_err").show();
                

            }
            
            

            
        }
        
    });
        



    }

  });
});
