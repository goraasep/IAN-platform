@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            {{-- <table class="table table-bordered" id="device_list">
                <thead>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Created At</th>
                </thead>
            </table> --}}
            {!! $chart->container() !!}
            {!! $chart->script() !!}
        </div>
    </div>
@endsection
