
function QrColorPicker(_defaultColor){
    if(!_defaultColor) _defaultColor = "";
    QrXPCOM.init();
    this.id = QrColorPicker.lastid++;
    this.defaultColor = _defaultColor;
	QrColorPicker.DefaultColor = "";
    QrColorPicker.instanceMap["QrColorPicker"+this.id] = this;
	this.path = "static/qrx/";
}
//QrColorPicker.SetDefaultColor('QrColorPicker0','#0E6DBC');

QrColorPicker.prototype.getHTML = function(id,obj){
    var html = ""
	html+="<SPAN class=\"QrComponent\" id=\"$pickerId\" onclick=\"javascript:void(QrColorPicker.popupPicker('$pickerId'));\"><img src=\""+this.path+"transparentpixel.gif\" width=\"1\" height=\"1\" align=\"absmiddle\" id=\"$pickerId#color\" style=\"width:40px;height:20px;border:1px inset gray;background-color:\$defaultColor;cursor:pointer;\"/>\n<A href=\"javascript:void('QrColorPicker$pickerId');\" ><SPAN id=\"$pickerId#text\" style=\"color:$defaultColor\">$defaultColor</SPAN></A></SPAN> &nbsp; "
	
	
	
	
	
	
	html+="<DIV style=\"display:none; position:absolute; border:solid 1px gray;background-color:white;z-index:2;\" id=\"$pickerId#menu\"\n onmouseout=\"javascript:QrColorPicker.restoreColor('$pickerId');\" onclick=\"javascript:QrXPCOM.onPopup();\">"
	
	html+= "<table border=\"0\" width=\"192\"><tr>"
	
	html+="<td><img src=\""+this.path+"transparentpixel.gif\" width=\"1\" height=\"1\" align=\"absmiddle\" onclick=\"javascript:QrColorPicker.setCustomColor('$pickerId', '')\"  style=\"width:14px;height:14px;border:1px inset gray;cursor:pointer;\"/></td>"
	
	html+="<td><img src=\""+this.path+"transparentpixel.gif\" width=\"1\" height=\"1\" align=\"absmiddle\" onclick=\"javascript:QrColorPicker.setCustomColor('$pickerId', '#FF0000')\"  style=\"width:14px;height:14px;border:1px inset gray;background-color:\#ff0000;cursor:pointer;\"/></td>"
	
	html+="<td><img src=\""+this.path+"transparentpixel.gif\" width=\"1\" height=\"1\" align=\"absmiddle\" onclick=\"javascript:QrColorPicker.setCustomColor('$pickerId', '#008000')\"  style=\"width:14px;height:14px;border:1px inset gray;background-color:\#008000;cursor:pointer;\"/></td>"
	
	html+="<td><img src=\""+this.path+"transparentpixel.gif\" width=\"1\" height=\"1\" align=\"absmiddle\" onclick=\"javascript:QrColorPicker.setCustomColor('$pickerId', '#0000FF')\"  style=\"width:14px;height:14px;border:1px inset gray;background-color:\#0000FF;cursor:pointer;\"/></td>"

	html+="</tr></table>"
	
	
	
	html+="\n\n<NOBR><IMG SRC=\""+this.path+"colorpicker.jpg\" NATURALSIZEFLAG=\"3\" BORDER=\"0\" \nonMouseMove=\"javascript:QrColorPicker.setColor(event,'$pickerId');\" onClick=\"javascript:QrColorPicker.selectColor(event,'$pickerId');\" style=\"cursor:crosshair\" WIDTH=\"192\" HEIGHT=\"128\" ALIGN=\"BOTTOM\"></NOBR><BR><NOBR><IMG SRC=\""+this.path+"graybar.jpg\" NATURALSIZEFLAG=\"3\" BORDER=\"0\" \nonMouseMove=\"javascript:QrColorPicker.setColor(event,'$pickerId');\"\nonClick=\"javascript:QrColorPicker.selectColor(event,'$pickerId');\" style=\"cursor:crosshair\"\nWIDTH=\"192\" HEIGHT=\"8\" ALIGN=\"BOTTOM\"></NOBR><BR>\n<NOBR><input type=\"text\" size=\"8\" id=\"$pickerId#input\" style=\"border:solid 1px gray;font-size:12pt;margin:1px;\" onkeyup=\"QrColorPicker.keyColor('$pickerId')\" value=\"$defaultColor\" onChange='QrColorPicker.InputValueChange(this);' /><a href=\"javascript:QrColorPicker.SetDefaultColor('$pickerId','"+QrColorPicker.DefaultColor+"');\"><img src=\""+this.path+"grid.gif\" style=\"height:20px; width:20px;\" align=\"absmiddle\" border=\"0\">»Ö¸´Ä¬ÈÏ</a></NOBR></DIV>";
	
	if(id){
		html = html.replace(/\$pickerId/g,"QrColorPicker"+id);
		var defaultColor = this.defaultColor;
		if(!QrColorPicker.instanceMap["QrColorPicker"+id]){
			QrColorPicker.instanceMap["QrColorPicker"+id] = this;
		}
		if(obj){
			if(obj.onChange){
				QrColorPicker.instanceMap["QrColorPicker"+id].onChange = obj.onChange;
			}
			//if(obj.defaultColor){
				//defaultColor = obj.defaultColor
			//}
		}
		return html.replace(/\$defaultColor/g,defaultColor);
	}
	else{
    	return html.replace(/\$pickerId/g,"QrColorPicker"+this.id).replace(/\$defaultColor/g,this.defaultColor);
	}
	
}

