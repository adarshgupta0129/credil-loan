/* GET URL OF QUERY STRING */
var full_url = new URLSearchParams(window.location.search);


/******     CUSTOMER REGISTRATION 		******/

function registration(get_id) {
	var urlpost = baseUrl + txtclass + "/register_candidate";
	var term = $('#txtterm').is(':checked');
	if (check(get_id)) {
		if (term == true) {
			$("#function").html("<div>Registration has been processed.</div>");
			$.ajax({
				type: "POST",
				url: urlpost,
				data: $('#' + get_id).serialize(),
				beforeSend: function () {
					$.blockUI(
						{
							message: '<img src="' + baseUrl + 'application/libraries/loading.gif" />'
						});
				},
				success: function (msg) {
					$.unblockUI();
					if (msg != "") {
						$("#" + get_id).html("<center><h2>Welcome to V Credil Loan, </h2></br><h4>" + msg + "</h4><p><a href='" + baseUrl + txtclass + "/registration' class='btn btn-info btn-xs'>Click Here</a></p></center>")
					}
					else {
						bootbox.alert("Some Error on this page!!");
					}
				}
			});
		}
		else {
			bootbox.alert("Plaese Check term and Condition!");
		}
	}
}

function login_mobile_change(ref) {
	if (ref.value.length != 10)
		bootbox.alert("Mobile Number is Not Valid");
	else {
		$.ajax({
			type: "POST",
			url: baseUrl + txtclass + "/register_otp_send",
			data: { mobile: ref.value },
			beforeSend: function () {
				$.blockUI({ message: '<img src="' + baseUrl + 'application/libraries/loading.gif" />' });
			},
			success: function (res) {
				$.unblockUI();
				res = JSON.parse(res);
				if (res.status == "1")
					bootbox.alert("Otp Send Successfully!");
			}
		});
	}
}


/* Change Status */

function change_user_status(id, status, proc) {
	var urlpost = baseUrl + "Get_Details/change_user_status";
	$.ajax({
		type: "POST",
		url: urlpost,
		data: { "id": id, "status": status, "proc": proc },
		beforeSend: function () {
			$.blockUI({
				message: '<img src="' + baseUrl + 'application/libraries/loading.gif" />'
			});
		},
		success: function (msg) {
			$.unblockUI();
			window.location.href = baseUrl + txtclass + "/" + txtmethod + "?" + full_url;
		}
	});
}

/* Update One value */

