@extends('layout_nomenu')
@section('content')
<!DOCTYPE html>
<html>
<head>
  <title>Number of Clients in country per premium 2024</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- Too Long because there is no layout.blade.php include in this page  -->
  <!-- CSRF Token -->
 
  <link rel="stylesheet" href="{{ asset('css/dashboard_index.css') }}" />
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" /></head>

<body>
   <div class="header-section">

      <div class="button">
        <a href="/2024/dashboard/country_premium"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
    <center><h1 class="title-header">Number of Clients in country per premium 2024</h1></center>
          
  
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
                  <th>Country of Residence</th>
                  <th>Lives</th>
                  <th>Premium</th>
                  <th>Start Date</th>
                  <th>Encoded By</th>
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
                  ['15', '25', '50', 'Show all']
              ],
           
              "processing": true,
              "serverSide": true,
              "ajax": {
                  "url": "{{ route('country_premium_index') }}",
                  "data": function(d) {
                // Get the source inquiry parameter from the URL
                const urlParams = new URLSearchParams(window.location.search);
                const country_residenceFilter = urlParams.get('country_residence');
                // Add it to the data object sent to the server
                d.country_residence = country_residenceFilter;
            }
          },
              "columns": [
                  { data: 'id', name: 'id' , className:'include'},
                  { data: 'policy', name: 'policy' , className:'include'},
                  { data: 'membership', name: 'membership' , className:'include' },
                  { data: 'full', name: 'full' , className:'include' },
                  { data: 'insurer', name: 'insurer' , className:'include' },
                  { data: 'country_residence', name: 'country_residence' , className:'include' },
                  { data: 'lives_2024', name: 'lives_2024' , className:'include' },
                  { data: 'convert_premium_USD', name: 'convert_premium_USD' , className:'include' },
                  { data: 'start_date', name: 'start_date' , className:'include' },
                  { data: 'encoded_by', name: 'encoded_by' , className:'include' },
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
     // Event handler for when the source inquiry filter changes
     $('.country_residence').on('change', function () {
        table.ajax.reload(); // This will trigger the AJAX call with the new data
    });

    // Event handler for when the policy filter changes
    $('.policy_filter').on('change', function () {
        table.ajax.reload(); // This will trigger the AJAX call with the new data
    });
});
  </script>
  



</body>
</html>