QrColorPicker.setCustomColor = function(id, color){
	QrColorPicker.activeId=id;
	QrColorPicker.instanceMap[id].set(color);
}

QrColorPicker.GetActiveId = function(){
	return QrColorPicker.activeId.replace(/QrColorPicker/,'');
}

QrColorPicker.prototype.render = function(){
    document.write(this.getHTML());
}

QrColorPicker.prototype.set = function(color){
    if(QrColorPicker.instanceMap[QrColorPicker.activeId].onChange){
        QrColorPicker.instanceMap[QrColorPicker.activeId].onChange(color);
    }
    if(color == "") color = "";
    document.getElementById(QrColorPicker.activeId+"#input").value = color;
    document.getElementById(QrColorPicker.activeId+"#text").innerHTML = color;
    document.getElementById(QrColorPicker.activeId+"#color").style.background = color;
}

QrColorPicker.prototype.get = function(){
    return document.getElementById(QrColorPicker.activeId+"#input").value;
}

QrColorPicker.lastid = 0;

QrColorPicker.instanceMap = new Array;
QrColorPicker.restorePool = new Array;

QrColorPicker.transparent= function(id){
    QrColorPicker.instanceMap[id].set("transparent");
    document.getElementById(id+"#menu").style.display = "none";
    if(QrColorPicker.instanceMap[id].onChange){
        QrColorPicker.instanceMap[id].onChange("transparent");
    }
}

QrColorPicker.SetDefaultColor = function(id,color){
	QrColorPicker.instanceMap[id].set(color);
    document.getElementById(id+"#menu").style.display = "none";
    if(QrColorPicker.instanceMap[id].onChange){
		color = '';
        QrColorPicker.instanceMap[id].onChange(color);
    }
}



QrColorPicker.popupPicker= function(id){
	QrColorPicker.activeId = id;
    var pop = document.getElementById(id);
    var p = QrXPCOM.getDivPoint(pop);
    QrXPCOM.setDivPoint(document.getElementById(id+"#menu"), p.x, p.y+ 20);

    document.getElementById(id+"#menu").style.display = "";
    QrXPCOM.onPopup(document.getElementById(id+"#menu"));
}

QrColorPicker.InputValueChange = function(ele){
	try{
		
	}catch(e){}
}

QrColorPicker.keyColor = function(id){
    try{
        document.getElementById(id+"#color").style.background = document.getElementById(id+"#input").value;
        QrColorPicker.restorePool[id] = document.getElementById(id+"#input").value;
        document.getElementById(id+"#text").innerHTML = QrColorPicker.restorePool[id];
    }catch(e){}
};


