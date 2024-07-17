
<!DOCTYPE html>
<html>
<head>
  <title>Commission of Clients</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
{{-- Too Long because there is no layout.blade.php include in this page --}}
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
{{-- logo for show edit delete  --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <!-- Offline CSS ( Use StyleSheet StyleSheet)-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
  <!-- OFFLINE JS (Use SCript formaT) (-->
  <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
  <link  rel="stylesheet" href="{{ asset('css/dashboard_index.css') }}">
</head>
<body>
    
 <div class="text">
    
      {{-- Title --}}
      <br>
      <div class="button">
        <a href="/2024/dashboard/insurer_premium"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
          <center><h1>Clients per Insurer and their Commission 2024</h1></center>
      </div>
      <br>
      <div class="containerTable">
        
      <br>

  <table id="table" class="display nowrap" style="width:100%">
        <thead>
          <tr>
              <th>No</th>
              <th>Policy</th>
              <th>Membership</th>       
              <th>Full Name</th>
              <th>Insurer</th>
              <th>Source of Inquiry</th>
              <th>Lives</th>
              <th>Group Name</th>
              <th>Start Date</th>
              <th>Premium (USD)</th></th>
              <th>Commission (USD)</th>
              <th>Status</th>
              <th>Age</th>
              <th>Personal E-mail</th>
              <th>Actions</th> 

          </tr>
      </thead>
      <tbody>
          
      </tbody>
  </table>
</div>

  <!-- Include jQuery and DataTables libraries -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <!-- Include DataTables Buttons libraries -->
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>


  <script type="text/javascript">
      $(document).ready(function () {
          const table = $('#table').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "scrollX": true,
              "info": true,
              "autoWidth": true,
              lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'Show all' ]
                ],
                dom: 'lBfrtip',
            buttons: [
              {
                  extend: 'copyHtml5',
                  exportOptions: {
                    columns: '.include, .not-visible'
                }
              },
              {
                  extend: 'csvHtml5',
                  exportOptions: {
                    columns: '.include, .not-visible'
                  }
              },
              {
                  extend: 'print',
                  exportOptions: {
                    columns: '.include, .not-visible'
                  }
              }
            ],
              "processing": true,
              "serverSide": true,
              "ajax": {
                  "url": "{{ route('insurer_premium_index') }}",
                  "data": function(d) {
                // Get the source inquiry parameter from the URL
                const urlParams = new URLSearchParams(window.location.search);
                const insurerFilter = urlParams.get('insurer');
                // Add it to the data object sent to the server
                d.insurer = insurerFilter;
            }
          },
              "columns": [
                  { data: 'id', name: 'id' , className:'include'},
                  { data: 'policy', name: 'policy' , className:'include'},
                  { data: 'membership', name: 'membership' , className:'include' },
                  { data: 'full', name: 'full' , className:'include' },
                  { data: 'insurer', name: 'insurer' , className:'include' },
                  { data: 'source_inquiry', name: 'source_inquiry' , className:'include' },
                  { data: 'lives_2024', name: 'lives_2024' , className:'include' },
                  { data: 'group_name', name: 'group_name' , className:'include' },
                  { data: 'start_date', name: 'start_date' , className:'include' },
                  { data: 'convert_premium_USD', name: 'convert_premium_USD' , className:'include' },
                  { data: 'commission_2024', name: 'commission_2024' , className:'include'},
                  { data: 'status', name: 'status'  , className:'include'},
                  { data: 'age', name: 'age', visible: false, className: 'not-visible' },
                  { data: 'email_address', name: 'email_address', visible: false, className: 'not-visible' },
                      
                  
                  {
                      data: null,
                      render: function (data, type, row) {
                          return '<a href="' + "{{ url('/2024/accountsection/') }}/" + row.id + '/" title="Show Client"><button class="btnColor"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Show</button></a>';                              
                      }
                  }
              ]
          });
          $('.insurer').on('change', function () {
                table.ajax.reload();
            });
        });
      
      
  </script>




</body>
</html>

