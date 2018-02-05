<div class="container">
	<h2>Registro de Foto Usuario</h2>
	 
	<form>
		  <div class="form-group">
			<label for="exampleInputFile">Subir archivo</label>
				<center><input type="file"  id="fileToUpload" onchange="upload_image();"></center>
			<p class="help-block">Seleccion un archivo.</p>
		  </div>
		  <div class="upload-msg"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
		 
		</form>
</div>
<script>
	function upload_image(){//Funcion encargada de enviar el archivo via AJAX
				$(".upload-msg").text('Cargando...');
				var inputFileImage = document.getElementById("fileToUpload");
				var file = inputFileImage.files[0];
				var data = new FormData();
				data.append('fileToUpload',file);
				
				/*jQuery.each($('#fileToUpload')[0].files, function(i, file) {
					data.append('file'+i, file);
				});*/
							
				$.ajax({
					url: "upload.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$(".upload-msg").html(data);
						window.setTimeout(function() {
						$(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();
						});	}, 5000);
					}
				});
				
			}
</script>