@if($dataFooter->isNotEmpty())
    @php
        $footer = json_decode($dataFooter[0]->option_value, true);
    @endphp
@endif
@section('title')
    Footer setting
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Footer Setting</h4>
@endsection
<div class="form-group row">
    <label for="example-text-input" class="col-sm-2 col-form-label">
        Copyright right text
    </label>
    <div class="col-sm-10">
        <input class="form-control" name="copyright_text" type="text" value="{{ ((isset($footer['copyright_text'])) && !empty($footer['copyright_text'])) ? $footer['copyright_text'] : ""  }}">
    </div>
</div>
<div class="form-group row">
    <label for="example-text-input" class="col-sm-2 col-form-label">
        Developed by text
    </label>
    <div class="col-sm-10">
        <textarea id="developed" class="form-control" name="develop_text">{{ ((isset($footer['develop_text'])) && !empty($footer['develop_text'])) ? $footer['develop_text'] : ""  }}</textarea>
    </div>
</div>
@section('extension_script')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('developed', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
    </script>
@endsection
