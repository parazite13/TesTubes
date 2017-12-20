function formatTime(duration){
	return duration.substr(2).toLowerCase();
}

function formatDate(day, month, year){
	if(day < 10) day = "0" + day;
	if(month < 10) month = "0" + month;

	return day + '/' + month + '/' + year;
}

function formatInt(nStr){

	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ' ' + '$2');
	}
	
	return x1 + x2;
}

String.prototype.lpad = function(padString, length) {
	var str = this;
	while (str.length < length)
		str = padString + str;
	return str;
}