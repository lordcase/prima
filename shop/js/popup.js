// Popup Div Script
// by Anaiz
// -------------------------
// info@anaiz.hu
// www.anaiz.hu


function showPopup(popupId) {
  showPopupAt(popupId, 80, 250);
}

function showPopupAt(popupId, popX, popY) {
  document.getElementById("Popup" + popupId).style.left = popX;
  document.getElementById("Popup" + popupId).style.top = popY;
  document.getElementById("Popup" + popupId).style.visibility = "visible";
}

function hidePopup(popupId) {
  document.getElementById("Popup" + popupId).style.visibility = "hidden";
}
