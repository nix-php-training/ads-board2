$(document).ready(function() {
    $("#resetdialog").dialog({autoOpen:false,buttons:{
        OK:function(){
            $(this).dialog("close");
            alert("ОК");},
        CANCEL:function(){
            $(this).dialog("close");
            alert("CANCEL");}}
    });
    $("#resetplan").click(function(){
        $("#resetdialog").dialog("open");
    });
});