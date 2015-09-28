/*****************************************************/
/* IE fix for Dropdown hover                         */
/*****************************************************/
/* JS document for http://www.cbafitness.hu website  */
/* Copyright 2007 anaiz                              */
/* contact developer at info@anaiz.hu                */
/*                      wwww.anaiz.hu                */
/*****************************************************/

startList = function() {
if (document.all && document.getElementById) {
navRoot = document.getElementById("mainmenu");
for (i=0; i<navRoot.childNodes.length; i++) {
  node = navRoot.childNodes[i];
  if (node.nodeName=="LI") {
  node.onmouseover=function() {
  this.className+=" IEhover";
    }
  node.onmouseout=function() {
  this.className=this.className.replace
      (" IEhover", "");
   }
   }
  }
 }
}
window.onload=startList;
