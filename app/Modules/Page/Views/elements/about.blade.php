<div class="section">
    <h5>Our Vision</h5>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th></th>
            <th>Image</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if(isset($itemMap) && !empty($itemMap))
            @foreach($itemMap[0] as $key => $value)
                <tr>
                    <td class="counter">{{ $key + 1 }}</td>
                    <td style="max-width: 400px;">
                        {!! renderMediaManage('images[]',$value->image) !!}
                    </td>
                    <td>
                        <textarea class="form-control required" style="height: 200px" name="descriptions[]">{{ $value->desc }}</textarea>
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
            @endforeach
        @else
            <tr>
                <td class="counter">1</td>
                <td style="width: 400px;">
                    {!! renderMediaManage('images[]') !!}
                </td>
                <td>
                    <div class="form-group">
                        <textarea class="form-control required" style="height: 100px" name="descriptions[]"></textarea>
                        <p class="text-danger error-message" style="font-weight: bold">
                        </p>
                    </div>
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
    <input type="hidden" class="item-count" name="numbers[]" value="{{ isset($itemMap[0]) && !empty($itemMap[0]) ? count($itemMap[0]) : 1 }}">
</div>

<div class="section">
    <h5>Our Mission</h5>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th></th>
            <th>Image</th>
            <th>Description</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if(isset($itemMap) && !empty($itemMap))
            @foreach($itemMap[1] as $key => $value)
                <tr>
                    <td class="counter">{{ $key + 1 }}</td>
                    <td style="max-width: 400px;">
                        {!! renderMediaManage('images[]',$value->image) !!}
                    </td>
                    <td>
                        <div class="form-group">
                            <textarea class="form-control required" style="height: 200px" name="descriptions[]">{{ $value->desc }}</textarea>
                            <p class="text-danger error-message" style="font-weight: bold">
                            </p>
                        </div>
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
            @endforeach
        @else
            <tr>
                <td class="counter">1</td>
                <td style="width: 400px;">
                    {!! renderMediaManage('images[]') !!}
                </td>
                <td>
                    <div class="form-group">
                        <textarea class="form-control required" style="height: 100px" name="descriptions[]"></textarea>
                        <p class="text-danger error-message" style="font-weight: bold">
                        </p>
                    </div>
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
    <input type="hidden" class="item-count" name="numbers[]" value="{{ isset($itemMap[1]) && !empty($itemMap[1]) ? count($itemMap[1]) : 1 }}">
</div>

<div class="section">
<h5>Our Reward</h5>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th></th>
            <th>Image</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if(isset($imageMap) && !empty($imageMap))
            @foreach($imageMap as $key=>$value)
                <tr>
                    <td class="counter">{{ $key + 1 }}</td>
                    <td style="max-width: 400px;">
                        <div class="image-items">
                            <table class="table table-bordered">
                                <tbody>
                                @foreach($value as $k => $item)
                                    <tr style="background: #fff">
                                        <td>{!! renderMediaManage('gallery[]',$item) !!}</td>
                                        <td style="vertical-align: middle;width: 50px;">
                                            <div class="button-wrapper">
                                                <button class="btn btn-success btn-add-child"><i class="dripicons-plus"></i></button>
                                                @if($k > 0)
                                                    <button class="btn btn-danger btn-delete-child"><i class="dripicons-minus"></i></button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <input type="hidden" name="rowItem[]" class="row-item" value="{{count($value)}}">
                        </div>
                    </td>
                    <td style="vertical-align: middle;width: 50px">
                        <div class="action-wrapper">
                            <button class="btn btn-success btn-add-type parent"><i class="dripicons-plus"></i></button>
                            @if($key > 0)
                                <button class="btn btn-danger btn-delete-type parent"><i class="dripicons-minus"></i></button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="counter">1</td>
                <td style="max-width: 400px;">
                    <div class="image-items">
                        <table class="table table-bordered">
                            <tbody>
                                <tr style="background: #fff">
                                    <td>{!! renderMediaManage('gallery[]') !!}</td>
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
