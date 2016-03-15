<?php

class blog
{

    /*
     * Create an image from a submitted (or otherwise) browsed picture.
     * This will normally be used with conjunction with a html form that is uploaded
     * to a php script.
     *
     * @param $path: The name of the image.
     * @param $save: The target path of the image.
     * @param $width: The width of the thumbnail.
     * @param $height: The height of the thumbnail.
     */
    function create_thumbnail($path, $save, $width, $height)
    {
        $info = getimagesize($path);
        $size = array($info[0], $info[1]);

        if ($info['mime'] == 'image/png') {
            $src = imagecreatefrompng($path);
        } else if ($info['mime'] == 'image/jpeg') {
            $src = imagecreatefromjpeg($path);
        } else if ($info['mime'] == 'image/gif') {
            $src = imagecreatefromgif($path);
        } else {
            return false;
        }

        $thumb = imagecreatetruecolor($width, $height);

        $src_aspect = $size[0] / $size[1];
        $thumb_aspect = $width / $height;

        if ($src_aspect < $thumb_aspect) {
            // narrower input image - crop sides
            $scale = $width / $size[0]; // width / width to get scale factor
            $new_size = array($width, $width / $src_aspect);
            $src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2); // Co-ordinate we start copying from
        } else if ($src_aspect > $thumb_aspect) {
            // taller input image - crop top
            $scale = $height / $size[1];
            $new_size = array($height * $src_aspect, $height);
            $src_pos = array(0, ($size[0] * $scale - $width) / $scale / 2);
        } else {
            // same shape as input image
            $new_size = array($width, $height);
            $src_pos = array(0, 0);
        }

        // Handle user from breaking script
        $new_size[0] = max($new_size[0], 1);
        $new_size[1] = max($new_size[1], 1);

        imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);

        if ($save === false) {
            return imagepng($thumb);
        } else {
            return imagepng($thumb, "../../images/" . $save);
        }

    }

}