@extends(themeView('admin', 'layout.main'))
@push('style')
    <link rel="stylesheet" href="{{ themeAsset('admin', 'css/dropzone.min.css') }}" type="text/css" />
    <style>
        .image-container {
            position: relative;
            overflow: hidden;
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-container:hover .delete-btn {
            opacity: 1;
        }
    </style>
@endpush
@push('script')
    <script src="{{ themeAsset('admin', 'js/dropzone.js') }}"></script>
@endpush
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>@lang("admin/{$folder}.images")</h4>
                    <h6>@lang("admin/{$folder}.images_description")</h6>
                </div>
            </div>
            @php
            @endphp
            {{ html()->form('DELETE')->route("admin.{$route}.destroyAllImages", $service)->open() }}
            <a href="javascript:void(0);" class="btn btn-danger confirm-btn">{{ __('admin/general.all_delete') }}</a>
            {{ html()->form()->close() }}
        </div>
        <div class="card">
            <div class="card-body">
                {{ html()->form()->route("admin.{$route}.storeImage", $service)->class('dropzone mb-4')->acceptsFiles()->open() }}
                {{ html()->form()->close() }}
                <div class="row">
                    @foreach ($service->getMedia('gallery') as $image)
                        <div class="col-lg-2 col-md-3">
                            <div class="image-container p-2 border rounded position-relative mb-4">
                                <img src="{{ $image->getUrl() }}" class="img-fluid" alt="">
                                {{ html()->form('DELETE')->route("admin.media.destroy", $image)->open() }}
                                <button type="button" class="confirm-btn delete-btn btn btn-danger btn-sm">
                                    @lang("admin/general.delete")
                                </button>
                                {{ html()->form()->close() }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
