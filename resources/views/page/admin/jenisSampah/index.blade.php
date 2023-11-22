@extends('layouts.base_admin.base_dashboard')
@section('judul', 'Jenis Sampah')
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
                        <th class="text-center w-25">Jenis Sampah</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route("sampah.store")}}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Jenis Sampah</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Jenis Sampah" name="jenis_sampah">

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



  @foreach($data as $sampah)
  <div class="modal fade" id="exampleModal{{$sampah->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$sampah->id}}" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel{{$sampah->id}}">Update Jenis Sampah</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('sampah.update', $sampah->id) }}" method="post">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                          <label for="exampleInputEmail1">Jenis Sampah</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                              placeholder="Masukkan Jenis Sampah" name="jenis_sampah" value="{{ $sampah->jenis_sampah }}">
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
                "url": "{{ route('sampah-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "id", "className": "text-center"},
                { "data": "jenis_sampah"
                },
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
