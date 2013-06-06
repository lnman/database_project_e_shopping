$(document).ready(function(){
      $("#signin").validate({
        rules:{
          uname:"required",
          passwd:"required",
        },
        errorClass: "help-inline"
      });
    });