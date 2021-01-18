

{{--    {{ getDataSeoOption($objectId, $seoType) }}--}}

@if(isset($objectId) && !empty($objectId) && isset($seoType) && !empty($seoType))
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">SEO option</h4>

            <form action="{{ route('seo.add',['object_id' => $objectId, 'seo_type' => $seoType]) }}" method="POST">
                @csrf
                <div class="seo-field" style="border: 1px solid #ced4da; margin-bottom: 30px">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#seo" role="tab"><i class="mdi mdi-bookmark-check"></i>SEO</a>
                        </li>
                        @if($seoType != \App\Core\Glosary\SeoConfigs::SEOTYPE['GROUP']['KEY'])
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#schema" role="tab"><i class="mdi mdi-format-list-checks"></i>Schema</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#social" role="tab"><i class="mdi mdi-share-variant"></i>Social</a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active p-3" id="seo" role="tabpanel">

                            <label class="mb-1">Focus keyphrase</label>
                            <p class="text-muted mb-3 font-size-14">
                                Help on choosing the perfect focus keyphrase
                            </p>
                            <input type="text" class="form-control" maxlength="25" name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['FOCUS_KEYPHARE'] }}"
                                   id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['FOCUS_KEYPHARE'] }}" />

                            <div class="mt-4">
                                <label class="mb-1">SEO title</label>
                                <input type="text" maxlength="25" name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['TITLE'] }}" class="form-control"
                                       id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['TITLE'] }}" />
                            </div>

                            <div class="mt-4">
                                <label class="mb-1">Meta description</label>
                                <textarea class="form-control" name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['DESC'] }}"
                                          id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['DESC'] }}" rows="3"></textarea>
                            </div>


                            <div class="mt-4">
                                <label class="mb-1">Allow search engines to show this Post in search results?</label>
                                <select class="form-control" name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['SHOW_POST_IN_SEARCH'] }}"
                                        id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['SHOW_POST_IN_SEARCH'] }}">
                                    <option value="1" selected >Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <div style="display: flex; align-items: center">
                                    Should search engines follow links on this Post
                                    <div style="line-height: 0; margin-left: auto">
                                        <input type="checkbox" switch="none" checked=""
                                               name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['FOLLOW_LINK_POST'] }}"
                                               id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['FOLLOW_LINK_POST'] }}">
                                        <label for="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['FOLLOW_LINK_POST'] }}" data-on-label="On" data-off-label="Off" style="margin: 0"></label>
                                    </div>

                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="mb-1">
                                    Meta robots advanced
                                </label>

                                <div style="display: flex; align-items: center; margin-bottom: 10px">
                                    Meta robots no image
                                    <div style="line-height: 0; margin-left: auto">
                                        <input type="checkbox" switch="primary"
                                               name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['ROBOTS_ADVANCED_NO_IMAGE'] }}"
                                               id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['ROBOTS_ADVANCED_NO_IMAGE'] }}">
                                        <label for="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['ROBOTS_ADVANCED_NO_IMAGE'] }}" data-on-label="On" data-off-label="Off" style="margin: 0"></label>
                                    </div>

                                </div>

                                <div style="display: flex; align-items: center; margin-bottom: 10px">
                                    Meta robots no archive
                                    <div style="line-height: 0; margin-left: auto">
                                        <input type="checkbox" switch="primary"
                                               name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['ROBOTS_ADVANCED_NO_ARCHIVE'] }}"
                                               id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['ROBOTS_ADVANCED_NO_ARCHIVE'] }}">
                                        <label for="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['ROBOTS_ADVANCED_NO_ARCHIVE'] }}" data-on-label="On" data-off-label="Off" style="margin: 0"></label>
                                    </div>

                                </div>

                                <div style="display: flex; align-items: center; margin-bottom: 10px">
                                    Meta robots no snippet
                                    <div style="line-height: 0; margin-left: auto">
                                        <input type="checkbox" switch="primary"
                                               name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['ROBOTS_ADVANCED_NO_SNIPPET'] }}"
                                               id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['ROBOTS_ADVANCED_NO_SNIPPET'] }}" >
                                        <label for="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['ROBOTS_ADVANCED_NO_SNIPPET'] }}" data-on-label="On" data-off-label="Off" style="margin: 0"></label>
                                    </div>
                                </div>

                            </div>

                            <div class="mt-4">
                                <label class="mb-1">
                                    Canonical URL
                                </label>
                                <input type="text" maxlength="25" name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['CANONICAL_URL'] }}"
                                       id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SEO']['CANONICAL_URL'] }}"
                                       class="form-control" id="seo_conical_url" />
                            </div>



                        </div>
                        @if($seoType != \App\Core\Glosary\SeoConfigs::SEOTYPE['GROUP']['KEY'])
                        <div class="tab-pane p-3" id="schema" role="tabpanel">
                            <p class="font-14 mb-0">
                                <b>describes your pages using schema.org</b><br>
                                This helps search engines understand your website and your content.
                                You can change some of your settings for this page below.</p>
                            <div class="mt-4">
                                <textarea class="form-control"
                                          name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SCHEMA']['CUSTOM_VALUE'] }}"
                                          id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SCHEMA']['CUSTOM_VALUE'] }}"
                                          rows="8"></textarea>
                            </div>
                        </div>
                        @endif
                        <div class="tab-pane p-3" id="social" role="tabpanel">

                            <div class="social-facebook">
                                <div class="mt-4">
                                    <label class="mb-1">
                                        Facebook image
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['FACEBOOK']['IMAGE'] }}"
                                               id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['FACEBOOK']['IMAGE'] }}"
                                               aria-label="Image" aria-describedby="button-image">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary waves-effect waves-light" type="button" id="button-image-face">Select Image</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="mb-1">
                                        Facebook title
                                    </label>
                                    <input type="text" maxlength="25"
                                           name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['FACEBOOK']['TITLE'] }}"
                                           id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['FACEBOOK']['TITLE'] }}"
                                           class="form-control"/>
                                </div>

                                <div class="mt-4">
                                    <label class="mb-1">
                                        Facebook description
                                    </label>
                                    <textarea class="form-control"
                                              name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['FACEBOOK']['DESCRIPTION'] }}"
                                              id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['FACEBOOK']['DESCRIPTION'] }}"
                                              rows="3"></textarea>
                                </div>
                            </div>
                            <hr>
                            <div class="social-twitter">
                                <div class="mt-4">
                                    <label class="mb-1">
                                        Twitter image
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                               name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['TWITTER']['IMAGE'] }}"
                                               id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['TWITTER']['IMAGE'] }}"
                                               aria-label="Image" aria-describedby="button-image">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary waves-effect waves-light" type="button" id="button-image-twitter">Select Image</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="mb-1">
                                        Twitter title
                                    </label>
                                    <input type="text" maxlength="25" name="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['TWITTER']['TITLE'] }}"
                                           id="{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['TWITTER']['TITLE'] }}" class="form-control"/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <div class="form-group mb-0">
                        <div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                Save SEO option
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById('button-image-face').addEventListener('click', (event) => {
                event.preventDefault();

                inputId = "{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['FACEBOOK']['IMAGE'] }}";

                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });

            // second button
            document.getElementById('button-image-twitter').addEventListener('click', (event) => {
                event.preventDefault();

                inputId = "{{ \App\Core\Glosary\SeoConfigs::SEOKEY['SOCIAL']['TWITTER']['IMAGE'] }}";

                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
        });

        // input
        let inputId = '';

        // set file link
        function fmSetLink($url) {
            document.getElementById(inputId).value = $url;
        }
        function loadSeoData() {
            var xhttp = new XMLHttpRequest();
            xhttp.responseType = 'json';
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var seoResponse = this.response;
                    for(var [key, value] of Object.entries(seoResponse)) {
                        var element = document.getElementById(key);
                        if(element) {
                            var tag = element.tagName;
                            if(tag === 'INPUT'){
                                if (element.type == "text") {
                                    element.value = value;
                                }
                                if (element.type == "checkbox") {
                                    if(value === '1'){
                                        element.checked = true;
                                    }else{
                                        element.checked = false;
                                    }
                                }
                                if (element.type == "radio") {
                                    // some code
                                }
                            }
                            if(tag === 'SELECT') {
                                element.value = value;
                            }
                            if(tag === 'TEXTAREA') {
                                element.value = value;
                            }
                        }
                    }
                }
            };
            xhttp.open("GET", "{{ route('seo.data',['object_id' => $objectId, 'seo_type' => $seoType]) }}", true);
            xhttp.send();
        }
        document.addEventListener("DOMContentLoaded", function() {
            loadSeoData();
        });
    </script>
@endif

