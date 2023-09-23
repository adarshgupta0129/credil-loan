
if(localStorage.getItem('LS_pincode') != null){
	set_pincode(localStorage.getItem('LS_pincode'));
}
var pin = localStorage.getItem("LS_pincode");
if(pin != ''){
	set_pincode(pin);
	}
/* GET VALUE FROM GET METHOD */
function get(q) {
    s = window.location.href;
	var url = new URL(s);
	return url.searchParams.get(q);
}


/* SET PINCODE IN GET METHOD */

function set_pincode(pincode) {	
		full_url.set("pincode", pincode);
 		history.replaceState(null, null, "?"+full_url.toString());
		localStorage.setItem('LS_pincode',pincode);
 		$('#pincode').val(localStorage.getItem('LS_pincode'));
		$('#pincode1').val(localStorage.getItem('LS_pincode'));
		$('#pincode2').val(localStorage.getItem('LS_pincode'));
 		get_pincode_data(localStorage.getItem('LS_pincode'));
}

/* GET DATA ACCORDING TO PINCODE */

function get_pincode_data(pincode){
//	alert(pincode);
	
}

setTimeout(function(){ $('.alert1').hide() }, 5000);


