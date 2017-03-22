<article class="grid12">
	<div>
    	<h1>Forms &amp; Ajax</h1>
        <p>
            <form>
            	<table>
                	<tr>
                    	<td><input class="medium" placeholder="Manufacturer" type="text"></td>
                		<td><input class="medium" placeholder="Model" type="text"></td>
                        <td><input class="medium" placeholder="Price" type="text"></td>
                    </tr>
                </table>
            </form>
        </p>
        <p>
        	<table id="tblProduct">
        		<thead>
	                <tr>
	                	<th>ID</th>
	                    <th>Manufacturer</th>
	                    <th>Model</th>
	                    <th>Price</th>
	                </tr>
	            </thead>
            </table>
            
            <script>
            	$(function(){
					$('#tblProduct').DataTable({
						pagingType: 'full_numbers',
						dom: 'rt<"controls"ipl>',
						processing: true,
						serverSide: true,
	        			ajax: '/ajax/sspProducts.php',
	        			lengthMenu: [[2, -1], [2, "All"]],
	        			fnDrawCallback: function(){
	        				$('.paginate_button').button();
	        			}
					});
            	});

            	
			</script>
        </p>
    </div>
</article>