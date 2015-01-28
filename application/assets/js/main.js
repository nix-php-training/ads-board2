$(function() {
    $("#resetdialog").dialog({
        autoOpen:false,
        height: 200,
        width: 500,
        buttons:{
            OK:function()
            {
                window.location.replace('/user/reset');
                $(this).dialog("close");
            },

            CANCEL:function()
            {
                $(this).dialog("close");
            }
        }
    });
    $("#resetplan").click(function(){
        $("#resetdialog").dialog("open");
    });

    $("#birthday").datepicker({dateFormat:"yy-mm-dd"});

    $("button#submitContact").click(function(){
        $.ajax({
            type: "POST",
            url: "/contact", //process to mail
            data: $('form.contact').serialize(),
            success: function(){
                $("#contactUs").modal('hide'); //hide popup
            },
            error: function(){
                alert("failure");
            }
        });
    });
});