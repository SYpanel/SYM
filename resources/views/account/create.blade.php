@extends('app')

@section('title')
    Create New Account
@endsection

@section('subtitle')

@endsection

@section('breadcrumbs')
    <li class="">Accounts</li>
    <li class="active">Create New Account</li>
@endsection

@section('content')
    <form class="form-horizontal" action="{{action('AccountsController@store')}}" method="post">
        {{csrf_field()}}
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Account Info</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="domain" class="col-sm-2 control-label">Domain</label>
                            <div class="col-sm-5">
                                <input name="domain" id="domain" type="text" class="form-control" placeholder="example.com" title="Valid Domain name only" required pattern="[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-5">
                                <input name="username" id="username" type="text" class="form-control" required maxlength="16" pattern="[a-z][-a-z0-9]*">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-5">
                                <input name="password" id="password" type="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="repassword" class="col-sm-2 control-label">Retype Password</label>
                            <div class="col-sm-5">
                                <input name="repassword" id="repassword" type="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-strength" class="col-sm-2 control-label">Strength</label>
                            <div class="col-sm-3">
                                <div class="progress">
                                    <div id="complexity-bar" class="progress-bar" role="progressbar"></div>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <span id="complexity">0%</span>
                            </div>
                            <div style="text-align: center;" class="col-xs-1">
                                <button id="generate-password" type="button" class="btn">Generate Password</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-5">
                                <input name="email" id="email" type="email" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Account Resources</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="package_id" class="col-sm-2 control-label">Package</label>
                                <div class="col-sm-5">
                                <select name="package_id" id="package_id">
                                    @foreach($packages as $package)
                                        <option value="{{$package->id}}">{{$package->name}}</option>
                                    @endforeach
                                </select>
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
                                <button type="submit" class="btn btn-default">Create Account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        $('#generate-password').pGenerator({
            'bind': 'click',
            'passwordElement': '#password',
            'displayElement': '#display-password',
            'passwordLength': 16,
            'uppercase': true,
            'lowercase': true,
            'numbers': true,
            'specialChars': true,
            'onPasswordGenerated': function (generatedPassword) {
                $('#repassword').val(generatedPassword);
                $('#password').trigger('keyup');
                swal({
                    title: 'Password',
                    html: '<input id="' + generatedPassword + '" readonly type="text" value="' + generatedPassword + '">',
                });
            }
        });

        $('#password').complexify({
            bannedPasswords: ['Aa123456'],
            minimumChars: 8
        }, function (valid, complexity) {
            var progressBar = $('#complexity-bar');

            progressBar.toggleClass('progress-bar-success', valid);
            progressBar.toggleClass('progress-bar-danger', !valid);
            progressBar.css({'width': complexity + '%'});

            $('#complexity').text(Math.round(complexity) + '%');
        });

        $('#package_id').bind('change', function () {
            if (this.value != '') {
                $.ajax({
                    url: '{{action('PackagesController@packageJSON')}}',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        id: this.value
                    },
                    success: function (json) {
                        $.each(json, function (k,v) {
                            $('#'+k).val(v);
                        });
                    }
                });
            }
        });
        $('#package_id').trigger('change');
    </script>
@endsection