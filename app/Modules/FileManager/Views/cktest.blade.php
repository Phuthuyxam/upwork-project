@extends('backend.default')
@section('content')
    <div class="container-fluid">


        <div class="card">
            <div class="card-body">

                <textarea name="content" id="editor" rows="10" cols="80">
                    This is my textarea to be replaced with CKEditor.
                </textarea>

            </div>
        </div>
    </div>
@endsection
@section('extension_script')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('script')
    <script>
        CKEDITOR.replace('editor', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
    </script>
@endsection
