function copyh5purl2clipboard(a) {
    /* Get the text field */
    var copyText = document.getElementById(a);
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/
    document.execCommand("copy");
}