function update_user_value(id, val, proc) {
	var urlpost = baseUrl + "Get_Details/update_user_value";
	$.ajax({
		type: "POST",
		url: urlpost,
		data: { "id": id, "val": val, "proc": proc },
		beforeSend: function () {
			$.blockUI({
				message: '<img src="' + baseUrl + 'application/libraries/loading.gif" />'
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

$('.password').on('click', function () {
	$(this).find(".pass_hide").toggle();
	$(this).find(".pass_show").toggle();
});
/*
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
*/
function get_data(u_id) {
	var id = u_id;
	$.ajax({
		url: '/Userprofile/member_address_data',
		type: 'POST',
		dataType: "json",
		data: {
			id: id,
		},
		success: function (data) {
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
function delete_data(u_id) {
	var id = u_id;
	if (confirm("Are you sure you want to delete ?")) {
		$.ajax({
			url: '/Userprofile/member_address_delete',
			type: 'POST',
			dataType: "json",
			data: {
				id: id,
			},
			success: function (response) {
				if (response.status == true) {
					alert(response.message);
					setTimeout(function () {
						location.reload();
					}, 1000);
				}
			}
		});
	}
	else {
		return false;
	}

}
function remove(id) {
	$.ajax({
		url: baseUrl + "welcome/remove_product",
		type: "post",
		dataType: "json",
		data: {
			id: id,
		},
		success: function (data) {
			if (data == "1") {
				location.reload(true);
			} else {
				alert('somthing wrong');
			}
		},

	});

}


function stat() {
	var stateid = $('#state').val();

	if (stateid != '') {
		$.ajax({
			url: baseUrl + "welcome/fetch_city",
			method: "POST",
			data: { stateid: stateid },
			success: function (data) {
				$('#city').html(data);
			}
		});
	}
	else {
		$('#city').html('<option value="">Select City</option>');
	}
}

function verify_mobile() {
	var txtmobile = $("#txtmobile").val();
	if (txtmobile.length == 10) {
		if ($("#txtmobile").val().match(/^[0-9]+$/)) {
			$.ajax({
				type: "POST",
				url: baseUrl + "Get_details/verify_mobile_regis",
				data: { 'txtmobile': txtmobile },
				beforeSend: function () {
					$.blockUI(
						{
							message: '<h1><img src="' + baseUrl + 'application/libraries/loading36.gif" /> Please Wait ...</h1>'
						});
					setTimeout($.unblockUI, 1000);
				},
				success: function (msg) {
					if (msg.trim() == '1') {
						$("#txtotp").focus();
						$('#custom-modal').modal({
							backdrop: 'static',
							keyboard: false
						});
					}
					else {
						$("#divtxtmobile").html("Same mobile number can be use only 3 times!");
						$("#txtmobile").val('');
					}

				}
			});
		}
		else {
			bootbox.alert("Enter valid mobile number!");
		}
	}
	else if (txtmobile.length > 10) {
		$("#txtmobile").val(txtmobile.substr(0, 10));
		console.log(txtmobile.substr(0, 4));
	}
}
function verify_otp(get_id) {
	if (check(get_id)) {
		var txtotp = $("#txtotp").val();
		$.ajax({
			type: "POST",
			url: baseUrl + "get_details/verify_otp_regis",
			data: { 'txtotp': txtotp },
			success: function (msg) {
				if (msg.trim() == '1') {
					$("#txtemail").focus();
					$("#divtxtmobile").html("<i class='fa fa-check success'></i> &nbsp; verified mobile number");
					$("#txtmobile").attr("readonly", "readonly");
					$('#custom-modal').modal("hide");
				}
				else {
					bootbox.alert("Incorrect OTP !");
				}
			}
		});
	}
}

function get_city() {
	var ddstate = $("#ddstate").val();
	var ocity = $("#hdocity").val();
	if (ddstate != "-1") {
		$.ajax(
			{
				type: "POST",
				url: baseUrl + "Get_Details/get_city",
				dataType: 'json',
				data: { 'ddstate': ddstate },
				beforeSend: function () {
					$.blockUI(
						{
							message: '<img src="' + baseUrl + 'application/libraries/loading.gif" />'
						});
					setTimeout($.unblockUI, 1000);
				},
				success: function (msg) {
					$("#ddcity").empty();
					$("#ddcity").append("<option value=-1>Select City</option>");
					$.each(msg.rec, function (i, item) {
						if (ocity != "") {
							if (item.loc_id == ocity) {
								$('#ddcity').append("<option value=" + item.loc_id + " selected>" + item.loc_name + "</option>");
							}
							else {
								$('#ddcity').append("<option value=" + item.loc_id + ">" + item.loc_name + "</option>");
							}
						}
						else {
							$('#ddcity').append("<option value=" + item.loc_id + ">" + item.loc_name + "</option>");
						}
					});
				}
			});
	}
}

/******************************** Rishi Code  ****************************/

/********************************** Get Loan Plan *******************************/
function get_loan_plan(id) {
	$.ajax(
		{
			type: "GET",
			url: baseUrl + "Get_Details/get_loan_plan/" + id,
			dataType: 'json',
			beforeSend: function () {
				$.blockUI(
					{
						message: '<img src="' + baseUrl + 'application/libraries/loading.gif" />'
					});
				setTimeout($.unblockUI, 500);
			},
			success: function (msg) {
				$("#ddloanplan").empty();
				$("#ddloanplan").append("<option value=-1>Select Loan Plan</option>");
				$.each(msg.rec, function (i, item) {
					$('#ddloanplan').append("<option value=" + item.ln_plan_id + ">" + item.ln_plan_name + "</option>");
				});
			}
		});
}
/********************************** End Loan Plan *******************************/

/********************************* Submit Loan Plan ***************************/

function add_loan(id) {
	$.ajax(
		{
			url: baseUrl + "Get_Details/check_loan_amt/" + id,
			dataType: 'json',
			success: function (msg) {
				// console.log(msg);
				$("#hf_max").val(msg['ln_plan_max_amount']);
				$("#hf_min").val(msg['ln_plan_min_amount']);
				$("#txtinterst").val(msg['ln_plan_annual_interest']).prop("readonly", true);
				$("#txtcharges").val(msg['ln_plan_proc_fee_percent']).prop("readonly", true);
			}
		});
}

// function add_loan() {
// 	if (check('add_loan')) {
// 		var formData = new FormData(this);

// 		$.ajax({
// 			url: baseUrl + "Get_Details/check_loan_amt",
// 			type: "post",
// 			data: formData,
// 			dataType: "json",
// 			processData: false,
// 			contentType: false,

// 			success: function (response) {
// 				$('#loadingOverlay').hide();
// 				if (response['status']) {
// 					swal(response['msg'], {
// 						icon: "success",
// 					}).then((willDelete) => {
// 						if (willDelete) {
// 							$('#vehicle_form_insert input, #vehicle_form_insert select, #vehicle_form_insert textarea').each(function () {
// 								if ($(this).is('select')) {
// 									$(this).val(0);
// 								} else {
// 									$(this).val("");
// 								}
// 							});
// 							get_data();
// 							$("#divfd_img").html("");
// 							$(".MultipleRecord").find('.duplicate-row').not(':first').remove();
// 						} else {
// 							window.location.reload();
// 						}
// 					});
// 				} else {
// 					if (response['msg'] == 'error') {
// 						$("#divfd_img").html("Please upload some image.!");
// 					} else {
// 						Swal.fire({
// 							icon: 'error',
// 							title: 'Oops...',
// 							text: 'Something went wrong!'
// 						});
// 					}
// 				}
// 			}
// 		});
// 	} else {
// 		return false;
// 	}
// }
// $('#add_loan').submit(function (event) {
// 	event.preventDefault();
// 	alert("hello");
// 	if (check('add_loan')) {
// 		var formData = new FormData(this);

// 		$.ajax({
// 			url: baseUrl + "Get_Details/check_loan_amt",
// 			type: "post",
// 			data: formData,
// 			dataType: "json",
// 			processData: false,
// 			contentType: false,

// 			success: function (response) {
// 				$('#loadingOverlay').hide();
// 				if (response['status']) {
// 					swal(response['msg'], {
// 						icon: "success",
// 					}).then((willDelete) => {
// 						if (willDelete) {
// 							$('#vehicle_form_insert input, #vehicle_form_insert select, #vehicle_form_insert textarea').each(function () {
// 								if ($(this).is('select')) {
// 									$(this).val(0);
// 								} else {
// 									$(this).val("");
// 								}
// 							});
// 							get_data();
// 							$("#divfd_img").html("");
// 							$(".MultipleRecord").find('.duplicate-row').not(':first').remove();
// 						} else {
// 							window.location.reload();
// 						}
// 					});
// 				} else {
// 					if (response['msg'] == 'error') {
// 						$("#divfd_img").html("Please upload some image.!");
// 					} else {
// 						Swal.fire({
// 							icon: 'error',
// 							title: 'Oops...',
// 							text: 'Something went wrong!'
// 						});
// 					}
// 				}
// 			}
// 		});
// 	} else {
// 		return false;
// 	}
// });
/********************************* End Submit Loan Plan ***************************/

/********************************** End Code Rishi *****************************/



/*----------------Script For Export to excel------------------------*/

function exportTableToExcel(tableID, filename = '') {
	var downloadLink;
	var dataType = 'application/vnd.ms-excel';
	var tableSelect = document.getElementById(tableID);
	var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

	// Specify file name
	filename = filename ? filename + '.xls' : 'excel_data.xls';

	// Create download link element
	downloadLink = document.createElement("a");

	document.body.appendChild(downloadLink);

	if (navigator.msSaveOrOpenBlob) {
		var blob = new Blob(['\ufeff', tableHTML], {
			type: dataType
		});
		navigator.msSaveOrOpenBlob(blob, filename);
	} else {
		// Create a link to the file
		downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

		// Setting the file name
		downloadLink.download = filename;

		//triggering the function
		downloadLink.click();
	}
}



