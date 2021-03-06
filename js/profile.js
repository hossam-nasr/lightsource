$(function(){

	// count up stats when they appear on screen
	$('.data').each(function(){
		$(this).addClass("notScrolled");
	});
	$(window).scroll(function(){
		$('.data.notScrolled').each(function(){
			if (isScrolledIntoView(this)) 
			{
				$(this).removeClass("notScrolled");
				var end = getFloat2($(this));
				var per = parseInt($(this).attr("value"));
				countUp3($(this), 0, end, 5000, per);
			}
		});
	});
	
	// change modal to display two buttons once opened
	$('#edit-dp-button').click(function() {
		var header = "";
		header += '<button type="button" class="close" data-dismiss="modal">&times;</button>';
		header += '<h4 class="modal-title">Edit profile picture</h4>';
		$('#edit-dp-modal-header').html(header);
		
		var content = "";
		content += '<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-cloud-upload"></span> Upload image</button>';
		content += '<button type="button" id="edit-dp-url" class="btn btn-default"><span class="glyphicon glyphicon-link"></span> Use URL</button>';
		$('#edit-dp-modal-body').html(content);
		
		// change modal content when URL button is pressed
		$('#edit-dp-url').click(function() {
			$('#edit-dp-modal-body').fadeOut("fast", function(){
				var content = "";
				content += '<div class="row">';
				content += '<div class="col-md-8 pull-left">';
				content += '<input autofocus id="edit-dp-url-content" class="form-control" name="url" placeholder="URL" type="text" width="100%" />';
				content += '</div>';
				content += '<div class="col-md-4 pull-right">';
				content += '<button type="button" id="edit-dp-url-submit" class="btn btn-success">Submit</button>';
				content += '</div>';
				content += '</div>';
				$(this).html(content);
				$(this).fadeIn("fast");
				
				$('#edit-dp-url-submit').click(function() {
					$('#edit-dp-modal-body').fadeOut("fast", function() {
				
						// extract URL
						var url = $('#edit-dp-url-content').val();
					
						// chech if it's an image or it exceeds the length
						if(!checkURL(url) || url.length > 1000)
						{
							var header = '';
							header += '<button type="button" class="close" data-dismiss="modal">&times;</button>';
							header += '<h2 class="modal-title text-danger">Error</h2>'
							$('#edit-dp-modal-header').html(header);
						
							var body = '';
							body += '<h4 class="text-danger">The URL provided is not a valid image or it exceeds the length limit. Images can only be of extensions jpeg, jpg, gif or png and the URL must be 1000 characters or less.</h4>';
							$('#edit-dp-modal-body').html(body);
						}
					
					
						// success
						else 
						{
							// update database
							query(["UPDATE `users` SET dp = ? WHERE id = ?", url, -1], function(){
							
								// display success
								var header = '';
								header += '<button type="button" class="close" data-dismiss="modal">&times;</button>';
								header += '<h2 class="modal-title text-success">Success</h2>'
								$('#edit-dp-modal-header').html(header);
						
								var body = '';
								body += '<h4 class="text-success">Your profile picture has successfully been updated.</h4>';
								$('#edit-dp-modal-body').html(body);
						
								// update profile picture
								$('#dp').fadeOut("slow", function() {
									$(this).attr("src", url);
									$(this).fadeIn("slow");
								});
							});
						}
					
						$(this).fadeIn("fast");
					});
				});
				
			});
			
		});
	});
	
	
	function checkURL(url) {
    	return(url.match(/\.(jpeg|jpg|gif|png)$/) != null);
	}
	
});
