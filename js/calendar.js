$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        editable:true,
        events: 'api/getEvent.php',
        selectable:true,
        selectHelper:true,
        select: function(start,allDay)
        {
             var Event = prompt("Add Event");
             if(Event)
             {
                  var Date = $.fullCalendar.formatDate(start, "Y-MM-DD");
                  $("#event-action-response").hide();
                  $.ajax({
                       url:"api/addEvent.php",
                       type:"POST",
                       data:{title:Event, start:Date},
                       success:function()
                       {
                        calendar.fullCalendar('refetchEvents');
                        $("#event-action-response").html("Event added Successfully");
                        $("#event-action-response").show();
                       }
                  })
             }
        },

          // delete event
        eventClick: function (event) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "api/deleteEvent.php",
                    data: {event_id:event.id},
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Deleted Successfully");
                        }
                    }
                });
            }
        },

    

        // move event
        eventDrop: function(event, delta, revertFunc) {
            if (!confirm("Are you sure about to move this event?")) {
                 revertFunc();
            } else {
                var editedDate = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                $("#event-action-response").hide();
                $.ajax({
                    url:"api/editevent.php",
                    type:"POST",
                    data:{event_id:event.id, start:editedDate},
                    success:function(resource)
                    {
                     calendar.fullCalendar('refetchEvents');
                     $("#event-action-response").html("Event moved Successfully");
                     $("#event-action-response").show();
                    }
                })
            }
        },        
    });
});  