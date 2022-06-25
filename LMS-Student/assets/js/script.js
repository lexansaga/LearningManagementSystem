$(window).on('load', function () {
    // DataTable

    $('#datatable').DataTable({
        ordering: true,
        pageLength: 20,
        dom: 'B<"clear">lfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'csv', 'print'
        ]
    });

    //Menu Bar 

    var isMenuOpen = true;
    $('.menu').on('click', function () {
        $('.sidebar').toggleClass('open')

        if (isMenuOpen == true) {
            $('.menu').empty().html(' <i class="bx bx-x"></i>')
            isMenuOpen = false;
        } else {
            $('.menu').empty().html(' <i class="bx bx-menu"></i>')
            isMenuOpen = true;
        }
        console.log(isMenuOpen)
    })


    // Calendar Script
    // Link : https://www.jqueryscript.net/time-clock/animated-event-calendar.html
    $(function () {
        $('#calendar-container').calendar();
    });

})