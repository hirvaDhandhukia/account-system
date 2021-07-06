// for validation in the registration form
$(document).ready(function() {
    $('#fname_err').hide();
    $('#lname_err').hide();
    $('#username_err').hide();
    $('#email_err').hide();
    $('#date_err').hide();
    $('#gender_err').hide();
    $('#password_err').hide();
    $('#confirm_password_err').hide();
    $('#checkbox_err').hide();

    //errors are all false rn (at this particular moment, there are no errors)
    var error_fname = false;
    var error_lname = false;
    var error_username = false;
    var error_email = false;
    var error_date = false;
    var error_gender = false;
    var error_password = false;
    var error_confirm_password = false;
    var error_checkbox = false;

    $('#fname').focusout(function() {
        check_fname();
    })
    $('#lname').focusout(function() {
        check_lname();
    })
    $('#username').focusout(function() {
        check_username();
    })
    $('#email').focusout(function() {
        check_email();
    })
    $('#date').focusout(function() {
        check_date();
    })
    $('#gender').focusout(function() {
        check_gender();
    })
    $('#password').focusout(function() {
        check_password();
    })
    $('#confirm_password').focusout(function() {
        check_confirm_password();
    })
    $('#checkbox').focusout(function() {
        check_checkbox();
    })

    // functions to validate the input values
    function check_fname() {
        var regex = /^[a-zA-Z]*$/;
        var fnameValue = $('#fname').val();
        if(regex.test(fnameValue) && fnameValue !== '') {
            $('#fname_err').hide();
        } else if(fnameValue == '') {
            $('#fname_err').html("First name cannot be blank");
            $('#fname_err').show();
            $('#fname').css("border","2px solid #F90A0A");
            error_fname = true;
        } else {
            $('#fname_err').html("Name should contain only characters");
            $('#fname_err').show();
            $('#fname').css("border","2px solid #F90A0A");
            error_fname = true;
        }
    }

    function check_lname() {
        var regex = /^[a-zA-Z]*$/;
        var lnameValue = $('#lname').val();
        if(regex.test(lnameValue) && lnameValue !== '') {
            $('#lname_err').hide();
        } else if(lnameValue == '') {
            $('#lname_err').html("Last name cannot be blank");
            $('#lname_err').show();
            $('#lname').css("border","2px solid #F90A0A");
            error_lname = true;
        } else {
            $('#lname_err').html("Name should contain only characters");
            $('#lname_err').show();
            $('#lname').css("border","2px solid #F90A0A");
            error_lname = true;
        }
    }

    function check_username() {
        var usernameValue = $('#username').val();
        if(usernameValue == '') {
            $('#username_err').html("Username cannot be blank");
            $('#username_err').show();
            $('#username').css("border","2px solid #F90A0A");
            error_username = true;
        } else {
            $('#username_err').hide();
        }
    }

    function check_email() {
        var regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var emailValue = $('#email').val();
        //var emailValue = document.getElementById('email').this.value; // avu kaik
        if(regex.test(emailValue) && emailValue !== '') {
            $('#email_err').hide();
        } else {
            $("#email_err").html("Invalid Email");
            $("#email_err").show();
            $("#email").css("border","2px solid #F90A0A");
            error_email = true;
        }
    }

    function check_date() {
        var dateValue = $('#date').val();
        if(dateValue == '') {
            $('#date_err').html("Date cannot be blank");
            $('#date_err').show();
            $("#date").css("border","2px solid #F90A0A");
            error_date = true;
        } else {
            $('#date_err').hide();
        }
    }

    function check_gender() {
        // same name = gender
        if(document.getElementsByName('gender').checked) {
            $('#gender').hide();
        } else {
            $('#gender_err').html("Enter your gender");
            $('#gender_err').show();
            error_gender = true;
        }
    }

    function check_password() {
        var passwordValue = $('#password').val();
        var password_length = $("#password").val().length;
        if(passwordValue == '') {
            $('#passwrod_err').html("Password cannot be blank");
            $('#password_err').show();
            $("#password").css("border","2px solid #F90A0A");
            error_password = true;
        } else if (password_length < 5) {
            $('#password_err').html("Password should contain atleast 5 characters");
            $('#password_err').show();
            $("#password").css("border","2px solid #F90A0A");
            error_password = true;
        } else {
            $('#password_err').hide();
        }
    }

    function check_confirm_password() {
        var confirmPasswordValue = $('#confirm_password').val();
        if(confirmPasswordValue == '') {
            $('#confirm_password_err').html("Confirm your password");
            $('#cofirm_password_err').show();
            $("#confirm_password").css("border","2px solid #F90A0A");
            error_confirm_password = true;
        } else if(confirmPasswordValue !== passwordValue) {
            $('#confirm_password_err').html("Passwords donot match. Write same passwords.");
            $('#cofirm_password_err').show();
            $("#confirm_password").css("border","2px solid #F90A0A");
            error_confirm_password = true;
        } else {
            $('#confirm_password_err').hide();
        }
    }

    function check_checkbox() {
        if( document.getElementById('checkbox').checked) {
            $('#checkbox_err').hide(); 
        } else {
            $('#checkbox_err').html("Check the box and then click submit button");
            $('#checkbox_err').show();
            $('#checkbox').css("border","2px solid #F90A0A");
            error_checkbox = true;
        }
    }

    $('#form').submit(function() {
        error_fname = false;
        error_lname = false;
        error_username = false;
        error_email = false;
        error_password = false;
        error_confirm_password = false;

            check_fname();
            check_lname();
            check_username();
            check_email();
            check_password();
            check_confirm_password();

            if (error_fname == false && error_lname == false && error_username && error_email == false && error_password == false && error_confirm_password == false) {
                alert("Registration Successfull");
                return true;
            } else {
                alert("Please Fill the form Correctly");
                return false;
            }
    });

});

// function checkemail() {
//     var request = new XMLHttpRequest();
//     var url = "registration.php";
//     var emailaddress = document.getElementById('email').value;
//     var vars = "email="+emailaddress;
//     request.open("POST", url, true);

//     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

//     request.onreadystatechange = function() {
//         if(request.readyState === 4 && request.status === 200) {
//             var return_data = request.responseText;
//             document.getElementById('email_err').innerHTML = return_data;
//         }
//     }
//     request.send(vars);
// }