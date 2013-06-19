$(document).ready(function(){
	$('#myCarousel').carousel();
	if(document.getElementById("change") !== null){var num=localStorage.length/3;
	$('#change').text("No of item "+num);}
	$('.item_add').click(function()
	{
		if(document.getElementById("change") !== null)
		{
			var x=$('.item_id').attr("value");
			if(localStorage)
			{
				localStorage.setItem(x+'name',$('.name').attr("value"));
				localStorage.setItem(x+'price',$('.price').attr("value"));
				localStorage.setItem(x+'n_o_p',$('.item_Quantity').attr("value"));
				var num=localStorage.length/3;
				$('#change').text("No of item "+num);
				alert('added');
			}
			else alert("No localStorage found");

		}
		else

		{
			window.location='./login.php';
		}
		
	});
	$('.bookmark').click(function()
	{
		var x=$('.item_id').attr("value");
		$.ajax({
	      url: "bookmark.php",
	      type:"post",
	      data:{id:x},
	      success: function(data){
	      	if(data=='not loggged'){window.location='./login.php';}
	      	else alert(data);
	      },
	      error:function(){
	          alert("failure");
	      }   
	    }); 		
		
	});

	$('.book').click(function()
	{
		var x=$('.item_id').attr("value");
		var y=$('.item_Quantity').attr("value");
		$.ajax({
	      url: "booked_product.php",
	      type:"post",
	      data:{id:x,no:y},
	      success: function(data){
	      	if(data=='not loggged'){window.location='./login.php';}
	      	else alert(data);
	      },
	      error:function(){
	          alert("failure");
	      }   
	    }); 		
		
	});
});