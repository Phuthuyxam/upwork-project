function changeToSlug(str)
{
    let slug;
    //Đổi chữ hoa thành chữ thường
    slug = str.toLowerCase();
    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/\&/gi, 'va');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');

    return slug;
}

function validateFileUpload(input)
{
    let allowed_extensions = ["jpg","png","gif","jpeg",'svg'];
    if (input.files) {
        let filesAmount = input.files.length;
        for (let i = 0; i < filesAmount; i++) {
            let file_extension = input.files[i].name.split('.').pop().toLowerCase();
            if (!allowed_extensions.includes(file_extension)) {
                return false;
            }
            if (input.files[i].size >= maxFileSize) {
                return false;
            }
        }
    }
    return true;
}

function readURLMultiple(input, element) {

    if (input.files) {
        let filesAmount = input.files.length;
        $(element).empty();
        for (let i = 0; i < filesAmount; i++) {
            let reader = new FileReader();

            reader.onload = function(event) {
                let html = '<div class="items">' +
                    '<img  style="width: 100%" src="' + event.target.result + '" title="'+name+'" alt="your image" />'+
                    '</div>';

                $(element).append(html);
            }

            reader.readAsDataURL(input.files[i]);
        }
    }
}

function readURL(input, element) {
    if (input.files && input.files[0]) {
        element.find('img').remove();
        let reader = new FileReader();
        let name = input.files[0].name;
        reader.onload = function (e) {

            let html = '<img id="image" style="width: 100%" src="' + e.target.result + '" title="'+name+'" alt="your image" />';
            element.append(html);
        }
        reader.readAsDataURL(input.files[0]);
    }
}


// load image media manager
function openMediaManager(btnElm) {
    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
    // input
    inputElement = btnElm;
}
// set file link
let inputElement = '';
function fmSetLink($url) {
    findParent(inputElement, 'media-load-image').querySelector('.home-slider-image').setAttribute('value' , $url );
    addPreviewImage($url,findParent(inputElement, 'media-load-image').querySelector('.image-preview-container') );
}
function findParent(el, clas) {
    while ((el = el.parentNode) &&
    el.className.indexOf(clas) < 0);
    return el;
}
function addPreviewImage($url, $elm) {
    let htmlTemp = `<img class="image-preview" style="width: 20%" src="`+ $url +`" alt="your image">`;
    $elm.innerHTML = htmlTemp;
}
function deleteImagePreview(thisElm) {
    findParent(thisElm, 'media-load-image').querySelector('.home-slider-image').setAttribute('value' , "" );
    findParent(thisElm, 'media-load-image').querySelector('.image-preview-container').innerHTML = "";
}
