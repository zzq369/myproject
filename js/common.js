<!--
// Sidemenu show
function show(no){
var Obj=document.getElementById("menusub" + no);
//var ImgObj=eval("menuimg"+ no);
var tempColl = document.getElementsByTagName("li");
 for(i=0; i<tempColl.length; i++)
 {
  if ((tempColl[i].id != Obj.id) && ((tempColl[i].className == "menusub"))){  
   tempColl[i].style.display = "none";
   }
   
 }
if(Obj.style.display=='none')
 {
   Obj.style.display='';
  // ImgObj.src='bbs_image/forum_parent_1.gif';
 }
else
 {
   Obj.style.display='none';
   //ImgObj.src='bbs_image/forum_parent_0.gif';
 }
}

function showta(no){
var Obj=eval("mm" + no);
var tempColl = document.getElementsByTagName("table");
 for(i=0; i<tempColl.length; i++)
 {
  if ((tempColl[i].id != Obj.id) && ((tempColl[i].className == "mm"))){  
   tempColl[i].style.display = "none";   
   }
   
 }	
 if(Obj.style.display=='none')
 {
   Obj.style.display='';
 }
}

function rates(no,state){
   var stars = document.getElementsByName("star");    
   document.rate.rep.value=no;
   for(i=0; i<no; i++)
   {
	   stars[i].src="Images/star2.gif";
   }
   for(j=no; j<5; j++)
   {
	   stars[j].src="Images/star1.gif";
   }
   
}

//other

function initMenu(obj,list) {
var cobj=document.getElementById(list);
if(cobj != null){
cobj.style.display=(cobj.style.display=="none") ? "" : "none";
}
}

function Winopen(Url)
{
	window.open(Url,"facility","left=0,top=0,width=700,height=600,toolbar=1,status=1,scrollbars=1");
}
function regInput(obj, reg, inputStr)
	{
		var docSel	= document.selection.createRange()
		if (docSel.parentElement().tagName != "INPUT")	return false
		oSel = docSel.duplicate()
		oSel.text = ""
		var srcRange	= obj.createTextRange()
		oSel.setEndPoint("StartToStart", srcRange)
		var str = oSel.text + inputStr + srcRange.text.substr(oSel.text.length)
		return reg.test(str)
	}
	
function showLargePic (pic) { 	
	if (document.getElementById) { 		
	document.getElementById('LargePic').src = pic.href;
	return false; 	
	} 
	  else { return true; } 
}
	
function checkspace(checkstr) {
  var str = '';
  for(i = 0; i < checkstr.length; i++) {
    str = str + ' ';
  }
  return (str == checkstr);
}

// feedback
function CheckForm()
{
	
	if(document.myformfeedback.username.value=="")
	{
		alert("Must be Filled Name?");
		document.myformfeedback.username.focus();
		return false;
	}
	
	if(document.myformfeedback.Country.value=="")
	{
		alert("Must be Filled Country?");
		document.myformfeedback.Country.focus();
		return false;
	}
		
 if(document.myformfeedback.email.value.length!=0)
  {
    if (document.myformfeedback.email.value.charAt(0)=="." ||        
         document.myformfeedback.email.value.charAt(0)=="@"||       
         document.myformfeedback.email.value.indexOf('@', 0) == -1 || 
         document.myformfeedback.email.value.indexOf('.', 0) == -1 || 
         document.myformfeedback.email.value.lastIndexOf("@")==document.myformfeedback.email.value.length-1 || 
         document.myformfeedback.email.value.lastIndexOf(".")==document.myformfeedback.email.value.length-1)
     {
      alert("E-mail spelling error?");
      document.myformfeedback.email.focus();
      return false;
      }
   }
 else
  {
   alert("Must be Filled E-mail?");
   document.myformfeedback.email.focus();
   return false;
   }
	
	if(document.myformfeedback.title.value=="")
	{
		alert("Must be Filled Subject?");
		document.myformfeedback.title.focus();
		return false;
	}
	
	if(document.myformfeedback.content.value=="")
	{
		alert("Must be Filled Content?");
		document.myformfeedback.content.focus();
		return false;
	}
	
}


