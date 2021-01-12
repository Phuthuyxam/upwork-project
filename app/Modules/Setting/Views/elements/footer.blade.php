@if($dataFooter->isNotEmpty())
    @php
        $menus = json_decode($dataFooter[0]->option_value, true);
    @endphp
@endif

<div class="form-group row">
    <label for="example-text-input" class="col-sm-2 col-form-label">
        Copyright right text
    </label>
    <div class="col-sm-10">
        <input class="form-control" name="copyright_text" type="text" value="{{ ((isset($menus['copyright_text'])) && !empty($menus['copyright_text'])) ? $menus['copyright_text'] : ""  }}">
    </div>
</div>
<div class="form-group row">
    <label for="example-text-input" class="col-sm-2 col-form-label">
        Developed by text
    </label>
    <div class="col-sm-10">
        <input class="form-control" name="develop_text" type="text" value="{{ ((isset($menus['develop_text'])) && !empty($menus['develop_text'])) ? $menus['develop_text'] : ""  }}">
    </div>
</div>
