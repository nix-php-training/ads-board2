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
            beforeSend: function(){
                $("#contactLoading").show();
                $("#submitContact").hide();
            },
            type: "POST",
            url: "/contact",
            data: $('form.contact').serialize(),
            success: function(){
                $("#contactUs").modal('hide');
            },
            error: function(){
                alert("failure");
            }
        });
    });


});