@extends('layout')
@section('content')

<head>
  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/databasis.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

  <!-- Script -->
  <script type="text/javascript" src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
</head>

<section>
<!-- Initialize DataTable for Source Inquiry New Lives -->
<script>
    $(document).ready(function () {
        $('#inquiryNewLives').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "columnDefs": [
                { "width": "100px", "targets": "_all" }
            ],
            "fixedColumns": true,
        });
    });
</script>

<div class="table-container">
    <div class="card">
        <table id='inquiryNewLives' class="table">
            <thead>
                <tr>
                    <th class="th-head" colspan="{{ count($source_inquiry) + 2 }}">Source of Inquiry 2022 (New Lives)</th>
                </tr>
                <tr>
                    <th>Case Officer</th>
                    @foreach ($source_inquiry as $row)
                        @if (!empty($row->source_inquiry))
                            <th>{{ $row->source_inquiry }}</th>
                        @endif
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $filtered_case_closed = [];
                @endphp
                @foreach ($case_closed as $row)
                    @php
                        $case_total = 0;
                        $row_data = [];
                    @endphp
                    @foreach ($source_inquiry as $row1)
                        @if (!empty($row1->source_inquiry))
                            @php $count = 0; @endphp
                            @foreach ($accountsection as $accountsec)
                                @if ($accountsec->source_inquiry == $row1->source_inquiry && $row->case_closed == $accountsec->case_closed)
                                    @php $count = $accountsec->count; $case_total += $count; @endphp
                                    @break
                                @endif
                            @endforeach
                            @php
                                $row_data[] = $count;
                            @endphp
                        @endif
                    @endforeach
                    @if ($case_total > 0)
                        @php
                            $filtered_case_closed[] = ['case_closed' => $row->case_closed, 'data' => $row_data, 'total' => $case_total];
                        @endphp
                    @endif
                @endforeach

                @foreach ($filtered_case_closed as $officer_data)
                    <tr>
                        <td><a target="_blank" href="/2022/databasis_index/case_closed_inquiry_index?case_closed={{ urlencode($officer_data['case_closed']) }}">{{ $officer_data['case_closed'] }}</a></td>
                        @foreach ($officer_data['data'] as $count)
                            <td>{{ $count }}</td>
                        @endforeach
                        <td>{{ $officer_data['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="total-col"><b>Total</b></td>
                    @php
                        $column_totals = [];
                        $grand_total = 0;
                    @endphp
                    @foreach ($source_inquiry as $index => $row1)
                        @if (!empty($row1->source_inquiry))
                            @php $col_total = 0; @endphp
                            @foreach ($accountsection as $accountsec)
                                @if ($accountsec->source_inquiry == $row1->source_inquiry)
                                    @php $col_total += $accountsec->count; @endphp
                                @endif
                            @endforeach
                            @php
                                $column_totals[] = $col_total;
                            @endphp
                            @if ($col_total > 0)
                                <td class="total-col">{{ $col_total }}</td>
                                @php $grand_total += $col_total; @endphp
                            @endif
                        @endif
                    @endforeach
                    <td class="total-col">{{ $grand_total }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


<!-- Initialize DataTable for Source Inquiry Renewals -->
<script>
    $(document).ready(function () {
        $('#inquiryRenewal').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "columnDefs": [
                { "width": "100px", "targets": "_all" }
            ],
            "fixedColumns": true,
        });
    });
</script>

<div class="table-container">
    <div class="card">
        <table id="inquiryRenewal" class="table">
            <thead>
                <tr>
                    <th class="th-head" colspan="{{ count($source_inquiry2) + 2 }}">Source of Inquiry 2022 (Renewals)</th>
                </tr>
                <tr>
                    <th>Case Officer</th>
                    @foreach ($source_inquiry2 as $row)
                        @if (!empty($row->source_inquiry))
                            <th>{{ $row->source_inquiry }}</th>
                        @endif
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $filtered_case_officers = [];
                @endphp
                @foreach ($case_officer_2022 as $row)
                    @php
                        $case_total = 0;
                        $row_data = [];
                    @endphp
                    @foreach ($source_inquiry2 as $row1)
                        @if (!empty($row1->source_inquiry))
                            @php $count = 0; @endphp
                            @foreach ($accountsection2 as $accountsec)
                                @if ($accountsec->source_inquiry == $row1->source_inquiry && $row->case_officer_2022 == $accountsec->case_officer_2022)
                                    @php $count = $accountsec->count; $case_total += $count; @endphp
                                    @break
                                @endif
                            @endforeach
                            @php
                                $row_data[] = $count;
                            @endphp
                        @endif
                    @endforeach
                    @if ($case_total > 0)
                        @php
                            $filtered_case_officers[] = ['case_officer' => $row->case_officer_2022, 'data' => $row_data, 'total' => $case_total];
                        @endphp
                    @endif
                @endforeach

                @foreach ($filtered_case_officers as $officer_data)
                    <tr>
                        <td><a target="_blank" href="/2022/databasis_index/case_officer_2022_inquiry_index?case_officer_2022={{ urlencode($officer_data['case_officer']) }}">{{ $officer_data['case_officer'] }}</a></td>
                        @foreach ($officer_data['data'] as $count)
                            <td>{{ $count }}</td>
                        @endforeach
                        <td>{{ $officer_data['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="total-col"><b>Total</b></td>
                    @php
                        $column_totals = [];
                        $grand_total = 0;
                    @endphp
                    @foreach ($source_inquiry2 as $index => $row1)
                        @if (!empty($row1->source_inquiry))
                            @php $col_total = 0; @endphp
                            @foreach ($accountsection2 as $accountsec)
                                @if ($accountsec->source_inquiry == $row1->source_inquiry)
                                    @php $col_total += $accountsec->count; @endphp
                                @endif
                            @endforeach
                            @php
                                $column_totals[] = $col_total;
                            @endphp
                            @if ($col_total > 0)
                                <td class="total-col">{{ $col_total }}</td>
                                @php $grand_total += $col_total; @endphp
                            @endif
                        @endif
                    @endforeach
                    <td class="total-col">{{ $grand_total }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>



  <!-- Initialize DataTable for New Lives January 2022 to Date -->
   <script>
    $(document).ready(function () {
      $('#todateNewLives').DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "columnDefs": [
          { "width": "100px", "targets": "_all" }
        ],
        "fixedColumns": true,
      });
    });
  </script>

  <div class="table-container">
    <div class="col col-xl-12 col-md-12">
      <div class="row">
        <div class="col largecol-xl-6 col-md-6">
          <div class="card">
            <table id='todateNewLives' class="table">
              <thead>
                <tr>
                  <th class="th-head" colspan="2">New Lives - January 1, 2022 to Date</th>
                </tr>
                <tr>
                  <th>Insurer</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data3 as $row)
                  <tr>
                    <td>{{ $row->insurer }}</td>
                    <td>{{ $row->lives_2022 }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td>Total</td>
                  <td><b>{{ $total_data3 }}</b></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <!-- Initialize DataTable for New Lives Today -->
        <script>
        $(document).ready(function () {
          $('#todayNewLives').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "columnDefs": [
              { "width": "100px", "targets": "_all" }
            ],
            "fixedColumns": true,
          });
        });
      </script>

        <div class="col largecol-xl-6 col-md-6 row-md-6">
          <div class="card">
            <table id='todayNewLives' class="table">
              <thead>
                <tr>
                  <th class="th-head" colspan="2">New Lives Today - <script>
                      date = new Date().toLocaleDateString("en-PH", {month: "long", day: "numeric", year: "numeric"});
                      document.write(date);
                    </script></th>
                </tr>
                <tr>
                  <th>Insurer</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($today_data3 as $row)
                  <tr>
                    <td>{{ $row->insurer }}</td>
                    <td>{{ $row->lives_2022 }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td>Total</td>
                  <td><b>{{ $total_today_data3 }}</b></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Initialize DataTable for Renewals Cancellation 2022 -->
  <script>
        $(document).ready(function () {
          $('#todateCancellationRenewal').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "columnDefs": [
              { "width": "100px", "targets": "_all" }
            ],
            "fixedColumns": true,
          });
        });
      </script>

  <div class="table-container">
    <div class="col col-xl-12 col-md-12">
      <div class="row">
        <div class="col largecol-xl-4 col-md-4 row-md-4">
          <div class="card">
            <table id='todateCancellationRenewal' class="table">
              <thead>
                <tr>
                  <th class="th-head" colspan="2">Cancellation 2022 Renewals since 1 Jan 2022</th>
                </tr>
                <tr>
                  <th>Case Officer</th>
                  <th>Lives 2022</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data2 as $row)
                  <tr>
                    <td>{{ $row->insurer }}</td>
                    <td>{{ $row->lives_2022 }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td>Total</td>
                  <td><b>{{ $total_renewal }}</b></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <!-- Initialize DataTable for New Lives Cancellation 2022 -->
        <script>
          $(document).ready(function () {
            $('#todateCancellationNewLives').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "columnDefs": [
                  { "width": "100px", "targets": "_all" }
                ],
                "fixedColumns": true,
              });
            });
          </script>

        <div class="col largecol-xl-4 col-md-4 row-md-4">
          <div class="card">
            <table id='todateCancellationNewLives' class="table">
              <thead>
                <tr>
                  <th class="th-head" colspan="2">Cancellation 2022 New Lives since 1 Jan 2022</th>
                </tr>
                <tr>
                  <th>Case Officer</th>
                  <th>Lives 2022</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $row)
                  <tr>
                    <td>{{ $row->insurer }}</td>
                    <td>{{ $row->lives_2022 }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td>Total</td>
                  <td><b>{{ $total_newlives }}</b></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <!-- Initialize DataTable for Today's Cancellation -->
        <script>
          $(document).ready(function () {
            $('#todayCancellation').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "columnDefs": [
                  { "width": "100px", "targets": "_all" }
                ],
                "fixedColumns": true,
              });
            });
          </script>

        <div class="col largecol-xl-4 col-md-4 row-md-4">
          <div class="card">
            <table id='todayCancellation' class="table">
              <thead>
                <tr>
                  <th class="th-head" colspan="2">Cancellation Today - <script>
                      date = new Date().toLocaleDateString("en-PH", {month: "long", day: "numeric", year: "numeric"});
                      document.write(date);
                    </script>
                  </th>
                <tr>
                  <th>Case Officer</th>
                  <th>Cancelation Today</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($today_data as $row)
                  <tr>
                    <td>{{ $row->insurer }}</td>
                    <td>{{ $row->lives_2022 }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td>Total</td>
                  <td><b>{{ $total_today_data }}</b></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Initialize DataTable for Encoded Data Entry Progress -->
  <script>
    $(document).ready(function () {
        $('#encoderProgress').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "columnDefs": [
                { "width": "100px", "targets": "_all" }
            ],
            "fixedColumns": true,
        });

        $('#encoderCreated').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "columnDefs": [
                { "width": "100px", "targets": "_all" }
            ],
            "fixedColumns": true,
        });

        $('#encoderUpdated').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "columnDefs": [
                { "width": "100px", "targets": "_all" }
            ],
            "fixedColumns": true,
        });
    });
