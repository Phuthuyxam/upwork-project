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
    findParent(inputElement, 'media-load-image').querySelector('.home-slider-image').value = $url;
    addPreviewImage($url,findParent(inputElement, 'media-load-image').querySelector('.image-preview-container') );
}
function findParent(el, clas) {
    while ((el = el.parentNode) &&
    el.className.indexOf(clas) < 0);
    return el;
}
function addPreviewImage($url, $elm) {
    let htmlTemp = `<img class="image-preview" style="width: 100%" src="`+ $url +`" alt="your image">`;
    $elm.innerHTML = htmlTemp;
}
function deleteImagePreview(thisElm) {
    findParent(thisElm, 'media-load-image').querySelector('.home-slider-image').setAttribute('value' , "" );
    findParent(thisElm, 'media-load-image').querySelector('.home-slider-image').value = ""
    findParent(thisElm, 'media-load-image').querySelector('.image-preview-container').innerHTML = "";
}
