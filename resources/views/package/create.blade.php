@extends('app')

@section('title')
    Create New Package
@endsection

@section('subtitle')

@endsection

@section('breadcrumbs')
    <li class="">Packages</li>
    <li class="active">Create New Package</li>
@endsection

@section('content')
    <form class="form-horizontal" action="{{action('PackagesController@store')}}" method="post">
        {{csrf_field()}}
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Package Resources</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Package Name</label>
                            <div class="col-sm-3">
                                <input required name="name" id="name" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="disk_space" class="col-sm-2 control-label">Disk Space (MB)</label>
                            <div class="col-sm-1">
                                <input name="disk_space" id="disk_space" type="number" class="form-control" placeholder="0" required pattern="\d+">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bandwidth" class="col-sm-2 control-label">Bandwidth (MB)</label>
                            <div class="col-sm-1">
                                <input name="bandwidth" id="bandwidth" type="number" class="form-control" placeholder="0" required pattern="\d+">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="emails" class="col-sm-2 control-label">Email boxes</label>
                            <div class="col-sm-1">
                                <input name="emails" id="emails" type="number" class="form-control" placeholder="0" required pattern="\d+">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dbs" class="col-sm-2 control-label">Databases</label>
                            <div class="col-sm-1">
                                <input name="dbs" id="dbs" type="number" class="form-control" placeholder="0" required pattern="\d+">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sub_domains" class="col-sm-2 control-label">Sub Domains</label>
                            <div class="col-sm-1">
                                <input name="sub_domains" id="sub_domains" type="number" class="form-control" placeholder="0" required pattern="\d+">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="parked_domains" class="col-sm-2 control-label">Parked Domains</label>
                            <div class="col-sm-1">
                                <input name="parked_domains" id="parked_domains" type="number" class="form-control" placeholder="0" required pattern="\d+">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="addon_domains" class="col-sm-2 control-label">Addon Domains</label>
                            <div class="col-sm-1">
                                <input name="addon_domains" id="addon_domains" type="number" class="form-control" placeholder="0" required pattern="\d+">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Create Package</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
@endsection