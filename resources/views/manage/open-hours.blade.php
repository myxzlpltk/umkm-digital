@extends('layouts.console.app')

@section('title', 'Jam Buka')

@section('breadcrumbs', Breadcrumbs::render('manage.open-hours.index'))

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('actions')
@endsection

@section('card-stats')
@endsection

@section('header')
@endsection

@section('content')
    <form action="{{ route('manage.open-hours.update') }}" method="post">
        @csrf
        @method('PATCH')

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="mb-0">Jam Buka</h3>
            </div>
            <div class="table-responsive py-4">
                <table class="table align-items-center table-flush table-sm">
                    <thead class="thead-light">
                    <tr>
                        <th>Hari</th>
                        <th>Mulai</th>
                        <th>Akhir</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($days as $day)
                        <tr>
                            <td>
                                {{ $day->name }}
                                <input type="hidden" name="day_id[{{ $day->id }}]" value="{{ $day->id }}">
                                @error('day_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="time" class="form-control form-control-sm @error('food_name') is-invalid @enderror" value="{{ old("start.{$day->id}", substr(optional($day->pivot)->start, 0, 5)) }}" name="start[{{ $day->id }}]">
                                @error("start.{$day->id}")
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="time" class="form-control form-control-sm @error('food_name') is-invalid @enderror" value="{{ old("end.{$day->id}", substr(optional($day->pivot)->end, 0, 5)) }}" name="end[{{ $day->id }}]">
                                @error("end.{$day->id}")
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-body pt-0">
                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save fa-fw"></i> Simpan</button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush
