 
window.onerror=function(){return true;} 
function $_wfah(id){return document.getElementById(id);}
function getHeight(){$_wfah("wffahuo").style.height=$_wfah("wfforml").offsetHeight-100+"px";}
window.onload=function(){getHeight();}
//////////////////////////// WFORDERJSFGX ////////////////////////////
function wfpostcheck(){
	var ifmun=/^[1-9]+[0-9]*]*$/;
	var ifname=/^[\u4e00-\u9fa5]{2,6}$/;
	var ifidcard=/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
	var ifmob=/^1[3,4,5,7,8]\d{9}$/;
	var ifmobcode=/^\d{6}$/;
	var ifqq=/^\d{5,15}$/;
	var ifemail=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	try{
		var flag1=0;
		var radio1=document.getElementsByName("wfproduct");		
		for(var i=0;i<radio1.length;i++){
			if(radio1.item(i).checked==true){
				flag1=1;
				break;
			}
		}
		if(!flag1&&radio1.item(0).getAttribute("type")=="radio"){
			alert('请选择您要订购的产品！');
			return false;
		}
    }catch(ex){}
	try{		
		var cbxs=document.getElementsByName("wfproduct[]");
		var flag2=0;
		for(var i=0;i<cbxs.length;i++){
			if(cbxs[i].checked){
				flag2+=1;
			}
		}
		if(flag2<1&&cbxs[0].getAttribute("type")=='checkbox'){
			alert('请选择您要订购的产品！');
			return false;
		}
	}catch(ex){}	
	try{
		if(document.wfform.wfproduct.value==""){
			alert('请选择您要订购的产品！');
			document.wfform.wfproduct.focus();
			return false;
		}
    }catch(ex){}	
	try{
		if(document.wfform.wfproductb.value==""){
			alert('请选择产尺码！');
			document.wfform.wfproductb.focus();
			return false;
		}
    }catch(ex){}
	try{
		if(document.wfform.wfproductc.value==""){
			alert('请选择产品颜色！');
			document.wfform.wfproductc.focus();
			return false;
		}
    }catch(ex){}
	try{
		if(!ifmun.test(document.wfform.wfmun.value)){
			alert('订购数量只能填写正整数！');
			document.wfform.wfmun.focus();
			return false;
		}
    }catch(ex){}
	try{
		if(document.wfform.wfname.value==""){
			alert('请填写姓名！');
			document.wfform.wfname.focus();
			return false;
		}
		if(!ifname.test(document.wfform.wfname.value)){
			alert('姓名格式不正确，请重新填写！');
			document.wfform.wfname.focus();
			return false;
		}
    }catch(ex){}
    try{
		if(document.wfform.wfidcard.value==""){
			alert('请填写身份证号！');
			document.wfform.wfidcard.focus();
			return false;
		}
		if(!ifidcard.test(document.wfform.wfidcard.value)){
			alert('身份证号格式不正确，请重新填写！');
			document.wfform.wfidcard.focus();
			return false;
		}
    }catch(ex){}	
    try{
		if(document.wfform.wfmob.value==""){
			alert('请填写手机号码！');
			document.wfform.wfmob.focus();
			return false;
		}
		if(!ifmob.test(document.wfform.wfmob.value)){
			alert('手机号码格式不正确，请重新填写！');
			document.wfform.wfmob.focus();
			return false;
		}
    }catch(ex){}	
    try{
		if(document.wfform.wfmobcode.value==""){
			alert('请填写手机验证码！');
			document.wfform.wfmobcode.focus();
			return false;
		}
		if(!ifmobcode.test(document.wfform.wfmobcode.value)){
			alert('手机验证码格式不正确，请重新填写！');
			document.wfform.wfmobcode.focus();
			return false;
		}
    }catch(ex){}
	try{
		if(document.wfform.wfprovince.value=="省份"||document.wfform.wfcity.value=="城市"){
			alert('请选择所在地区！');
			document.wfform.wfprovince.focus();
			return false;
		}
    }catch(ex){}
    try{
		if(document.wfform.wfaddress.value==""){
			alert('请填写详细地址！');
			document.wfform.wfaddress.focus();
			return false;
		}
    }catch(ex){}
    try{
		if(document.wfform.wfqq.value==""){
			alert('请填写QQ号码！');
			document.wfform.wfqq.focus();
			return false;
		}
		if(!ifqq.test(document.wfform.wfqq.value)){
			alert('QQ号码格式不正确，请重新填写！');
			document.wfform.wfqq.focus();
			return false;
		}
    }catch(ex){}	
    try{
		if(document.wfform.wfweixin.value==""){
			alert('请填写微信号！');
			document.wfform.wfweixin.focus();
			return false;
		}
    }catch(ex){}	
	try{
		if(document.wfform.wfemail.value==""){
			alert('请填写E-MAIL！');
			document.wfform.wfemail.focus();
			return false;
		}
		if(!ifemail.test(document.wfform.wfemail.value)){
			alert('E-MAIL格式不正确，请重新填写！');
			document.wfform.wfemail.focus();
			return false;
		}
    }catch(ex){}
    try{
		if(document.wfform.wfinvcode.value==""){
			alert('请填写邀请码！');
			document.wfform.wfinvcode.focus();
			return false;
		}
    }catch(ex){}
    try{
		if(document.wfform.wfcode.value == ""){
			alert('请填写验证码！');
			document.wfform.wfcode.focus();
			return false;
		}
    }catch(ex){}
    try{		
		var onwfpay = document.getElementsByName("wfpay"); 
		for(var i=0;i<onwfpay.length;i++){
			if(onwfpay[i].checked){
				var wfpay=onwfpay[i].value;
			}else{
				var wfpay=document.wfform.wfpay.value;				
			}
		}
		if(wfpay=="alipay"||wfpay=="alipaywap"||wfpay=="wangyin"||wfpay=="weixin"||wfpay=="scancode"){
			document.wfform.wfsubmit.value="重新提交";
		}
		else{
			document.wfform.wfsubmit.value="正在提交，请稍等 >>";
		}
		return true;
    }catch(ex){}
}
//////////////////////////// WFORDERJSFGX ////////////////////////////
try{
	wfshowarea();
}catch(ex){}
try{
	var thissrc=document.getElementById("wfcode").src;
	function refreshCode(){
		document.getElementById("wfcode").src=thissrc+"&temp="+Math.random(); 
	}
}catch(ex){}
//////////////////////////// WFORDERJSFGX ////////////////////////////
function wftotal(mun,type){
	if(type=='dx'){		
		var wfproduct=document.wfform.wfproduct.alt;	
		for(var i=0;i<document.wfform.wfproduct.length;i++){
			if(document.wfform.wfproduct[i].checked==true){
				var wfproduct=document.wfform.wfproduct[i].alt;
				break;
			}
		}
	}else{
		var wfcpxljg=document.getElementById("wfproduct");
		var wfproduct=wfcpxljg.options[document.getElementById("wfproduct").options.selectedIndex].title;		
	}
    if(mun==1){
		document.wfform.wfmun.value=parseInt(document.wfform.wfmun.value)+1;
	}else if(mun==0){
		var wfmun=parseInt(document.wfform.wfmun.value);
		if(wfmun>1){
			document.wfform.wfmun.value=wfmun-1;			
		}		
	}
	var wfmun=document.wfform.wfmun.value;
	var wfprice=wfproduct*wfmun;	
	document.wfform.wfprice.value=wfprice.toFixed(2);
	document.getElementById("showprice").innerHTML=wfprice.toFixed(2);
}
function wfcheckbox(){
	var wfmun=0;
	var wfprice=0;	
	var obj=document.getElementsByName("wfproduct[]");
    for(var i=0;i<obj.length;i++){
		if(obj[i].checked){
			wfmun++;
			wfprice+=parseInt(obj[i].alt);
		}
	}
	document.wfform.wfmun.value=wfmun;
	document.wfform.wfprice.value=wfprice.toFixed(2);
	document.getElementById("showmun").innerHTML=wfmun;
	document.getElementById('showprice').innerHTML=wfprice.toFixed(2);
}
//////////////////////////// WFORDERJSFGX ////////////////////////////
function wfpaydiv(i){
    var k=6;
	for(var j=0;j<k;j++){
	    if(j==i){
		    document.getElementById("paydiv" + j).style.display="block";
		}
		else{		
		    document.getElementById("paydiv" + j).style.display="none";
		}
	}
}
function wftgp(zk){
	document.getElementById("wfform").target="_parent";
	try{var wfprice=document.wfform.wfprice.value*zk;document.getElementById('showprice').innerHTML=wfprice.toFixed(2);}catch(ex){}
}
function wftgb(zk){
    document.getElementById("wfform").target="_blank";
	try{var wfprice=document.wfform.wfprice.value*zk;document.getElementById('showprice').innerHTML=wfprice.toFixed(2);}catch(ex){}
}
//////////////////////////// WFORDERJSFGX ////////////////////////////
function wfsmscode(obj){
  $.ajax({
	  url:"../wfpublic/wfsmscode.php",
	  type:"post",
	  data:"wfmob="+$("#wfmob").val()+"&wfproname="+$("#wfproname").val(),
	  success:function(msg){
		  if (msg=="ok"){
			  alert("验证码已成功发送到你的手机上，请注意查收。");
			  var count=60;
			  var countdown=setInterval(CountDown,1000);
			  function CountDown(){
				  $("#getcode").attr("disabled",true);
				  $("#getcode").val("等待"+count+"秒后可重新获取");
				  if(count==0){
					  $("#getcode").val("重新获取验证码 >>").removeAttr("disabled");
					  clearInterval(countdown);
				  }
				  count--;
			  }
			  return;
		  }
		  if(msg=="error"){
			  alert("验证码发送失败，请联系管理员。");
			  return;
		  }
		  alert(msg);
	  }
  })
}
//////////////////////////// WFORDERJSFGX ////////////////////////////
function WFDDURL(){
	var WFDDURL=null;
	if(parent!==window){
		WFDDURL=document.referrer;
	}else{
		if(top!==window){
			WFDDURL=top.location.href;
		}else{
			WFDDURL=window.location.href;
		}
	}
	return WFDDURL;
}
document.getElementById("WFDDURL").value=WFDDURL();
document.cookie="WFDDURL="+escape(WFDDURL())+";path=/";
function setCookie(){
	var WFLLURL=window.top.document.referrer;			
    document.cookie="WFLLURL="+escape(WFLLURL)+";path=/";
}
function getCookie(){
    var name="WFLLURL=";
    var ca=document.cookie.split(';');
    for(var i=0;i<ca.length;i++){
        var c=ca[i];
        while(c.charAt(0)==" ")c=c.substring(1);
        if(c.indexOf(name)!=-1)return c.substring(name.length,c.length);
    }
	return "";
}
function checkCookie(){
	var IFWFLLURL=getCookie();
	if(IFWFLLURL==""||IFWFLLURL==null){
		setCookie();
	}
}
function getString(){
	var wfreg=new RegExp("(^|&)id=([^&]*)(&|$)");
	var wfggref=window.top.location.search.substr(1).match(wfreg);
	var i='';if(wfggref!=null)i=wfggref[2];
	document.cookie="wfggref="+i+";path=/";
}
checkCookie();
getString();
//////////////////////////// WFORDERJSEND ////////////////////////////