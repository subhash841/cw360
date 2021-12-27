<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <title></title>
</head>

<body>
    
    <div>
        <form name="deletUserForm" id="deletUserForm" method="POST" autocomplete="off" enctype="multipart/form-data">
			<div class="form-group m-5">
			  <p class="text-center"><b>ENTER EMAILS</b></p>
			  <textarea class="form-control" rows="3" cols="50" id="emails" name="emails" placeholder="Note: Multiple Email IDs should be separated by commas"></textarea>
			</div>
			<div class="m-5 text-center">
			  	<button type="submit" class="btn btn-primary">DELETE</button>
			</div>
		</form>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script>
	    $("form#deletUserForm").on("submit", function(e) {
	        e.preventDefault();
	        if ($('#emails').val()=='') {
	        	swal('Email field cannot be empty', '');
	        }else{
		        var formdata = $('#deletUserForm').serialize();
		        $.ajax({
		            url: 'https://test.crowdwisdom360.com/Delete_users/deleteUser',
		            data: formdata,
		            type: 'POST',
		            dataType: 'JSON',
		            success: function(res, textStatus, jqXHR) {
		                if (res.status==true) {
		                	swal(res.message, '' , "success")
		                	$('#deletUserForm').trigger("reset");
		                }else{
		                	if (res.type = 'warning'){
		                		swal(res.message, '', "warning")
		                	}else if(res.type = 'error'){
		                		swal(res.message, '', "error")
		                	}else{
		                		location.reload();
		                	}
		                }
		            },
		            error: function(jqXHR, textStatus, errorThrown) {}
		        })
	        }
	    })
	</script>
</body>

</html>