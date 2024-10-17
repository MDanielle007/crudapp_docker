<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Simple Pet CRUD APP</title>
</head>

<body>
    <div class="container py-4">
        <form id="petForm" class="row gy-2 gx-3 align-items-center">
            <input type="hidden" class="form-control" id="id">
            <div class="col-auto">
                <label for="petName">Pet Name</label>
                <input type="text" class="form-control" id="petName">
            </div>
            <div class="col-auto">
                <label for="petType">Pet Type</label>
                <select class="form-select" id="petType">
                    <option selected>Choose...</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Hamster">Hamster</option>
                    <option value="Bird">Bird</option>
                    <option value="Pig">Pig</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="petAge">Pet Age</label>
                <input type="text" class="form-control" id="petAge">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <table id="dataTable" class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Pet Name</th>
                    <th scope="col">Pet Type</th>
                    <th scope="col">Pet Age</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Pet Name</label>
                        <input type="text" class="form-control" id="editName">
                    </div>
                    <div class="mb-3">
                        <label for="editType" class="form-label">Pet Type</label>
                        <input type="text" class="form-control" id="editType">
                    </div>
                    <div class="mb-3">
                        <label for="editAge" class="form-label">Pet Age</label>
                        <input type="text" class="form-control" id="editAge">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fetchData() {
            $.ajax({
                url: 'ajaxHandler.php',
                type: 'POST',
                data: { action: 'getAll' },
                dataType: 'json',
                success: function (data) {
                    var tbody = $('#dataTable tbody');
                    tbody.empty();
                    data.forEach(function (pet) {
                        var row = $('<tr>');
                        row.append('<td>' + pet.id + '</td>');
                        row.append('<td>' + pet.pet_name + '</td>');
                        row.append('<td>' + pet.pet_type + '</td>');
                        row.append('<td>' + pet.pet_age + '</td>');
                        row.append('<td><button class="btn btn-warning btn-edit" data-id="' + pet.id + '">Edit</button> ' +
                                   '<button class="btn btn-danger btn-delete" data-id="' + pet.id + '">Delete</button></td>');
                        tbody.append(row);
                    });
                }
            });
        }

        $(document).ready(() => {
            fetchData();

            // Edit button click event
            $(document).on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                $.post('ajaxHandler.php', { action: 'get', id: id }, function(data) {
                    $('#editId').val(data.id);
                    $('#editName').val(data.pet_name);
                    $('#editType').val(data.pet_type);
                    $('#editAge').val(data.pet_age);
                    $('#editModal').modal('show');
                }, 'json');
            });

            // Save changes button click event
            $('#saveChanges').click(function() {
                const id = $('#editId').val();
                const name = $('#editName').val();
                const type = $('#editType').val();
                const age = $('#editAge').val();
                $.post('ajaxHandler.php', { action: 'update', id: id, name: name, type: type, age: age }, function(response) {
                    alert(response.message);
                    $('#editModal').modal('hide');
                    fetchData();
                }, 'json');
            });

            // Delete button click event
            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this pet?')) {
                    $.post('ajaxHandler.php', { action: 'delete', id: id }, function(response) {
                        alert(response.message);
                        fetchData();
                    }, 'json');
                }
            });
        })
    </script>
</body>

</html>
