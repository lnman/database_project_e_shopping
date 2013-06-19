$(document).ready(function(){
      $("#show_add_advertisement").validate({
        rules:{
          name:"required",
          desc:"required",
          file:"required",
        },
        errorClass: "help-inline"
      });
    });