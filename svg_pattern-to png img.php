
	
$b64image = base64_encode(file_get_contents($innerImage));
?>
<script type="text/javascript">
function onload_call(){
	
	var svgText = document.getElementById("myViewer").outerHTML;
	var myCanvas = document.getElementById("canvas");
	var ctxt = myCanvas.getContext("2d");
	
	function drawInlineSVG(ctx, rawSVG, callback) {
	
		var svg = new Blob([rawSVG], {type:"image/svg+xml;charset=utf-8"}),
			domURL = self.URL || self.webkitURL || self,
			url = domURL.createObjectURL(svg),
			img = new Image;
		
		img.onload = function () {
			ctx.drawImage(this, 0, 0);     
			domURL.revokeObjectURL(url);
			callback(this);
		};
		
		img.src = url;
	}
	
	// usage:
	drawInlineSVG(ctxt, svgText, function() {
		console.log(canvas.toDataURL());  // -> PNG
		//alert("see console for output...");
	
		var img = canvas.toDataURL();
		$.ajax({
		  url:"svgtopngconverter_process.php",
		  // send the base64 post parameter
		  data:{
			postid: '<?php echo $imageid; ?>',
			base64: img
		  },
		  // important POST method !
		  type:"post",
		  complete:function(){
		  	$('#mask_loading').hide();
            $('#dvLoading').hide();
			console.log("Ready");
		  }
		});
	});
}
</script>
<canvas id="canvas" width=400 height=400></canvas>


<script type="text/javascript">
onload_call();
 $('#mask_loading').show();
 $('#dvLoading').show();
</script>


</div>