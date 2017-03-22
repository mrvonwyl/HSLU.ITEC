(function($) {
	$.widget("tharsis.messenger", {

		options : {
			effectSpeed: 400,
			showDuration: 10000,
			autoHide: true,
			refreshed: function(event, data){}
		},

		_create : function() {
			this.element.addClass('trs-messenger');
			this.add('', 'Messenger successfully initialized!', '');
		},

		_setOption : function(key, value) {
			if(key === 'effectSpeed'){
				effectSpeed = value;
			}
			
			if(key === 'showDuration'){
				showDuration = value;
			}
			
			if(key === 'autoHide'){
				autoHide = value;
			} 
			
			this._super(key, value);
		},
		
		_setOptions: function(options){
			 this._super(options);
		},
		
		_destroy : function() {
			this.element
				.css('background', 'blue');
		},
		
		add: function(type, title, content){
			var	speed = this.options.effectSpeed,
				iconClass = 'fa-info-circle';
							
			if(type == 'error'){
				iconClass = 'fa-warning';
			}
			else if(type == 'success'){
				iconClass = 'fa-check-circle';
			}
						
			var message = $('<div/>', {class: 'message ' + type, style: '' }),
				header = $('<span/>', {class: 'header'}),
				icon = $('<i/>', {class: 'icon fa ' + iconClass}),
				titleBar = $('<span/>', {class: 'title'}).html(title),
				detailer = content.length > 0 ? $('<i/>', {class: 'detailer fa fa-caret-right'}) : '',
				closer = $('<i/>', {class: 'closer fa fa-close'}),
				body = $('<span/>', {class: 'content'}).html(content);
	
			if(detailer != ''){
				detailer.click(function(){
					if(body.is(':hidden')){
						$(this).switchClass('fa-caret-right', 'fa-caret-down', 0);
					}
					else {
						$(this).switchClass('fa-caret-down', 'fa-caret-right', 0);
					}
					
					body.toggle();
				});
			}
			
			closer.click(function(){
				message.remove();
			});
			
			header.append(icon).append(titleBar).append(closer).append(detailer);
			message.append(header).append(body);
	
			if(this.options.autoHide){
				setTimeout(function(){
					message.remove();
				}, this.options.showDuration);
			}
			
			//this.element.append(message.fadeIn(speed));
			this.element.append(message);
		},
		
		rem: function(message){
			message.fadeTo(this.options.effectSpeed, 0.001).slideUp(this.options.effectSpeed, function(){ $(this).remove(); });
		},
		
		refresh: function(){			
			//this._trigger('refreshed', null, {color: this.options.color});
		}
	});
}(jQuery));