</script>

@if(auth()->user()->role == '1' || auth()->user()->role == '3')
    <div class="table-container">
        <div class="col col-xl-12 col-md-12">
            <div class="row">
                <div class="col largecol-xl-4 col-md-4 row-md-4">
                    <div class="card">
                        <table id='encoderProgress' class="table">
                            <thead>
                                <tr>
                                    <th class="th-head" colspan="2">DATA ENTRY PROGRESS</th>
                                </tr>
                                <tr>
                                    <th>Encoder Name</th>
                                    <th>Number of Encoded</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($encoded as $row)
                                    @if ($row->count > 0)
                                        <tr>
                                            <td>{{ $row->encoded_by }}</td>
                                            <td>{{ $row->count }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td><b>{{ $total_encoded }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col largecol-xl-4 col-md-4 row-md-4">
                    <div class="card">
                        <table id='encoderCreated' class="table">
                            <thead>
                                <tr>
                                    <th class="th-head" colspan="2">CREATED TODAY - <script>
                                            date = new Date().toLocaleDateString("en-PH", {
                                                month: "long",
                                                day: "numeric",
                                                year: "numeric"
                                            });
                                            document.write(date);
                                        </script>
                                    </th>
                                <tr>
                                    <th>Encoder</th>
                                    <th>Encoded Today</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($encoded_today as $row)
                                    @if ($row->count > 0)
                                        <tr>
                                            <td>{{ $row->encoded_by }}</td>
                                            <td>{{ $row->count }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td><b>{{ $total_encoded_today }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


  <!-- Initialize DataTable for Group 2022 -->
  <script>
    $(document).ready(function () {
      const table = $('#groupSummary').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "columnDefs": [
                { "width": "100px", "targets": "_all" }
            ],
        "fixedColumns": true,
        "orderFixed": {
          "pre": -1 // Lock the last row at the bottom
        },
        lengthMenu: [
          [10, 25, 50, -1],
          ['10', '25', '50', 'ALL']
        ],
     
      });
    });
  </script>

  <div class="table-container">
    <div class="card">
      <table id='groupSummary' class="group-table stripe">
        <theader class="group-header">GROUP LIST</theader>
        <thead>
          <tr>
            <th>GROUP NAME</th>
            <th>Members in Group</th>
          </tr>
        </thead>
        <tbody>
          @php
            $totalMembers = 0;
            $totalPremium = 0;
          @endphp

          @foreach ($group_name as $row)
            <tr>
              <td>{{ $row->group_name }}</td>
              <td>{{ $row->lives_2022 }}</td>
            </tr>
            @php $totalMembers += $row->lives_2022; @endphp
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td class="footer"><b>Total</b></td>
            <td class="footer"><b>{{ $totalMembers }}</b></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>



  <!-- Include DataTables Buttons libraries -->

  <script>
    $(document).ready(function () {
      if ($.fn.DataTable.isDataTable('#myTable')) {
        $('#myTable').DataTable().destroy();
      }
      $('#myTable').DataTable();
    });
  </script>

</section>
@endsection
