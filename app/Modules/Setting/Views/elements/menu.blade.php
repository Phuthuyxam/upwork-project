<table class="table table-bordered">
    <thead>
    <tr>
        <th>Title</th>
        <th>Url</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if($dataMenu->isNotEmpty())
        @php
            $menus = json_decode($dataMenu[0]->option_value, true);
        @endphp
        @if(!is_null($menus) && !empty($menus))
            @foreach( $menus as $menu )
                <tr>
                    <td style="width: 400px;">
                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_title[]"
                               value="{{ $menu['title'] }}"
                               class="form-control required option-menu-title">
                    </td>
                    <td>
                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_url[]"
                               value="{{ $menu['url'] }}"
                               class="form-control required option-menu-url">
                    </td>
                    <td style="vertical-align: middle">
                        <div class="action-wrapper">
                            <button type="button" class="btn btn-success btn-add-type" style="margin-right: 1rem; margin-bottom: 0">
                                <i class="dripicons-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    @else
        <tr>
            <td style="width: 400px;">
                <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_title[]" class="form-control required option-menu-title" >
            </td>
            <td>
                <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_url[]" class="form-control required option-menu-url">
            </td>
            <td style="vertical-align: middle">
                <div class="action-wrapper">
                    <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                </div>
            </td>
        </tr>
    @endif
    </tbody>
</table>
