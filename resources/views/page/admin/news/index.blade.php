@extends('layouts.base_admin.base_dashboard')
@section('judul', 'NEWS')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>News</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
            <li class="breadcrumb-item active">News</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>

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
                <button
                    type="button"
                    class="btn btn-tool"
                    data-card-widget="remove"
                    title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0" style="margin: 20px">
            <table
                id="previewAkun"
                class="table table-striped table-bordered display"
                style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Cover</th>
                        <th>Tags</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $d)
                    <tr>
                        <td>{{$d->title}}</td>
                        <td>{{$d->cover}}</td>
                        <td>{{$d->tag->nama}}</td>
                        <td>Tombol</td>
                    </tr>
                    @empty
                    <tr><td colspan="4">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>

@endsection @section('script_footer')
<script
    type="text/javascript"
    src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script
    type="text/javascript"
    src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
@endsection
