
<!DOCTYPE html>
<html>
<head>
  <title>Case Closed Inquiry Index</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Too Long because there is no layout.blade.php include in this page -->
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<!-- logo for show edit delete -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <!-- Offline CSS ( Use StyleSheet StyleSheet)-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
  <!-- OFFLINE JS (Use SCript formaT) (-->
  <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
  
  <!-- this for seperatis css to html -->
  <link  rel="stylesheet" href="{{ asset('css/dashboard_index.css') }}">


  <!-- this for seperating js to html -->
  <script src="{{ asset('js/case_officer_2024_inquiry_index.js') }}"></script>
  <script>
  var case_officer_2024_inquiry_index_url = "{{ route('case_officer_2024_inquiry_index') }}";
</script>

  

</head>


<body>
    
 <div class="text">
      <br>
      <div class="button">
        <a href="/2024/databasis/cancellation_newlives"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
    </div>
          <center><h1 style="color: white;">Source Of Inquiry / Case Officer 2024</h1></center>
            
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
  
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  
  

  
  
</body>
</html>

