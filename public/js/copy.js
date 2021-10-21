function hidden(x) {
    document.getElementById("copied" + x).style.visibility = "hidden";
}

function copyToClipboard(x) {
    
    var copyTarget = document.getElementById("string" + x);
    
    document.getElementById("copied" + x).style.visibility = "visible";
    
    copyTarget.select();
    
    document.execCommand("Copy");
    
    window.getSelection().removeAllRanges();
    
    //setTimeout(hidden(x), 20000);

}