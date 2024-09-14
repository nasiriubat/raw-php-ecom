// $('.custom-table').DataTable(); //Buttons examples

//     var table = $('#datatable-buttons').DataTable({
//       lengthChange: false,
//       buttons: [{
//         extend: 'copy',
//         exportOptions: {
//           columns: [0, ':visible']
//         }
//       },
//       {
//         extend: 'excel',
//         exportOptions: {
//           columns: ':visible'
//         }
//       },
//       {
//         extend: 'pdf',
//         exportOptions: {
//           columns: [0, 1, 2, 3, 4, 5]
//         }
//       }, 'colvis']
//     });
//     table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
//     $(".dataTables_length select").addClass('form-select form-select-sm');

let table = new DataTable('.custom-table');
 
// table.on('click', 'tbody tr', function () {
//     // let data = table.row(this).data();
 
//     // alert('You clicked on ' + data[0] + "'s row");
// });