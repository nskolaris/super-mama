<?php
/*
File: /app/controllers/components/image.php
*/

/*
 * @note	(3 ago 2009)
 * el parametro folderName de la funcion upload_image_and_thumbnail, antes se usaba relativo al directorio de imagenes, ahora no
 *
 * @note	(15 ago 2009)
 * se agregan varios formatos de imagen mas, necesarios para el front
 * 
 * @note	(18 abr 2010)
 * se cambia el tema de los tamanios de las imagenes, se definen todos en un array
 *  
 */

class ImageComponent extends Object
{
    /*
    *	Uploads an image and its thumbnail into $folderName/big and $folderName/small respectivley.
    * 	Also uploads a zoom cropped image into $folderName/home. You could easily modify it to suit your needs!
    
    * 	Directions:
    *	In view where you upload the image, make sure your form creation is similar to the following
    *	<?= $form->create('FurnitureSet',array('type' => 'file')); ?>
    

    *	In view where you upload the image, make sure that you have a file input similar to the following
    *	<?= $form->file('Image/name1'); ?>
    
    
    *	In the controller, add the component to your components array
    *	var $components = array("Image");
    

    *	In your controller action (the parameters are expained below)
    *	$image_path = $this->Image->upload_image_and_thumbnail($this->data,"name1", 573,380,80,80, "sets");
    *	this returns the file name of the result image.  You can  store this file name in the database
    *
    *	Note that your image will be stored in 3 locations:
    *	Image: /webroot/img/$folderName/big/$image_path 
    *	Thumbnail:  /webroot/img/$folderName/small/$image_path 
    *	Homepage:  /webroot/img/$folderName/home/$image_path  
    *
    *	You could easily add more locations or remove locations you don't need


    *	Finally in the view where you want to see the images
    *	<?= $html->image('sets/big/'.$furnitureSet['FurnitureSet']['image_path']);
    * 	where "sets" is the folder name we saved our pictures in, and $furnitureSet['FurnitureSet']['image_path'] is the file name we stored in the database
    

    *	Parameters:
    *	$data: CakePHP data array from the form
    *	$datakey: key in the $data array. If you used <?= $form->file('Image/name1'); ?> in your view, then $datakey = name1
    *	$maxw: the maximum width that you want your picture to be resized to
    *	$maxh: the maximum width that you want your picture to be resized to
    *	$thumbscalew: the maximum width hat you want your thumbnail to be resized to
    *	$thumbscaleh: the maximum height that you want your thumbnail to be resized to
    *	$folderName: the name of the parent folder of the images. The images will be stored to $folderName/big/ and  $folderName/small/
    * 					esto cambio, antes era relativo a la carpeta de imagenes, ahora no
    */

    /*
     * @var $tamanios = array(
     * 		tamname => array(
     * 			width 		=> el ancho de la imagen (siempre se hace resizeCrop)
     * 			height 		=> el alto de la imagen
     * 			folderName	=> el nombre de la carpeta (relativo al parametro folderName que recibe la funcion)
     * 						   opcional, si no esta seteado, se usa la clave del arreglo (tamname)
     * 			quality		=> opcional, 85 por default
     * 			watermark	=> (bool) opcional, false por default
     * 
     */
    /*
     * el watermark lo va a buscar siempre a la carpeta de imagenes
     * 
     * /webroot/img/watermark_search.png	el watermark para la imagen de tamanio "search"
     * ...
     * /webroot/img/watermark_grande.png	el watermark para la imagen de tamanio "grande"
     */
	var $tamanios = array(
    	'versiones' => array(
    		'width' => 76, 'height' => 76,
    	),
    	'thumb' => array(
    		'width' => 144, 'height' => 144,
    	),
    	'normal' => array(
    		'width' => 500, 'height' => 500,
    	),
    );
    
    
    
