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
});