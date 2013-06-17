$(document).ready(function(){
	if(document.getElementById("change") !== null){var num=localStorage.length/3;
   $('#change').text("No of item "+num);}
	tot=0;
	for (i = 0; i < localStorage.length; i=i+3){

      key1 = localStorage.key(i);
      value1 = localStorage.getItem(key1);
      key2 = localStorage.key(i+1);
      value2 = localStorage.getItem(key2);
      key3= localStorage.key(i+2);
      value3 = localStorage.getItem(key3);
      tot=tot+value1*value3;
      $('.test').after("<tr>"+"<td>"+value2+"</td>"+"<td>"+value3+"</td>"+"<td>"+value1+"</td>"+"<td>"+value1*value3+"</td>"+"<td>"+"<button class='btn-warning' id='remove' ff='"+value2+"'>Remove</button>"+"</td>"+"</tr>");
    } 
   $('.table:last').after("<table class='table'><tr>"+"<td class='span8'>"+"total"+"</td>"+"<td>"+tot+"</td>"+"<td>"+"<button class='btn-success offset6' id='check_and_out'>Check out</button>"+"</td>"+"</tr></table>");
   $('#remove').click(function(){
      var tt=$(this).attr('ff');
      for (i = 0; i < localStorage.length; i=i+3){
      key1 = localStorage.key(i);
      value1 = localStorage.getItem(key1);
      key2 = localStorage.key(i+1);
      value2 = localStorage.getItem(key2);
      key3= localStorage.key(i+2);
      value3 = localStorage.getItem(key3);
      if(value2==tt)
      {
         localStorage.removeItem(key1);
         localStorage.removeItem(key2);
         localStorage.removeItem(key3);
         window.location='./check_out.php';
      }
   }
   });

   $('#check_and_out').click(function(){
      var ll={};
      var a = [];
      for (i = 0; i < localStorage.length; i=i+3){
      x= parseInt(localStorage.key(i).slice(0,-5));
      y= localStorage.getItem(localStorage.key(i));
      a.push(x+"="+y);
      var serialized = a.join("&");
   }
   $.ajax({
         url: "finish_transaction.php",
         type:"post",
         data:{id:serialized},
         success: function(data){
            window.location='post_check_out.php';
         },
         error:function(){
             alert("failure");
         }   
       }); 


   });


});