    //http://sabbour.wordpress.com/2008/07/18/enhanced-image-upload-component-for-cakephp-12/
    function upload_image_and_thumbnail($data, $datakey, $folderName)
    {
        if (strlen($data['name']) > 4) {
            $error = 0;
            $tempuploaddir = $folderName . DS . "tmp"; // the /temp/ directory, should delete the image after we upload
            
            // Make sure the required directories exist, and create them if necessary
            if (!is_dir($tempuploaddir)) {
                mkdir($tempuploaddir, true);
            }
            
            
            $filetype = $this->getFileExtension($data['name']);
          	$filetype = strtolower($filetype);

           	if (($filetype != "jpeg") && ($filetype != "jpg") && ($filetype != "gif") && ($filetype != "png")) {
               	// verify the extension
               	return;
           	} else {
               	// Get the image size
               	$imgsize = GetImageSize($data['tmp_name']);
           	}

            // Generate a unique name for the image
           	$id_unic = str_replace(".", "", uniqid());
           	$filename = $id_unic;

           	settype($filename, "string");
           	$filename .= ".";
           	$filename .= $filetype;
            
           	$tempfile = $tempuploaddir . DS . $filename;
            	
            if (is_uploaded_file($data['tmp_name'])) {
                // Copy the image into the temporary directory
                if (!copy($data['tmp_name'], "$tempfile")) {
                    print "Error Uploading File!.";
                    exit();
                } else {
           	
                	foreach( $this->tamanios as $tam => $tam_conf ) {
            			$imagedir = $folderName . DS . ( isset($tam_conf['folderName']) ? $tam_conf['folderName'] : $tam );
            	
	            		// Make sure the required directories exist, and create them if necessary
    	        		if (!is_dir($imagedir)) {
                			mkdir($imagedir, true);
            			}

                        $this->resizeImage(
                        	'resizeCrop', 
                        	$tempuploaddir, $filename, 
                        	$imagedir, $filename,
                            $tam_conf['width'], $tam_conf['height'], 
                            (isset($tam_conf['quality']) ? $tam_conf['quality'] : 85),
                            (isset($tam_conf['watermark']) && $tam_conf['watermark'] ? WWW_ROOT.'img'.DS.'watermark_'.$tam.'.png' : null)
                        );
                            
            		}
            		
                    // Delete the temporary image
                    unlink($tempfile);
                    
                }
                
            }
            
	        // Image uploaded, return the file name
    	    return $filename;
        
        }
    }
            
            	

    /*
    *	Deletes the image and its associated thumbnail
    *	Example in controller action:	$this->Image->delete_image("1210632285.jpg","sets");
    *
    *	Parameters:
    *	$filename: The file name of the image
    *	$folderName: the name of the parent folder of the images. The images will be stored to /webroot/img/$folderName/big/ and  /webroot/img/$folderName/small/
    */
    function delete_image($filename, $folderName)
    {
       	foreach( $this->tamanios as $tam => $tam_conf ) {
    		$imagedir = $folderName . DS . ( isset($tam_conf['folderName']) ? $tam_conf['folderName'] : $tam );
        	if (is_file($imagedir . DS . $filename)) {
        		unlink($imagedir . DS . $filename);
        	}
       	}
    }

