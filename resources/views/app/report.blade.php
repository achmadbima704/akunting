@extends('layouts.app')

@section('content')
    <div class="row mx-5 col-md-4">
        <label class="col-sm-2 col-form-label" for="date">Bulan</label>
        <div class="col-sm-10">
            <input type="month" lang="id" id="date" class="form-control" value="{{ $month }}">
        </div>
    </div>
    <div class="row mx-5 mt-4 col-md-4">
        <div class="btn-group w-100 col-md-4" role="group">
            <a href="/daily-report" target="_blank" id="btn-daily" class="btn btn-danger">Daily Report</a>
            <a href="/avarage-report" target="_blank" id="btn-average" class="btn btn-warning">Rata - Rata Omset</a>
            <a href="/chart" target="_blank" id="btn-chart" class="btn btn-success">Grafik</a>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            let date = $('#date')

            $('#btn-daily').attr('href', `/daily-report/{{$month}}`)
            $('#btn-average').attr('href', `/avarage-report/{{$month}}`)
            $('#btn-chart').attr('href', `/chart/{{$month}}`)

            date.on('change', function () {
                $('#btn-daily').attr('href', `/daily-report/${date.val()}`)
                $('#btn-average').attr('href', `/avarage-report/${date.val()}`)
                $('#btn-chart').attr('href', `/chart/${date.val()}`)
            })
        })
    </script>
@endpush
