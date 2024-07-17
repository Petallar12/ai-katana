@extends('layout_nomenu')
@section('content')
<!DOCTYPE html>
<html>
<head>
  <title>Source Of Inquiry / Case Officer 2024</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- Too Long because there is no layout.blade.php include in this page  -->
  <!-- CSRF Token -->
 
  <link rel="stylesheet" href="{{ asset('css/dashboard_index.css') }}" />
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" /></head>

<body>
   <div class="header-section">
      <div class="button">
        <a href="/2024/databasis/cancellation_newlives"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <center><h1 class="title-header">Source Of Inquiry / Case Officer 2024</h1></center>
            
      </div>
 
      <div class="container-index">
        <table id="table" class="table table-striped nowrap" style="width: 100%">
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
  
  <script src="{{ asset('js/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
  
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
                [15, 25, 50, -1],
                  ['15', '25', '50', 'All']
            ],
            "dom": 'lBfrtip',
            "buttons": [
                'copyHtml5',
                'csvHtml5',
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('case_closed_inquiry_index') }}",

                //FOR PARAMETER QUERY 
                "data": function (d) {
                    // Get the value of the selected case officer from the URL parameter if it exists
                    const urlParams = new URLSearchParams(window.location.search);
                    const caseOfficer = urlParams.get('case_closed');
                    d.case_closed = caseOfficer; // Pass this value to your server-side script
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
                  { data: 'placement_date', name: 'placement_date' , className:'include' },
                  { data: 'case_closed', name: 'case_closed' , className:'include' },
                  { data: 'updated_by', name: 'updated_by' , className:'include'},
                  { data: 'status', name: 'status'  , className:'include'},
                  { data: 'age', name: 'age', visible: false, className: 'not-visible' },
                  { data: 'email_address', name: 'email_address', visible: false, className: 'not-visible' },                   
                  {
                      data: null,
                      render: function (data, type, row) {
                          return '<a href="' + "{{ url('/2024/accountsection/') }}/" + row.id + '/" title="Show Client"><button class="actionBtn"><i class="fa fa-eye"></i></button></a>';                              
                      }
                  }
              ]
          });
        // Set the dropdown to the correct value on page load based on the URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const caseOfficerParam = urlParams.get('case_closed');
        if (caseOfficerParam) {
            $('.case_closed').val(caseOfficerParam);
        }
    });

  </script>
</body>
</html>

