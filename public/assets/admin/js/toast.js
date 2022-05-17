const toast = {
    showToast: (param) => {
        let handle = $("#popNotifications"),
            css = '';
    
        //reset
        handle.removeClass("show")
        handle.find(".toast").removeClass(css);
    
        switch (param.type) {
            case "error":
                css = 'toast-error';
                break;
            case "info":
            default:
                css = 'toast-info';
                break;
        }
    
        handle.find("p").html(param.msg);
    
        handle.addClass("show");
    
        handle.find(".toast").addClass(css);
    
        setTimeout(function() {
            handle.removeClass("show")
            handle.find(".toast").removeClass(css);
        }, 5 * 1000);
    }
}