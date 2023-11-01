@extends('layouts.base_admin.base_dashboard') @section('judul', 'Tambah Akun')
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
                <h1>Create News</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Create News</li>
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
            <h3 class="card-title">Create News</h3>

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
            <form action="{{route('news.store')}}" method="post" enctype="multipart/form-data">
                @csrf

            <div class="form-group">
                <label for="inputName">Title</label>
                <input
                    type="text"
                    id="inputName"
                    name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    placeholder="Enter Title"
                    value="{{ old('title') }}"
                    required="required"
                    autocomplete="title"
                />
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label>Tags</label>
                <div class="select2-purple">
                    <select
                    name="tags[]"
                        class="select2 select2-hidden-accessible"
                        multiple=""
                        data-placeholder="Select Tags"
                        data-dropdown-css-class="select2-purple"
                        style="width: 100%"
                        data-select2-id="15"
                        tabindex="-1"
                        aria-hidden="true"
                    >
                        @foreach ($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->nama}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail">Content</label>
                <textarea name="content" id="summernote" style="display: none;">
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input
                            type="file"
                            name="cover"
                            class="custom-file-input"
                            id="exampleInputFile"
                            accept=".png, .jpg, .jpeg"
                        />
                        <label class="custom-file-label" for="exampleInputFile"
                            >Choose file</label
                        >
                    </div>
                    <div class="input-group-append"></div>
                </div>
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
