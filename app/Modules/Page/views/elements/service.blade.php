<table class="table table-bordered">
    <thead>
    <tr>
        <th>Image</th>
        <th>Desciption</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    @if(isset($result) && !empty($result))
        @php
            $result = json_decode($result);
        @endphp
        @foreach($result as $key=> $value)
            <tr>
                <td style="max-width: 400px;">
                    <div class="preview-image">
                        <div class="close @if($value->image == '') {{ 'deleted' }} @endif">
                            <i class="dripicons-cross"></i>
                        </div>
                        <img src="{{ asset($value->image) }}" style="width: 100%" alt="">
                    </div>
                    <input type="file" style="padding: 3px 5px; overflow: hidden" class="form-control banner-image @if($value->image != '') {{ 'hidden' }} @else {{'required'}} @endif"
                           name="images[]">
                    <input type="hidden" class="banner-link" name="items[]" data-type="{{ \App\Core\Glosary\MetaKey::BANNER['VALUE'] }}" value="{{ $value->image }}">
                    <p class="text-danger error-message" style="font-weight: bold" id="excerpt-error">
                    </p>
                </td>
                <td>
                    <textarea class="form-control required" name="descriptions[]">{{ $value->desc }}</textarea>
                    <p class="text-danger error-message" style="font-weight: bold">
                    </p>
                </td>
                <td style="vertical-align: middle">
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
            <td style="width: 400px;">
                <div class="preview-image">
                    <div class="close">
                        <i class="dripicons-cross"></i>
                    </div>
                </div>
                <input type="file" style="padding: 3px 5px; overflow: hidden" class="form-control required banner-image"
                       name="images[]">
                <p class="text-danger error-message" style="font-weight: bold" id="excerpt-error">
                </p>
            </td>
            <td>
                <textarea class="form-control required" name="descriptions[]"></textarea>
                <p class="text-danger error-message" style="font-weight: bold">
                </p>
            </td>
            <td style="vertical-align: middle">
                <div class="action-wrapper">
                    <button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                </div>
            </td>
        </tr>
    @endif
    </tbody>
</table>
