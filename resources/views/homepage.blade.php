<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Tables</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link href="{{asset('assets/vendor/fonts/circular-std/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/libs/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/buttons.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/select.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatables/css/fixedHeader.bootstrap4.css')}}">
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
         <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
         <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="#">Concept</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">

                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('assets/images/avatar-1.jpg')}}" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">John Abraham</h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
       <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                      <ul class="navbar-nav flex-column">
                          <li class="nav-divider">
                              <a class="nav-link" href="{{url('/')}}"> Homepage </a>
                          </li>
                      </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Data Tables</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>

                        </div>
                        <button  type="button" id="zip_folder_button" name="zip_folder_button" class="btn-dark btn btn-sm mb-2" style="float:right;">Download All Imported Files</button>
                        <button data-toggle="modal" data-target="#import_modal" type="button" id="import_data_modal" name="import_data_modal" class="mr-3 btn-success btn btn-sm mb-2" style="float:right;">Upload Excel Sheet</button>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- basic table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <div class="card">
                            <h5 class="card-header">Data</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first" id="client_details_table">
                                        <thead>
                                            <tr>
                                                <th>Unique Number</th>
                                                <th>Date of Installation</th>
                                                <th>Seal Name</th>
                                                <th>Client</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                          </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end basic table  -->
                    <!-- ============================================================== -->
                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" id="import_modal" tabindex="-1" role="dialog" aria-labelledby="import_modal" aria-hidden="true">



        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Upload Data</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                </div>

                <div class="modal-body">
                    <label for="">Please Check for these Headers are available in the file</label>
                    <ul class="mb-4">
                      <li>Date of Installation [dd-mm-yyyy] format <span style="color:red">*</span></li>
                      <li>Seal name <span style="color:red">*</span></li>
                      <li>Installed at <span style="color:red">*</span></li>
                      <li>Type <span style="color:red">*</span></li>
                      <li>Use <span style="color:red">*</span></li>
                      <li>Client <span style="color:red">*</span></li>
                    </ul>
                  <form enctype="multipart/form-data" id="file_upload_form" name="file_upload_form">
                    <input type="file" name="task_import" id="task_import" accept=".xls,.xlsx" >
                  </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <button type="button" class="btn btn-primary" id="upload_files" name="upload_files">Upload</button>

                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModal" aria-hidden="true">



        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Alert Data</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                </div>

                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Alert Modal -->


    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="{{asset('assets/vendor/jquery/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
    <script src="{{asset('assets/vendor/slimscroll/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('assets/vendor/multi-select/js/jquery.multi-select.js')}}"></script>
    <script src="{{asset('assets/libs/js/main-js.js')}}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/vendor/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="{{asset('assets/vendor/datatables/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/data-table.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> -->

    <script>
    var table;
    $(document).ready(function() {


          $.ajaxSetup({
                headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            get_clients_data();

            $('#upload_files').on('click', function(e) {
                e.preventDefault(); // Prevent the default button click behavior
                // alert('hi');
                // Create a FormData object from the form
                var formData = new FormData($('#file_upload_form')[0]);

                $.ajax({
                    url: '{{url("/upload_file")}}',  // Replace with your backend URL
                    type: 'POST',
                    data: formData,
                    contentType: false,       // Important: Don't set content type
                    processData: false,       // Important: Don't process the data
                    success: function(response) {
                        // Handle success
                        // console.log('File uploaded successfully.');
                        // console.log(response);
                        if (response.status === '200') {
                            $('#import_modal').modal('hide');

                            $('#alertModal .modal-body').text(response.message);
                            $('#alertModal').modal('show');
                        } else {
                            $('#alertModal .modal-body').text(response.message);
                            $('#alertModal').modal('show');
                        }
                        // You can also close the modal or show a success message here
                        // window.location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle error
                        console.error('Error uploading file.');
                        console.error('Status:', textStatus);
                        console.error('Error:', errorThrown);
                        // Display an error message or perform other error handling
                    }
                });
            });

            $('#zip_folder_button').click(function() {
                  $.ajax({
                      url: '{{url("download_zip")}}',
                      type: 'GET',
                      xhrFields: {
                          responseType: 'blob'
                      },
                      success: function(data) {
                          var a = document.createElement('a');
                          var url = window.URL.createObjectURL(data);
                          a.href = url;
                          a.download = 'dataupload.zip';
                          document.body.append(a);
                          a.click();
                          a.remove();
                          window.URL.revokeObjectURL(url);
                      },
                      error: function(xhr, status, error) {
                          console.error('An error occurred: ' + error);
                      }
                  });
              });


              $('#client_details_table tbody').on('click', 'tr', function () {
                  var data = table.row(this).data();
                  if (data) {
                        // Redirect to details page with the ID as a query parameter
                        window.location.href = '/details/' + data.id;
                  }
              });

              $('#alertModal').on('hidden.bs.modal', function () {
                  window.location.reload();
              });




        });

        function get_clients_data(){
          if ($.fn.DataTable.isDataTable('#client_details_table')) {
              // If it is, destroy it
              $('#client_details_table').DataTable().clear().destroy();
          }

            table =  $('#client_details_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ url("getData") }}',
                    columns: [
                        { data: 'unique_id', name: 'unique_id' },
                        { data: 'date_of_installation', name: 'date_of_installation' },
                        { data: 'seal_name', name: 'seal_name' },
                        { data: 'client', name: 'client', orderable: false, }
                    ]
                });
        }


    </script>

</body>

</html>
