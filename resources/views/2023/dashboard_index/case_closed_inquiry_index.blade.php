
<!DOCTYPE html>
<html>
<head>
  <title>Source Of Inquiry Clients</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Datalokey') }}</title>

  <link rel="icon" type="image/png" href="/public/favicon.png">


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  
  <!-- Offline CSS ( Use StyleSheet StyleSheet)-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">



  <!-- OFFLINE JS (Use SCript formaT) (-->
  <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
</head>

<link  rel="stylesheet" href="{{ asset('css/dashboard_index.css') }}">

<body>
    
 <div class="text">
      <br>
      <div class="button">
        <a href="/2024/databasis/cancellation_newlives"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
          <center><h1>Source Of Inquiry / Case Officer 2023</h1></center>
            
      </div>
      <br>
      <div class="containerTable">
      <br>
      <select class="case_closed" onchange="table.ajax.reload();">
          <option value="">All Case Officer</option>
          @foreach ($case_closedFilter as $case_closed)
              <option value="{{ $case_closed }}">{{ $case_closed }}</option>
          @endforeach
      </select>
  
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
                  <th>Placement Date</th>
                  <th>Case Officer</th>
                  <th>Updated By</th>
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
  
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
              "lengthMenu": [
                  [10, 25, 50, -1],
                  ['10', '25', '50', 'Show all']
              ],
              "dom": 'lBfrtip',
              "buttons": [
                  'copyHtml5',
                  'csvHtml5',
                  'excelHtml5',
                  'pdfHtml5',
                  'print'
              ],
              "processing": true,
              "serverSide": true,
              "ajax": {
                  "url": "{{ route('case_closed_inquiry_index_2023') }}",
                  "data": function (d) {
                      d.case_closed = $('.case_closed').val();
                      
                  }
              },
              "columns": [
                  { data: 'id', name: 'id' , className:'include'},
                  { data: 'policy', name: 'policy' , className:'include'},
                  { data: 'membership', name: 'membership' , className:'include' },
                  { data: 'full', name: 'full' , className:'include' },
                  { data: 'insurer', name: 'insurer' , className:'include' },
                  { data: 'source_inquiry', name: 'source_inquiry' , className:'include' },
                  { data: 'lives_2023', name: 'lives_2023' , className:'include' },
                  { data: 'group_name', name: 'group_name' , className:'include' },
                  { data: 'placement_date', name: 'placement_date' , className:'include' },
                  { data: 'case_closed', name: 'case_closed' , className:'include' },
                  { data: 'updated_by', name: 'updated_by' , className:'include'},
                  { data: 'status', name: 'status'  , className:'include'},
                  { data: 'age', name: 'age', visible: false, className: 'not-visible' },
                  { data: 'email_address', name: 'email_address', visible: false, className: 'not-visible' },                   
                  {
                      data: null,
                      render: function (data, type, row) {
                          return '<a href="' + "{{ url('/2023/accountsection/') }}/" + row.id + '/" title="Show Client"><button class="btnColor"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Show</button></a>';                              
                      }
                  }
              ]
          });
     // Event handler for when the source inquiry filter changes
     $('.case_closed').on('change', function () {
        table.ajax.reload(); // This will trigger the AJAX call with the new data
    });
});
  </script>
</body>
</html>

