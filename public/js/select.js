function check(){
    radio = document.getElementsByName('flexRadioDefault');
    if(radio[0].checked) {
        document.getElementById('check1').style.visibility = "";
        document.getElementById('check2').style.visibility = "hidden";
    }else if(radio[1].checked) {
        document.getElementById('check1').style.visibility = "hidden";
        document.getElementById('check2').style.visibility = "";
        
    }
    window.onload = check;
}

window.onpageshow = function(event) {
	if (event.persisted) {
		 window.location.reload();
	}
};