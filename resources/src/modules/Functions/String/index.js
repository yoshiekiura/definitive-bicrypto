export function string_cut(string, length = 10) {
    if(!string || string.length == 0) return "";
    if(string.length <= length) return string;

    return string.substring(0, length) + "..."
};

export function string_is_number(evt) {
    evt = (evt) ? evt : window.event;
    let charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
    } else {
        return true;
    }
}

export function string_is_number2(event,element) {
    event.target.setCustomValidity('');
    const patt = /^\d+\.{0,1}\d{0,2}$/;
    let value = event.target.value;
    if(!patt.test(value)){
        event.target.reportValidity();
        element.setAttribute("maxlength",value.length);
    }
    else
    {
        element.removeAttribute("maxlength")
    }
    if(value.length === 0){
        element.removeAttribute("maxlength");
    }
}


