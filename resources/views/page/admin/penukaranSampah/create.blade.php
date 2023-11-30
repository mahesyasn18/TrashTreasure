@extends('layouts.base_admin.base_dashboard') @section('judul', 'Form Penukaran Sampah ke Poin')
@section('script_head')
<link
    rel="stylesheet"
    href="{{ asset('vendor/adminlte3/css/select2-bootstrap4.min.css') }}"
/>
<link
    rel="stylesheet"
    href="{{ asset('vendor/adminlte3/css/select2.min.css') }}"
/>
<link
    rel="stylesheet"
    href="{{ asset('vendor/adminlte3/css/select2.min.css') }}"
/>
<link
    rel="stylesheet"
    href="{{ asset('vendor/adminlte3/css/summernote-bs4.min.css') }}"
/>

@endsection @section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Penukaran Sampah Menjadi Poin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Form Penukaran Sampah Menjadi Poin</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Create Penukaran Sampah Menjadi Poin</h3>

            <div class="card-tools">
                <button
                    type="button"
                    class="btn btn-tool"
                    data-card-widget="collapse"
                    title="Collapse"
                >
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('riwayat-penukaran-sampah.store')}}" method="post">
                @csrf
            <div class="form-group">
                <label for="exampleFormControlSelect1">Pilih Nama</label>
                <select class="form-control" id="exampleFormControlSelect1" name="user_id">
                    <option hidden>-- Silahkan Pilih Nama Pembuang Sampah --</option>
                    @foreach ($user as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach

                </select>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Pilih Jenis Sampah</label>
                <select class="form-control" id="exampleFormControlSelect1" name="jenis_sampah_id">
                    <option hidden>-- Silahkan Pilih Jenis Sampah --</option>
                    @foreach ($jenissampah as $item)
                    <option value="{{$item->id}}">{{$item->jenis_sampah}}</option>
                    @endforeach

                </select>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Berat Sampah (kg)</label>
                <input type="number" name="jumlah_sampah" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>

        <!-- /.card-body -->
    </div>
</section>
<!-- /.content -->

@endsection @section('script_footer')
<script src="{{ asset('vendor/adminlte3/js/select2.full.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte3/js/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte3/js/bs-custom-file-input.min.js') }}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
    });
</script>
<script>
    $(document).ready(function () {
        $("#summernote").summernote();
    });
</script>
<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>
@endsection
