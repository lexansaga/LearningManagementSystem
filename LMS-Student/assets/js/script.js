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
    if ($('body').hasClass('hasCalendar')) {

        $(function () {
            $('#calendar-container').calendar();
        });

    }

    $('input[type="file"]').change(function (e) {
        var fileName = e.target.files[0].name;
        console.log('The file "' + fileName + '" has been selected.');
    });
})