@extends('layouts.base_user.base_user')
@section('judul', 'Penukaran Poin')
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
        </div>
        <div class="card-body p-0" style="margin: 20px">
            <div class="mb-4">
            </div>
            <table
                id="myTable"
                class="table table-striped table-bordered display"
                style="width:100% ">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>

                        <th class="text-center w-25">Jenis Sampah</th>
                        <th class="text-center">Jumlah Sampah</th>
                        <th class="text-center">Jumlah Poin</th>

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
                "url": "{{ route('users-penukaran-sampah-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "id", "className": "text-center"},
                {
                    "data": "created_at",
                    "className": "text-center",
                    "render": function (data) {
                        var date = new Date(data);
                        var options = { year: 'numeric', month: 'numeric', day: 'numeric' };
                        return date.toLocaleDateString('id-ID', options);
                    }
                },

                { "data": "jenis_sampah_id", "className": "text-center" },
                { "data": "jumlah_sampah"
                },
                { "data": "jumlah_point", "className": "text-center" },

            ],
        });
    });
</script>
@endsection
