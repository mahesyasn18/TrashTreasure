@extends('layouts.base_admin.base_dashboard')
@section('judul', 'NEWS')
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
            <div class="d-flex justify-content-between">
                <h3 class="card-title">{{$title}} Table</h3>
                <a href="{{route('export-news')}}" class="btn btn-success">Export <i class="far fa-file-excel"></i></a>
            </div>
        </div>
        <div class="card-body p-0" style="margin: 20px">
            <table
                id="myTable"
                class="table table-striped table-bordered display"
                style="width:100% ">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center w-25">Title</th>
                        <th class="text-center">Cover</th>
                        <th class="text-center">Tags</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
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
                "url": "{{ route('news-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "id", "className": "text-center"},
                { "data": "title",
                    render: function (data, type, row) {
                        return data.replace(/\b\w/g, function (match) {
                            return match.toUpperCase();
                        });
                    }
                },
                { "data": "cover", "className": "text-center" },
                { "data": "tags" },
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
