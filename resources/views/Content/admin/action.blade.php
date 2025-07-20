<a href="{{ route('center-point.edit', $model) }}" class="btn btn-warning btn-sm">Edit</a>
<form action="{{ route('center-point.destroy', $model) }}" method="POST" class="d-inline" id="delete-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm" id="delete">Delete</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    $('#delete').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
    })
</script>