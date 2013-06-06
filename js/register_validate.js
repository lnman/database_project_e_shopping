 $(document).ready(function(){
      $("#signup").validate({
        rules:{
          fname:"required",lname:"required",uname:"required",
          dob:{required:true,date: true},sq:"required",sa:"required",
          email:{required:true,email: true},
          passwd:{required:true,minlength: 8},
          conpasswd:{required:true,equalTo: "#passwd"},
          gender:"required",phone:{digits: true,minlength: 8}
        },
        errorClass: "help-inline"
      });
      $("#gender > button").click(function(){
        $("#gender").value=this.value;
      });

    });