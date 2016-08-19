@extends('xlog::template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Website Requests Logs
                    </div>
                    <table class="table table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Code</th>
                            <th>IP</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>OS</th>
                            <th>Browser</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->title }}</td>
                                <td>{{ $log->url }}</td>
                                <td>{{ $log->response_code }}</td>
                                <td>{{ $log->ip }}</td>
                                <td>{{ $log->country or '' }}</td>
                                <td>{{ $log->city or '' }}</td>
                                <td>{{ $log->os or '' }}</td>
                                <td>{{ $log->browser or '' }}</td>
                                <td><a href="{{ url("/rscpanel/logs/{$log->id}", [], env('SECURE')) }}" class="btn {{ $log->exception ? 'btn-danger' : 'btn-primary' }} btn-sm btn-flat">Detail</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection