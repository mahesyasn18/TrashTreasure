@extends('layouts.base_admin.base_dashboard')
@section('judul', 'Akun')
@section('script_head')
@endsection

<style>
.swal2-default-outline:focus{
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
}
</style>

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$title}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">{{$title}}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
                <button
                    type="button"
                    class="btn btn-tool"
                    data-card-widget="collapse"
                    title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0" style="margin: 20px">
            <table
                id="myTable"
                class="table table-striped table-bordered display"
                style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Bergabung pada</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
@endsection 

@section('script_footer')
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{ route('users-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "id", "className": "text-center"},
                { "data": "name",
                    render: function (data, type, row) {
                        return data.replace(/\b\w/g, function (match) {
                            return match.toUpperCase();
                        });
                    } 
                },
                { "data": "email"},
                { "data": "created_at"},
                { "data": "options", "className": "text-center" }
            ],
        });

        // hapus data
        $('#myTable').on('click', '.hapusData', function () {
            var id = $(this).data("id");
            var url = $(this).data("url");
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DC3545",
                confirmButtonText: 'Ya, hapus!',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}"
                        },
                        success: function (response) {
                            Swal.fire('Terhapus!', response.msg, 'success');
                            $('#myTable').DataTable().ajax.reload();
                        }
                    });
                }
            })
        });
    });
</script>
@endsection
