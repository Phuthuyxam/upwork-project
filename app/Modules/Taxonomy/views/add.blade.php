@extends('backend.default')
@section('heading')
    <h4 class="page-title font-size-18">Add Category</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('taxonomy.add') }}" method="post" role="form">
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
@endsection
