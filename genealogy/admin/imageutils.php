<?php
function chkgd2(){
	$testGD = get_extension_funcs( "gd" ); // Grab function list
	if( !$testGD ) { echo "GD not installed."; exit; }
	if( in_array ( "imagegd2", $testGD ) )
		return true;
	else 
		return false; 
}

function image_createThumb( $src, $dest, $maxWidth, $maxHeight, $quality ) { 
    if( file_exists( $src ) && isset( $dest ) ) {
        $destInfo = pathInfo( $dest );
        $srcSize = @getImageSize( $src );

        // image dest size $destSize[0] = width, $destSize[1] = height
		if( $srcSize[1] )
	        $srcRatio  = $srcSize[0] / $srcSize[1]; // width/height ratio
		else
			return false;
		if( !$maxWidth ) $maxWidth = 50;
		if( !$maxHeight ) $maxHeight = 50;
        $destRatio = $maxWidth / $maxHeight; 
        if ($destRatio > $srcRatio) { 
            $destSize[1] = $maxHeight; 
            $destSize[0] = $maxHeight * $srcRatio; 
        } 
        else { 
            $destSize[0] = $maxWidth; 
            $destSize[1] = $maxWidth / $srcRatio; 
        }

        if( strtoupper( $destInfo['extension'] ) == "GIF")
            $dest = substr_replace( $dest, 'jpg', -3 ); 
			
        $gd2 = chkgd2();
		if( $gd2 && function_exists( imageCreateTrueColor ) ) {
	        $destImage = @ImageCreateTrueColor( $destSize[0], $destSize[1] ) or  $destImage = ImageCreate( $destSize[0], $destSize[1] );
			if( function_exists( imageAntiAlias ) )
	        	@imageAntiAlias( $destImage, true ); 
		}
		else
	        $destImage = ImageCreate( $destSize[0], $destSize[1] );

        switch ($srcSize[2]) { 
            case 1: //GIF 
	            $srcImage = @imageCreateFromGif( $src );
	            break; 
            case 2: //JPEG 
	            $srcImage = @imageCreateFromJpeg( $src );
	            break; 
            case 3: //PNG 
	            $srcImage = @imageCreateFromPng( $src );
	            break;
            default:
	            return false;
	            break;
        }
		if( !$srcImage ) return false;

        // resampling 
		if( $gd2 && function_exists( imageCopyResampled ) ) {
	       if( !@imageCopyResampled( $destImage, $srcImage, 0, 0, 0, 0, $destSize[0], $destSize[1], $srcSize[0], $srcSize[1] ) )
	        	imagecopyresized( $destImage, $srcImage, 0, 0, 0, 0, $destSize[0], $destSize[1], $srcSize[0], $srcSize[1] );
		}
		else
        	imagecopyresized( $destImage, $srcImage, 0, 0, 0, 0, $destSize[0], $destSize[1], $srcSize[0], $srcSize[1] );

        // generating image 
        switch( $srcSize[2] ) { 
            case 1: case 2: 
	            if( !@imageJpeg( $destImage, $dest, $quality ) ) return false;
	            break; 
            case 3: 
	            if( !@imagePng( $destImage, $dest ) ) return false;
	            break; 
        } 
        return true; 
    } 
    else
        return false; 
}
?>
