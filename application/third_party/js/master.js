
/* Edid Menu in Master Panel */

function edit_menu_details(id, menu_parent_id, name, badges, stat, level, display)
{
	$("#menu_name").focus();;
	$("#menu_id").val(id); 
	$("#menu_parent_id").val(menu_parent_id); 
	$("#menu_name").val(name);
	$("#menu_level").val(level);
	$("#ddbadges").val(badges);
	$("#ddstatus").val(stat);
	if(display == '1')
		$("#isdisplay").attr('checked', 'checked');
	else
		$("#isdisplay").removeAttr('checked');
 	if(id === '0'){
		$("#submit").attr('name','add'); 
		$("#submit").text('Add');  
	} else {
		$("#submit").attr('name','update'); 
		$("#submit").text('Update'); 
	}
	$.blockUI({message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'});
	$.ajax({
		type:"POST",
		url:baseUrl+txtclass+"/get_menu_location",
		data:{menu:id},
		success:function(res){
			$.unblockUI();
			//console.log(res);
			$("#ddlocationGroup").val(res.data).trigger('change');
		}
	});

}

/* Set Menu in Master Panel */

function set_front_menu(get_id)
{
	var urlpost = baseUrl+txtclass+"/set_front_menu";
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
		success: function(msg) {
			$.unblockUI();
			//bootbox.alert(msg);
			//window.location.href = baseUrl+txtclass+"/"+txtmethod;
		}
	});
}

/* Change Status */

function change_status(id, status, proc)
{
	var urlpost = baseUrl+"Get_Details/change_status";
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

function update_value(id, val, proc)
{
	var urlpost = baseUrl+"Get_Details/update_value";
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


/* Edid Category in Product Master Panel */

function edit_category_details(id, cat_parent_id, name, stat, level, img)
{
	let url = baseUrl+'images/category/'+id+'/s/'+img;
	$("#cat_name").focus();;
	$("#cat_id").val(id); 
	$("#cat_parent_id").val(cat_parent_id); 
	$("#cat_name").val(name);
	$("#cat_level").val(level);
	$("#ddstatus").val(stat);
	$("#cat_img").attr('src',url);
	if(id === '0'){
		$("#submit").attr('name','add'); 
		$("#submit").text('Add');  
		} else {
		$("#submit").attr('name','update'); 
		$("#submit").text('Update'); 
	}
}

/* Set Category in Product Master Panel */

function set_category(get_id)
{
	var urlpost = baseUrl+txtclass+"/set_category";
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
		success: function(msg) {
			$.unblockUI;
			//bootbox.alert(msg);
			window.location.href = baseUrl+txtclass+"/"+txtmethod;
		}
	});
}

/* Edid Location in Product Master Panel */

function edit_location_details(id, loc_parent_id, name, stat, level)
{
	$("#loc_name").focus();;
	$("#loc_id").val(id); 
	$("#loc_parent_id").val(loc_parent_id); 
	$("#loc_name").val(name);
	$("#loc_level").val(level);
	$("#ddstatus").val(stat);
	if(id === '0'){
		$("#submit").attr('name','add'); 
		$("#submit").text('Add');  
		} else {
		$("#submit").attr('name','update'); 
		$("#submit").text('Update'); 
	}
}

/* Set Location in Product Master Panel */

function set_location(get_id)
{
	var urlpost = baseUrl+txtclass+"/set_location";
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
		success: function(msg) {
			$.unblockUI;
			//bootbox.alert(msg);
			window.location.href = baseUrl+txtclass+"/"+txtmethod;
		}
	});
}

/* Edid Location in Product Master Panel */

function edit_group_location_details(id, loc_parent_id, name, stat, level)
{
	$("#loc_name").focus();;
	$("#loc_id").val(id); 
	$("#loc_parent_id").val(loc_parent_id); 
	$("#loc_name").val(name);
	$("#loc_level").val(level);
	$("#ddstatus").val(stat);
	if(id === '0'){
		$("#submit").attr('name','add'); 
		$("#submit").text('Add');  
		} else {
		$("#submit").attr('name','update'); 
		$("#submit").text('Update'); 
	}
}
/* Set Group Location in Product Master Panel */

function set_location_group(get_id)
{
	var urlpost = baseUrl+txtclass+"/set_group_location";
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
		success: function(msg) {
			$.unblockUI;
			//bootbox.alert(msg);
			window.location.href = baseUrl+txtclass+"/"+txtmethod;
		}
	});
}