<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Full Calendar Demo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">

        <!-- css -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.1/fullcalendar.min.css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.min.css">
		<link rel="stylesheet" href="{{ URL::asset('/css/scheduler.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('/css/jquery-ui.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('/css/fullcalendar.css') }}">
        <!-- js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.1/fullcalendar.min.js"></script> -->
		<script src="{{ URL::asset('/js/fullcalendar.js') }}"></script>
		<script src="{{ URL::asset('/js/scheduler.min.js') }}"></script>
		<script src="{{ URL::asset('/js/lang/de.js') }}"></script>
        <script>
			//$( function() {
				//$( "#fc-event-container" ).resizable();
			//} );
            $(document).ready(function() {
                $('#calendar').fullCalendar({ 
					schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
                    displayEventTime: true,
					//editable: true,
					selectable: true,
					eventLimit: true, // allow "more" link when too many events
					defaultView: 'agendaWeek',
                    allDay: true,
					resources: 'api/events/resources',
                    events: 'api/events/all',
					timeFormat: 'H(:mm)',
					minTime: '07:00:00',
					maxTime: '19:00:00',
					timezone:'local',
					//slotDuration: '00:15:00',
					businessHours: {
						start: '07:00',
						end: '19:00',
					},
					/* select: function(start, end) {
						// var title = prompt('Event title');
						
                                location.href = 'edit';
                        
						var eventData;						
					},*/
					eventRender: function(event,element) {
						
						element.find('.fc-title').append("<br/>" + event.details + "<br/> Raum: " + event.roomname + "<br/> Gebäude: " + event.building);
					},
                    eventClick: function(calEvent, jsEvent, view) {

                        $('#modalTitle').text(calEvent.title)
                        if(calEvent.details != null) {
                            $('#modalBody').html(calEvent.details)
							$('#modalMoredetails').html( "Raum: " + calEvent.roomname + "<br/>" + "Gebäude: " + calEvent.building)
                        }

                        $('#modalCalendar').modal('show');
                    },
                    eventMouseover: function() {
                        $(this).css({'cursor': 'pointer'});
                    },
                    customButtons: {
                        editEvent: {
                            text: 'Editieren',
                            click: function() {
                                location.href = 'edit';
                            }
                        }
                    },
                    header: {
						left: 'prev,next today',
						center: 'title',
                        right: 'editEvent,agendaWeek,month,agendaDay'
                    },                            
					views: {
						agendaTwoDay: {
							type: 'agenda',
							duration: { days: 2 },

							// views that are more than a day will NOT do this behavior by default
							// so, we need to explicitly enable it
							groupByResource: true
						}
					}
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
              </div>
			  <div class="modal-body" id="modalMoredetails">
			  </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>        
    </body>
</html>
