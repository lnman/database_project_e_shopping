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
      $('.username_check').click(function()
      {
        var x=$('#uname').attr("value");
        $.ajax({
            url: "check_username.php",
            type:"post",
            data:{uname:x},
            success: function(data){
              if(data=='found')
              {
                alert('exists');
              }else alert('Ok!:)');
            },
            error:function(){
                alert("failed to check");
            }   
          });
      });
    });