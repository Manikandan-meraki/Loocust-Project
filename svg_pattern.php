

<?php if ( $message ) : ?>
<div>
Convert svg to png <br>
<?php
/* DB Connection */
/** The name of the database for WordPress */
define('DB_NAME', 'loocust');

/** MySQL database username */
define('DB_USER', 'loocust');

/** MySQL database password */
define('DB_PASSWORD', 'L0o(U$!1q2w');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');



$mysqli=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$imageid = $_REQUEST["post"];
//$imageid = $argv[0];

//echo "<pre>";print_r($_REQUEST["post"]);

$query = "SELECT b.guid FROM lc_postmeta a 
LEFT OUTER JOIN lc_posts b ON b.ID = a.meta_value
WHERE 1 AND a.meta_key = 'background_image' AND a.post_id = '".$imageid."'";

// Perform queries 

if ($stmt = mysqli_prepare($mysqli, $query)) {

    /* execute statement */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    mysqli_stmt_bind_result($stmt, $guid);

    /* fetch values */
    while (mysqli_stmt_fetch($stmt)) {
        //printf ("%s \n", $guid);
		$innerImage = $guid;
    }

    /* close statement */
    mysqli_stmt_close($stmt);
}

//mysqli_query($con, $strSQL);


mysqli_close($mysqli);
if($innerImage == "")
	 {
        echo "No background images found to convert."; 

	 }else {

	
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

<!-- SVG include -->
<!-- SVG include -->

<script type="text/javascript">
onload_call();
 $('#mask_loading').show();
 $('#dvLoading').show();
</script>

 <?php } ?>
</div>