//Reg
function checkreginfo()
{  
  
  if(document.userinfo.firstname.value.length=="" || document.userinfo.firstname.value.length < 2)
  {
   alert("Must be Filled First Name? Must contain a minimum of 2 characters ?");
   document.userinfo.firstname.focus();
   return false;
   }
   
  if(document.userinfo.lastname.value.length=="" || document.userinfo.lastname.value.length < 2)
  {
   alert("Must be Filled Last Name? Must contain a minimum of 2 characters ?");
   document.userinfo.lastname.focus();
   return false;
   }
   
  if(document.userinfo.street.value.length=="" || document.userinfo.street.value.length < 5)
  {
   alert("Must be Filled Street Address? Must contain a minimum of 5 characters ?");
   document.userinfo.street.focus();
   return false;
   }
      
   if(document.userinfo.city.value.length=="" || document.userinfo.city.value.length < 2)
  {
   alert("Must be Filled City? Must contain a minimum of 2 characters ?");
   document.userinfo.city.focus();
   return false;
   }
   
   if(document.userinfo.province.value.length=="" || document.userinfo.province.value.length < 2)
  {
   alert("Must be Filled Province? Must contain a minimum of 2 characters ?");
   document.userinfo.province.focus();
   return false;
   }
   
   if(document.userinfo.postcode.value.length=="" || document.userinfo.postcode.value.length < 4)
  {
   alert("Must be Filled Post Code? Must contain a minimum of 4 characters ?");
   document.userinfo.postcode.focus();
   return false;
   }
   
   if(document.userinfo.country.value.length=="")
  {
   alert("Must be Select the Country? ");
   document.userinfo.country.focus();
   return false;
   }
   
   if(document.userinfo.msn.value.length!=0)
  {
    if (document.userinfo.msn.value.charAt(0)=="." ||        
         document.userinfo.msn.value.charAt(0)=="@"||       
         document.userinfo.msn.value.indexOf('@', 0) == -1 || 
         document.userinfo.msn.value.indexOf('.', 0) == -1 || 
         document.userinfo.msn.value.lastIndexOf("@")==document.userinfo.msn.value.length-1 || 
         document.userinfo.msn.value.lastIndexOf(".")==document.userinfo.msn.value.length-1)
     {
      alert("Must be Filled Msn?");
      document.userinfo.msn.focus();
      return false;
      }
   }
  else
  {
   alert("Must be Filled MSN?");
   document.userinfo.msn.focus();
   return false;
   }
   
   if(document.userinfo.tel.value.length=="" || document.userinfo.tel.value.length < 2)
  {
   alert("Must be Filled Telephone? Must contain a minimum of 3 characters ?");
   document.userinfo.tel.focus();
   return false;
   }
   
      
   if(document.userinfo.birth.value.length=="")
  {
   alert("Must be Filled Birthday?");
   document.userinfo.birth.focus();
   return false;
   }   
      
  if(document.userinfo.email.value.length!=0)
  {
    if (document.userinfo.email.value.charAt(0)=="." ||        
         document.userinfo.email.value.charAt(0)=="@"||       
         document.userinfo.email.value.indexOf('@', 0) == -1 || 
         document.userinfo.email.value.indexOf('.', 0) == -1 || 
         document.userinfo.email.value.lastIndexOf("@")==document.userinfo.email.value.length-1 || 
         document.userinfo.email.value.lastIndexOf(".")==document.userinfo.email.value.length-1)
     {
      alert("Must be Filled Email?");
      document.userinfo.email.focus();
      return false;
      }
   }
  else
  {
   alert("Must be Filled Email?");
   document.userinfo.email.focus();
   return false;
   }
   
   if(checkspace(document.userinfo.userpassword.value) || document.userinfo.userpassword.value.length < 6) {
	document.userinfo.userpassword.focus();
    alert("Must be Filled Password? Must contain a minimum of 6 characters ?");
	return false;
   }
    if(document.userinfo.userpassword.value != document.userinfo.userpassword1.value) {
	document.userinfo.userpassword1.focus();
	document.userinfo.userpassword1.value = '';
    alert("Must be Filled the two password is the same?");
	return false;
   }
   
}


