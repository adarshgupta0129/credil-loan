 /* GET URL OF QUERY STRING */
 var full_url = new URLSearchParams(window.location.search);


/******     CUSTOMER REGISTRATION 		******/

function registration(get_id)
{
	var urlpost = baseUrl+txtclass+"/register_candidate";
	var productId = get('productId');
	var variantId = get('variantId');
	if(check(get_id))
	{
		$.ajax({
			type: "POST",
			url : urlpost,
			data: $('#'+get_id).serialize(),
		 	beforeSend : function(){
				$.blockUI(
				{
					message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
				});
			},
			success: function(msg){
				$.unblockUI();
				if(msg.trim() == "OTP_NOT_MATCH"){
					bootbox.alert("Otp Not Matched!");
				}else if(msg != "")
				{
					bootbox.alert(msg.trim(),function (){
						window.location.href = baseUrl+txtclass+"/"+txtmethod;
					});
				}
				else
				{
					bootbox.alert("Some Error on this page!");
				}
			}
		});
	}
}

function login_mobile_change(ref){
	if(ref.value.length != 10)
		bootbox.alert("Mobile Number is Not Valid");
	else{
		$.ajax({
			type: "POST",
			url :  baseUrl+txtclass+"/register_otp_send",
			data: {mobile:ref.value},
		 	beforeSend : function(){
				$.blockUI({	message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'});
			},
			success: function(res){
				$.unblockUI();
				res=JSON.parse(res);
				if(res.status == "1")
					bootbox.alert("Otp Send Successfully!");
			}
		});
	}
}


/* Change Status */

function change_user_status(id, status, proc)
{
	var urlpost = baseUrl+"Get_Details/change_user_status";
	$.ajax({
		type: "POST",
		url : urlpost,
		data:{"id":id, "status":status, "proc":proc},
		beforeSend : function(){
			$.blockUI({
				message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
			});
		}, 
		success: function(msg) {	
				$.unblockUI();
 					window.location.href = baseUrl+txtclass+"/"+txtmethod+"?"+full_url;
				}
	});
}

/* Update One value */

function update_user_value(id, val, proc)
{
	var urlpost = baseUrl+"Get_Details/update_user_value";
	$.ajax({
		type: "POST",
		url : urlpost,
		data:{"id":id, "val":val, "proc":proc},
		beforeSend : function(){
			$.blockUI({
				message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
			});
		},
		complete: function () {
			$.unblockUI();
		}
	});
}


/***** HIDE PASSWORD FROM DIRECT SHOW *****/

$(".pass_show").hide(); 
$(".password").append("<span class='pass_hide'>******</span>");
$(".pass_hide").show(); 

$('.password').on('click', function() 
{ 
	$(this).find(".pass_hide").toggle(); 
	$(this).find(".pass_show").toggle(); 
});

$(document).on('submit','.form_submit',function(event){ 
	event.preventDefault();
	formdata = new FormData($(this)[0]);
	$.ajax({
			url: $(this).attr('action'),
			data: formdata,
			contentType: false,
			processData: false,
			type: 'POST',
			dataType:"json",
			success: function(response){
			
				if(response.success == true){
				   $('.form_submit')[0].reset();
				   alert(response.message);
				   setTimeout(function(){
				   location.reload();
					},1000);
				}
				else{
					$.each(response.errors,function(key,value){
					   console.log(value);
					   $('.err'+key).css('color','red').text(value);
					});
					
				}
		
			}
		});
});
function get_data(u_id){
	var id = u_id;
	$.ajax({
		url: '/Userprofile/member_address_data',
		type: 'POST',
		dataType:"json",
		data: {
			id:id,
			},
		success: function(data){
				//alert(data.user_data.user_addr_name);
				$('#name').val(data.user_data.user_addr_name);
				$('#email').val(data.user_data.user_addr_email);
				$('#mobile').val(data.user_data.user_addr_mobile);
				$('#address').val(data.user_data.user_addr_address);
				$('#city').val(data.user_data.user_addr_city);
				$('#state').val(data.user_data.user_addr_state);
				$('#zip').val(data.user_data.user_addr_pincode);
				$('#member_id').val(data.user_data.user_addr_id);
		}
	});
}
function delete_data(u_id){
	var id = u_id;
	if(confirm("Are you sure you want to delete ?")){
        $.ajax({
			url: '/Userprofile/member_address_delete',
			type: 'POST',
			dataType:"json",
			data: {
				id:id,
				},
			success: function(response){
				if(response.status == true){
					alert(response.message);
					   setTimeout(function(){
					   location.reload();
						},1000);
				}	
			}
		});
    }
    else{
        return false;
    }
	
}
	function remove(id){
	$.ajax({
	url: baseUrl+"welcome/remove_product",
	type: "post",
	dataType: "json",
	data: {
		id: id,
	},
	success: function(data) { 
		if(data == "1") { 
			location.reload(true);
			} else {
			alert('somthing wrong');
		}
	},
	
});

} 


function stat(){
	var stateid = $('#state').val();
	
	if(stateid != '')
	{
		$.ajax({
			url:baseUrl+"welcome/fetch_city",
			method:"POST",
			data:{stateid:stateid},
			success:function(data)
			{
				$('#city').html(data);
			}
		});
	}
	else
	{
		$('#city').html('<option value="">Select City</option>');
	}
}

	
function get_city()
{
	var ddstate=$("#ddstate").val();
	var ocity=$("#hdocity").val();
	if(ddstate!="-1")
	{
		$.ajax(
			{
				type:"POST",
				url:baseUrl+"Get_Details/get_city",
				dataType: 'json',
				data: {'ddstate': ddstate},
				beforeSend : function(){
					$.blockUI(
						{
							message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
						});
						setTimeout($.unblockUI, 1000);
				},
				success: function(msg) {
					$("#ddcity").empty();
					$("#ddcity").append("<option value=-1>Select City</option>");
					$.each(msg.rec,function(i,item)
						{
							if(ocity!="")
							{
								if(item.loc_id==ocity)
								{
									$('#ddcity').append("<option value="+item.loc_id+" selected>"+item.loc_name+"</option>");
								}
								else
								{
									$('#ddcity').append("<option value="+item.loc_id+">"+item.loc_name+"</option>");
								}
							}
							else
							{
								$('#ddcity').append("<option value="+item.loc_id+">"+item.loc_name+"</option>");
							}
						});
				}
			});
	}
}



