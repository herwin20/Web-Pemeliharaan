<!-- Full Calendar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Full Calendar -->
<script type="text/javascript">
    $(document).ready(function() {
        var kerjaan = @json($kerjaan);
        console.log(kerjaan);
        $('#calendar').fullCalendar({
            header: {
                left: 'prev, next today',
                center: 'title',
                right: 'month, agendaWeek, agendaDay'
            },
            events: kerjaan,
            selectable: true,
            selectHelper: true,
        });

        $('.fc-event').css('border-radius', '5px');
    })
</script>
