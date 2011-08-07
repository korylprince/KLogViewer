//Global Declaration so multiple functions can access timer.
var t;
//Function to run on page load.
$(document).ready(function() {
    $('#logoutbutton').click(function() {
        window.location = "main.php?logout=true";
    });
    //If Autorefresh is red then clear the timer and turn off refresh. Otherwise make it red and refresh if there is a time set.
    $("#autotext").click(function(){
        if ($("#autotext").data("on")) {
            $("#autotext").css("color","#000");
            $("#autotext").data("on",false);
            clearTimeout(t);
        }
        else {
            $("#autotext").css("color","#f00");
            $("#autotext").data("on",true);
                refresh();
        }
    });
    //Set the window to the right size.
    $("#content").height($(window).height() - 80);
    if ($.browser.msie) {
        $("#content").height($(window).height() - 92);
    }
    checkCookie();
    //If the user changes something refresh
    $("#logselect").change(function(){refresh();});
    $("#lines").change(function(){refresh();});
    $("#searchsubmit").click(function(){refresh();});
    //If autorefresh is changed check the color and value
    $("#autoselect").change(function(){
        $("#autotext").css("color","#f00");
        $("#autotext").data("on",true);
        refresh();
    });
    $("#ajaxloader")
    .hide()  // hide it initially
    .ajaxStart(function() {
        $(this).show();
    })
    .ajaxStop(function() {
        $(this).hide();
    });
});

//Function to run on page load to get previous values from a cookie
function checkCookie() {
    if ($.cookie("type")) {
        $("#logselect").val($.cookie("type"));
    }
    if ($.cookie("search")) {
        $("#searchtext").val($.cookie("search"));
    }
    if ($.cookie("lines")) {
        $("#lines").val($.cookie("lines"));
    }
    refresh();
}

//AJAX function. Loads values from cookies and sends them to the server
function refresh() {
    //Clear the timeout first to make sure there is no buildup.
    clearTimeout(t);
    //For Autorefresh - if autorefresh is on and there is a time set, set a timeout to run
    if ($("#autotext").data("on") == true) {
        t = setTimeout("refresh();",$("#autoselect").val() * 1000);
    }
    //Get the json from the UI, then set the cookies
    var json = {"type":$("#logselect").val(),"search":$("#searchtext").val(),"lines":$("#lines").val(),"sessionID":$.cookie("sessionID")};
    $.cookie("type",$("#logselect").val());
    $.cookie("search",$("#searchtext").val());
    $.cookie("lines",$("#lines").val());
    $.ajax({
        type: "POST",
        url: "logviewer.php",
        data: json,
        dataType: "json",
        success: function(returndata){
            //If user did not authenticate send them back to the main page.
            if (returndata["Login"] == "User not Authenticated.") {
                $.cookie("sessionID",null);
                window.location = "../";
            }
            //Otherwise update the UI
            else {
                $("#content").html(returndata[0].replace(/\n/g,"<br />"));
                $("#linenumber").html("Lines: "+returndata[1]);
                $("#searchnumber").html("Search Found: "+returndata[2]);
            }
        },
        //If there is some strange error
        error: function() {
            $("#content").html("Error");
            $("#linenumber").html("Error");
            $("#searchnumber").html("Error");
        }
    });
}
