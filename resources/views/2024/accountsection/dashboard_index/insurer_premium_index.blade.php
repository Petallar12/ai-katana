@extends('layout_nomenu')
@section('content')
<!DOCTYPE html>
<html>
<head>
  <title>Clients per Insurer and their Premium 2024</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- Too Long because there is no layout.blade.php include in this page  -->
  <!-- CSRF Token -->
 
  <link rel="stylesheet" href="{{ asset('css/dashboard_index.css') }}" />
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" /></head>

<body>
   <div class="header-section">
      <div class="button">
        <a href="/2024/dashboard/insurer_premium"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <center><h1 class="title-header">Clients per Insurer and their Premium 2024</h1></center>
          
  
      </div>
      <div class="container-index">
        <table id="table" class="table table-striped nowrap" style="width: 100%">

        <thead>
          <tr>
              <th>No</th>
              <th>Policy</th>
              <th>Membership</th>       
              <th>Full Name</th>
              <th>
                Insurer
              </th>
              <th>Source of Inquiry</th>
              <th>Lives</th>
              <th>Group Name</th>
              <th>Start Date</th>
              <th>Premium (USD)</th></th>
              <th>Commission (USD)</th>
              <th>Status</th>
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
              lengthMenu: [
                [ 15, 25, 50, -1 ],
                [ '15', '25', '50', 'All' ]
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
                  {
                      data: null,
                      render: function (data, type, row) {
                          return '<a href="' + "{{ url('/2024/accountsection/') }}/" + row.id + '/" title="Show Client"><button class="actionBtn"><i class="fa fa-eye"></i></button></a>';                              
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

