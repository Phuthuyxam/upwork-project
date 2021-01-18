@extends('backend.default')
@section('title')
    {{ \App\Core\Glosary\PageTemplateConfigs::parse($template)['DISPLAY'] }}
@endsection
@section('style')
    <style>
        .error {
            border: 1px solid red;
        }

        .form-group p {
            margin-bottom: 0;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        .preview-image,
        .preview-image-multiple .items{
            position: relative;
            overflow: hidden;
            margin-bottom: 1rem;
            /*width: 50%;*/
        }
        .preview-image-multiple {
            margin-bottom: 1rem;
        }

        .preview-image-multiple .items {
            padding: 0 10px;
        }
        .preview-image-multiple {
            display: flex;
            align-items: center;
        }
        .preview-image .close,
        .preview-image-multiple .items .close{
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            background: #9C9C9C;
            border-radius: 100%;
            opacity: 1;
            text-shadow: unset;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-image-multiple .items .close {
            top: 0;
            right: 0;
        }

        .preview-image .close i {
            font-size: 14px;
            line-height: .4;
        }

        .action-wrapper button,
        .button-wrapper button{
            display: block;
            margin-bottom: 1rem;
        }
        .image-items .preview-image {
            width: 20% !important;
        }
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">{{ \App\Core\Glosary\PageTemplateConfigs::parse($template)['DISPLAY'] }}</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('backend.elements.languages')
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <div class="alert alert-danger alert-common" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Some fields need to required. Please check it again !
            </div>
            <form action="{{ route('page.add',$template) }}" id="add-form" method="post" role="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" id="commonTab">
                                        <a class="nav-link active" id="commonTab" data-toggle="tab" href="#common" role="tab">Common</a>
                                    </li>
                                    @if(!in_array($template,$defaultTemplate))
                                    <li class="nav-item" id="customTab">
                                        <a class="nav-link " data-toggle="tab" href="#slide" role="tab">Custom Setting</a>
                                    </li>
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    @csrf
                                    <div class="tab-pane active p-3" id="common" role="tabpanel">
                                        <div class="form-group">
                                            <label for="title">Title <span style="color: red">*</span></label>
                                            <input type="text" class="form-control required" name="post_title" id="title"
                                                   placeholder="Title"
                                                   value="{{ old('post_title') ? old('post_title') : ( $page ? $page->post_title : '') }}">
                                            <p style="font-style: italic; font-size: 12px">The name is how it appears on your
                                                website</p>
                                            <p class="text-danger error-message" style="font-weight: bold" id="title-error">
                                                @error('post_title')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="slug">Slug <span style="color: red">*</span></label>
                                            <input type="text" class="form-control required" name="post_name" id="slug"
                                                   placeholder="Slug"
                                                   value="{{ old('post_name') ? old('post_name') : ( $page ? $page->post_name : '') }}">
                                            <p style="font-style: italic; font-size: 12px">The "slug" is the URL-friendly of the
                                                name. It is usually all lower case and contains only letters, numbers, and
                                                hyphens and must be unique</p>
                                            <p class="text-danger error-message" style="font-weight: bold" id="slug-error">
                                                @error('post_name')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="excerpt">Excerpt <span style="color: red">*</span></label>
                                            <textarea type="text" class="form-control required" name="post_excerpt" id="excerpt" placeholder="Excerpt" rows="8">{{ old('post_excerpt') ? old('post_excerpt') : ($page ? $page->post_excerpt : '') }}</textarea>
                                            <p class="text-danger error-message" style="font-weight: bold" id="excerpt-error">
                                                @error('post_excerpt')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Content <span style="color: red">*</span></label>
                                            <div class="editor-wrapper">
                                                <textarea name="post_content" id="description" class="form-control"
                                                          style="width: 100%; height: 90px"
                                                          placeholder="Description">{{ old('post_content') ? old('post_content') : ( $page ? $page->post_content : '' ) }}</textarea>
                                            </div>
                                            <p class="text-danger error-message" style="font-weight: bold"
                                               id="description-error">
                                                @error('post_content')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">Banner <span style="color: red">*</span></label>
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 100px">Desktop</th>
                                                    <td>
                                                        {!!  renderMediaManage('files[]',!empty($pageMetaMap) ? $pageMetaMap[\App\Core\Glosary\MetaKey::BANNER['NAME']][0] : '') !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 100px">Tablet</th>
                                                    <td>
                                                        {!!  renderMediaManage('files[]',!empty($pageMetaMap) ? $pageMetaMap[\App\Core\Glosary\MetaKey::BANNER['NAME']][1] : '') !!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 100px">Mobile</th>
                                                    <td>
                                                        {!!  renderMediaManage('files[]',!empty($pageMetaMap) ? $pageMetaMap[\App\Core\Glosary\MetaKey::BANNER['NAME']][2] : '') !!}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-3" id="slide" role="tabpanel">
                                        @if($template == \App\Core\Glosary\PageTemplateConfigs::SERVICE['NAME'])
                                            @include('Page::elements.service',
                                                    ['serviceItem' => $pageMetaMap[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']]])
{{--                                            @include('Page::elements.service')--}}
                                        @endif
                                        @if($template == \App\Core\Glosary\PageTemplateConfigs::ABOUT['NAME'])
                                            @include('Page::elements.about', [ 'imageMap' => $imageMap , 'itemMap' => $itemMap ])
{{--                                                @include('Page::elements.about')--}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <h5 class="card-header mt-0 font-size-16">Publish</h5>
                            <div class="card-body">
                                <div class="status">
                                    <span><i class="dripicons-flag"></i> Status : {{ \App\Core\Glosary\PostStatus::DRAFT['NAME'] }}</span>
                                </div>
                            </div>
                            <div class="card-footer" style="display: flex; align-items: center; justify-content: space-between">
                                <input type="hidden" id="publishStatus" name="status">
                                <button type="submit" class="btn btn-info btn-draft waves-effect waves-light">Save Draft</button>
                                <button type="submit" class="btn btn-primary btn-submit waves-effect waves-light">Publish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('extension_script')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('script')
    <script>
        const maxFileSize = '{{ \App\Core\Glosary\MaxFileSize::IMAGE['VALUE'] }}';
        {{--const slugs = JSON.parse('{!! json_encode($slugs) !!}')--}}
        CKEDITOR.replace('description', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
        $(document).ready(function () {

            $('#title').on('change', function () {
                let val = $(this).val();
                $('#slug').val(changeToSlug(val));
                if (val.trim() !== '') {
                    $(this).removeClass('error required');
                    $('#title-error').text("");
                    $('#slug').removeClass('error required');
                    $('#slug-error').text('');
                } else {
                    $(this).addClass('error required');
                    $('#title-error').text("This field cannot be null");
                    $('#slug').addClass('required');
                }
            })

            $('#slug').on('change', function () {
                let val = $(this).val();
                if (val.trim() === '') {
                    $(this).val(changeToSlug($('#title').val()));
                    $(this).removeClass('required');
                } else {
                    if (slugs.indexOf(val) >= 0) {
                        $('#slug-error').text('Slug already exist');
                        $(this).addClass('error');
                    } else {
                        $('#slug-error').text('');
                        $(this).removeClass('error');
                    }
                }
            })

            $('#excerpt').on('change',function () {
                let val = $(this).val();
                if (val.trim() === '') {
                    $(this).addClass('error');
                    $('#excerpt-error').text('This field cannot be null');
                }else{
                    $(this).removeClass('error');
                    $('#excerpt-error').text('');
                }
            })

            $('body').on('change', '.required', function () {
                let value = $(this).val();
                if (value.trim() === '') {
                    $(this).addClass('error');
                    $(this).parent().find('.error-message').text('This field cannot be null');
                } else {
                    $(this).removeClass('error');
                    $(this).parent().find('.error-message').text('');
                }
            })

            $('.btn-submit').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#publishStatus').val(1);
                    $('#add-form').submit();
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops... !',
                        text: 'Some field need to required. Please check it again',
                    });
                }
            })

            $('.btn-draft').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#publishStatus').val(0);
                    $('#add-form').submit();
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops... !',
                        text: 'Some field need to required. Please check it again',
                    });
                }
            })
        })

        let rowCount = 1;
        $('body').on('click','.btn-add-type',function (e){
            e.preventDefault();
            let row = $(this).parents('tr').clone();
            row.find('.action-wrapper').empty();
            row.find('.action-wrapper').append('<button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>');
            row.find('.preview-image img').remove();
            row.find('.banner-image').val('');
            row.find('.banner-image').show();
            row.find('textarea').val('');

            // multiple image
            rowCount = rowCount + 1;
            row.find('.banner-image-multiple').val('');
            row.find('.banner-image-multiple').attr('name','row'+rowCount+'[]');
            row.find('.preview-image-multiple').empty();
            row.find('.number-image').val(0);

            row.find('.home-slider-image').val('');
            row.find('.image-preview-container').html("");

            if ($(this).hasClass('parent')) {
                row.find('.action-wrapper').empty();
                row.find('.action-wrapper').append('<button class="btn btn-success btn-add-type parent"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete-type parent"><i class="dripicons-minus"></i></button>');
                let imageRow = row.find('.image-items tr').first();
                row.find('.image-items tbody').empty();
                row.find('.image-items tbody').append(imageRow[0].outerHTML);
                row.find('.image-items tbody')
                row.find('.row-item').val(1);
                row.find('.home-slider-image').val('');
            }

            $(this).parents('tbody').append(row);

            let count = parseInt($(this).parents('.section').find('.item-count').val());
            count = count + 1;
            $(this).parents('.section').find('.item-count').val(count);

        })
        $('body').on('click','.btn-delete-type',function (e){
            e.preventDefault();
            let count = parseInt($(this).parents('.section').find('.item-count').val());
            count = count - 1;
            $(this).parents('.section').find('.item-count').val(count);
            $(this).parents('tr').remove();

        })

        $('body').on('click', '.btn-add-child', function (e) {
            e.preventDefault();
            let row = $(this).closest('tr').clone();
            row.find('.button-wrapper').empty();
            row.find('.button-wrapper').append('<button class="btn btn-success btn-add-child"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete-child"><i class="dripicons-minus"></i></button>');
            row.find('textarea').val('');
            row.find('.home-slider-image').val('');
            row.find('.image-preview-container').html("");
            $(this).closest('tbody').append(row);


            let countItem = parseInt($(this).closest('.image-items').find('.row-item').val());
            countItem = countItem + 1;
            $(this).closest('.image-items').find('.row-item').val(countItem);
        })

        $('body').on('click', '.btn-delete-child', function (e) {
            e.preventDefault();

            let countItem = parseInt($(this).closest('.image-items').find('.row-item').val());
            countItem = countItem - 1;
            $(this).closest('.image-items').find('.row-item').val(countItem);

            $(this).closest('tr').remove();
        })

        function checkRequired(formId) {
            let valid = true;
            $('#' + formId).find('.required').each(function () {
                if ($(this).val().trim() === '') {
                    $(this).addClass('error');
                    $(this).closest('.form-group').find('.error-message').text('This field cannot be null');
                    valid = false;
                } else {
                    $(this).removeClass('error');
                    $(this).closest('.form-group').find('.error-message').text('');
                }
            })
            return valid;
        }
    </script>
@endsection
