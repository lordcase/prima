// Image Popup Window Script
// by Anaiz
// -------------------------
// info@anaiz.hu
// www.anaiz.hu


function imageWindow(imgName, imgWidth, imgHeight, lang)
{
  var windowWidth = imgWidth + 100;
  var windowHeight = imgHeight + 60;
    
	var windowLang = (lang == null) ? "hu" : lang;	
    
  window.open('image.php?img=' + imgName + "&lang=" + windowLang, '', 'width=' + windowWidth + ',height=' + windowHeight);
}

function movieWindow(movName, movWidth, movHeight, lang)
{
  var windowWidth = movWidth + 100;
  var windowHeight = movHeight + 60;

	var windowLang = (lang == null) ? "hu" : lang;	
    
  window.open('movie.php?mov=' + movName + "&lang=" + windowLang, '', 'width=' + windowWidth + ',height=' + windowHeight);
}