QrColorPicker.selectColor = function(event,id){
    var picked = QrColorPicker.setColor(event,id);

    document.getElementById(id+"#menu").style.display = "none";
    QrColorPicker.restorePool[id] = picked;
    if(QrColorPicker.instanceMap[id].onSelect){
    	if(picked == '#0E6DBC'){
    		picked = '';
    	}
        QrColorPicker.instanceMap[id].onSelect(picked);
    }
};

QrColorPicker.restoreColor = function(id){
    if(QrColorPicker.restorePool[id]){
        document.getElementById(id+"#input").value = QrColorPicker.restorePool[id];
        document.getElementById(id+"#text").innerHTML = QrColorPicker.restorePool[id];
        document.getElementById(id+"#color").style.background = QrColorPicker.restorePool[id];
        if(QrColorPicker.instanceMap[id].onChange){
        	picked = QrColorPicker.restorePool[id];
        	if(picked == '#0E6DBC'){
        		picked = '';
        	}
            QrColorPicker.instanceMap[id].onChange(picked);
        }
        QrColorPicker.restorePool[id] = null;
    }
};

QrColorPicker.setColor = function(event,id){
    if(!QrColorPicker.restorePool[id]) QrColorPicker.restorePool[id] = document.getElementById(id+"#input").value;

    var d = QrXPCOM.getMousePoint(event,document.getElementById(id+"#menu"));
    var picked = QrColorPicker.colorpicker(d.x,d.y).toUpperCase();

    document.getElementById(id+"#input").value = picked;
    document.getElementById(id+"#text").innerHTML = picked;
    document.getElementById(id+"#color").style.background = picked;
    if(QrColorPicker.instanceMap[id].onChange){
    	if(picked == '#0E6DBC'){
    		picked = '';
    	}
        QrColorPicker.instanceMap[id].onChange(picked);
    }
    return picked;
};

QrColorPicker.colorpicker = function(prtX,prtY){
    var colorR = 0;
    var colorG = 0;
    var colorB = 0;

    if(prtX < 32){
        colorR = 256;
        colorG = prtX * 8;
        colorB = 1;
    }
    if(prtX >= 32 && prtX < 64){
        colorR = 256 - (prtX - 32 ) * 8;
        colorG = 256;
        colorB = 1;
    }
    if(prtX >= 64 && prtX < 96){
        colorR = 1;
        colorG = 256;
        colorB = (prtX - 64) * 8;
    }
    if(prtX >= 96 && prtX < 128){
        colorR = 1;
        colorG = 256 - (prtX - 96) * 8;
        colorB = 256;
    }
    if(prtX >= 128 && prtX < 160){
        colorR = (prtX - 128) * 8;
        colorG = 1;
        colorB = 256;
    }
    if(prtX >= 160){
        colorR = 256;
        colorG = 1;
        colorB = 256 - (prtX - 160) * 8;
    }

    if(prtY < 64){
        colorR = colorR + (256 - colorR) * (64 - prtY) / 64;
        colorG = colorG + (256 - colorG) * (64 - prtY) / 64;
        colorB = colorB + (256 - colorB) * (64 - prtY) / 64;
    }
    if(prtY > 64 && prtY <= 128){
        colorR = colorR - colorR * (prtY - 64) / 64;
        colorG = colorG - colorG * (prtY - 64) / 64;
        colorB = colorB - colorB * (prtY - 64) / 64;
    }
    if(prtY > 128){
        colorR = 256 - ( prtX / 192 * 256 );
        colorG = 256 - ( prtX / 192 * 256 );
        colorB = 256 - ( prtX / 192 * 256 );
    }

    colorR = parseInt(colorR);
    colorG = parseInt(colorG);
    colorB = parseInt(colorB);

    if(colorR >= 256){
        colorR = 255;
    }
    if(colorG >= 256){
        colorG = 255;
    }
    if(colorB >= 256){
        colorB = 255;
    }

    colorR = colorR.toString(16);
    colorG = colorG.toString(16);
    colorB = colorB.toString(16);

    if(colorR.length < 2){
    colorR = 0 + colorR;
    }
    if(colorG.length < 2){
    colorG = 0 + colorG;
    }
    if(colorB.length < 2){
    colorB = 0 + colorB;
    }

    return "#" + colorR + colorG + colorB;
}