//vip 
function checkuserinfo()
{  
  
  if(document.userinfo.firstname.value.length=="" || document.userinfo.firstname.value.length < 2)
  {
   alert("Must be Filled First Name? Must contain a minimum of 2 characters ?");
   document.userinfo.firstname.focus();
   return false;
   }
   
  if(document.userinfo.lastname.value.length=="" || document.userinfo.lastname.value.length < 2)
  {
   alert("Must be Filled Last Name? Must contain a minimum of 2 characters ?");
   document.userinfo.lastname.focus();
   return false;
   }
   
  if(document.userinfo.street.value.length=="" || document.userinfo.street.value.length < 5)
  {
   alert("Must be Filled Street Address? Must contain a minimum of 5 characters ?");
   document.userinfo.street.focus();
   return false;
   }
      
   if(document.userinfo.city.value.length=="" || document.userinfo.city.value.length < 2)
  {
   alert("Must be Filled City? Must contain a minimum of 2 characters ?");
   document.userinfo.city.focus();
   return false;
   }
   
   if(document.userinfo.province.value.length=="" || document.userinfo.province.value.length < 2)
  {
   alert("Must be Filled Province? Must contain a minimum of 2 characters ?");
   document.userinfo.province.focus();
   return false;
   }
   
   if(document.userinfo.postcode.value.length=="" || document.userinfo.postcode.value.length < 4)
  {
   alert("Must be Filled Post Code? Must contain a minimum of 4 characters ?");
   document.userinfo.postcode.focus();
   return false;
   }
   
   if(document.userinfo.country.value.length=="")
  {
   alert("Must be Select the Country? ");
   document.userinfo.country.focus();
   return false;
   }
   
   if(document.userinfo.msn.value.length!=0)
  {
    if (document.userinfo.msn.value.charAt(0)=="." ||        
         document.userinfo.msn.value.charAt(0)=="@"||       
         document.userinfo.msn.value.indexOf('@', 0) == -1 || 
         document.userinfo.msn.value.indexOf('.', 0) == -1 || 
         document.userinfo.msn.value.lastIndexOf("@")==document.userinfo.msn.value.length-1 || 
         document.userinfo.msn.value.lastIndexOf(".")==document.userinfo.msn.value.length-1)
     {
      alert("Must be Filled Msn?");
      document.userinfo.msn.focus();
      return false;
      }
   }
  else
  {
   alert("Must be Filled MSN?");
   document.userinfo.msn.focus();
   return false;
   }
   
   if(document.userinfo.tel.value.length=="" || document.userinfo.tel.value.length < 2)
  {
   alert("Must be Filled Telephone? Must contain a minimum of 3 characters ?");
   document.userinfo.tel.focus();
   return false;
   }
   
      
   if(document.userinfo.birth.value.length=="")
  {
   alert("Must be Filled Birthday?");
   document.userinfo.birth.focus();
   return false;
   }   
           
}


function changeinfo()
{  
  
  if(document.userinfo.firstname.value.length=="" || document.userinfo.firstname.value.length < 2)
  {
   alert("Must be Filled First Name? Must contain a minimum of 2 characters ?");
   document.userinfo.firstname.focus();
   return false;
   }
   
  if(document.userinfo.lastname.value.length=="" || document.userinfo.lastname.value.length < 2)
  {
   alert("Must be Filled Last Name? Must contain a minimum of 2 characters ?");
   document.userinfo.lastname.focus();
   return false;
   }
   
  if(document.userinfo.street.value.length=="" || document.userinfo.street.value.length < 5)
  {
   alert("Must be Filled Street Address? Must contain a minimum of 5 characters ?");
   document.userinfo.street.focus();
   return false;
   }
      
   if(document.userinfo.city.value.length=="" || document.userinfo.city.value.length < 2)
  {
   alert("Must be Filled City? Must contain a minimum of 2 characters ?");
   document.userinfo.city.focus();
   return false;
   }
   
   if(document.userinfo.province.value.length=="" || document.userinfo.province.value.length < 2)
  {
   alert("Must be Filled Province? Must contain a minimum of 2 characters ?");
   document.userinfo.province.focus();
   return false;
   }
   
   if(document.userinfo.postcode.value.length=="" || document.userinfo.postcode.value.length < 4)
  {
   alert("Must be Filled Post Code? Must contain a minimum of 4 characters ?");
   document.userinfo.postcode.focus();
   return false;
   }
   
   if(document.userinfo.country.value.length=="")
  {
   alert("Must be Select the Country? ");
   document.userinfo.country.focus();
   return false;
   }
   
   if(document.userinfo.tel.value.length=="" || document.userinfo.tel.value.length < 2)
  {
   alert("Must be Filled Telephone? Must contain a minimum of 3 characters ?");
   document.userinfo.tel.focus();
   return false;
   }   
           
}


function check0()
{
   if(checkspace(document.shop0.email.value)) {
	document.shop0.email.focus();
    alert("Must be Fill email");
	return false;
  }
  }
function check1()
{
   if(checkspace(document.shop1.UserAnswer.value)) {
	document.shop1.UserAnswer.focus();
    alert("Must be Fill answer");
	return false;
  }
  }
   function check2()
{
   if(checkspace(document.shop2.UserPassword1.value)) {
	document.shop2.UserPassword1.focus();
    alert("Must be Fill new password");
	return false;
  }
  if(checkspace(document.shop2.UserPassword2.value)) {
	document.shop2.UserPassword2.focus();
    alert("Must be Fill confirm password");
	return false;
  }
  if(document.shop2.UserPassword1.value != document.shop2.UserPassword2.value) {
	document.shop2.UserPassword1.focus();
	document.shop2.UserPassword1.value = '';
	document.shop2.UserPassword2.value = '';
    alert("the two password is the same?");
	return false;
  }
}

