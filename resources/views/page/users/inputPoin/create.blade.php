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
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Penukaran Poin Menjadi Uang</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Beranda</a></li>
            <li class="breadcrumb-item active">Penukaran Poin Menjadi Uang</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>

        <!-- Main content -->
        <section class="content container-fluid d-flex align-items-center justify-content-center">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Create Penukaran Poin Menjadi Uang</h3>


                </div>
                <div class="card-body">
                    <form action="{{route('poin.stores')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input id="my-input" type="hidden" name="user_id" value="{{auth()->user()->id}}">
                        <div class="form-group">
                                <label for="exampleInputEmail1">Nama Pembuang Sampah</label>
                                <input type="text" value="{{auth()->user()->name}}" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="auth()->user()->name" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Jumlah Poin</label>
                            <input type="number" name="jumlah_poin" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    <div class="mt-3">
                        <h4>Your Current Points:</h4>
                        @if ($poin)
                            <p>Total Points: {{ $poin->jumlah_poin}}</p>
                            <!-- Add more information if needed -->
                        @else
                            <p>No points available.</p>
                        @endif
                    </div>
                    <h6 class="text-success text-bold">Note:</h6>
                    <p class="text-success text-bold">1 poin = Rp. 100</p>

                </div>

                <!-- /.card-body -->
            </div>
        </section>

@endsection
@section('script_footer')
<script></script>
@endsection
