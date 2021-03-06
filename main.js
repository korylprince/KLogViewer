//Function to run on page load.
$(document).ready(function() {
    checkCookie();
    $("#submitbutton").button();
    //To make the boxes show active state
    $('input').click(function() {
        $(this).not("button").removeClass("ui-state-default");
        $(this).not("button").addClass("ui-state-active");
    });
    $('input').blur(function() {
        $(this).not("button").addClass("ui-state-default");
        $(this).not("button").removeClass("ui-state-active");
    });
    //Submit button is clicked
    $('#submitbutton').click(function() {
        submit({"username":$('[name="username"]').val(),"password":$('[name="password"]').val()});
    });
});


//Post to login.php
function submit(jsondata) {
    $.ajax({
        type: "POST",
        url: "auth/login.php",
        data: jsondata,
        dataType: "json",
        success: function(returndata){
            if (returndata.Login == "True") {
                //Set the cookie. Path is required for using in /auth/ subtext
                var cookiepath = window.location.pathname.substr(0,window.location.pathname.lastIndexOf("/"));
                $.cookie("sessionID",returndata.data.sessionID, { path: cookiepath });
                window.location = "auth/main.php";
            }
            else if (returndata.Login == "Restricted") {
                showError("Unknown Username or Bad Password!");
            }
            else if (returndata.Login == "Error") {
                showError("Unknown Error! Error Code: "+returndata.errorCode);
            }
            else {
                showError("Unknown Error! Error Code: "+returndata.Login);
            }
        },
        error: function() {
            showError("Error! Contact Your System Administrator!");
        }
    });
}

//If sessionID is already set in cookies go ahead and forward to page
function checkCookie() {
    if ($.cookie("sessionID") && $.cookie("logout") == null){
        window.location = "auth/main.php";
    }
    else {
        var cookiepath = window.location.pathname.substr(0,window.location.pathname.lastIndexOf("/"));
        $.cookie("sessionID",null, { path: cookiepath });
        $.cookie("logout",null, { path: cookiepath });
    }
}

//Shows box at bottom of page with any error message
function showError(error) {
    $("#errorboxwrapper").hide();
    $("#errorbox").html(error);
    $("#errorboxwrapper").fadeIn();
    var t=setTimeout("hideError()", 7000);  
}

//Function to call to hide error
function hideError() {
    $("#errorboxwrapper").fadeOut();
}
