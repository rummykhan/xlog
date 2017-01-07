@extends('xlog::template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Logs
                    </div>
                    <table class="table table-striped table-responsive table-hover">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Method</th>
                            <th>URL</th>
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
                                <td>{{ $log->request_method }}</td>
                                <td>{{ $log->url }}</td>
                                <td>{{ $log->ip }}</td>
                                <td>{{ $log->country or '' }}</td>
                                <td>{{ $log->city or '' }}</td>
                                <td>{{ $log->os or '' }}</td>
                                <td>{{ $log->browser or '' }}</td>
                                <td><a href="{{ url( str_replace('{id}', $log->id ?: $log->_id, config('xlog.routes.detail.route') )) }}" class="btn {{ $log->exception ? 'btn-danger' : 'btn-primary' }} btn-sm btn-flat">Detail</a></td>
                                <td>
                                    <form method="POST" action="{{ url( str_replace('{id}', $log->id ?: $log->_id, config('xlog.routes.delete.route') )) }}" name="log-delete-form">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="submit" value="Delete" class="btn btn-primary btn-sm">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $logs->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection