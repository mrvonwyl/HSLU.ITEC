(function($) {
	$.fn.serializeObject = function()
	{
	    var o = {};
	    var a = this.serializeArray();
	    $.each(a, function() {
	        if (o[this.name] !== undefined) {
	            if (!o[this.name].push) {
	                o[this.name] = [o[this.name]];
	            }
	            o[this.name].push(this.value || '');
	        } else {
	            o[this.name] = this.value || '';
	        }
	    });
	    return o;
	};
})(jQuery);



function transformImage(source, dim, hex, size, hc, prefix){
	var width = dim.w,
		height = dim.h,
		newWidth = size * hc,
		newHeight = newWidth * (height / width),
		stepWidth = (width + newWidth) / 2,
		stepHeight = (height + newHeight) / 2;
	
	//alert(source + ' - ' + hex  + ' - ' + size + ' - ' + hc + ' - ' + prefix);
	
	var canvas = $("<canvas/>")[0],
		ctx = canvas.getContext("2d");
	
	if(size == 0){
		canvas.width = width;
		canvas.height = height;
		
		ctx.drawImage(source, 0, 0, width, height);
	}
	else{
		var canvasStep = $("<canvas/>")[0],
			ctxStep = canvasStep.getContext("2d");
			
		canvasStep.width = stepWidth;
		canvasStep.height = stepHeight;
		
		ctxStep.drawImage(source, 0, 0, stepWidth, stepHeight);
		
		canvas.width = newWidth;
		canvas.height = newHeight;
		
		ctx.drawImage(canvasStep, 0, 0, newWidth, newHeight);
	}

	if(hex != '0'){
		var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height),
			pixels = imageData.data,
			color = hexToRgb(hex);
	
		//Loops through all of the pixels and modifies the components.
		for(var i = 0, n = pixels.length; i < n; i += 4){
	  		pixels[i] = color.r;   // Red component
	  		pixels[i+1] = color.g; // Blue component
	  		pixels[i+2] = color.b; // Green component
	  		//pix[i+3] is the transparency.
		}
		
		ctx.putImageData(imageData, 0, 0);
	}
		
	var result = $("<img/>", {
		class: 'results',
		name: prefix + size + 'x' + size + '_' + hex.substring(1) + '.png'
	})[0];
	result.src = canvas.toDataURL("image/png");
	
	return result;
}

function dataURLtoBlob(dataURL) {
	// Decode the dataURL    
	var binary = atob(dataURL.split(',')[1]);
	// Create 8-bit unsigned array
	var array = [];
	for(var i = 0; i < binary.length; i++) {
	    array.push(binary.charCodeAt(i));
	}
	// Return our Blob object
	return new Blob([new Uint8Array(array)], {type: 'image/png'});
}

function getTextColor(rgb){
	return (0.2126 * rgb.r + 0.7152 * rgb.g + 0.0722 * rgb.b) < 128 ? '#fff' : '#000';
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}