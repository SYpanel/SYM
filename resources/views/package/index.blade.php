@extends('app')

@section('title')
    Packages
@endsection

@section('subtitle')

@endsection

@section('breadcrumbs')
    <li class="active">Packages</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">

                    <div class="card-title">
                        <div class="title">Packages List</div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable table table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Disk Space</th>
                            <th>Bandwidth</th>
                            <th>Emails</th>
                            <th>Databases</th>
                            <th>Sub Domains</th>
                            <th>Parked Domains</th>
                            <th>Addon Domains</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Disk Space</th>
                            <th>Bandwidth</th>
                            <th>Emails</th>
                            <th>Databases</th>
                            <th>Sub Domains</th>
                            <th>Parked Domains</th>
                            <th>Addon Domains</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @forelse($packages as $package)
                            <tr>
                                <td>{{$package->name}}</td>
                                <td>{{$package->disk_space}}</td>
                                <td>{{$package->bandwidth}}</td>
                                <td>{{$package->emails}}</td>
                                <td>{{$package->dbs}}</td>
                                <td>{{$package->sub_domains}}</td>
                                <td>{{$package->parked_domains}}</td>
                                <td>{{$package->addon_domains}}</td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
    </script>
@endsection