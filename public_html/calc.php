<?php
?>
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 22.04.16
 * Time: 18:16
 */
<!DOCTYPE html>
<html>
<head>
<link href='css/fullcalendar.css' rel='stylesheet' />
    <script type="text/javascript" src="js/jquery-1.12.3.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.js"></script>
    <script type="text/javascript" src="js/jquery-1.12.3.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.js"></script>
    <script type="text/javascript" src="js/components/bootstrap/dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="js/components/underscore/underscore.js"></script>
    <script type="text/javascript" src='js/components/moment/min/moment-with-locales.min.js'></script>
    <script type="text/javascript"
            src="js/components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/components/bootstrap3-typeahead/bootstrap3-typeahead.js"></script>
    <script type="text/javascript" src="js/components/bootstrap-notify/bootstrap-notify.js"></script>
    <script type="text/javascript" src='js/fullcalendar.js'></script>
    <script type="text/javascript" src='js/scheduler.min.js'></script>
    <script type="text/javascript" src='js/calendar.js'></script>
<script src='js/fullcalendar.min.js'></script>
<script>

$(document).ready(function() {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var calendar = $('#calendar').fullCalendar({
   editable: true,
   header: {
        left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },

   events: "http://localhost:8888/fullcalendar/events.php",

   // Convert the allDay from string to boolean
   eventRender: function(event, element, view) {
        if (event.allDay === 'true') {
            event.allDay = true;
        } else {
            event.allDay = false;
        }
    },
   selectable: true,
   selectHelper: true,
   select: function(start, end, allDay) {
        var title = prompt('Event Title:');
        var url = prompt('Type Event url, if exits:');
        if (title) {
            var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
            var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
            $.ajax({
   url: 'http://localhost:8888/fullcalendar/add_events.php',
   data: 'title='+ title+'&start='+ start +'&end='+ end +'&url='+ url ,
   type: "POST",
   success: function(json) {
                alert('Added Successfully');
            }
   });
   calendar.fullCalendar('renderEvent',
   {
   title: title,
   start: start,
   end: end,
   allDay: allDay
   },
   true // make the event "stick"
   );
   }
        calendar.fullCalendar('unselect');
    },

   editable: true,
   eventDrop: function(event, delta) {
        var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
        var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
        $.ajax({
   url: 'http://localhost:8888/fullcalendar/update_events.php',
   data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
   type: "POST",
   success: function(json) {
            alert("Updated Successfully");
        }
   });
   },
   eventResize: function(event) {
        var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
        var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
        $.ajax({
    url: 'http://localhost:8888/fullcalendar/update_events.php',
    data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
    type: "POST",
    success: function(json) {
            alert("Updated Successfully");
        }
   });

}

  });

 });

</script>
<style>

body {
    margin-top: 40px;
  text-align: center;
  font-size: 14px;
  font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;

  }


 #calendar {
  width: 900px;
  margin: 0 auto;
  }

</style>
</head>
<body>
<div id='calendar'></div>
</body>
</html>