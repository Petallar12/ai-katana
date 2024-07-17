@extends('layout')
@section('content')

<!DOCTYPE html>
<html>
<head>
  <title>Cancelled Clients From 2022 to 2023</title>
  <meta name="csrf-token" content="{{ csrf_token() }}"> 
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></> 

  <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  
</head>
<link  rel="stylesheet" href="{{ asset('css/index.css') }}">


<body>
  
  <div class="text">
      {{-- Title --}}

          <center><h1>Cancelled Clients From 2022 to 2023</h1></center>
  
      </div>
      <br>
<div class="containerTable">
    <div class="tableHeader">

</div>
      

  <table id="table" class="display nowrap" style="width:100%">
      <thead>
          <tr>
              <th>No</th>
              <th>
                <select class="policy_filter" onchange="reloadTable();">
                <option value="">Policy</option>
                @foreach ($Policyfilter as $policy)
                    <option value="{{ $policy }}">{{ $policy }}</option>
                @endforeach
                </select>
            </th>
            <th>Membership</th>       
            <th>Full Name</th>
            <th>
                <select class="insurer_filter" onchange="reloadTable();">
                <option value="">Insurer</option>
                @foreach ($Insurerfilter as $insurer)
                    <option value="{{ $insurer }}">{{ $insurer }}</option>
                @endforeach
                </select>
            </th>
            <th>
                <select class="source_inquiry" onchange="reloadTable();">
                <option value="">Source of Inquiry</option>
                @foreach ($sourceInquiries as $inquiry)
                    <option value="{{ $inquiry }}">{{ $inquiry }}</option>
                @endforeach
                </select>
            </th>
              <th>
                <select class="lives_2023_filter" onchange="reloadTable();">
                <option value="">Lives</option>
                @foreach ($Lives_2023_filter as $lives_2023)
                    <option value="{{ $lives_2023 }}">{{ $lives_2023 }}</option>
                @endforeach
                </select>
            </th>
            <th>
                <select class="group_name" onchange="reloadTable();">
                <option value="">Group Name</option>
                @foreach ($Group_name_filter as $group_name)
                    <option value="{{ $group_name }}">{{ $group_name }}</option>
                @endforeach
                </select>
            </th>
              <th>Start Date</th>
              <th>Encoded By</th></th>
              <th>Updated By</th>
              <th>Status</th>

        
              <th>Application Form</th>
              <th>Actions</th> <!-- Add a column for actions -->

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
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  


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



              "processing": true,
              "serverSide": true,
              "ajax": {
                "url": "{{ route('cancelled_index') }}",
                "type": "GET",
                "data": function (d) {
                    d.source_inquiry = $('.source_inquiry').val();
                    d.policy = $('.policy_filter').val();
                    d.insurer = $('.insurer_filter').val();
                    d.lives_2023 = $('.lives_2023_filter').val();
                    d.group_name = $('.group_name').val();
                }
            },

              "columns": [

                { data: 'id', name: 'id' , className:'not-include'},
                { data: 'policy', name: 'policy' , className:'include'},
                { data: 'membership', name: 'membership' , className:'include' },
                { data: 'full', name: 'full' , className:'include' },
                { data: 'insurer', name: 'insurer' , className:'include' },
                { data: 'source_inquiry', name: 'source_inquiry' , className:'not-include' },
                { data: 'lives_2023', name: 'lives_2023' , className:'include' },
                { data: 'group_name', name: 'group_name' , className:'include' },
                { data: 'start_date', name: 'start_date' , className:'include' },
                { data: 'cancelled_date', name: 'cancelled_date' , className:'not-include' },
                { data: 'placement_date', name: 'placement_date' , className:'not-include'},
                { data: 'status', name: 'status'  , className:'include'},

                { data: 'attachment_3', name: 'attachment_3', visible: false, className: 'not-visible' },

                  // Define your actions column here...
                  {
                      data: null,
                      render: function (data, type, row) {
                          return '<a href="' + "{{ url('/2023/accountsection/') }}/" + row.id + '/" title="Show Client" target="_blank"><button class="btnColor"><i class="fa fa-eye" aria-hidden="true"></i> </button></a>';                              
                      }
                  }
              ]
          });
                  // Function to trigger reload of DataTables
        function reloadTable() {
            table.ajax.reload();
        }

        // Event handler for filter changes
        $('.source_inquiry, .policy_filter, .insurer_filter, .lives_2023_filter, .group_name').on('change', function () {
            table.ajax.reload();
        });

          $('#table').on('click', '.delete-btn', function () {
    var id = $(this).data('id');
    deleteRow(id);
});

function deleteRow(id) {
    if (confirm('Confirm delete?')) {
        $.ajax({
            type: 'POST',
            url: "{{ url('/2023/accountsection/delete') }}/" + id,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (data) {
                console.log('Success:', data);
                window.location.href = "{{ url('/2023/accountsection/index') }}";
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
}
        // Add an event listener for the transfer button
        $(document).on('click', '.transfer-btn', function () {
            var id = $(this).data('id');
            transferData(id);
        });

        function transferData(id) {
            $.ajax({
                url: '/2023/accountsection/' + id + '/transfer',
                method: 'POST',
                data: {_token: '{{ csrf_token() }}'},

        success: function (response) {
                    alert('Data transferred successfully!');
                    reloadTable(); // Reload the DataTable to reflect changes
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error transferring data:', xhr.responseText);
                    alert('Error transferring data. Check the console for details.');
                }
            });
        }
     // Function to update export CSV URL
     function updateExportCsvUrl() {
        var filters = {
            source_inquiry: $('.source_inquiry').val(),
            policy: $('.policy_filter').val(),
            insurer: $('.insurer_filter').val(),
            lives_2023: $('.lives_2023_filter').val(),
            group_name: $('.group_name').val(),
        };

        var queryString = $.param(filters);
        var newExportCsvUrl = "{{ route('export.csv') }}" + "?" + queryString;
        $("a.btn.btn-primary").attr("href", newExportCsvUrl);
    }

    // Call updateExportCsvUrl on filter change and page load
    $('.source_inquiry, .policy_filter, .insurer_filter, .lives_2023_filter, .group_name').on('change', function () {
        updateExportCsvUrl();
    });

    updateExportCsvUrl(); // Call on page load to set initial URL
});
  </script>
</body>
</html>

@endsection