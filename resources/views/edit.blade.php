<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Full Calendar Demo - Edit Event</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- css -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.min.css">
		<link rel="stylesheet" href="{{ URL::asset('/css/scheduler.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('/css/jquery-ui.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('/css/fullcalendar.css') }}">

        <!-- js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.4/ckeditor.js"></script>
		<script src="{{ URL::asset('/js/scheduler.min.js') }}"></script>
		<script src="{{ URL::asset('/js/lang/de.js') }}"></script>
        <script>
            var DISPLAY_DATE_FORMAT = 'DD-MMM-YYYY';
            var JSON_DATE_FORMAT = 'YYYY-MM-DD';
            var tempEventObj;
			
            function setModalDate(startDate, endDate) {
                var displayStartDate, displayEndDate, jsonStartDate, jsonEndDate;

                displayStartDate = moment(startDate).format(DISPLAY_DATE_FORMAT)
                jsonStartDate = moment(startDate).format(JSON_DATE_FORMAT);

                if(endDate != null) {
                    displayEndDate = moment(endDate).format(DISPLAY_DATE_FORMAT);
                    jsonEndDate = moment(endDate).format(JSON_DATE_FORMAT);
                }
                else {
                    displayEndDate = displayStartDate;
                    jsonEndDate = jsonStartDate;
                }

                $('#display-start').val(displayStartDate);
                $('#display-end').val(displayEndDate);
                $('#start').val(jsonStartDate);
                $('#end').val(jsonEndDate);
            }

            function clearModal() {
                $('#id, #title, #details, #display-start, #display-end, #start, #end').val('');
                $('#error').css({'display': 'none'})
            }

            function validateInput() {
                var flag = true;

                flag = $('#title').val() != '' && $('#details').val() != ''
                        && (moment($('#start').val()).isBefore($('#end').val())
                        || moment($('#start').val()).isSame($('#end').val()));

                return flag;
            }

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#calendar').fullCalendar({
                    displayEventTime: false,
                    allDay: true,
					resources: 'api/events/resources',
                    events: 'api/events/all',					
					timeFormat: 'H(:mm)',
					displayEventTime: true,
					editable: true,
					selectable: true,
					selectHelper: true,
					defaultView: 'agendaWeek',
					businessHours: {
						start: '08:00',
						end: '18:00',
					},
					eventRender: function(event,element) {
						element.find('.fc-title').append("<br/>" + event.details + "<br/> Raum: " + event.roomname + "<br/> (" + event.building + ")");
					},
                    dayClick: function(date, jsEvent, view) {
                        clearModal();
                        setModalDate(date);
                        $('#modalTitle').text('Neuen Event anlegen' );
                        $('#btnDel').css({display: 'none'});
						$('#starttime').val('');
						$('#endtime').val('');
						$('#room').val(1);
                        $('#modalCalendar').modal('show');
                    },
                    eventClick: function(calEvent, jsEvent, view) {
                        tempEventObj = calEvent;
                        setModalDate(calEvent.start, calEvent.end);
                        $('#modalTitle').text('Event editieren');
                        $('#id').val(calEvent.id);
                        $('#title').val(calEvent.title_real);
						$('#starttime').val(calEvent.starttime);
						$('#endtime').val(calEvent.endtime);
                        $('#details').val(calEvent.details);
						$('#room').val(calEvent.resourceId);
                        $('#btnDel').css({display: 'inline'});
                        $('#modalCalendar').modal('show');
                    },
					select: function(start, end) {
						$('#modalTitle').text('Neuen Event anlegen' );
						var x = 1;
						var hour = "";
						var m = "";
						var startdate = start._i[0] + "-" + start._i[1] + "-" + start._i[2];
						var enddate = end._i[0] + "-" + end._i[1] + "-" + end._i[2];
						setModalDate(startdate, enddate);
						if(start._i[3] < 10) {
							hour = "0" + start._i[3];
						} else {
							hour = start._i[3];
						}
						if(start._i[4] < 10) {
							m = "0" + start._i[4];
						} else {
							m = start._i[4];
						}
						var starttime = hour + ":" + m;

						if(end._i[3]<10) {
							hour = "0" + end._i[3];
						} else {
							hour = end._i[3];
						}
						if(end._i[4]<10) {
							m = "0" + end._i[4];
						} else {
							m = end._i[4];
						}

						var endtime = hour + ":" + m;
						$('#starttime').val(starttime);
						$('#endtime').val(endtime);
						$('#room').val(1);
						$('#btnDel').css({display: 'none'});
						$('#modalCalendar').modal('show');
					},
                    eventMouseover: function() {
                        $(this).css({'cursor': 'pointer'});
                    },
                    customButtons: {
                        home: {
                            text: 'Home',
                            click: function() {
                                location.href = '{{ url('/') }}';
                            }
                        }
                    },
                    header: {
						left: 'prev,next today',
						center: 'title',
                        //right: 'editEvent,agendaWeek,month,agendaDay'
                        right: 'home agendaWeek today',
                    }                                 
                });

                $('#display-start, #display-end').datepicker({
                    format: 'dd-M-yyyy',
                    todayHighlight:'TRUE',
                    autoclose: true,
                    forceParse: false
                });

                $('#display-start, #display-end').change(function() {
                    var date = moment(this.value).format(JSON_DATE_FORMAT);

                    if(this.id == 'display-start') {
                        $('#start').val(date);
                    }
                    else {
                        $('#end').val(date);
                    }
                });

                $('#btnSave').click(function() {
                    $('#error').css({'display': 'none'})

                    if(!validateInput()) {
                        $('#error').css({'display': 'block'})
                        return;
                    }

                    var data = $('#eventForm').serialize();

                    $.ajax({
                        url: 'api/events/set',
                        method: 'POST',
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            $('#calendar').fullCalendar('refetchEvents');
                            $('#modalCalendar').modal('hide');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $('#error').css({'display': 'block'})
                        }
                    });
                });

                $('#btnDel').click(function() {
                    var data = {id: $('#id').val()};

                    $.ajax({
                        url: 'api/events/delete',
                        method: 'POST',
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            $('#calendar').fullCalendar('refetchEvents');
                            $('#modalCalendar').modal('hide');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                        }
                    });
                });

            });
        </script>
    </head>
    <body>
        <div class="container">        
            <div id="calendar"></div>
        </div>
        <div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="modalTitle">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalTitle">Title</h4>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <form id="eventForm">
                            <input type="hidden" name="id" id="id">
                            <div class="control-group has-error" id="error" style="display: none">
                                <label class="control-label">Please fill in the form properly!</label>
                            </div>
                            <div class="form-group">
                                <label>Title</label>                    
                                <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label>Start Datum</label>                    
                                <input type="text" name="display-start" id="display-start" class="form-control" placeholder="Start Date">
                                <input type="hidden" name="start" id="start">
                            </div>
                            <div class="form-group">
                                <label>End Datum</label>                    
                                <input type="text" name="display-end" id="display-end" class="form-control" placeholder="End Date">
                                <input type="hidden" name="end" id="end">
                            </div>
                             <div class="form-group">
                                <label>Startzeit</label>                    
                                <input type="time" name="starttime" id="starttime" class="form-control" placeholder="HH:mm">
                            </div>
                            <div class="form-group">
                                <label>Endzeit</label>                    
                                <input type="time" name="endtime" id="endtime" class="form-control" placeholder="HH:mm">
                            </div>
                            <div class="form-group">
								<label>Räume</label>
								<select name="room" id="room" class="room">
									<option value="1">Hörsaal 1</option>
									<option value="2">Hörsaal 2</option>
									<option value="3">Hörsaal 8</option>
									<option value="4">Cafe Relax</option>
									<option value="5">EB Raum 1</option>
									<option value="6">EB Raum 2</option>
								</select>
							</div>
                            <div class="form-group">
                                <label>Details</label>                    
                                <textarea name="details" id="details" class="form-control" placeholder="Details" rows="10"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnSave">Speichern</button>
                        <button type="button" class="btn btn-danger" id="btnDel">Löschen</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Schließen</button>
                    </div>
                </div>
            </div>
        </div>        
    </body>
</html>
