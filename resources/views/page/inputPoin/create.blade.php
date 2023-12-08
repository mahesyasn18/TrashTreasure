<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Penukaran Poin Jadi Uang | Trash Treasure</title>
        <!-- Style -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('vendor/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('vendor/adminlte3/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte3/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte3/css/adminlte.min.css') }}">
        <!-- dataTables -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
        @yield('script_head')
    </head>

    <body>
        <section class="content-header">
            <div class="container-fluid d-flex align-items-center justify-content-center">

                <h1>Penukaran Poin Menjadi Uang</h1>

            </div>
            <!-- /.container-fluid -->
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

                </div>

                <!-- /.card-body -->
            </div>
        </section>
        <!-- jQuery -->
        <script src="{{ asset('vendor/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @include('sweetalert::alert')
        @yield('script_footer')
        
    </body>
</html>

