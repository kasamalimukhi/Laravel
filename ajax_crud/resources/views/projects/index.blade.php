<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AJAX CRUD with Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">AJAX CRUD with Modal</h2>

        <div class="col-md-12 mt-4">
            <div class="alert alert-success alert-dismissible fade show" id="ajaxMessageAlert" style="display:none;">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <span id="ajaxMessage"></span>
            </div>
        </div>

        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#projectModal">
            Add New Project
        </button>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <button class="btn btn-success" id="exportPdfBtn">Export as a PDF</button>
            </div>
            <div>
                <button class="btn btn-info" id="exportCsvBtn">Export CSV</button>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importCsvModal">Import
                    CSV</button>
                <div class="search">
                    <input type="text" id="searchInput" placeholder="Search by Title, Name, Description, or Author"
                        class="form-control my-2">
                </div>
            </div>
            <!-- You can also add a search bar, filter, or other tools here if needed -->
        </div>

        <table class="table table-bordered text-center" id="projectTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Author</th>
                    <th>Prize</th>
                    <th>Actions</th>
                    {{-- <form action="/projects/${project.id}" method="POST" style="display:inline-block;" >
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="btn btn-danger btn-sm ms-3 btn-delete">Delete</button>
                    </form> --}}
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                        <input type="checkbox" id="selectall">
                        <label for="selectall">Select all</label>
                    </th>
                </tr>
            </thead>
            <tbody id="projectTableBody">
                @foreach ($projects as $project)
                <tr>
                    {{-- <td><input type="checkbox" class="select-item" name="selected_ids[]" value="{{ $project->id }}"></td>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->author }}</td>
                    <td>{{ $project->prize }}</td> --}}
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <button type="submit" id="deleteSelected" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete the selected items?');">
                Delete Selected
            </button>
        </div>
    </div>

    <!-- create Modal -->
    <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="projectForm">
                        <input type="hidden" id="project_id">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="author">
                        </div>
                        <div class="mb-3">
                            <label for="prize" class="form-label">Prize</label>
                            <input type="number" step="0.01" class="form-control" id="prize">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Show Project Modal -->
    <div class="modal fade" id="showProjectModal" tabindex="-1" aria-labelledby="showProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showProjectModalLabel">Project Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Project details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- csv import modal --}}
    <div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importCsvLabel">Import CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importCsvForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Choose CSV File</label>
                            <input type="file" class="form-control" id="csvFile" name="csvFile"
                                accept=".csv">
                        </div>
                        {{-- <button type="submit" class="btn btn-primary">Import</button> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="importCsvForm" class="btn btn-primary">Import</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            fetchProjects();

            function showMessage(message) {
                $('#ajaxMessage').text(message);
                $('#ajaxMessageAlert').slideDown();

                setTimeout(() => {
                    $('#ajaxMessageAlert').slideUp();
                }, 5000);
            }

            function fetchProjects() {
                $.ajax({
                    url: "{{ route('projects.fetch') }}",
                    method: 'GET',
                    success: function(data) {
                        let rows = '';
                        $.each(data, function(key, project) {
                            rows += `<tr data-id="${project.id}">
                    <td>${key + 1}</td> 
                    <td>${project.title}</td>
                    <td>${project.name}</td>
                    <td>${project.description}</td>
                    <td>${project.author}</td> 
                    <td>${project.prize}</td>
                    <td>
                        <input type="checkbox" class="select-item" name="selected_ids[]" value="${project.id}">
                        <button class="btn btn-info btn-show" data-id="${project.id}">Show</button>
                        <button class="btn btn-success btn-edit" data-id="${project.id}">Edit</button>
                        <button class="btn btn-danger btn-delete" data-id="${project.id}">Delete</button>   
                    </td>
                </tr>`;
                        });

                        $('#projectTableBody').html(rows);
                    },
                    error: function(xhr, status, error) {
                        console.error("Failed to fetch projects:", xhr.responseText);
                    }
                });
            }

            // Clear project_id and reset form when creating a new project
            $('#projectModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);

                if (button.hasClass('btn-create')) {
                    $('#project_id').val(''); // Clear the ID field
                    $('#projectForm')[0].reset(); // Reset the form fields
                }
            });

            $('#projectForm').submit(function(e) {
                e.preventDefault();

                let id = $('#project_id').val();
                let url = id ? `projects/${id}` : "{{ route('projects.store') }}";
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        title: $('#title').val(),
                        name: $('#name').val(),
                        description: $('#description').val(),
                        author: $('#author').val(),
                        prize: $('#prize').val(),
                    },
                    success: function(data) {
                        $('#projectModal').modal('hide');
                        $('#projectForm')[0].reset();
                        $('#project_id').val('');
                        fetchProjects();
                        // Show a message with the custom table index
                        let index;
                        if (id) {
                            // For updating, find the row index in the current table
                            index = $(`#projectTableBody tr[data-id="${id}"]`).index() + 1;
                        } else {
                            // For new records, get the total number of rows
                            index = $('#projectTableBody tr').length + 1;
                        }

                        showMessage(id ? `Project ${index} updated successfully` :
                            `Project ${index} created successfully`);
                    }
                });
            });

            $(document).on('click', '.btn-show', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/projects/${id}`,
                    method: 'GET',
                    success: function(data) {
                        $('#showProjectModal .modal-body').html(`
                <p><strong>ID:</strong> ${data.id}</p>
                <p><strong>Title:</strong> ${data.title}</p>
                <p><strong>Name:</strong> ${data.name}</p>
                <p><strong>Description:</strong> ${data.description}</p>
                <p><strong>Author:</strong> ${data.author}</p>
                <p><strong>Prize:</strong> ${data.prize}</p>
            `);
                        $('#showProjectModal').modal('show'); // Display the modal
                    },
                });
            });


            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get(`projects/${id}`, function(data) {
                    $('#project_id').val(data.id);
                    $('#title').val(data.title);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#author').val(data.author);
                    $('#prize').val(data.prize);
                    $('#projectModal').modal('show');
                });
            });

            $(document).on('click', '.btn-delete', function() {
                if (confirm('Are you sure you want to delete this project?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `projects/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            fetchProjects();
                            showMessage(`Project ${data.id} deleted successfully`);
                        },
                    });
                }
            });

            // CSV when the export button is clicked
            $(document).on('click', '#exportCsvBtn', function() {
                // Collect selected project IDs
                let selectedIds = [];
                $('input[name="selected_ids[]"]:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                // If no projects are selected, export all
                if (selectedIds.length === 0) {
                    Swal.fire({
                        title: 'No Selection!',
                        text: 'No projects selected, exporting all data.',
                        icon: 'info',
                        showConfirmButton: true,
                    });
                }

                Swal.fire({
                    title: 'Exporting...',
                    text: 'Your export is being processed. Please wait.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();

                        // Send the AJAX request to export the selected projects
                        $.ajax({
                            url: "{{ route('projects.export') }}",
                            method: 'POST',
                            data: {
                                selected_ids: selectedIds,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                // After export, show the success message
                                Swal.fire({
                                    title: 'Export Successful!',
                                    text: 'Your data has been exported successfully.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Trigger download of the exported file
                                window.location.href = response.fileUrl;
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Export Failed!',
                                    text: 'There was an error processing the export.',
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            });


            // handle CSV import
            $('#importCsvForm').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('projects.import.projects') }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // setTimeout(function() {
                        //     alert(response.success);
                        // }, 2000);

                        // Show success message with SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: response.success,
                            timer: 3000, // Auto-close after 2 seconds
                            showConfirmButton: false
                        });

                        // hide the modal and reset the form
                        $('#importCsvModal').modal('hide');
                        $('#importCsvForm')[0].reset();
                        fetchProjects();
                    },
                    error: function(xhr, status, error) {
                        console.error("Failed to import CSV:", xhr.responseText);
                        alert('Failed to import data!');
                    }
                });
            });

            $(document).on('click', '#exportPdfBtn', function() {
                // Show a loading message
                Swal.fire({
                    title: 'Exporting...',
                    text: 'Your PDF is being generated. Please wait.',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();

                        // Simulate a delay for exporting
                        setTimeout(() => {
                            // Start the export process
                            window.location.href = "{{ route('projects.export.pdf') }}";

                            // Show the success message after the export
                            Swal.fire({
                                title: 'Export Successful!',
                                text: 'Your PDF has been generated successfully.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }, 3000); // Adjust the delay time as necessary
                    }
                });
            });

            let timeout = null;
            $('#searchInput').on('keyup', function() {
                clearTimeout(timeout); // Clear the previous timeout

                let query = $(this).val();
                timeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('projects.search') }}",
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            console.log(response)
                            $('#projectTableBody').html(response);
                        }
                    });
                }, 300); 
            });


            // multiple select / delete 
            $('#selectall').on('change', function() {
                $('input[name="selected_ids[]"]').prop('checked', this.checked);
            });

            // Delete Selected
            $('#deleteSelected').on('click', function() {
                // Collect all selected IDs
                let selectedIds = [];
                $('input[name="selected_ids[]"]:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                
                if (selectedIds.length > 0) {
                    if (confirm('Are you sure you want to delete the selected items?')) {
                        // Send AJAX request to delete selected rows
                        $.ajax({
                            url: "{{ route('projects.bulkDelete') }}",
                            type: 'DELETE',
                            data: {
                                ids: selectedIds,
                                _token: '{{ csrf_token() }}' // Laravel CSRF protection
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Reload the table or remove the deleted rows from the table
                                    selectedIds.forEach(function(id) {
                                        $('input[value="' + id + '"]').closest('tr')
                                            .remove();
                                    });
                                    alert('Selected items deleted successfully!');
                                } else {
                                    alert('Error deleting items. Please try again.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                                alert('An error occurred: ' + xhr.responseText);
                            }
                        });
                    }
                } else {
                    alert('Please select at least one item to delete.');
                }
            });

        });
    </script>
</body>

</html>
