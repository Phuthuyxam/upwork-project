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
        <a class="nav-link" data-toggle="tab" href="#tab5" role="tab">Map</a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active p-3" id="tab1" role="tabpanel">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="">
                        <div class="row">
                            <div class="col-lg-12" style="margin-bottom: 30px">
                                <textarea rows="8" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_desc[]" placeholder="Type hotel description" class="form-control option-home-slider-desc"></textarea>
                            </div>
                            <div class="col-lg-12" style="margin-bottom: 30px">
                                <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_url[]" placeholder="Type url" class="form-control option-home-slider-url">
                            </div>
                            <div class="col-lg-12">
                                <label class="mb-1">
                                    Logo image
                                </label>
                                <div class="input-group media-load-image">
                                    <div class="preview-image" style="width: 100%">
                                        <div class="close" onclick="deleteImagePreview(this)">
                                            <i class="dripicons-cross"></i>
                                        </div>
                                        <div class="image-preview-container">
{{--                                            <img class="image-preview" style="width: 20%" src="http://127.0.0.1:8000/storage/categories/wts.jpg" alt="your image">--}}
                                        </div>
                                    </div>
                                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_logo[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mb-1">
                                    Banner image
                                </label>
                                <div class="input-group media-load-image">
                                    <div class="preview-image" style="width: 100%">
                                        <div class="close" onclick="deleteImagePreview(this)">
                                            <i class="dripicons-cross"></i>
                                        </div>
                                        <div class="image-preview-container">
{{--                                            <img class="image-preview" style="width: 20%" src="http://127.0.0.1:8000/storage/categories/wts.jpg" alt="your image">--}}
                                        </div>
                                    </div>
                                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_banner[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="action-wrapper">
                            <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                        </div>
                    </td>

                </tr>
            </tbody>
        </table>


    </div>
    <div class="tab-pane p-3" id="tab2" role="tabpanel">

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Background image</label>
            <div class="col-sm-10">
                <div class="input-group media-load-image">
                    <div class="preview-image" style="width: 100%">
                        <div class="close" onclick="deleteImagePreview(this)">
                            <i class="dripicons-cross"></i>
                        </div>
                        <div class="image-preview-container">
{{--                            <img class="image-preview" style="width: 20%" src="http://127.0.0.1:8000/storage/categories/wts.jpg" alt="your image">--}}
                        </div>
                    </div>
                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_our_service_bg[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="" name="option_our_service_title">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Heading paragraph</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="" name="option_our_service_heading">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Paragraph</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="option_our_service_paragraph" rows="8" placeholder="Type service description"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Url</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="" name="option_our_service_url">
            </div>
        </div>



    </div>
    <div class="tab-pane p-3" id="tab3" role="tabpanel">
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="" name="option_our_hotel_title">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Heading paragraph</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="" name="option_our_hotel_heading">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Url</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="" name="option_our_service_url">
            </div>
        </div>
        <div class="form-group row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Add Hotel</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="mb-1">
                                    Logo image
                                </label>
                                <div class="input-group media-load-image">
                                    <div class="preview-image" style="width: 100%">
                                        <div class="close" onclick="deleteImagePreview(this)">
                                            <i class="dripicons-cross"></i>
                                        </div>
                                        <div class="image-preview-container">
                                            {{--                                            <img class="image-preview" style="width: 20%" src="http://127.0.0.1:8000/storage/categories/wts.jpg" alt="your image">--}}
                                        </div>
                                    </div>
                                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_logo[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mb-1">
                                    Background image
                                </label>
                                <div class="input-group media-load-image">
                                    <div class="preview-image" style="width: 100%">
                                        <div class="close" onclick="deleteImagePreview(this)">
                                            <i class="dripicons-cross"></i>
                                        </div>
                                        <div class="image-preview-container">
                                            {{-- <img class="image-preview" style="width: 20%" src="http://127.0.0.1:8000/storage/categories/wts.jpg" alt="your image">--}}
                                        </div>
                                    </div>
                                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_home_slider_banner[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="action-wrapper">
                            <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                        </div>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>



    </div>
    <div class="tab-pane p-3" id="tab4" role="tabpanel">
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Background image</label>
            <div class="col-sm-10">
                <div class="input-group media-load-image">
                    <div class="preview-image" style="width: 100%">
                        <div class="close" onclick="deleteImagePreview(this)">
                            <i class="dripicons-cross"></i>
                        </div>
                        <div class="image-preview-container">
                            {{--                            <img class="image-preview" style="width: 20%" src="http://127.0.0.1:8000/storage/categories/wts.jpg" alt="your image">--}}
                        </div>
                    </div>
                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_our_message_bg[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="" name="option_our_message_title">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Paragraph</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="option_our_message_paragraph" rows="8" placeholder="Type message"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Author name</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="" name="option_our_message_auth">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Avatar image</label>
            <div class="col-sm-10">
                <div class="input-group media-load-image">
                    <div class="preview-image" style="width: 100%">
                        <div class="close" onclick="deleteImagePreview(this)">
                            <i class="dripicons-cross"></i>
                        </div>
                        <div class="image-preview-container">
                            {{--                            <img class="image-preview" style="width: 20%" src="http://127.0.0.1:8000/storage/categories/wts.jpg" alt="your image">--}}
                        </div>
                    </div>
                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_our_avatar_image[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Signature image</label>
            <div class="col-sm-10">
                <div class="input-group media-load-image">
                    <div class="preview-image" style="width: 100%">
                        <div class="close" onclick="deleteImagePreview(this)">
                            <i class="dripicons-cross"></i>
                        </div>
                        <div class="image-preview-container">
                            {{--                            <img class="image-preview" style="width: 20%" src="http://127.0.0.1:8000/storage/categories/wts.jpg" alt="your image">--}}
                        </div>
                    </div>
                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_our_message_sign[]" class="form-control required home-slider-image" aria-describedby="button-image" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <div class="tab-pane p-3" id="tab5" role="tabpanel">
        <p class="font-14 mb-0">
            Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.
        </p>
    </div>
</div>

<input type="hidden" name="option_type" value="homepage_setting">
