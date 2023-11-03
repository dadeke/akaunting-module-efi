"use strict";

//sales.customers
let efi_tax_number = document.getElementById('tax_number');
let efi_address = document.getElementById('address');
let efi_city = document.getElementById('city');
let efi_state = document.getElementById('state');
let efi_zip_code = document.getElementById('zip_code');

function setRequired(element, parentElement) {
    let div_class = parentElement.getAttribute('class');

    div_class += ' required';
    parentElement.setAttribute('class', div_class);

    if(element.required === false) {
        element.setAttribute('required', 'required');
    }
}

if(efi_tax_number !== null) {
    setRequired(
        efi_tax_number,
        efi_tax_number.parentElement.parentElement
    );

    efi_tax_number.setAttribute('maxlength', '14');
    efi_tax_number.setAttribute(
        'onkeypress',
        'return keyPressOnlyNumber(event)'
    );
}

if(efi_address !== null) {
    setRequired(
        efi_address,
        efi_address.parentElement
    );
}

if(efi_city !== null) {
    setRequired(
        efi_city,
        efi_city.parentElement.parentElement
    );
}

if(efi_state !== null) {
    setRequired(
        efi_state,
        efi_state.parentElement.parentElement
    );

    efi_state.setAttribute('maxlength', '2');
}

if(efi_zip_code !== null) {
    setRequired(
        efi_zip_code,
        efi_zip_code.parentElement.parentElement
    );

    efi_zip_code.setAttribute('maxlength', '9');
    efi_zip_code.setAttribute(
        'onkeypress',
        'return keyPressFormatCEP(event)'
    );
}

// Return key code
function getKey(e) {
	return window.event ? event.keyCode : e.which;
}

// Return key pressed only if is number
function keyPressOnlyNumber(e) {
	var key = getKey(e);

	if(key > 47 && key < 58) {
        return true;
    }
	else {
		if (key == 8 || key == 0){
            return true;
        }
		else {
            return false;
        }
	}
}

// Return key pressed to format Brazillian zip code
function keyPressFormatCEP(e) {
    let path = e.path || (e.composedPath && e.composedPath());
    if(path[0].value.length == 5) {
        path[0].value += '-';
    }

    return keyPressOnlyNumber(e);
}
