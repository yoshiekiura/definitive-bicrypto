@extends('layouts.app')
@php
    $api = new \App\Http\Controllers\Admin\Ext\InstallController;
@endphp
@section('content')
<div class="col-6 card text-center mx-auto">
    <div class="card-body">
        <h1 class="card-title">Extension Activator</h1><br>
        <div class="box">
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
              @if(empty($activate_response)){
                <div class="alert alert-danger mb-1">
                    <div class="alert-body">
                        Server is unavailable.
                    </div>
                </div>
              @else
                <div class="alert alert-success mb-1">
                    <div class="alert-body">
                        {{ $activate_response['message'] }}
                    </div>
                </div>
              @endif
              @if($activate_response['status'] != true)
                <form action="{{ route('admin.extensions.verify') }}" method="POST">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->product_id }}">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="basic-addon3">License code</span>
                        <input class="form-control" type="text" placeholder="Enter your purchase/license code" name="license" required>
                    </div>
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="basic-addon3">Your name</span>
                        <input class="form-control" type="text" placeholder="Enter your name/envato username" name="client" required>
                    </div>
                    <div class="mt-1 text-end">
                        <button type="submit" class="btn btn-success">Activate</button>
                      </div>
                  </form>
                @else
                <div class="alert alert-success mb-1">
                    <div class="alert-body">
                        {{ $activate_response['message'] }}
                    </div>
                </div>
                @endif
            @else
                <form action="{{ route('admin.extensions.verify') }}" method="POST">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->product_id }}">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="basic-addon3">License code</span>
                        <input class="form-control" type="text" placeholder="Enter your purchase/license code" name="license" required>
                    </div>
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="basic-addon3">Your name</span>
                        <input class="form-control" type="text" placeholder="Enter your name/envato username" name="client" required>
                    </div>
                  <div class="mt-1 text-end">
                    <button type="submit" class="btn btn-success">Activate</button>
                  </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="col-6 text-center mx-auto">
    <p>Copyright <?php echo date('Y'); ?> Mashdiv, All rights reserved.</p><br>
</div>
@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-success" href="{{ route('admin.clean') }}"><i class="bi bi-speedometer2"></i> {{ __('locale.Optimize')}}</a>
@endpush
