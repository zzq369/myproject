<!--
var flag=false;
function DrawImagee_small(ImgD,Imgwidth,Imgheight){
var image=new Image();
image.src=ImgD.src;
if(image.width>0 && image.height>0){
flag=true;
if(image.width/image.height>= 1){
if(image.width>Imgwidth){ 
ImgD.width=Imgwidth;
ImgD.height=(image.height*Imgwidth)/image.width;
}else{
ImgD.width=image.width; 
ImgD.height=image.height;
}
}
else{
if(image.height>Imgheight){ 
ImgD.height=Imgheight;
ImgD.width=(image.width*Imgheight)/image.height; 
}else{
ImgD.width=image.width; 
ImgD.height=image.height;
}
}
}
} 
//-->