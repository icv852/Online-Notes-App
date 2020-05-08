//Ajax Call for the sign up form
//Once the form is submitted
$("#signupform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
    //send them to signup.php using AJAX
    $.ajax({
        url: "signup.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#signupmessage").html(data);
            }
        },
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
        }
    });
    
});
    

//Ajax Call for the login form
//Once the form is submitted
    //prevent default php processing
    //collect user inputs
    //send them to login.php using AJAX
        //AJAX Call successful
            //if php files returns "success": redirect the user to notes page
            //otherwise show error message
        //AJAX Call fails: show Ajax Call error


//Ajax Call for the forgot password form
//Once the form is submitted
    //prevent default php processing
    //collect user inputs
    //send them to login.php using AJAX
        //AJAX Call successful: show error or success message
        //AJAX Call fails: show Ajax Call error