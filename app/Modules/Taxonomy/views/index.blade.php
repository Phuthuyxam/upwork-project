@extends('backend.default')
@section('style')
    <style>
        .error {
            border: 1px solid red;
        }
        .form-group p {
            margin-bottom: 0;
        }
        .preview-image {
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }
        .preview-image .close {
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
        .preview-image .close i {
            font-size: 14px;
            line-height: .4;
        }
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Categories</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Category</h4>
                            <form action="" method="post" role="form" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                    <p style="font-style: italic; font-size: 12px">The name is how it appears on your
                                        website</p>
                                    <p class="text-danger" style="font-weight: bold" id="name-error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug">
                                    <p style="font-style: italic; font-size: 12px">The "slug" is the URL-friendly of the
                                        name. It is usually all lower case and contains only letters, numbers, and
                                        hyphens</p>
                                </div>
                                <div class="form-group">
                                    <label for="parent">Parent</label>
                                    <select name="parent" class="form-control" id="parent">
                                        <option value="-1">None</option>
                                    </select>
                                    <p style="font-style: italic; font-size: 12px">Categories can have a hierarchy. You
                                        might have and Jazz category, and under that have children categories for Debop
                                        and Big Band. Totally optional</p>
                                </div>
                                <div class="form-group">
                                    <label for="file">Banner</label>
                                    <div class="preview-image">
                                        <div class="close">
                                            <i class="dripicons-cross"></i>
                                        </div>
                                    </div>
                                    <input type="file" name="file" id="file">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control"
                                              style="width: 100%; height: 90px"></textarea>
                                    <p style="font-style: italic; font-size: 12px">Description for your category.
                                        Totally optional</p>
                                </div>
                                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-wrapper">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th style="color:#1967a9;">Name</th>
                                        <th style="color:#1967a9;">Description</th>
                                        <th style="color:#1967a9;">Slug</th>
                                        <th style="color:#1967a9;">Created at</th>
                                        <th style="color:#1967a9;">Updated at</th>
                                        <th style="color:#1967a9;">Count</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($categories) && !empty($categories))
                                            @foreach($categories as $value)
                                                <tr>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->description }}</td>
                                                    <td>{{ $value->slug }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const responseCode = @php echo json_encode(\App\Core\Glosary\ResponeCode::getAll()) @endphp;
        $(document).ready(function (){
            $('#name').on('change',function (){
                let val = $(this).val();
                $('#slug').val(changeToSlug(val));
                if (val.trim() !== '') {
                    $(this).removeClass('error');
                    $('#name-error').text("");
                }
            })
            $('.btn-submit').click(function (e){
                e.preventDefault();

                let _token = $("input[name='_token']").val();
                let name = $('#name').val();
                let slug = $('#slug').val();
                let parent = $('#parent').val();
                let description = $('#description').val();
                let valid = true;
                if (name.trim() === '') {
                    valid = false;
                    $('#name-error').text("Name can not be null");
                    $('#name').addClass('error');
                }
                if (valid) {
                    $('#name-error').text("");
                    $('#name').removeClass('error');
                    $.ajax({
                        url: "{{ route('taxonomy.add') }}",
                        type:'POST',
                        data: {
                            _token:_token,
                            name:name,
                            slug:slug,
                            parent:parent,
                            description:description
                        },
                        success: function(response) {
                            if (response == responseCode.SUCCESS.CODE) {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Success',
                                })
                            }
                        },
                        error:function (e){
                            console.log(e);
                        }
                    });
                }
            })
            $("#file").change(function() {
                if ($(this).val()) {
                    readURL(this);
                }else {
                    $('.preview-image img').remove();
                }
            });
            $('.preview-image .close').click(function (){
                $(this).parent().find('img').remove();
                $('#file').val('');
            })
        })

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    let html = '<img id="image" style="width: 100%" src="'+e.target.result+'" alt="your image" />';
                    $('.preview-image').append(html);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endsection