    function getFileExtension($str)
    {

        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    /*
    * @param $cType - the conversion type: resize (default), resizeCrop (square), crop (from center) 
    * @param $id - image filename
    * @param $imgFolder  - the folder where the image is
    * @param $newName - include extension (if desired)
    * @param $newWidth - the  max width or crop width
    * @param $newHeight - the max height or crop height
    * @param $quality - the quality of the image
    * @param $bgcolor - this was from a previous option that was removed, but required for backward compatibility
    */
    function resizeImage($cType = 'resize', $srcfolder, $srcname, $dstfolder, $dstname = false,
        $newWidth = false, $newHeight = false, $quality = 75, $watermark = null)
    {
        $srcimg = $srcfolder . DS . $srcname;
        list($oldWidth, $oldHeight, $type) = getimagesize($srcimg);
        $ext = $this->image_type_to_extension($type);

        //check to make sure that the file is writeable, if so, create destination image (temp image)
        if (is_writeable($dstfolder)) {
            $dstimg = $dstfolder . DS . $dstname;
        } else {
            //if not let developer know
            debug("You must allow proper permissions for image processing. And the folder has to be writable.");
            debug("Run \"chmod 777 on '$dstfolder' folder\"");
            exit();
        }

        //check to make sure that something is requested, otherwise there is nothing to resize.
        //although, could create option for quality only
        if ($newWidth or $newHeight) {
            /*
            * check to make sure temp file doesn't exist from a mistake or system hang up.
            * If so delete.
            */
            if (file_exists($dstimg)) {
                unlink($dstimg);
            } else {
                switch ($cType) {
                    default:
                    case 'resize':
                        # Maintains the aspect ration of the image and makes sure that it fits
                        # within the maxW(newWidth) and maxH(newHeight) (thus some side will be smaller)
                        $widthScale = 2;
                        $heightScale = 2;

                        // Check to see that we are not over resizing, otherwise, set the new scale
                        if ($newWidth) {
                            if ($newWidth > $oldWidth)
                                $newWidth = $oldWidth;
                            $widthScale = $newWidth / $oldWidth;
                        }
                        if ($newHeight) {
                            if ($newHeight > $oldHeight)
                                $newHeight = $oldHeight;
                            $heightScale = $newHeight / $oldHeight;
                        }
                        //debug("W: $widthScale  H: $heightScale<br>");
                        if ($widthScale < $heightScale) {
                            $maxWidth = $newWidth;
                            $maxHeight = false;
                        } elseif ($widthScale > $heightScale) {
                            $maxHeight = $newHeight;
                            $maxWidth = false;
                        } else {
                            $maxHeight = $newHeight;
                            $maxWidth = $newWidth;
                        }

                        if ($maxWidth > $maxHeight) {
                            $applyWidth = $maxWidth;
                            $applyHeight = ($oldHeight * $applyWidth) / $oldWidth;
                        } elseif ($maxHeight > $maxWidth) {
                            $applyHeight = $maxHeight;
                            $applyWidth = ($applyHeight * $oldWidth) / $oldHeight;
                        } else {
                            $applyWidth = $maxWidth;
                            $applyHeight = $maxHeight;
                        }
                        $startX = 0;
                        $startY = 0;
                        break;
                    case 'resizeCrop':

                        // Check to see that we are not over resizing, otherwise, set the new scale
                        // -- resize to max, then crop to center
                        if ($newWidth > $oldWidth)
                            $newWidth = $oldWidth;
                        $ratioX = $newWidth / $oldWidth;

                        if ($newHeight > $oldHeight)
                            $newHeight = $oldHeight;
                        $ratioY = $newHeight / $oldHeight;

                        if ($ratioX < $ratioY) {
                            $startX = round(($oldWidth - ($newWidth / $ratioY)) / 2);
                            $startY = 0;
                            $oldWidth = round($newWidth / $ratioY);
                            $oldHeight = $oldHeight;
                        } else {
                            $startX = 0;
                            $startY = round(($oldHeight - ($newHeight / $ratioX)) / 2);
                            $oldWidth = $oldWidth;
                            $oldHeight = round($newHeight / $ratioX);
                        }
                        $applyWidth = $newWidth;
                        $applyHeight = $newHeight;
                        break;
                    case 'crop':
                        // -- a straight centered crop
                        $startY = ($oldHeight - $newHeight) / 2;
                        $startX = ($oldWidth - $newWidth) / 2;
                        $oldHeight = $newHeight;
                        $applyHeight = $newHeight;
                        $oldWidth = $newWidth;
                        $applyWidth = $newWidth;
                        break;
                }

                switch ($ext) {
                    case 'gif':
                        $oldImage = imagecreatefromgif($srcimg);
                        break;
                    case 'png':
                        $oldImage = imagecreatefrompng($srcimg);
                        break;
                    case 'jpg':
                    case 'jpeg':
                        $oldImage = imagecreatefromjpeg($srcimg);
                        break;
                    default:
                        //image type is not a possible option
                        return false;
                        break;
                }

                //create new image
                $newImage = imagecreatetruecolor($applyWidth, $applyHeight);

                //put old image on top of new image
                imagecopyresampled($newImage, $oldImage, 0, 0, $startX, $startY, $applyWidth, $applyHeight,
                    $oldWidth, $oldHeight);

                if ($watermark != null) {
                  imagealphablending ($newImage, TRUE);
                  $water = imagecreatefrompng ($watermark);
                  $water_width  = imagesx ($water);
                  $water_height = imagesy ($water);
                  $pos_x = ($applyWidth  - $water_width)  >> 1;
                  $pos_y = ($applyHeight - $water_height) >> 1;
                  imagecopy ($newImage, $water, $pos_x, $pos_y, 0, 0, $water_width, $water_height);
                  imagedestroy($water);
                }

                switch ($ext) {
                    case 'gif':
                        imagegif($newImage, $dstimg, $quality);
                        break;
                    case 'png':
                        imagepng($newImage, $dstimg, $quality);
                        break;
                    case 'jpg':
                    case 'jpeg':
                        imagejpeg($newImage, $dstimg, $quality);
                        break;
                    default:
                        return false;
                        break;
                }

                imagedestroy($newImage);
                imagedestroy($oldImage);

                return true;
            }

        } else {
            return false;
        }


    }

    function image_type_to_extension($imagetype)
    {
        if (empty($imagetype))
            return false;
        switch ($imagetype) {
            case IMAGETYPE_GIF:
                return 'gif';
            case IMAGETYPE_JPEG:
                return 'jpg';
            case IMAGETYPE_PNG:
                return 'png';
            case IMAGETYPE_SWF:
                return 'swf';
            case IMAGETYPE_PSD:
                return 'psd';
            case IMAGETYPE_BMP:
                return 'bmp';
            case IMAGETYPE_TIFF_II:
                return 'tiff';
            case IMAGETYPE_TIFF_MM:
                return 'tiff';
            case IMAGETYPE_JPC:
                return 'jpc';
            case IMAGETYPE_JP2:
                return 'jp2';
            case IMAGETYPE_JPX:
                return 'jpf';
            case IMAGETYPE_JB2:
                return 'jb2';
            case IMAGETYPE_SWC:
                return 'swc';
            case IMAGETYPE_IFF:
                return 'aiff';
            case IMAGETYPE_WBMP:
                return 'wbmp';
            case IMAGETYPE_XBM:
                return 'xbm';
            default:
                return false;
        }
    }
}

?>