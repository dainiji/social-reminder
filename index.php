<!DOCTYPE html>
<html>
<head>
	<title>WhatsApp API Project</title>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>

	<script type="text/javascript" src="js/datetimepicker/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css" />
	<link rel="stylesheet" type="text/css" href="css/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" >
    
</head>
<body>
	<div class="container">
		<div class="row">
			
			<h2>Enter list of names and Phone numbers / Messenger id</h2>
			<div class="col-md-5">
				<p>
					Enter list of names and phone numbers e.g <br/>
					Joe; 917563564867 <br/> 
					Mike; 322345647895
				</p>
				<p>First two digits of phone number must be country code</p>
			</div>
			<div class="col-md-2">
				<h3><strong>OR</strong></h3>
			</div>
			<div class="col-md-5">
				<p>
					Enter list of names and Messenger id e.g <br/>
					Daini; dainiDev <br/> 
					Mike; mikeCoder
				</p>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-12">
				<form name="contact-form" method="post" action="save.php">
					<input type="hidden" name="action" value="POST" />
					<div class="form-group">
						<label for="contactList">Enter Name/Phone List <strong>OR</strong> Enter Name/Messenger id</label>
						<textarea required name="contactList" class="form-control" id="contactList" rows="3"></textarea>
					</div>
					<div class="form-group">
						<label for="message">Message</label>
						<textarea required name="message" class="form-control" id="message" rows="3"></textarea>
					</div>

					<button type="submit" class="btn btn-primary">Add to List</button>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h3 style="margin-top: 20px">Contact List</h3>
				<table id="contact-list" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th style="display:none"></th>
							<th>Name</th>
							<th style="min-width: 150px;">Phone / Messenger</th>
							<th style="max-width: 450px;">Message</th>
							<th style="min-width: 150px;">Date</th>
							<th>Contact</th>
							<th>Status</th>
							<th style="min-width: 100px;">Actions</th>
							
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th style="display:none"></th>
							<th>Name</th>
							<th>Phone / Messenger</th>
							<th style="max-width: 450px;">Message</th>
							<th>Date</th>
							<th>Contact</th>							
							<th>Status</th>
							<th>Actions</th>
							
						</tr>
					</tfoot>
					<tbody id="tableBody"></tbody>
				</table>
			</div>
		</div>
		<div>
			<form id="deleteForm" name="delete-form" method="post" action="save.php">
				<input type="hidden" name="id" value="" />
				<input type="hidden" name="action" value="DELETE" />
			</form>
		</div>
		<div id="editModal" class="modal" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="updateForm" name="update-form" method="post" action="save.php">
							<input type="hidden" name="id" value="" />
							<input type="hidden" name="action" value="PATCH" />
							<div class="form-group">
								<label for="contactName">Name</label>
								<input type="text" required name="name" class="form-control" id="contactName"/>
							</div>
							<div class="form-group">
								<label for="contactPhone">Phone / Messenger Id</label>
								<input type="text" required name="phone" class="form-control" id="contactPhone"/>
							</div>

							<div class="form-group">
								<label for="message">Message</label>
								<textarea required name="message" class="form-control" id="message" rows="3"></textarea>
							</div>

							<div class="form-group">
								<label for="status">Status</label>
								<select name="status" class="form-control" id="status">
									<option value="pending">Pending</option>
									<option value="contacted">Contacted</option>
								</select>
							</div>
							
							
							<div class="input-group date set_datetime col-md-5" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dateTime">
                    			<input class="form-control" style="min-width:350px" type="text" value="" readonly>
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                			</div>
							<input type="hidden" id="dateTime" name="dateTime" value="" /><br/>
						
							

						</form>
					</div>
					<div class="modal-footer">
						<button id="updateRecord" type="button" class="btn btn-primary">Save changes</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>


		<!-- Set Date Time Modal -->
		<div id="setDateTimeModal" class="modal" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Set date Time</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="input-group date set_datetime col-md-5" data-date-format="dd MM yyyy - HH:ii p" data-link-field="date_time">
                    	<input class="form-control" style="min-width:350px" type="text" value="" readonly>
							<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                		</div>
						<input type="hidden" id="date_time" value="" /><br/>
						
					</div>
					<div class="modal-footer">
						<input type="hidden" id="update_date_id" value="">
						<button id="saveDateBtn" type="button" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>


	</div>
	<script type="text/javascript">
		var records;

		var getLinkWhatsApp = function(record) {
			var message = record['message'].replace('{name}', record['name']);
			message = message.replace('{date}', record['messageDate']);
			return 'https://api.whatsapp.com/send?phone='+record['phone']+'&text='+message;
		};

		var getStatus = function(record) {
			var status = ''
			if(record['status'] === 'pending') {
				status = '<span class="badge badge-primary">Pending</span>';
			} else if (record['status'] === 'contacted') {
				status =  '<span class="badge badge-danger">Contacted</span>';
			}

			return status;
		};

		var renderRows = function(data) {
			var elements = '';
			data.forEach(function(record) {
				if("dateTime" in record){
					if(record['diffrence'] < 10800 && record['diffrence'] > 0 && record['status']!== "contacted" ){
						var due_date = "<strong><span style='color:#F00'>"+record['niceDate']+"</span></strong>";
					} else {
						var due_date = "<span style='color:#000'>"+record['niceDate']+"</span>";
					}
				} else {
					var due_date = "Not Available";
				}
				if($.isNumeric(record['phone'])){
				//var link = '<a data-id="'+record['id']+'" target="_blank" href="'+ getLinkWhatsApp(record) +'" class="changeStatus btn btn-sm btn-success"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>';
					var link = '<a data-id="'+record['id']+'" target="_blank" href="javascript:window.open(\''+ getLinkWhatsApp(record) +'\' , \'WhatsApp Login \', \'width=800,height=600,top=150,left=200\')" class="changeStatus btn btn-sm btn-success"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>';
				
				} else {
					var link = "<a data-id='"+record['id']+"' class='changeStatus' href='javascript:window.open(\"https://messenger.com/t/"+record['phone']+"\", \"Social Login\",\"width=800,height=600,top=150,left=200\")' ><img src='images/messanger.png' style='width:30px;'></a>";
				}
				elements += `<tr>
					<td style="display:none">`+record['updated_at']+`</td>
					<td>`+record['name']+`</td>
					<td>`+record['phone']+`</td>
					<td>`+record['message']+`</td>
					<td>`+due_date+`</td>
					<td>`+link+`</td>
					<td class="status">`+getStatus(record)+`</td>
					<td>
						<button data-toggle="modal" data-target="#editModal" data-id='`+record['id']+`' class="btn btn-sm btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button> &nbsp;
						<button data-id="`+record['id']+`" class="setDate btn btn-sm btn-success"><i class="fa fa-calendar" aria-hidden="true"></i></button>
						<button data-id="`+record['id']+`" class="deleteRecord btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>

					</td>
				</tr>`;
			});
			
			// This section is to show latest record on top by default when datatabe created it shows order by asc but we need order by desc
			// We have error / warning from datatable when we use datatabe with order option
				// Error
				//	DataTables warning: table id=contact-list - Cannot reinitialise DataTable. For more information about this error, please see http://datatables.net/tn/3
				//
			
			if($("#tableBody").html() == ""){  // Check if tbody is empty using datatable funstion first time,  then use ->  DataTable({"order": [[ 0, 'desc' ]]});
				$("#tableBody").html(elements);
				$('#contact-list').DataTable({"order": [[ 0, 'desc' ]]});				
			} else {				// if tabel already created by datatabe then do not use this option 
				$("#tableBody").html(elements);
				$('#contact-list').DataTable();  
			}		
			


				
			
		};

		$(document).ready(function() {

			$.post('ajax.php', {action:'GET'}, function(responce) {
				var resp = JSON.parse(responce);
				if(resp.status) {
					var data = resp.data;
					records = data;
					
					renderRows(records);
				}
				
			});

			$('#editModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id') // Extract info from data-* attributes
                var record;
                records.forEach(function(r) {
                	if(r['id'] == id) {
                		record = r;
                		return;
                	}
                });
                console.log(records);
                var modal = $(this)
                modal.find('.modal-body input[name="id"]').val(record.id);
                modal.find('.modal-body input[name="name"]').val(record.name);
                modal.find('.modal-body input[name="phone"]').val(record.phone);
                modal.find('.modal-body textarea[name="message"]').val(record.message);
                modal.find('.modal-body select[name="status"]').val(record.status);
                modal.find('.modal-body input[name="dateTime"]').val(record.dateTime);
            });

			$("form[name='contact-form']").submit(function(e){
				e.preventDefault();

				var contactList = $("textarea[name='contactList']").val();
				var contacts = contactList.split('\n');
				console.log(contacts)

				contacts.forEach(function(pair) {
					var namePhonePair = pair.split(';');

					if(namePhonePair.length !== 2) {
						alert('Please enter valid Name:Phone pair')
					}

					if($.isNumeric(namePhonePair[1])){
						console.log("This is a phone number now check if valied phone number")
						if( !(/^[0-9]{12,15}$/.test(namePhonePair[1].trim())) ) {
							alert('Please enter phone number with country code. Remove + or any other special charaters. Ref: ' + namePhonePair[1].trim());
						}
					} else {
						console.log("This is messenger id");
					}
				});

				var data = $( this ).serializeArray();

				$.post('ajax.php', data , function(responce) {
					var resp = JSON.parse(responce);
					if(resp.status) {
						var data = resp.data;
						records = data;
						
						renderRows(records);
						alert(contacts.length +' new contacts added.')
					}
				});				
			});

			$(document).on('click', '#updateRecord', function() {
            	var form = $("form#updateForm");
            	var phone = form.find('input[name="phone"]').val();
            	var modal = $("#editModal");

            	

            	if($.isNumeric(phone) && !(/^[0-9]{12,15}$/.test(phone.trim())) ){
            		alert('Please enter phone number with country code. Remove + or any other special charaters');
            	} else {
					var data = $(form).serializeArray();

					$.post('ajax.php', data , function(responce) {
						var resp = JSON.parse(responce);
						if(resp.status) {
							var data = resp.data;
							records = data;
							
							renderRows(records);
							modal.modal('hide');
						}
					});
				}
            });

            $(document).on('click', '.deleteRecord', function() {
            	var form = $("#deleteForm");
            	var id = $(this).data('id');
            	var r = confirm("Are you sure!");

            	if (r == true) {
            		form.find('input[name="id"]').val(id);
            		var data = $(form).serializeArray();

					$.post('ajax.php', data , function(responce) {
						var resp = JSON.parse(responce);
						if(resp.status) {
							var data = resp.data;
							records = data;
							
							renderRows(records);
						}
					});
            	}
            });


            $(document).on('click', '.changeStatus', function() {
            	var self = $(this).parent('td').parent('tr').find('td.status');
            	var id = $(this).data('id');
           
            	$.post('ajax.php', {id: id, action: 'STATUSPATCH'}, function(responce) {
            		var resp = JSON.parse(responce);
            		if(resp.status) {
            			var data = resp.data;
            			records = data;

            			renderRows(records);
            		}
            	});
            });

            // Set Date time Functionality Start
            $(document).on('click', '.setDate', function() {
            	$("#update_date_id").val($(this).data('id'));
				$("#setDateTimeModal").modal("show");
            });

            $(document).on('click',"#saveDateBtn", function(){
        		var modal = $("#editModal");
            	$.ajax({url: "ajax.php",
            		type: 'POST', 
            		dataType: 'json',
            		data: {
            			'action' : "udateDateTime",
            			'id' : $("#update_date_id").val(),
            			'dateTime' : $("#date_time").val(),
            		},
            		success: function(responce){
						if(responce.status) {
							records = responce.data;
							renderRows(records);
							$("#setDateTimeModal").modal("hide");
						}
    				}
    			});

            });

            $('.set_datetime').datetimepicker({
    		    //language:  'fr',
    		    weekStart: 1,
    		    todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				forceParse: 0,
    		    showMeridian: 1
    		});

		});

	</script>
</body>
</html>