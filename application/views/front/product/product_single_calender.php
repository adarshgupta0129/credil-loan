<link rel="stylesheet" href="<?php echo base_url() ?>application/libraries/assets/plugins/fullcalendar/css/fullcalendar.min.css"/>

<div class="modal fade" id="calenderModal" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content" id="calenderModalView">
			<div id='calendar'></div> 
		</div>      
	</div>
</div>

<div class="modal fade" id="slotModel" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="dayTitle">Select Slot</h4>
			</div>
			<div class="modal-body">
				<h4 class="modal-title" id="dayTitle">Delivery Charges-</h4>
				<div class="row">
					<center>
						<div class="col-md-12">
							<ul class="slot" id="slotTiming">
								<li class="timeslottable">
									<input type="radio" class="input-group-field " name="selectTimeSlot" id="selectTimedSlot1"/>
									<label>
										<span id="timeRange">07:00 - 21:00</span>&nbsp;
										<span class="hrs"> hrs</span>
									</label>
								</li> 
								<li class="timeslottable">
									<input type="radio" class="input-group-field " name="selectTimeSlot" id="selectTimewSlot1"/>
									<label>
										<span id="timeRange">07:00 - 21:00</span>&nbsp;
										<span class="hrs"> hrs</span>
									</label>
								</li> 
								<li class="timeslottable">
									<input type="radio" class="input-group-field " name="selectTimeSlot" id="selectTimreSlot1"/>
									<label>
										<span id="timeRange">07:00 - 21:00</span>&nbsp;
										<span class="hrs"> hrs</span>
									</label>
								</li> 
							</ul>
						</div>
					</center>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="save-event">Confirm</button>
			</div>
		</div> 
	</div> 
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment-with-locales.js"></script>
<script src="<?php echo base_url() ?>application/libraries/assets/plugins/fullcalendar/js/fullcalendar.min.js"></script>

<script>
	$(document).ready(function() {		
		$('#calenderModalView').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right:''
			},
			defaultDate: new Date(),
			minDate: new Date(),
			navLinks: false, // can click day/week names to navigate views
			selectable: true,
			droppable: false,
			disableDragging: false,
			editable: false,
			startEditable: false,
			dragScroll: false,
			eventStartEditable: false,
			selectHelper: false,
			select: function(start, end) {
				var d1 = new Date();
				var d2 = new Date(end);
				if(d1.getTime() <= d2.getTime()){
				//	$('#calenderModal').css('opacity','0.3');						
					//$('#slotModel').modal('show');	
					getSlotTiming(end);
				}
			},
			eventLimit: true // allow "more" link when too many events					
		});
	});
	
	function getSlotTiming(end)
	{
		var urlpost = baseUrl+"Get_Details/get_slot_timing";
	//alert(urlpost);
		$.ajax({
			type: "POST",
			url : urlpost,
			dataType : 'JSON',
			data:{"date": end},
			beforeSend : function(){
				$.blockUI({
					message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
				});
			}, 
			success: function(msg){
				$.unblockUI();
				console.log(msg);
				//setSlotTiming(msg);
				}
			});
	}
	function setSlotTiming(timing)
	{
/* 		var html_code = '';
		
		html_code += '<tr id="row_id_'+count+'">';
		html_code += '<td id="'+count+'">'+count+'</td>';
		html_code += '<td><input type="file" id="userfile'+count+'" class="variant_img" name="userfile[]" onchange="get_vari_image(this)" />';
		html_code += '</td>';
		html_code += '<td style="display: inline-flex;"><input type="text" id="variant_unit" name="variant_unit[]" class="form-control" /> &nbsp;';
		html_code += '<select class="form-control" name="ddunit[]" id="ddunit'+count+'" class="prod_add_select_weight"><?php foreach($units as $unit) { ?><option value="<?= $unit->unit_id; ?>"><?= $unit->unit_name; ?></option><?php } ?></select></td>';
		html_code += '<td><input type="number" value="'+amt+'" id="variant_amt'+count+'" class="form-control" name="variant_amt[]" /></td>';
		html_code += '<td><input type="number" value="'+show_amt+'" id="variant_show_amt'+count+'" class="form-control" name="variant_show_amt[]" /></td>';
		html_code += '<td><button type="button" name="remove_row" id="'+count+'" onclick="remove_tr(this,'+count+')" class="btn btn-danger btn-xs remove_row">X</button></td>';
		html_code += '</tr>';
		$('#slotTiming').after(html_code); */
	}
</script>

<style>
	#slotModel ul.slot {
    margin: 0 auto;
    text-align: center;
    width: 100%;
    list-style-type: none;
}

#slotModel ul li {
    max-width: 100%;
    list-style: none;
}
#slotModel .timeslottable {
    margin: 15px auto;
    border: 1px solid #CCC;
    border-radius: 5px;
    padding: 9px 40px 0px 40px;
}
	
</style>