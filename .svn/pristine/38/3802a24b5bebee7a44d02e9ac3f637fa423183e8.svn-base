(function($) {
	$.widget("tharsis.loading", {

		options : {
			//TODO: Angles have to be in 30 degree intervals
			angles: [0, 30, 60, 90, 120],
			animSpeed: 180,
			animAngle: 5,
			animType: 'c', //c: circle, s: straight
			color: '#0074A2',
			cvsWidth: 30,
			cvsHeight: 30,
			duration: null,
			imgSize: 30,
			permanent: false
		},
		
		helpers : {
			next: [null, null],
			interval: null,
			image: $('<img/>', {src: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAYAAAA5ZDbSAAAA2klEQVR4nO3ZQQqDMBAF0H8cj9a1+97Jk3gGD6K0mwhd2dqAbfQ9GATJYuCTRJMEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACo1CXpkwxJpiRzeQ7lfferxqh3SzImeWzUWMbRmHuSJdvhrrWU8TTils/DfQ3ZTG5Al/fL8tZybU/+c32+C3et/viW2WNIXcDD8S2zx5S6gKejG2afOXUBz8e3zB5TzOBTswefnK/ok/MffAFOsi7AWfQFuE26APfBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAANOEJhHXhFKTf5RgAAAAASUVORK5CYII='})[0],
			cvs: $('<canvas/>'),
			initCycles: 1,
			layersToInit: [],
			startAnim: true,
			stopAnim: false
		},

		start: function(){
			var $this = this;
			if($this.helpers.interval == null){
				$this.helpers.startAnim = true;
				$this.helpers.stopAnim = false;
				$this.helpers.interval = $this._setIntervalWithContext(function(){ $this._rotate(); }, $this.options.animSpeed, $this);
			}
        },
		
		stop: function(){
			var $this = this;
			$this.helpers.stopAnim = true;
		},
		
		_rotate: function(){
			var $this = this;
			
			//loop through each layer an animate slow or fast according to NEXT array
			$.each($this.helpers.cvs.getLayers(), function(index){
				var layer = $this.helpers.cvs.getLayer(index);
					animate1 = (layer.index == $this.helpers.next[0]),
					animate2 = (layer.index == $this.helpers.next[1] && $this.options.angles.length > 2),
					animate3 = (layer.index == $this.helpers.next[2] && $this.options.angles.length > 3);
				
				//fade layers in one after another
				if(animate1 && $this.helpers.startAnim && $this.helpers.layersToInit[0] == layer.index){
					//console.log('init: ' + layer.index);
					$this.helpers.layersToInit.shift();
					layer.opacity2 = 1;
				}
				//fade layers out one after another
				else if(animate1 && !$this.helpers.startAnim && $this.helpers.layersToInit.indexOf(layer.index) == -1){
					//console.log('uninit: ' + layer.index);
					$this.helpers.layersToInit.push(layer.index);
					layer.opacity2 = 0;
				}
				
				//calculate fast, so that no bullets overlap
				var i = ($this.options.angles.length <= 2) ? 1 : ($this.options.angles.length <= 3) ? 2 : 3,
					slow = $this.options.animAngle,
					fast = (360 - $this.options.angles.length * 30 + slow * i) / i;
	
				layer.rotate2 += (animate1 || animate2 || animate3) ? fast : slow;
				
				//animation Object
				var animateObject = {
					rotate: layer.rotate2,
					opacity: layer.opacity2
				};
	
				//animate layer
				$this.helpers.cvs.animateLayer(layer, animateObject, $this.options.animSpeed, 'linear');
			});
			
			//shift NEXT array
			$this._setNext();
			
			//set start to false if stop is true
			if($this.helpers.stopAnim){
				$this.helpers.startAnim = false;
			}
			
			//clear interval, as soon as all items are faded out
			if($this.helpers.layersToInit.length == $this.options.angles.length && !$this.helpers.startAnim && $this.helpers.interval != null){
				clearInterval($this.helpers.interval);
				$this.helpers.interval = null;
			}
		},
		
		_setNext: function(){
			var $this = this;
			var a = $this.helpers.next.shift();
			
			if($this.options.permanent){
				if(a != null){
					$this.helpers.next.push(a);
				}
			}
			else{
				$this.helpers.next.push(a);
			}
		},
		
		_create : function() {
			var $this = this;
			
			//add canvas to dom object and set dimensions
			//$this.element.css('display', 'inline-block');
			$this.element.append($this.helpers.cvs);
			$this.helpers.cvs.attr('width', $this.options.cvsWidth + 'px').attr('height', $this.options.cvsHeight + 'px');

			//transform sourceimage (120x120) to the size and color needed
			var source = transformImage($this.helpers.image, {w: 120, h: 120}, $this.options.color, $this.options.imgSize, 1, 'loading');
			
			//sort angles, so the highest angle is at first position
			$this.options.angles = $this.options.angles.sort(function(a, b){ return b-a; /*b-a: numeric desc, a-b numeric asc*/});
			
			//for each angle draw the sourceimage and and the rotate2 to the canvas layers
			$.each($this.options.angles, function(index, angle){
				$this.helpers.cvs.drawImage({
					layer: true,
					source: source,
					x: $this.options.cvsWidth * 0.5,
					y: $this.options.cvsHeight * 0.5,
					width: $this.options.imgSize,
					height: $this.options.imgSize,
					rotate: angle,
					opacity: 0
				});
				
				$this.helpers.layersToInit.push(index);
				
				var layer = $this.helpers.cvs.getLayer(index);
				layer.rotate2 = layer.rotate;
				layer.opacity2 = layer.opacity;
			});
			
			//and an index in the next array for every angle defined
			for(var i = 0; i < $this.options.angles.length; i++){
				$this.helpers.next.push(i);
			}
			
			//adds two nulls to the next array for each angle (except one: first two nulls for init) -> needed for unpermanent animation
			if(!$this.options.permanent){
				for(var j = 0; j < $this.options.angles.length * 2 - 4; j++){
					$this.helpers.next.push(null);
				}			
			}

			//start animation
			$this.start();
			
			//if duration is stated stop animation after duration
			if($this.options.duration != null){
				$this._setTimeoutWithContext(function(){ $this.stop(); }, $this.options.duration, $this);
			}
		},
		
		_destroy : function() {
			var $this = this;
			$this.stop();
			$this.helpers.cvs.remove();
		},

		_setIntervalWithContext: function(code, delay, context) {
            return setInterval(function () {
                code.call(context);
            }, delay);
        },
        
        _setTimeoutWithContext: function(code, delay, context) {
            return setTimeout(function () {
                code.call(context);
            }, delay);
        },
		
		_setOption : function(key, value) {
			if(key === 'angles'){ angles = value; }
			
			if(key === 'animSpeed'){ animSpeed = value; }
			
			if(key === 'animAngle'){ animAngle = value; }
			
			if(key === 'cvsWidth'){ cvsWidth = value; }
			
			if(key === 'cvsHeight'){ cvsHeight = value; }
			
			if(key === 'color'){ color = value; }
			
			if(key === 'permanent'){ permanent = value; }
			
			this._super(key, value);
		},
		
		_setOptions: function(options){
			 this._super(options);
		}
	});
}(jQuery));