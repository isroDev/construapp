$(document).ready(function(){

    $.ajax({
        type    :   "POST",
        url     :   '../../../controllers/controller.php',
        dataType:   "JSON",
        data    :   {action: "check_login"},
        success: function(response) 
        {
           
            if(response["login"] == false)
            {
                window.location.href = "../../../index.html";
                

            }
            
            
            
            

            
        }
        
    });


});