function toUppercaseUnderscore(event) {
    const input = event.target;
    let value = input.value;
    value = value.replace(/[^\w\s]/gi, '');

    value = value.replace(/\s+/g, '_');

    value = value.toUpperCase();

    input.value = value;
}

function toUppercase(event){
    const input = event.target;
    let value = input.value;

    value = value.toUpperCase();

    input.value = value;
}
