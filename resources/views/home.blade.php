@extends('layouts.base_admin.base_dashboard')
@section('judul', 'Halaman Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Beranda</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        
                        {{ __('You are logged in!') }}
                        <a href="{{ url('/logout') }}" class="text-sm text-gray-700 dark:text-gray-500 underline ml-2"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
