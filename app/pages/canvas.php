<article class="grid12">
	<div>
    	<h1>Canvas</h1>
        <p>
        	<div class="loading"></div>
        </p>
        <p>
            <div class="startLoading"><i class="fa fa-play"></i>Start</div>
            <div class="stopLoading"><i class="fa fa-stop"></i>Stop</div>
            
            <script>
                $(function(){
					//plugincode in jquery.loading.js
                    $('.loading').loading({
						cvsWidth: 50,
						cvsHeight: 50,
						imgSize: 50
					});
                
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