<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th></th>
        <th>Image</th>
        <th>Desciption</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if(isset($serviceItem) && !empty($serviceItem))
        @foreach($serviceItem as $key=> $value)
            <tr>
                <td class="counter">{{ $key + 1 }}</td>
                <td style="max-width: 400px;">
                    {!!  renderMediaManage('images[]', $value->image) !!}
                    <p class="text-danger error-message" style="font-weight: bold" id="excerpt-error">
                    </p>
                </td>
                <td>
                    <div class="form-group">
                        <textarea class="form-control required" style="height: 100px" name="descriptions[]">{{ $value->desc }}</textarea>
                        <p class="text-danger error-message" style="font-weight: bold">
                        </p>
                    </div>
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
            <td class="counter">1</td>
            <td style="width: 400px;">
                {!!  renderMediaManage('images[]') !!}
                <p class="text-danger error-message" style="font-weight: bold" id="excerpt-error">
                </p>
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
