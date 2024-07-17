
<!DOCTYPE html>
<html>
<head>
  <title>Case Closed Inquiry Index</title>
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
      <br>
      <div class="button">
        <a href="/2023/databasis/cancellation_newlives"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
          <center><h1 style="color: white;">Source Of Inquiry / Case Officer 2023</h1></center>
            
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
                  <th>Placement Date</th>
                  <th>Case Officer</th>
                  <th>Updated By</th>
                  <th>Status</th>

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
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('case_officer_2023_inquiry_index') }}",

                //FOR PARAMETER QUERY 
                "data": function (d) {
                    // Get the value of the selected case officer from the URL parameter if it exists
                    const urlParams = new URLSearchParams(window.location.search);
                    const caseOfficer = urlParams.get('case_officer_2023');
                    d.case_officer_2023 = caseOfficer; // Pass this value to your server-side script
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
                  { data: 'case_officer_2023', name: 'case_officer_2023' , className:'include' },
                  { data: 'updated_by', name: 'updated_by' , className:'include'},
                  { data: 'status', name: 'status'  , className:'include'},
                
                  {
                      data: null,
                      render: function (data, type, row) {
                          return '<a href="' + "{{ url('/2023/accountsection/') }}/" + row.id + '/" title="Show Client"><button class="btnColor"><i class="fa fa-eye" aria-hidden="true"></i> Show</button></a>';                              
                      }
                  }
              ]
          });
        // Set the dropdown to the correct value on page load based on the URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const caseOfficerParam = urlParams.get('case_officer_2023');
        if (caseOfficerParam) {
            $('.case_officer_2023').val(caseOfficerParam);
        }
    });

  </script>
</body>
</html>

