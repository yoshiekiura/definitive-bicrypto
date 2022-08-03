@extends('layouts.app')
@section('page-style')
@endsection
@section('content')
<div class="col-4 card text-center mx-auto">
    <div class="card-body">
        <h1 class="card-title">License Deactivator</h1><br>
        <div class="box">
            <div class="alert alert-success mb-1">
                <div class="alert-body">
                    Click on deactivate license to deactivate and remove the currently installed license from this installation, So that you can activate the same license on some other domain.
                </div>
            </div>
              @if(!empty($_POST))
                @php
                  $deactivate_response = $api->deactivate_license();
                @endphp
                @if(empty($deactivate_response))
                  @php
                      $msg='Server is unavailable.';
                  @endphp
                @else
                  @php
                      $msg=$deactivate_response['message'];
                  @endphp
                @endif
                @if($deactivate_response['status'] != true)
                  <form action="{{ route('admin.lic.deactivate') }}" method="POST">
                    @csrf
                    <div class="alert alert-danger mb-1">
                        <div class="alert-body">
                            {{ ucfirst($msg) }}
                        </div>
                    </div>
                    <input type="hidden" name="something">
                    <center>
                      <button type="submit" class="btn btn-danger">Deactivate License</button>
                    </center>
                  </form>
                @else
                <div class="alert alert-success mb-1">
                    <div class="alert-body">
                        {{ ucfirst($msg) }}
                    </div>
                </div>
                @endif
              @else
                <form action="{{ route('admin.lic.deactivate') }}" method="POST">
                    @csrf
                  <input type="hidden" name="something">
                  <center>
                    <button type="submit" class="btn btn-danger">Deactivate License</button>
                  </center>
                </form>
              @endif
          </div>
        </div>
    </div>
</div>
<div class="col-6 text-center mx-auto">
    <p>Copyright {{ date('Y') }} Mashdiv, All rights reserved.</p><br>
</div>
@endsection
