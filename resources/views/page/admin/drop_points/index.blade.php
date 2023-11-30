@extends('layouts.base_admin.base_dashboard')
@section('judul', 'Drop Point')
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
                <a href="{{route('export.drop')}}" class="btn btn-success">Export <i class="far fa-file-excel"></i></a>
            </div>

        </div>
        <div class="card-body p-0" style="margin: 20px">
            <div class="text-right">
                <!-- Button trigger modal -->
                 <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
                 Tambah
                 </button>
             </div>
            
                
            <table
                id="myTable"
                class="table table-striped table-bordered display"
                style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center w-20">Nama Drop Point</th>
                        <th class="text-center w-20">Alamat</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Drop Point</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route("drop-point.store")}}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nama</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Nama Drop Point" name="nama">
                <label for="exampleInputEmail1">Alamat</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Alamat Drop Point" name="alamat">
              </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>



  @foreach($data as $drop_point)
  <div class="modal fade" id="exampleModal{{$drop_point->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$drop_point->id}}" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel{{$drop_point->id}}">Update Drop Point</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('drop-point.update', $drop_point->id) }}" method="post">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                              placeholder="Masukan Nama" name="nama" value="{{ $drop_point->nama }}">
                            <label for="exampleInputEmail1">Alamat</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                  placeholder="Masukkan Alamat" name="alamat" value="{{ $drop_point->alamat }}">
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update changes</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
  @endforeach
</section>
@endsection

@section('script_footer')
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{ route('drop-point-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "id", "className": "text-center"},
                { "data": "nama"},
                { "data": "alamat"},
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
