<?php

/*****************************************************************************
	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*****************************************************************************
	Name:
		skuto
	Description:
		Skuto is a PHP script that uses the GD library to offer a simple alternative
		to the deployment of images with the potential to change its size on the fly.
		It also lets you crop these images, for example, generate thumbnails and
		galleries.

		To use Skuto you simply call into the "src" attribute of the tag with the
		necessary parameters to do what you want.
	Author:
		Cristian Santana Benavides <http://www.cristiansantana.cl>
	Web:
		http://code.google.com/p/skuto
*****************************************************************************/

	//Quality
	if( empty( $_GET['q'] ) )
		$quality	=	90;
	else
		$quality	=	$_GET['q'];

	//Interlace
	if( $_GET['i'] == '1' )
		$interlace	=	true;
	else
		$interlace	=	false;

	//Get name of file
	$name	=	split( "/" , $_GET['url'] );
	$name	=	$url[( sizeof( $name ) - 1 )];

	//Get Info of File
	$info	=	getimagesize( $_GET['url'] );
	$width	=	$info[0];
	$height	=	$info[1];
	$type	=	image_type_to_mime_type( $info[2] );

	switch( $type )
	{
		case 'image/jpeg':
			$loadedImage	=	imagecreatefromjpeg( $_GET['url'] );
			break;
		case 'image/gif':
			$loadedImage	=	imagecreatefromgif( $_GET['url'] );
			break;
		case 'image/png':
			$loadedImage	=	imagecreatefrompng( $_GET['url'] );
			break;
	}

	//Make a Square
	if(!empty($_GET['square']))
	{
		$newWidth	=	$_GET['square'];
		$newHeight	=	$_GET['square'];
		if( $width >= $height )
			$width	=	$height;
		else
			$height	=	$width;
	}

	//Percentage Change
	elseif( !empty( $_GET['p'] ) )
	{
		$newWidth	=	( $_GET['p'] / 100 ) * $width;
		$newHeight	=	( $_GET['p'] / 100 ) * $height;
	}

	//Width change
	elseif( !empty( $_GET['width'] ) )
	{
		$newWidth	=	$_GET['width'];
		$newHeight	=	( $height * $newWidth ) / $width;
	}

	//Height change
	elseif( !empty( $_GET['height'] ) )
	{
		$newHeight	=	$_GET['height'];
		$newWidth	=	( $width * $newHeight ) / $height;
	}

	//setting maximum width and height
	elseif( ( !empty( $_GET['max_height'] ) ) && ( !empty( $_GET['max_width'] ) ) )
	{
		$relWidth	=	$_GET['max_width'] / $width;
		$relHeight	=	$_GET['max_height'] / $height;
		if( $relWidth < $relHeight )
		{
			$newWidth	=	$_GET['max_width'];
			$newHeight	=	( $height * $newWidth ) / $width;
		}
		else
		{
			$newHeight	=	$_GET['max_height'];
			$newWidth	=	( $width * $newHeight ) / $height;
		}
	}

	$newImage	=	imagecreatetruecolor( $newWidth , $newHeight );
	imageinterlace( $newImage , $interlace );
	imagecopyresampled( $newImage , $loadedImage , 0 , 0 , 0 , 0 , $newWidth , $newHeight , $width , $height );
	
	header( "Content-Disposition: inline; filename=" . $name ); 
	header( "Content-type:" . $type );
	switch( $type )
	{
		case 'image/jpeg':
			imagejpeg( $newImage , '' , $quality );
			break;
		case 'image/gif':
			imagegif( $newImage , '' , $quality );
			break;
		case 'image/png':
			imagepng( $newImage , '' , $quality );
			break;
	}
	imagedestroy( $newImage );
?>