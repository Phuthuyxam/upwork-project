@if($dataHome->isNotEmpty())
    @php
        $dataHome = json_decode($dataHome[0]->option_value, true);
    @endphp
@endif
@section('title')
    Home page setting
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Home Page</h4>
@endsection
<h4 class="card-title">Home Options</h4>
<p class="card-title-desc">All setting of home page</p>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-tabs-custom" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">Slider</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab2" role="tab">Our Services</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab3" role="tab">Our Hotels</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab4" role="tab">Message</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab5" role="tab">Our brands</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab6" role="tab">More yet to come</a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active p-3" id="tab1" role="tabpanel">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Slider</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                @if(isset($dataHome['slider']) && !empty($dataHome['slider']))
                    @foreach($dataHome['slider'] as $key => $slider)
                        <tr>
                            <td class="counter">{{ $key + 1 }}</td>
                            <td style="">
                                <div class="row">
                                    <div class="col-lg-12" style="margin-bottom: 30px">
                                        <textarea rows="8" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_desc[]"
                                                  placeholder="Type hotel description" class="form-control option-home-slider-desc">{{ (isset($slider['desc']) && !empty($slider['desc'])) ? $slider['desc'] : ""  }}</textarea>
                                    </div>
                                    <div class="col-lg-12" style="margin-bottom: 30px">
                                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_url[]"
                                               placeholder="Type url" class="form-control option-home-slider-url" value="{{ (isset($slider['url']) && !empty($slider['url'])) ? $slider['url'] : ""  }}">
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="mb-1">
                                            Logo image
                                        </label>
                                        <div class="form-group media-load-image">
                                            <div class="preview-image" >
                                                <div class="close" onclick="deleteImagePreview(this)">
                                                    <i class="dripicons-cross"></i>
                                                </div>
                                                <div class="image-preview-container">
                                                    @if(isset($slider['logo']) && !empty($slider['logo']))
                                                        <img class="image-preview" style="width: 100%" src="{{ $slider['logo'] }}" alt="your image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_logo[]"
                                                       class="form-control required home-slider-image" aria-describedby="button-image" readonly
                                                       value="{{ (isset($slider['logo']) && !empty($slider['logo'])) ? $slider['logo'] : ''  }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-top: 30px">
                                        <label class="mb-1">
                                            Banner image
                                        </label>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Desktop</label>
                                            <div class="col-sm-10">

                                                <div class="form-group media-load-image">
                                                    <div class="preview-image" >
                                                        <div class="close" onclick="deleteImagePreview(this)">
                                                            <i class="dripicons-cross"></i>
                                                        </div>
                                                        <div class="image-preview-container">
                                                            @if(isset($slider['banner_desktop']) && !empty($slider['banner_desktop']))
                                                                <img class="image-preview" style="width: 100%" src="{{ $slider['banner_desktop'] }}" alt="your image">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" style="padding: 3px 5px; overflow: hidden"
                                                               name="option_home_slider_banner_desktop[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                                                               value="{{ (isset($slider['banner_desktop']) && !empty($slider['banner_desktop'])) ? $slider['banner_desktop'] : ""  }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Tablet</label>
                                            <div class="col-sm-10">

                                                <div class="form-group media-load-image">
                                                    <div class="preview-image" >
                                                        <div class="close" onclick="deleteImagePreview(this)">
                                                            <i class="dripicons-cross"></i>
                                                        </div>
                                                        <div class="image-preview-container">
                                                            @if(isset($slider['banner_tablet']) && !empty($slider['banner_tablet']))
                                                                <img class="image-preview" style="width: 100%" src="{{ $slider['banner_tablet'] }}" alt="your image">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_banner_tablet[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                                                               value="{{ (isset($slider['banner_tablet']) && !empty($slider['banner_tablet'])) ? $slider['banner_tablet'] : ""  }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Mobile</label>
                                            <div class="col-sm-10">

                                                <div class="form-group media-load-image">
                                                    <div class="preview-image" >
                                                        <div class="close" onclick="deleteImagePreview(this)">
                                                            <i class="dripicons-cross"></i>
                                                        </div>
                                                        <div class="image-preview-container">
                                                            @if(isset($slider['banner_mobile']) && !empty($slider['banner_mobile']))
                                                                <img class="image-preview" style="width: 100%" src="{{ $slider['banner_mobile'] }}" alt="your image">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_banner_mobile[]" class="form-control required home-slider-image"
                                                               aria-describedby="button-image" readonly
                                                               value="{{ (isset($slider['banner_mobile']) && !empty($slider['banner_mobile'])) ? $slider['banner_mobile'] : ""  }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </td>
                            <td style="width: 50px; vertical-align: middle">
                                <div class="action-wrapper">
                                    <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button><button type="button" class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="counter">1</td>
                        <td style="">
                            <div class="row">
                                <div class="col-lg-12" style="margin-bottom: 30px">
                                        <textarea rows="8" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_desc[]" placeholder="Type hotel description" class="form-control option-home-slider-desc"></textarea>
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 30px">
                                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_url[]" placeholder="Type url" class="form-control option-home-slider-url" value="">
                                </div>
                                <div class="col-lg-12">
                                    <label class="mb-1">
                                        Logo image
                                    </label>
                                    <div class="form-group media-load-image">
                                        <div class="preview-image" >
                                            <div class="close" onclick="deleteImagePreview(this)">
                                                <i class="dripicons-cross"></i>
                                            </div>
                                            <div class="image-preview-container">

                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_logo[]"
                                                   class="form-control required home-slider-image" aria-describedby="button-image" readonly
                                                   value="">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="margin-top: 30px">
                                    <label class="mb-1">
                                        Banner image
                                    </label>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Desktop</label>
                                        <div class="col-sm-10">

                                            <div class="form-group media-load-image">
                                                <div class="preview-image" >
                                                    <div class="close" onclick="deleteImagePreview(this)">
                                                        <i class="dripicons-cross"></i>
                                                    </div>
                                                    <div class="image-preview-container">

                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" style="padding: 3px 5px; overflow: hidden"
                                                           name="option_home_slider_banner_desktop[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                                                           value="">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Tablet</label>
                                        <div class="col-sm-10">

                                            <div class="form-group media-load-image">
                                                <div class="preview-image" >
                                                    <div class="close" onclick="deleteImagePreview(this)">
                                                        <i class="dripicons-cross"></i>
                                                    </div>
                                                    <div class="image-preview-container">
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_banner_tablet[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                                                           value="">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">Mobile</label>
                                        <div class="col-sm-10">

                                            <div class="form-group media-load-image">
                                                <div class="preview-image" >
                                                    <div class="close" onclick="deleteImagePreview(this)">
                                                        <i class="dripicons-cross"></i>
                                                    </div>
                                                    <div class="image-preview-container">
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_banner_mobile[]" class="form-control required home-slider-image"
                                                           aria-describedby="button-image" readonly
                                                           value="">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </td>
                        <td style="width: 50px; vertical-align: middle">
                            <div class="action-wrapper">
                                <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                            </div>
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>


    </div>
    <div class="tab-pane p-3" id="tab2" role="tabpanel">

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Background image</label>
            <div class="col-sm-10">
                <div class="form-group media-load-image">
                    <div class="preview-image" >
                        <div class="close" onclick="deleteImagePreview(this)">
                            <i class="dripicons-cross"></i>
                        </div>
                        <div class="image-preview-container">
                            @if(isset($dataHome['our_service']['background']) && !empty($dataHome['our_service']['background']) )
                                <img class="image-preview" style="width: 100%" src="{{ $dataHome['our_service']['background'] }}" alt="your image">
                            @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_our_service_bg" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                        value="{{ (isset($dataHome['our_service']['background']) && !empty($dataHome['our_service']['background']) ) ? $dataHome['our_service']['background'] : ""  }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="{{ (isset($dataHome['our_service']['title']) && !empty($dataHome['our_service']['title'])) ? $dataHome['our_service']['title'] : ""  }}" name="option_our_service_title">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Heading paragraph</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="option_our_service_heading"
                       value="{{ (isset($dataHome['our_service']['heading']) && !empty($dataHome['our_service']['heading'])) ? $dataHome['our_service']['heading'] : ""  }}">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Paragraph</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="option_our_service_paragraph" rows="8" placeholder="Type service description">{{ (isset($dataHome['our_service']['paragraph']) && !empty($dataHome['our_service']['paragraph'])) ? $dataHome['our_service']['paragraph'] : ""  }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Url</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="option_our_service_url"
                       value="{{ (isset($dataHome['our_service']['url']) && !empty($dataHome['our_service']['url'])) ? $dataHome['our_service']['url'] : ""  }}">
            </div>
        </div>



    </div>



    <div class="tab-pane p-3" id="tab3" role="tabpanel">
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input class="form-control" type="text"
                       value="{{ isset($dataHome['our_hotel']['title']) && !empty($dataHome['our_hotel']['title']) ? $dataHome['our_hotel']['title'] : "" }}"
                       name="option_our_hotel_title">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Heading paragraph</label>
            <div class="col-sm-10">
                <input class="form-control" type="text"
                       value="{{ isset($dataHome['our_hotel']['heading']) && !empty($dataHome['our_hotel']['heading']) ? $dataHome['our_hotel']['heading'] : "" }}"
                       name="option_our_hotel_heading">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Url</label>
            <div class="col-sm-10">
                <input class="form-control" type="text"
                       value="{{ isset($dataHome['our_hotel']['url']) && !empty($dataHome['our_hotel']['url']) ? $dataHome['our_hotel']['url'] : "" }}"
                       name="option_our_hotel_url">
            </div>
        </div>
    </div>

    <div class="tab-pane p-3" id="tab4" role="tabpanel">
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Background image</label>
            <div class="col-sm-10">
                <div class="form-group media-load-image">
                    <div class="preview-image" >
                        <div class="close" onclick="deleteImagePreview(this)">
                            <i class="dripicons-cross"></i>
                        </div>
                        <div class="image-preview-container">
                            @if(isset($dataHome['message']['background']) && !empty($dataHome['message']['background']))
                                <img class="image-preview" style="width: 100%" src="{{ $dataHome['message']['background'] }}" alt="your image">
                            @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_our_message_bg" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                        value="{{ isset($dataHome['message']['background']) && !empty($dataHome['message']['background']) ? $dataHome['message']['background'] : "" }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="option_our_message_title"
                       value="{{ isset($dataHome['message']['title']) && !empty($dataHome['message']['title']) ? $dataHome['message']['title'] : "" }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Paragraph</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="option_our_message_paragraph" rows="8" placeholder="Type message">{{ isset($dataHome['message']['paragraph']) && !empty($dataHome['message']['paragraph']) ? $dataHome['message']['paragraph'] : "" }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Author name</label>
            <div class="col-sm-10">
                <input class="form-control" type="text"
                       value="{{ isset($dataHome['message']['author']) && !empty($dataHome['message']['author']) ? $dataHome['message']['author'] : "" }}" name="option_our_message_auth">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Avatar image</label>
            <div class="col-sm-10">
                <div class="form-group media-load-image">
                    <div class="preview-image" >
                        <div class="close" onclick="deleteImagePreview(this)">
                            <i class="dripicons-cross"></i>
                        </div>
                        <div class="image-preview-container">
                            @if(isset($dataHome['message']['avatar']) && !empty($dataHome['message']['avatar']))
                                <img class="image-preview" style="width: 100%" src="{{ $dataHome['message']['avatar'] }}" alt="your image">
                            @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_our_avatar_image" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                        value="{{ (isset($dataHome['message']['avatar']) && !empty($dataHome['message']['avatar'])) ? $dataHome['message']['avatar'] : "" }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Signature image</label>
            <div class="col-sm-10">
                <div class="form-group media-load-image">
                    <div class="preview-image" >
                        <div class="close" onclick="deleteImagePreview(this)">
                            <i class="dripicons-cross"></i>
                        </div>
                        <div class="image-preview-container" style="background: #ccc">
                            @if(isset($dataHome['message']['sign']) && !empty($dataHome['message']['sign']))
                                <img class="image-preview" style="width: 100%" src="{{ $dataHome['message']['sign'] }}" alt="your image">
                            @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_our_message_sign" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                        value="{{ isset($dataHome['message']['sign']) && !empty($dataHome['message']['sign']) ? $dataHome['message']['sign'] : "" }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane p-3" id="tab5" role="tabpanel">
{{--        <div class="form-group row">--}}
{{--            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>--}}
{{--            <div class="col-sm-10">--}}
{{--                <input class="form-control" type="text"--}}
{{--                       value="{{ isset($dataHome['our_brand']['title']) && !empty($dataHome['our_brand']['title']) ? $dataHome['our_brand']['title'] : "" }}"--}}
{{--                       name="option_our_brand_title">--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Heading paragraph</label>
            <div class="col-sm-10">
                <input class="form-control" type="text"
                       value="{{ isset($dataHome['our_brand']['heading']) && !empty($dataHome['our_brand']['heading']) ? $dataHome['our_brand']['heading'] : "" }}"
                       name="option_our_brand_heading">
            </div>
        </div>

        <div class="form-group row">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Add Brand</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if(isset($dataHome['our_brand']['brands']) && !empty($dataHome['our_brand']['brands']))
                    @foreach($dataHome['our_brand']['brands'] as $key => $brand)
                        <tr>
                            <td class="counter">{{ $key + 1 }}</td>
                            <td style="">
                                <div class="row">

                                    <div class="col-lg-12">
                                        <label class="mb-1">
                                            Logo Brand
                                        </label>
                                        <div class="form-group media-load-image">
                                            <div class="preview-image" >
                                                <div class="close" onclick="deleteImagePreview(this)">
                                                    <i class="dripicons-cross"></i>
                                                </div>
                                                <div class="image-preview-container">
                                                    @if(isset($brand['banner']) && !empty($brand['banner']))
                                                        <img class="image-preview" style="width: 100%" src="{{ $brand['banner'] }}" alt="your image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_brand_banner[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                                                       value="{{ (isset($brand['banner']) && !empty($brand['banner']) ) ? $brand['banner'] : "" }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Url</label>
                                    <div class="col-sm-10">
                                        <input class="form-control home_brand_url" type="text"
                                               value="{{ isset($brand['url']) && !empty($brand['url']) ? $brand['url'] : "" }}"
                                               name="option_home_brand_url[]">
                                    </div>
                                </div>


                            </td>
                            <td style="width: 50px; vertical-align: middle">
                                <div class="action-wrapper">
                                    <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="counter">1</td>
                        <td style="">
                            <div class="row">

                                <div class="col-lg-12">
                                    <label class="mb-1">
                                        Logo Brand
                                    </label>
                                    <div class="form-group media-load-image">
                                        <div class="preview-image" >
                                            <div class="close" onclick="deleteImagePreview(this)">
                                                <i class="dripicons-cross"></i>
                                            </div>
                                            <div class="image-preview-container">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_brand_banner[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Url</label>
                                <div class="col-sm-10">
                                    <input class="form-control home_brand_url" type="text"
                                           value=""
                                           name="option_home_brand_url[]">
                                </div>
                            </div>
                        </td>
                        <td style="width: 50px; vertical-align: middle">
                            <div class="action-wrapper">
                                <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                            </div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane p-3" id="tab6" role="tabpanel">
{{--        <div class="form-group row">--}}
{{--            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>--}}
{{--            <div class="col-sm-10">--}}
{{--                <input class="form-control" type="text"--}}
{{--                       value="{{ isset($dataHome['our_brand']['title']) && !empty($dataHome['our_brand']['title']) ? $dataHome['our_brand']['title'] : "" }}"--}}
{{--                       name="option_our_brand_title">--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Heading paragraph</label>
            <div class="col-sm-10">
                <input class="form-control" type="text"
                       value="{{ isset($dataHome['coming_brand']['heading']) && !empty($dataHome['coming_brand']['heading']) ? $dataHome['coming_brand']['heading'] : "" }}"
                       name="option_coming_brand_heading">
            </div>
        </div>

        <div class="form-group row">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Add Brand</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if(isset($dataHome['coming_brand']['brands']) && !empty($dataHome['coming_brand']['brands']))
                    @foreach($dataHome['coming_brand']['brands'] as $key => $brand)
                        <tr>
                            <td class="counter">{{ $key + 1 }}</td>
                            <td style="">
                                <div class="row">

                                    <div class="col-lg-12">
                                        <label class="mb-1">
                                            Logo Brand
                                        </label>
                                        <div class="form-group media-load-image">
                                            <div class="preview-image" >
                                                <div class="close" onclick="deleteImagePreview(this)">
                                                    <i class="dripicons-cross"></i>
                                                </div>
                                                <div class="image-preview-container">
                                                    @if(isset($brand['banner']) && !empty($brand['banner']))
                                                        <img class="image-preview" style="width: 100%" src="{{ $brand['banner'] }}" alt="your image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_coming_brand_banner[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                                                       value="{{ (isset($brand['banner']) && !empty($brand['banner']) ) ? $brand['banner'] : "" }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Url</label>
                                    <div class="col-sm-10">
                                        <input class="form-control home_brand_url" type="text"
                                               value="{{ isset($brand['url']) && !empty($brand['url']) ? $brand['url'] : "" }}"
                                               name="option_coming_brand_url[]">
                                    </div>
                                </div>


                            </td>
                            <td style="width: 50px; vertical-align: middle">
                                <div class="action-wrapper">
                                    <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="counter">1</td>
                        <td style="">
                            <div class="row">

                                <div class="col-lg-12">
                                    <label class="mb-1">
                                        Logo Brand
                                    </label>
                                    <div class="form-group media-load-image">
                                        <div class="preview-image" >
                                            <div class="close" onclick="deleteImagePreview(this)">
                                                <i class="dripicons-cross"></i>
                                            </div>
                                            <div class="image-preview-container">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_coming_brand_banner[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Url</label>
                                <div class="col-sm-10">
                                    <input class="form-control home_brand_url" type="text"
                                           value=""
                                           name="option_coming_brand_url[]">
                                </div>
                            </div>
                        </td>
                        <td style="width: 50px; vertical-align: middle">
                            <div class="action-wrapper">
                                <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                            </div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

<input type="hidden" name="option_type" value="homepage_setting">
