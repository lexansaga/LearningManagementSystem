$(window).on('load', function () {
    $('#datatable').DataTable({
        ordering: true,
        pageLength: 20,
        dom: 'B<"clear">lfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'csv', 'print'
        ]
    });

    $('.menu').on('click', function () {
        $('.sidebar').toggleClass('open')
    })
})