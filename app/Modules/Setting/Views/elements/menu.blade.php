@section('title')
    Menu setting
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Menu Setting</h4>
@endsection
<table class="table table-bordered" id="menu-table">
    <thead>
    <tr>
        <th></th>
        <th>Type</th>
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
            @foreach( $menus as $key => $menu )
                <tr>
                    <td class="counter">{{ $key + 1 }}</td>
                    <td style="width: 200px">
                        <select class="form-control menu-type"  name="type[]">
                            @foreach(\App\Core\Glosary\MenuType::getAll() as $value)
                                <option value="{{ $value['VALUE'] }}" {{ isset($menu['type']) ? ($value['VALUE'] == $menu['type'] ? 'selected' : '') : '' }}>{{ $value['DISPLAY'] }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_title[]"
                               value="{{ $menu['title'] }}"
                               class="form-control required option-menu-title">
                    </td>
                    <td style="width: 250px">
                        <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_url[]"
                               value="{{ $menu['url'] }}"
                               class="form-control required option-menu-url current-domain">
                    </td>
                    <td style="vertical-align: middle; width: 50px">
                        <div class="action-wrapper">
                            @if($key >= 4)
                            <button type="button" class="btn btn-success btn-add-type">
                                <i class="dripicons-plus"></i>
                            </button>
                            @endif
                            @if($key >= 5)
                                <button type="button" class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    @else
        @for($i = 0; $i < 5; $i++)
            <tr>
                <td class="counter">{{ $i + 1 }}</td>
                <td style="width: 200px">
                    <select class="form-control menu-type" name="type[]">
                        @foreach(\App\Core\Glosary\MenuType::getAll() as $value)
                            <option value="{{ $value['VALUE'] }}">{{ $value['DISPLAY'] }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_title[]" class="form-control required option-menu-title" >
                </td>
                <td style="width: 250px">
                    <input type="text" style="padding: 3px 5px; overflow: hidden" name="option_menu_url[]" class="form-control required option-menu-url current-domain">
                </td>
                <td style="vertical-align: middle; width: 50px">
                    <div class="action-wrapper">
                        @if($i == 4)
                            <button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                        @endif
                    </div>
                </td>
            </tr>
        @endfor
    @endif
    </tbody>
</table>
