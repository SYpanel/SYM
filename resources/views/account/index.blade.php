@extends('app')

@section('title')
    Accounts
@endsection

@section('subtitle')

@endsection

@section('breadcrumbs')
    <li class="active">Accounts</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">

                    <div class="card-title">
                        <div class="title">Accounts List</div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable table table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Domain</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Created on</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Domain</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Created on</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @forelse($accounts as $account)
                            <tr>
                                <td>{{$account->domain}}</td>
                                <td>{{$account->username}}</td>
                                <td>{{$account->email}}</td>
                                <td>{{$account->created_at}}</td>
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