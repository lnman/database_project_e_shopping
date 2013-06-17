$(document).ready(function(){
      $("#show_add_product").validate({
        rules:{
          name:"required",
          cat:"required",
          price:"required",
          n_o_p:"required",
          file_1:"required",
        },
        errorClass: "help-inline"
      });
    });