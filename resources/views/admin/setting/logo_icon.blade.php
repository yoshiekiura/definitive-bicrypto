@extends('layouts.app')
@section('content')
<div class="row mb-none-30">
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 mb-1">
                            <div class="img-fluid"
                                style="height:80px;background-size: cover;background-image: url({{ getImage(imagePath()['logoIcon']['path'].'/logo.png', '?'.time()) }})">
                                <button type="button" class="btn-icon btn-danger rounded"><i
                                        class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <div class="img-fluid bg-dark"
                                style="height:80px;background-size: cover;background-image: url({{ getImage(imagePath()['logoIcon']['path'].'/logo.png', '?'.time()) }})">
                                <button type="button" class="btn-icon btn-danger rounded"><i
                                        class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="file" id="profilePicUpload1"
                                    accept=".png, .jpg, .jpeg" name="logo">
                                <label class="input-group-text"
                                    for="profilePicUpload1">{{ __('locale.Select Logo')}}</label>
                            </div>
                        </div>
                        <small class="ms-1 text-danger"><code>350px x 75px</code></small>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 mb-1">
                            <div class="img-fluid"
                                style="height:80px;width:80px;background-size: cover;background-image: url({{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png', '?'.time()) }})">
                                <button type="button" class="btn-icon btn-danger rounded"><i
                                        class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <div class="img-fluid bg-dark"
                                style="height:80px;width:80px;background-size: cover;background-image: url({{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png', '?'.time()) }})">
                                <button type="button" class="btn-icon btn-danger rounded"><i
                                        class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="file" id="profilePicUpload2" accept=".png"
                                    name="favicon">
                                <label for="profilePicUpload2"
                                    class="input-group-text">{{ __('locale.Select Favicon')}}</label>
                            </div>
                        </div>
                        <small class="ms-1 text-danger"><code>64px x 64px</code></small>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 btn-lg">{{ __('locale.Update')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style type="text/css">
    .logoPrev{
        background-size: 100%;
    }
    .iconPrev{
        background-size: 100%;
    }
</style>
@endpush