function checkrepass()
{
   if(checkspace(document.userpass.UserPassword.value)) {
	document.userpass.UserPassword.focus();
    alert("Must be Fill old password");
	return false;
  }
     if(checkspace(document.userpass.UserPassword1.value)) {
	document.userpass.UserPassword1.focus();
    alert("Must be Fill new password");
	return false;
  }
     if(checkspace(document.userpass.UserPassword2.value)) {
	document.userpass.UserPassword2.focus();
    alert("Must be Fill confirm password");
	return false;
  }
   if(document.userpass.UserPassword1.value != document.userpass.UserPassword2.value) {
	document.userpass.UserPassword1.focus();
	document.userpass.UserPassword1.value = '';
	document.userpass.UserPassword2.value = '';
    alert("the two password is the same?");
	return false;
  }
}

  function checkuu()
{
    if(checkspace(document.loginfo.email.value)) {
	document.loginfo.email.focus();
    alert("Must be Fill email");
	return false;
  }
    if(checkspace(document.loginfo.UserPassword.value)) {
	document.loginfo.UserPassword.focus();
    alert("Must be Fill password");
	return false;
  }   
	
  }
  
  
 //order 
 function OrderCheckForm()
{
	
	if(document.order_myform.firstname.value=="")
	{
		alert("Must be Filled First Name?");
		document.order_myform.firstname.focus();
		return false;
	}
	if(document.order_myform.lastname.value=="")
	{
		alert("Must be Filled Last Name?");
		document.order_myform.lastname.focus();
		return false;
	}
	if(document.order_myform.email.value.length!=0)
  {
    if (document.order_myform.email.value.charAt(0)=="." ||        
         document.order_myform.email.value.charAt(0)=="@"||       
         document.order_myform.email.value.indexOf('@', 0) == -1 || 
         document.order_myform.email.value.indexOf('.', 0) == -1 || 
         document.order_myform.email.value.lastIndexOf("@")==document.order_myform.email.value.length-1 || 
         document.order_myform.email.value.lastIndexOf(".")==document.order_myform.email.value.length-1)
     {
      alert("E-mail spelling error?");
      document.order_myform.email.focus();
      return false;
      }
   }
 else
  {
   alert("Must be Filled?E-mail?");
   document.order_myform.email.focus();
   return false;
   }
   if(document.order_myform.msn.value=="")
	{
		alert("Must be Filled Address?");
		document.order_myform.msn.focus();
		return false;
	}
	if(document.order_myform.city.value=="")
	{
		alert("Must be Filled City?");
		document.order_myform.city.focus();
		return false;
	}
	if(document.order_myform.company.value=="")
	{
		alert("Must be Filled State / Province?");
		document.order_myform.company.focus();
		return false;
	}
	if(document.order_myform.Remark.value=="")
	{
		alert("Must be Filled Zip/Postal Code?");
		document.order_myform.Remark.focus();
		return false;
	}	
	if(document.order_myform.tel.value=="")
	{
		alert("Must be Filled Phone?");
		document.order_myform.tel.focus();
		return false;
	}
	if(document.order_myform.country.value=="")
	{
		alert("Must be Filled Country?");
		document.order_myform.country.focus();
		return false;
	}
}



function chkemail()
{
  if(document.sendmail.email.value.length!=0)
  {
    if (document.sendmail.email.value.charAt(0)=="." ||        
         document.sendmail.email.value.charAt(0)=="@"||       
         document.sendmail.email.value.indexOf('@', 0) == -1 || 
         document.sendmail.email.value.indexOf('.', 0) == -1 || 
         document.sendmail.email.value.lastIndexOf("@")==document.sendmail.email.value.length-1 || 
         document.sendmail.email.value.lastIndexOf(".")==document.sendmail.email.value.length-1)
     {
      alert("Please input a correct e-mail");
      document.sendmail.email.focus();
      return false;
      }
   }
   else
  {
	   alert("Please input the e-mail");
	   document.sendmail.email.focus();
	   return false;
   }
}

function kkform()
{
  if(document.stform.classid.value=="0")
  {
	  document.stform.action="productinfo.asp";
  }
  else
  {
	  document.stform.action="product.asp";
  }
}

function selshipf()
{
  if(document.selship.ship.value.length==0)
  {
	  alert("Please select the payment method");
	  return false;
  }
  else
    return true;
}
//-->

<!--
if(self!=top){top.location=self.location; 
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->

<!-- ËÑË÷ÏÂÀ­
//$=function(id){ 
//return document.getElementById(id); 
//} 
var flag=false; 
function shlist(){ 
document.getElementById("selectList").style.display=document.getElementById("selectList").style.display=="block"?"none":"block"; 
} 
function changesever(ts){ 
document.getElementById("selectTop").innerHTML="---"+ts.innerHTML+"---"; 
shlist(); 
} 
function setFlag(val){ 
flag=val; 
} 
function hideList(){ 
if(!flag)document.getElementById("selectList").style.display="none"; 
} 
setCss=function(p){ 
p.style.cursor='hand'; 
p.style.backgroundColor='#eeeeee'; 
} 
removeCss=function(p){ 
p.style.backgroundColor='white'; 
} 
//-->

function openbigpic(astr)
{
	document.getElementById("linkastr").href=astr;
}