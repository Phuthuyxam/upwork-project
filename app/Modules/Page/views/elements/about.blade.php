@php
    if (isset($indexItem) && !empty($indexItem)) {
        $indexItem = json_decode($indexItem);
    }
    if (isset($completeItem) && !empty($completeItem)) {
        $completeItem = json_decode($completeItem);
    }
    if (isset($imageItem) && !empty($imageItem)) {
        $imageItem = json_decode($imageItem);
    }
@endphp
<div class="section">
    <h5>Our Vision</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Image</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @if(isset($completeItem) && isset($indexItem))
            @foreach($completeItem as $key => $value)
                @if($key < $indexItem[0])
                    <tr>
                        <td style="max-width: 400px;">
                            {!! renderMediaManage('gallery[]',$value->image) !!}
                        </td>
                        <td>
                            <textarea class="form-control required" name="descriptions[]">{{ $value->desc }}</textarea>
                            <p class="text-danger error-message" style="font-weight: bold">
                            </p>
                        </td>
                        <td style="vertical-align: middle; width: 50px">
                            <div class="action-wrapper">
                                <button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                                @if($key > 0)
                                    <button class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td style="width: 400px;">
                    {!! renderMediaManage('images[]') !!}
                </td>
                <td>
                    <textarea class="form-control" name="descriptions[]"></textarea>
                </td>
                <td style="vertical-align: middle;width: 50px">
                    <div class="action-wrapper">
                        <button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                    </div>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    <input type="hidden" class="item-count" name="numbers[]" value="{{ isset($indexItem) && $indexItem[1] != '' ? $indexItem[0] : 1 }}">
</div>

<div class="section">
    <h5>Our Mission</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Image</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if(isset($completeItem) && isset($indexItem))
            @foreach($completeItem as $key => $value)
                @if($key >= $indexItem[0])
                    <tr>
                        <td style="max-width: 400px;">
                            {!! renderMediaManage('images[]',$value->image) !!}
                        </td>
                        <td>
                            <textarea class="form-control required" name="descriptions[]">{{ $value->desc }}</textarea>
                            <p class="text-danger error-message" style="font-weight: bold">
                            </p>
                        </td>
                        <td style="vertical-align: middle; width: 50px">
                            <div class="action-wrapper">
                                <button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                                @if($key > $indexItem[0])
                                    <button class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td style="width: 400px;">
                    {!! renderMediaManage('images[]') !!}
                </td>
                <td>
                    <textarea class="form-control required" name="descriptions[]"></textarea>
                    <p class="text-danger error-message" style="font-weight: bold">
                    </p>
                </td>
                <td style="vertical-align: middle;width: 50px">
                    <div class="action-wrapper">
                        <button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                    </div>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    <input type="hidden" class="item-count" name="numbers[]" value="{{ isset($indexItem) && $indexItem[1] != '' ? $indexItem[1] : 1 }}">
</div>

<div class="section">
<h5>Our Reward</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if(isset($imageItem))
            @foreach($imageItem as $key=>$item)
                <tr>
                    <td style="max-width: 400px;">
                        <div class="preview-image-multiple">
                            @if(!empty($item))
                                @foreach($item as $value)
                                    @if($value != '')
                                        <div class="items">
                                            <img style="width: 100%" src="{{ asset($value) }}" alt="">
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <input type="file" style="padding: 3px 5px; overflow: hidden" class="form-control banner-image-multiple {{ empty($item) ? 'required':'' }}"
                               name="row[]" multiple>
                        <input type="hidden" name="rowMap[]" class="banner-link" value="{{ json_encode($item) }}">
                        <p class="text-danger error-message" style="font-weight: bold"></p>
                    </td>
                    <td style="vertical-align: middle;width: 50px">
                        <div class="action-wrapper">
                            <button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                            @if($key > 0)
                                <button class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td style="max-width: 400px;">
                    <div class="image-items">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>{!! renderMediaManage('images[]') !!}</td>
                                    <td style="vertical-align: middle;width: 50px;">
                                        <div class="button-wrapper">
                                            <button class="btn btn-success btn-add-child"><i class="dripicons-plus"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="rowItem[]" class="row-item" value="1">
                    </div>
                </td>
                <td style="vertical-align: middle;width: 50px">
                    <div class="action-wrapper">
                        <button class="btn btn-success btn-add-type parent"><i class="dripicons-plus"></i></button>
                    </div>
                    <input type="hidden" name="row[]" class="row" value="1">
                </td>
            </tr>
        @endif
    </tbody>
</table>
</div>
