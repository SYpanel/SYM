@extends('app')

@section('title')
    Manage Services
@endsection

@section('subtitle')

@endsection

@section('breadcrumbs')
    <li class="">Server</li>
    <li class="active">Services</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div id="services_form" class="card">
                <form class="form-horizontal" action="{{action('PackagesController@store')}}" method="post">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <div class="title">Services</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach($services as $service => $status)
                                        <div class="form-group">
                                            <label for="{{$service}}" class="col-sm-2 control-label">{{$service}}</label>
                                            <div class="col-sm-4">
                                                <input type="checkbox" data-action="change" class="toggle-checkbox services-change" name="{{$service}}" {{($status ? 'checked' : '')}}>
                                                <button type="button" name="{{$service}}" data-action="reload" class="btn btn-default service-re">Reload</button>
                                                <button type="button" name="{{$service}}" data-action="restart" class="btn btn-default service-re">Restart</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('input.services-change').on('switchChange.bootstrapSwitch', function (event, state) {
            $('#services_form').addClass('loader');
            $.ajax({
                url: '{{action('ServerController@serviceChange')}}',
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'change',
                    service: this.name,
                    status: state
                },
                success: function (json) {
                    $('#services_form').removeClass('loader');
                }
            })
            ;
        });

        $('button.service-re').on('click', function (event, state) {
            $('#services_form').addClass('loader');
            $.ajax({
                url: '{{action('ServerController@serviceChange')}}',
                type: 'post',
                dataType: 'json',
                data: {
                    action: $(this).attr('data-action'),
                    service: this.name,
                },
                success: function (json) {
                    $('#services_form').removeClass('loader');
                }
            })
            ;
        });
    </script>
@endsection