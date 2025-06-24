<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: aliceblue;
            font-family: 'Franklin Gothic Medium', sans-serif;
            padding: 10px 10px 30px;
        }
        h1 {
            font-size: 30px;
            text-align: center;
            margin-top: 80px; /* Adjusted to position below navbar */
        }
        table {
            width: 90%;
            text-align: center;
            margin: 10px auto;
            border-collapse: collapse;
        }
        th, td {
            border: double 2px black; /* Double border for all cells */
            padding: 10px 20px;
        }
        th {
            font-size: large;
            font-family: sans-serif;
            background-color: darkblue; /* Dark blue background */
            color: white; /* White text */
        }
        .blocked {
            color: red;
        }
        .unblocked {
            color: green;
        }
        button {
            background-color: darkviolet;
            color: white;
        }
        #search {
            margin: 10px;
            padding: 8px;
            width: 300px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            padding: 10px 15px;
            border: 1px solid darkviolet;
            margin: 0 5px;
            text-decoration: none;
            color: darkviolet;
        }
        .pagination a.active {
            background-color: darkviolet;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    @include('navbar_admin') <!-- Make sure navbar_admin.blade.php exists in resources/views -->

    <h1><i class="fas fa-user"></i> MANAGE USERS</h1>

    <input type="text" id="search" placeholder="Search by username..." />

    <table id="t1">
        <thead>
            <tr>
                <th>SNo</th>
                <th>USERNAME</th>
                <th>EMAIL</th>
                <th>PHONE</th>
                <th>ADDRESS</th>
                <th>BLOCK/UNBLOCK</th>
                <th>VIEW</th>
            </tr>
        </thead>
        <tbody id="userTable">
            @foreach ($pages as $page)
                <tr class="{{ $page->is_blocked ? 'blocked' : 'unblocked' }}">
                    <td>{{ $page->id }}</td>
                    <td>{{ $page->username }}</td>
                    <td>{{ $page->email }}</td>
                    <td>{{ $page->phone }}</td>
                    <td>{{ $page->address }}</td>
                    <td>
                        <button class="block-unblock" data-id="{{ $page->id }}" data-blocked="{{ $page->is_blocked }}">
                            @if($page->is_blocked)
                                <i class="fas fa-unlock"></i> Unblock
                            @else
                                <i class="fas fa-lock"></i> Block
                            @endif
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('user.details', ['id' => $page->id]) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $pages->links() }}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Search functionality
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#userTable tr").filter(function() {
                    $(this).toggle($(this).find("td:nth-child(2)").text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Block/Unblock button functionality
            $(".block-unblock").click(function() {
                var button = $(this);
                var id = button.data("id");
                var is_blocked = button.data("blocked") == 1 ? 0 : 1; // Toggle blocked status

                $.ajax({
                    url: "{{ url('admin/users/block-unblock') }}",
                    method: "POST",
                    data: {
                        id: id,
                        is_blocked: is_blocked,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        alert(response);

                        // Update button text and data attribute
                        button.data("blocked", is_blocked);
                        button.html(is_blocked ? '<i class="fas fa-unlock"></i> Unblock' : '<i class="fas fa-lock"></i> Block');

                        // Change the row class based on the new blocked status
                        var row = button.closest('tr');
                        row.removeClass('blocked unblocked');
                        row.addClass(is_blocked ? 'blocked' : 'unblocked');
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message);
                    }
                });
            });
        });
    </script>
</body>
</html>
