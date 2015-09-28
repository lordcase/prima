/*****************************************************/
/* Editor front-end functions                        */
/*****************************************************/
/* JS document for http://www.cbafitness.hu website  */
/* Copyright 2007-2008 anaiz                         */
/* contact developer at info@anaiz.hu                */
/*                      wwww.anaiz.hu                */
/*****************************************************/


var eRoom;
var eDay;
var eHour;

var eClip = false;
var eClipInstr;
var eClipClass;
var eClipSpecial;

var eOpen = false;

function bweGetLeft(obj)
{
		fpos = obj.offsetLeft;
		dummy = obj.offsetParent;
  	while (dummy != null)
    {
  		fpos += dummy.offsetLeft;
	  	dummy = dummy.offsetParent;
  	}
		return fpos;
}

function bweGetTop(obj)
{
		fpos = obj.offsetTop;
		dummy = obj.offsetParent;
  	while (dummy != null)
    {
  		fpos += dummy.offsetTop;
	  	dummy = dummy.offsetParent;
  	}
		return fpos;
}


function bweCopy()
{
  eClip = true;
  eClipInstr = document.getElementById("bweInstructor").selectedIndex;
  eClipClass = document.getElementById("bweClassType").selectedIndex;

  if(document.getElementById("bweT1").checked)
  {
    eClipSpecial = 1;
  }
  else if(document.getElementById("bweT2").checked)
  {
    eClipSpecial = 2;
  }
  else if(document.getElementById("bweT3").checked)
  {
    eClipSpecial = 3;
  }
  else if(document.getElementById("bweT4").checked)
  {
    eClipSpecial = 4;
  }
  else
  {
    eClipSpecial = 0;
  }
}

function bweCut()
{
  bweCopy();
  bweErase();
}

function bweErase()
{
  document.getElementById("bweInstructor").selectedIndex = 0;
  document.getElementById("bweClassType").selectedIndex = 0;
  document.getElementById("bweT0").checked = true;
  document.getElementById("bweT1").checked = false;
  document.getElementById("bweT2").checked = false;
  document.getElementById("bweT3").checked = false;
  document.getElementById("bweT4").checked = false;
}


function bwePaste()
{
  if(eClip)
  {
    document.getElementById("bweInstructor").selectedIndex = eClipInstr;
    document.getElementById("bweClassType").selectedIndex = eClipClass;
    document.getElementById("bweT0").checked = false;
    document.getElementById("bweT1").checked = false;
    document.getElementById("bweT2").checked = false;
    document.getElementById("bweT3").checked = false;
	document.getElementById("bweT4").checked = false;
    document.getElementById("bweT" + eClipSpecial).checked = true;
  }
}

function bweOpen(room, day, hour)
{
  if(eOpen != true)
  {
  
    fcell = document.getElementById("bwec" + room + "_" + day + "_" + hour);
    fbox = document.getElementById("editbox");
    
    finputId = "bwei" + room + "_" + day + "_" + hour;
  
    eRoom = room;
    eDay = day;
    eHour = hour;
  
    var hunDays = new Array("Hétfõ", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat", "Vasárnap");
  
    if(room == 2)
    {
      if(hour == 6)
      {
        min = ":15";
      }
      else min = ":30";
    }
    else min = ":00";
  
    document.getElementById("bweHour").innerHTML = hour + min;
    document.getElementById("bweDay").innerHTML = hunDays[day - 1];
    
    i = 0;
    iindex = 0;
    ivalue = document.getElementById(finputId + "instr").value;
    imax = document.getElementById("bweInstructor").length - 1;
    while(iindex==0 && i<=imax)
    {
      if(document.getElementById("bweInstructor").options[i].value == ivalue)
      {
        iindex = i;
      }
      i++;
    }
    document.getElementById("bweInstructor").selectedIndex = iindex;
    
    
    i = 0;
    iindex = 0;
    ivalue = document.getElementById(finputId + "class").value;
    imax = document.getElementById("bweClassType").length - 1;
    while(iindex==0 && i<=imax)
    {
      if(document.getElementById("bweClassType").options[i].value == ivalue)
      {
        iindex = i;
      }
      i++;
    }
    document.getElementById("bweClassType").selectedIndex = iindex;
  
    document.getElementById("bweT0").checked = false;
    document.getElementById("bweT1").checked = false;
    document.getElementById("bweT2").checked = false;
    document.getElementById("bweT3").checked = false;
	document.getElementById("bweT4").checked = false;
    document.getElementById("bweT" + document.getElementById(finputId + "special").value).checked = true;
      
    itop = bweGetTop(fcell) + 20;
    ileft =  bweGetLeft(fcell) + 20;

    ftable = document.getElementById("bweTable" + room);

    fbox.style.top = 0;
    fbox.style.left = -1000;
    fbox.style.display = "block";

    maxtop = bweGetTop(ftable) + ftable.clientHeight - fbox.clientHeight - 20;     
    maxleft = bweGetLeft(ftable) + ftable.clientWidth - fbox.clientWidth - 20; 
    
    if (itop>maxtop) { itop = maxtop };
    if (ileft>maxleft) { ileft = maxleft };
  
    fbox.style.top = itop;
    fbox.style.left = ileft;
    
    eOpen = true;
  }
}

function bweOK()
{
  fcell = document.getElementById("bwec" + eRoom + "_" + eDay + "_" + eHour);
  
  finstrIndex = document.getElementById("bweInstructor").selectedIndex;
  finstrId = document.getElementById("bweInstructor").options[finstrIndex].value;
  fclassIndex = document.getElementById("bweClassType").selectedIndex;
  fclassId = document.getElementById("bweClassType").options[fclassIndex].value;

  finputId = "bwei" + eRoom + "_" + eDay + "_" + eHour;

  
  if(fclassId>0 || finstrId>0)
  {
    fcell.innerHTML = instrList[finstrId] + "<br />" + classList[fclassId];  
    document.getElementById(finputId + "instr").value = finstrId;
    document.getElementById(finputId + "class").value = fclassId;
    document.getElementById(finputId + "changed").value = 1;

    if(document.getElementById("bweT1").checked)
    {
      fcell.className = "uj";
      document.getElementById(finputId + "special").value = 1;
    }
    else if(document.getElementById("bweT2").checked)
    {
      fcell.className = "special";
      document.getElementById(finputId + "special").value = 2;
    }
    else if(document.getElementById("bweT3").checked)
    {
      fcell.className = "pot";
      document.getElementById(finputId + "special").value = 3;
    }
    else if(document.getElementById("bweT4").checked)
    {
      fcell.className = "special2";
      document.getElementById(finputId + "special").value = 4;
    }
    else
    {
      fcell.className = "";
      document.getElementById(finputId + "special").value = 0;
    }
  }
  else
  {
    fcell.innerHTML = "&nbsp;";
    fcell.className = "";
    document.getElementById(finputId + "instr").value = 0;
    document.getElementById(finputId + "class").value = 0;
    document.getElementById(finputId + "special").value = 0;
    document.getElementById(finputId + "changed").value = 1;
  }
  
  document.getElementById("editbox").style.display = "none";
  
  eOpen = false;
}


function bweCancel()
{
  document.getElementById("editbox").style.display = "none";

  eOpen = false;
}



startList2 = function() {
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
//window.onload=startList;
