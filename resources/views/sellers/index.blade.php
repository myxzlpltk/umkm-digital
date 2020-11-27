@extends('layouts.console.app')

@section('title', 'Penjual')

@section('breadcrumbs', Breadcrumbs::render('manage.sellers.index'))

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('card-stats')
@endsection

@section('header')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Data Penjual</h3>
        </div>
        <div class="table-responsive py-4">
            <table class="table align-items-center table-flush" id="datatable-basic">
                <thead class="thead-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sellers as $user)
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-auto">
                                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" class="avatar rounded-circle" alt="avatar">
                                </div>
                                <div class="col">
                                    <strong>{{ $user->name }}</strong><br>
                                    <span class="small text-muted">{{ $user->seller ? $user->seller->store_name: '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $user->email }}
                            @if($user->hasVerifiedEmail())
                                <i class="fas fa-check-circle fa-fw text-primary" data-toggle="tooltip" data-original-title="Terverifikasi"></i>
                            @else
                                <i class="fas fa-times-circle fa-fw text-danger" data-toggle="tooltip" data-original-title="Tidak Terverifikasi"></i>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('manage.users.show', $user) }}" class="table-action" data-toggle="tooltip" data-original-title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush
