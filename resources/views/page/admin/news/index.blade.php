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
                        <td>
                            @foreach($d->tags as $tag)
                                {{$tag->nama}},
                            @endforeach
                        </td>
                        <td>
                            <a type="button" class="btn btn-warning" href="/dashboard/admin/news/{{$d->id}}"><i class="fas fa-edit"></i></a>
                            <a type="button" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Data tidak ditemukan.</td></tr>
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
    <script>
        $(document).ready(function () {
                    $('#previewAkun').DataTable({
                        "serverSide": true,
                        "processing": true,
                        "ajax": {
                            "url": "/dashboard/admin/news",
                            "dataType": "json",
                            "type": "POST",
                            "data": {
                                _token: "{{csrf_token()}}"
                            }
                        },
                        "columns": [
                            {
                                "data": "title"
                            }, {
                                "data": "cover"
                            }, {
                                "data": "options"
                            }
                        ],
                        "language": {
                            "decimal": "",
                            "emptyTable": "Tak ada data yang tersedia pada tabel ini",
                            "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                            "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                            "infoFiltered": "(difilter dari _MAX_ total entri)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Tampilkan _MENU_ entri",
                            "loadingRecords": "Loading...",
                            "processing": "Sedang Mengambil Data...",
                            "search": "Pencarian:",
                            "zeroRecords": "Tidak ada data yang cocok ditemukan",
                            "paginate": {
                                "first": "Pertama",
                                "last": "Terakhir",
                                "next": "Selanjutnya",
                                "previous": "Sebelumnya"
                            },
                            "aria": {
                                "sortAscending": ": aktifkan untuk mengurutkan kolom ascending",
                                "sortDescending": ": aktifkan untuk mengurutkan kolom descending"
                            }
                        }
    
                    });
    
                    // hapus data
                    $('#previewAkun').on('click', '.hapusData', function () {
                        var id = $(this).data("id");
                        var url = $(this).data("url");
                        Swal
                            .fire({
                                title: 'Apa kamu yakin?',
                                text: "Kamu tidak akan dapat mengembalikan ini!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    // console.log();
                                    $.ajax({
                                        url: url,
                                        type: 'DELETE',
                                        data: {
                                            "id": id,
                                            "_token": "{{csrf_token()}}"
                                        },
                                        success: function (response) {
                                            // console.log();
                                            Swal.fire('Terhapus!', response.msg, 'success');
                                            $('#previewAkun').DataTable().ajax.reload();
                                        }
                                    });
                                }
                            })
                    });
            });
    </script>
@endsection
