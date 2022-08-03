@extends('layouts.app')
@section('page-style')
@endsection
@section('content')
<div class="col-4 card text-center mx-auto">
    <div class="card-body">
        <h1 class="card-title">License Activator</h1><br>
        <div class="box">
            <div class="alert alert-danger mb-1">
                <div class="alert-body">
                    Do not run this activater if your license is active in the platform otherwise your site will show error 406
                </div>
            </div>
            @php
            $license_code = null;
            $client_name = null;
            @endphp
            @if(!empty($_POST['license'])&&!empty($_POST['client']))
              @php
                $license_code = strip_tags(trim($_POST["license"]));
                $client_name = strip_tags(trim($_POST["client"]));
                $activate_response = $api->activate_license($license_code, $client_name);
              @endphp
              @if(empty($activate_response))
                @php
                    $msg = 'Server is unavailable.';
                @endphp
              @else
                @php
                    $msg = $activate_response['message'];
                @endphp
              @endif
              @if($activate_response['status'] != true)
                <form action="{{ route('admin.lic.activate') }}" method="POST">
                    @csrf
                    <div class="alert alert-danger mb-1">
                        <div class="alert-body">
                            {{ ucfirst($msg) }}
                        </div>
                    </div>
                  <div class="text-start mb-1">
                    <label class="form-control-label">License code</label>
                    <div class="control">
                      <input class="form-control" type="text" placeholder="Enter your purchase/license code" name="license" required>
                    </div>
                  </div>
                  <div class="text-start mb-1">
                    <label class="form-control-label">Your name</label>
                    <div class="control">
                      <input class="form-control" type="text" placeholder="Enter your name/envato username" name="client" required>
                    </div>
                  </div>
                  <div style='text-align: right;'>
                    <button type="submit" class="button is-link is-rounded">Activate</button>
                  </div>
                </form>
                @else
                <div class="alert alert-success mb-1">
                    <div class="alert-body">
                        {{ ucfirst($msg) }}
                    </div>
                </div>
                @endif
            @else
              <form action="{{ route('admin.lic.activate') }}" method="POST">
                @csrf
                <div class="text-start mb-1">
                  <label class="form-control-label">License code</label>
                  <div class="control">
                    <input class="form-control" type="text" placeholder="Enter your purchase/license code" name="license" required>
                  </div>
                </div>
                <div class="text-start mb-1">
                  <label class="form-control-label">Your name</label>
                  <div class="control">
                    <input class="form-control" type="text" placeholder="Enter your name/envato username" name="client" required>
                  </div>
                </div>
                <div class="text-end">
                  <button type="submit" class="btn btn-success">Activate</button>
                </div>
              </form>
            @endif
          </div>
    </div>
</div>
<div class="col-6 text-center mx-auto">
    <p>Copyright {{ date('Y') }} Mashdiv, All rights reserved.</p><br>
</div>
@endsection
