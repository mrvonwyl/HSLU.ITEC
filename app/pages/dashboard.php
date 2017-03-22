<div>
	<article class="grid4">
		<div>
			<h1>Heading 1</h1>
			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
			<h2>Heading 2</h2>
			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
			<h3>Heading 3</h3>
			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
			<h4>Heading 4</h4>
			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
			<h5>Heading 5</h5>
			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
			<h6>Heading 6</h6>
			<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
		</div>
	</article>
	
	<article class="grid8">
		<article class="grid4">
			<div>
				<h1>Forms</h1>
				<p>
					<form>
						<input placeholder="Placeholder" type="text">
						<br/>
						<select>
							<option>A</option>
							<option>B</option>
							<option>C</option>
						</select>
						<br/>
						<textarea placeholder="Placeholder"></textarea>
					</form>
				</p>
			</div>
        </article>
		<article class="grid4">
			<div class="noBg">
				<h1>No Background</h1>
				<p>
					Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
				</p>
			</div>
		</article>
        <article class="grid4">
			<div>
				<h1>Style Switcher</h1>
				<p>
					<div class="theme1">Theme 1</div>
					<div class="theme2">Theme 2</div>
                    
                    <script>
						$(function(){
							$('.theme1').button().click(function(){
								console.log('theme1');
								$('link[href="/styles/style_alt.css"]').attr('href', '/styles/style.css');
								$.cookie('style', 'style', {expires : 10, path: '/'});
							});
						
							$('.theme2').button().click(function(){
								console.log('theme2');
								$('link[href="/styles/style.css"]').attr('href', '/styles/style_alt.css');
								$.cookie('style', 'style_alt', {expires : 10, path: '/'});
							});
						});
					</script>
				</p>
			</div>
		</article>
		
		<article class="grid4">
			<div>
				<h1>Loading</h1>
				<p>
					<div class="startLoading"><i class="fa fa-play"></i>Start</div>
					<div class="stopLoading"><i class="fa fa-stop"></i>Stop</div>
					<div class="loading"></div>
					
					<script>
						$(function(){
							$('.loading').loading({});
						
							$('.startLoading').button().click(function(){
								$('.loading').loading('start');
							});
						
							$('.stopLoading').button().click(function(){
								$('.loading').loading('stop');
							});
						});				
					</script>
				</p>
			</div>
		</article>
		
		<article class="grid4">
			<div>
				<h1>Messenger</h1>
				<p>
	            	<div class="addErrMsg">Add Red</div>
	                <div class="addSucMsg">Add Green</div>
	                
					<script>
						$(function(){
							$('.addErrMsg').button().click(function(){
								$('#messenger').messenger('add', 'error', 'Test Message 1', 'Error: eine sehr lange lange nachricht, um zu testen, wie lange nachrichten ausehen!');
							});
							
							$('.addSucMsg').button().click(function(){
								$('#messenger').messenger('add', 'success', 'Test Message 2 long title test blaaa dl', 'Success: eine noch seehr viel längere nachricht, die wirklich wirklich lang ist, und die zeigen soll, wie gut es aussieht, bei wirklich viel text!');
							});
						});
					</script>
				</p>
			</div>
		</article>
	</article>
</div>