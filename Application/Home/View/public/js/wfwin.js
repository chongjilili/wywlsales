 
function wfwin(){
	html=document.documentElement;
	var bgObj=document.createElement("div");
	if(document.body.scrollHeight>document.documentElement.clientHeight){
		bg_heght=document.body.scrollHeight+"px";
	}else{
		bg_heght=Math.max(document.body.clientHeight,html.clientHeight)+"px";
	}
	
    document.body.appendChild(bgObj);
	bgObj.setAttribute("id","bgbox");
	bgObj.style.width=html.clientWidth+"px";
	bgObj.style.height=bg_heght;
	document.body.appendChild(bgObj);
	var oShow=document.getElementById('showbank');	
	document.getElementById('showbank').id="oshow";
	oShow.style.display='block';
	box=document.getElementById('oshow');
	boxWidth=oShow.offsetWidth,
    boxHeight=oShow.offsetHeight,
	setPos();
    getPos();
	function oClose(){
		oShow.style.display='none';
		oClosebtn.innerHTML="";
		document.getElementById('oshow').id="showbank";
		document.getElementById('showbank').style.marginLeft='0px';	
		document.getElementById('showbank').style.marginTop='0px';
		document.body.removeChild(bgObj);
	}
	var oClosebtn=document.createElement("span");
	oClosebtn.innerHTML="<input type='button' class='close' value='确 定'>";
	oShow.appendChild(oClosebtn);
	oClosebtn.onclick=oClose;
	bgObj.onclick=oClose;
	changeMsgPrice();
}
        
// 设置位置
function setPos() {
	// 可视窗口
	var htmlWidth=html.clientWidth;
	var htmlHeight=html.clientHeight;
	// margin 值
	var marginX=htmlWidth>boxWidth?-(boxWidth/2):0;
	var marginY=htmlHeight>boxHeight?document.documentElement.scrollTop-(boxHeight/2):0;
	// 可视宽度如果太小，要注意让内容能完整显示出来
	var left=marginX==0?0:'50%';
	var top=marginY==0?0:'120px';
	box.style.left=left;
	box.style.top=top;
	box.style.marginLeft=marginX+'px';
	//box.style.marginTop=marginY+'px';
}

// 找到位置
function getPos(){
	var box=document.getElementById('oshow');
	var curLeft=0,curTop=0,obj=box;
	if(obj.offsetParent){
		while(obj.offsetParent){
			curLeft+=box.offsetLeft;
			curTop+=box.offsetTop;
			obj=obj.offsetParent;
		}
	}
}
//////////////////////////// WFORDERJSEND ////////////////////////////