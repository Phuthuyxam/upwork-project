@extends('backend.default')
@section('title')
    Logs
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Logs</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        @if(isset($messages) && !empty($messages))
                        <tbody>
                            @foreach($messages as $value)
                                <tr>
                                    <td>
                                        {{$value}}
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
