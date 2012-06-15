$(document).ready(function() {
    $("#tellafriend").click(function() {
        $.modal('<div><iframe src="' + $(this).attr('href') + '" height="500" width="500" style="border:0"></div>', {
            containerCss:{
                backgroundColor:"white",
                borderColor:"black",
                height:530,
                padding:0,
                width:515
            },
            overlayClose:false
        });
        return false;
    });
});
