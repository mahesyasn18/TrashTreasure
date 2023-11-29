@extends('layouts.base_admin.base_dashboard')
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
            <h3 class="card-title">{{$title}} Table</h3>
        </div>
        <div class="card-body p-0" style="margin: 20px">
            <table
                id="myTable"
                class="table table-striped table-bordered display"
                style="width:100% ">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center w-25">Nama Pembuang Sampah</th>
                        <th class="text-center">Jumlah Poin</th>
                        <th class="text-center">Jumlah Uang</th>
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
                "url": "{{ route('penukaran-poin-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "id", "className": "text-center"},
                { "data": "user_id", "className": "text-center" },
                { "data": "jumlah_sampah"
                },
                { "data": "jumlah_point", "className": "text-center" },
            ],
        });
    });
</script>
@endsection
