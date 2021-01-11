<table class="table table-bordered">
    <thead>
    <tr>
        <th>Title</th>
        <th>Url</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <tr>
        <td style="width: 400px;">
            <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_title[]" class="form-control required option-menu-title" >
            @if(1 == -1) <p class="text-danger error-message" style="font-weight: bold" id="excerpt-error"></p> @endif
        </td>
        <td>
            <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_url[]" class="form-control required option-menu-url">
            @if(1 == -1)<p class="text-danger error-message" style="font-weight: bold">
            </p>@endif
        </td>
        <td style="vertical-align: middle">
            <div class="action-wrapper">
                <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
            </div>
        </td>
    </tr>
    </tbody>
</table>
