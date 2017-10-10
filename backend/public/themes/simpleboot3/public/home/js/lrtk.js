// 懒人图库 搜集整理 www.lanrentuku.com

window.onload=function()
{
	var oDiv=document.getElementById('box');
	mouseScroll(oDiv);
};

function mouseScroll(obj)
{
	if(!obj) return false;
	var oSpan=document.getElementsByTagName('h1')[0].getElementsByTagName('span')[0]; //关闭首页文字提示，请注释此行
	var oUl=obj.getElementsByTagName('ul')[0];
	var aLi=oUl.getElementsByTagName('li');
	var iLiWidth=[];
	var iUlResult=0;
	var iCurr=0;
	var iPicTarget=0;
	var iSummation=0;
	var iNow=1;
	var iCountTime=null;
	var autoTime=null;

	for(var i=0; i<aLi.length; i++){ iLiWidth.push(aLi[i].offsetWidth);	}
	iSummation=sumFn(iLiWidth);

	for(var i=0; i<iLiWidth.length; i++){ iUlResult+=iLiWidth[i]; }
	oUl.style.width=iUlResult+'px';

	function autoStyle()
	{
		obj.style.width=aLi[iCurr].offsetWidth+'px';
		obj.style.left=(document.documentElement.clientWidth-obj.offsetWidth)/2+'px';
	}
	autoStyle();
	window.onresize=function(){ autoStyle(); };

	var oP=document.createElement('p');
	for(var i=0; i<aLi.length; i++)
	{
		var oA=document.createElement('a');
		oA.href='http://www.lanrentuku.com/';
		oA.target='_blank';
		oA.innerHTML=i+1;
		oP.appendChild(oA);
	}
	oP.getElementsByTagName('a')[0].className='active';
	obj.appendChild(oP);

	for(var i=0,aA=obj.getElementsByTagName('p')[0].getElementsByTagName('a'); i<aA.length; i++)
	{
		aA[i].index=i;
		aA[i].onmouseover=function()
		{
			clearInterval(autoTime);
			iCurr=this.index;
			picScroll();
		};
		aA[i].onmouseout=function(){
			countTime();
		};
	}

	addScrollEvent(document, [mouseDown, mouseUp]);

	function mouseDown()
	{
		clearInterval(autoTime);
		countTime();
		iCurr++;
		picScroll();
	}
	function mouseUp()
	{
		clearInterval(autoTime);
		countTime();
		iCurr--;
		picScroll();
	}

	document.onkeydown=function(ev)
	{
		clearInterval(autoTime);
		countTime();
		
		ev=ev||window.event;
		if(ev.keyCode==37)
		{
			iCurr--;
		}
		if(ev.keyCode==39)
		{
			iCurr++;
		}
		picScroll();
	}

	function picScroll()
	{
		if(iCurr==aLi.length)
		{
			iCurr=aLi.length-1;
		}
		if(iCurr<0)
		{
			iCurr=0;
		}
		
		for(var i=0; i<aLi.length; i++)
		{
			oP.getElementsByTagName('a')[i].className='';
		}
		oP.getElementsByTagName('a')[iCurr].className='active';
		oSpan.innerHTML='当前图片是第'+(iCurr+1)+'张'; //关闭首页文字提示，请注释此行

		var tmpArr=[];
		for(var i=0; i<iCurr; i++)
		{
			tmpArr.push(iLiWidth[i]);
		}
		iPicTarget=sumFn(tmpArr);
		
		startMove(oUl,{left:-iPicTarget});
		startMove(obj,{width:aLi[iCurr].offsetWidth});
	}

	function autoPlay()
	{
		clearInterval(autoTime);
		autoTime=setInterval(function(){
			if(iCurr==aLi.length-1)
			{
				iNow=-1;
			}
			if(iCurr==0)
			{
				iNow=1;
			}
			iCurr+=iNow;
			oSpan.innerHTML='当前图片是第'+(iCurr+1)+'张'; //关闭首页文字提示，请注释此行
			picScroll();
		}, 4000); //间隔时间
	}
	autoPlay();

	function countTime()
	{
		var iNum=5; //自动播放倒计时时间
		clearTimeout(iCountTime);
		iCountTime=setInterval(function(){
			if(iNum==0)
			{
				oSpan.innerHTML='第0秒后自动播放'; //关闭首页文字提示，请注释此行
				clearInterval(iCountTime);
				autoPlay();
			}
			else
			{
				iNum--;
				oSpan.innerHTML='第'+(iNum+1)+'秒后自动播放'; //关闭首页文字提示，请注释此行
			}
		}, 1000);
	}
}

function sumFn(arr)
{
	var result=0;
	for(var i=0; i<arr.length; i++)
	{
		result+=arr[i];
	}
	return result;
}

function addScrollEvent()
{
	var obj=arguments[0];
	var functionSet=arguments[1];
	function scrollEvent(ev)
	{
		var oEvent=ev||event;
		var down=false;
		if(oEvent.wheelDelta){/*ie*/ down=oEvent.wheelDelta<0?true:false; }else{ down=oEvent.detail<0?false:true; }
		if(down){ functionSet[0]();	}else{ functionSet[1](); }
		if(oEvent.preventDefault){ oEvent.preventDefault();}
		return false;
	}
	if(obj.addEventListener){ obj.addEventListener('DOMMouseScroll', scrollEvent, false); }
	obj.onmousewheel=scrollEvent;
}

function startMove(obj, json, fnEnd)
{
	if(obj.timer)
	{
		clearInterval(obj.timer);
	}
	obj.timer=setInterval(function (){
		doMove(obj, json, fnEnd);

		document.getElementById('box').style.left=(document.documentElement.clientWidth-document.getElementById('box').offsetWidth)/2+'px';
		
	}, 30);
}

function getStyle(obj, attr)
{
	if(obj.currentStyle)
	{
		return obj.currentStyle[attr];
	}
	else
	{
		return getComputedStyle(obj, false)[attr];
	}
}

function doMove(obj, json, fnEnd)
{
	var iCur=0;
	var attr='';
	var bStop=true;	//假设运动已经该停止了
	
	for(attr in json)
	{
		if(attr=='opacity')
		{
			iCur=parseInt(100*parseFloat(getStyle(obj, 'opacity')));
		}
		else
		{
			iCur=parseInt(getStyle(obj, attr));
		}
		
		if(isNaN(iCur))
		{
			iCur=0;
		}
		
		var iSpeed=(json[attr]-iCur)/6;
		iSpeed=iSpeed>0?Math.ceil(iSpeed):Math.floor(iSpeed);
		
		if(json[attr]!=iCur)
		{
			bStop=false;
		}
		
		if(attr=='opacity')
		{
			obj.style.filter="alpha(opacity:"+(iCur+iSpeed)+")";
			obj.style.opacity=(iCur+iSpeed)/100;
		}
		else
		{
			obj.style[attr]=iCur+iSpeed+'px';
		}
	}
	
	if(bStop)
	{
		clearInterval(obj.timer);
		obj.timer=null;
		
		if(fnEnd)
		{
			fnEnd();
		}
	}
}