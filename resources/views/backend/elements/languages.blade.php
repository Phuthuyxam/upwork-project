@php
    $languages = \App\Core\Glosary\LocationConfigs::getAll();
    $defaultLang = \App\Core\Glosary\LocationConfigs::getLanguageDefault();
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="right" style="float: right; margin-bottom: 30px; display: flex; align-items: center">
                <i class="dripicons-web" style="font-size: 20px; line-height: 0; margin-right: 5px"></i>
                @if(isset($languages) && !empty($languages))
                <select class="selectpicker" data-width="fit" onchange="makeUrlTranslation(this)">
                    @foreach($languages as $lan)
                        <option
                            value="{{ renderTranslationUrl(url()->current(), $lan['VALUE']) }}"
                            {{ app()->getLocale() == $lan['VALUE'] ? 'selected' : false }}>{{ $lan['DISPLAY'] }}</option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    let languages = '{{ json_encode($languages) ? json_encode($languages) : ""  }}';
    function makeUrlTranslation($this) {
        let value = $this.value;
        window.location.href = value;
    }
</script>
