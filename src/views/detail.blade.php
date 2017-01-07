@extends('xlog::template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-globe"></i> <b>{{ $log->request_method }}:</b> {{ url($log->url, [], env('SECURE')) }}
                        <small class="pull-right">Date: {{ date('M d Y H:i:s', strtotime($log->created_at)) }}</small>
                    </div>
                    <div class="panel-body">
                        <div class="box box-primary">


                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="box box-info">
                                            <div class="box-body with-header">
                                                <b>Response Code:</b> {{ $log->code }}<br>
                                                <b>User Type:</b> {{ ucwords($log->account_type) }}<br>
                                                <b>Title:</b> {{ $log->title }}<br>
                                                <b>Action:</b> {{ $log->controller_action }}<br>

                                                @if( isset($log->email) )
                                                    <b>Email:</b> {{ $log->email or '' }}<br>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="box box-warning">
                                            <div class="box-body with-header">
                                                <b>IP:</b> <a href="http://blacklist.myip.ms/{{ $log->ip }}" target="_blank">{{ $log->ip }}</a><br>
                                                <b>Session ID:</b> {{ $log->session_id }}<br>
                                                <b>City:</b> {{ $log->city }}<br>
                                                <b>Country:</b> {{ $log->country }}<br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="box box-success">
                                            <div class="box-body with-header">
                                                <b>Browser:</b> {{ $log->browser.' '.$log->browser_version }}<br>
                                                <b>OS:</b> {{ $log->os.' '.$log->os_version }}<br>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                @if( count((array)json_decode($log->request_params)) > 0 )
                                    <div class="row">
                                        <div class="col-lg-10 col-lg-offset-1">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Parameter</th>
                                                    <th>Value</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach((array)json_decode($log->request_params) as $key => $param)
                                                    <tr>
                                                        <td>{{ $key }}</td>
                                                        <?php try{
                                                            echo "<td>";
                                                            echo is_array($param) ? '<pre>'.print_r($param).'</pre>' : $param;
                                                            echo "</td>";
                                                        }catch(Exception $e){

                                                        } ?>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif


                                <div class="row">
                                    <div class="col-lg-12">
                                        @if( isset($log['trace']) )
                                            <b>Message:</b> {{ $log->error_main }}<br>
                                            <b>Class:</b> {{ $log->class }}<br>
                                            <b>Error:</b> {{ $log->error_main }} <br><br>
                                        @endif
                                        @if($log['trace'])
                                        <pre>
                                            {{ var_dump(explode('\n', $log['trace'])) }}
                                        </pre>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection