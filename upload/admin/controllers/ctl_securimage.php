<?php
/**
 * ╣ВсцкУбтм╪
 *
 * @since 2009-7-13
 * @copyright http://www.114la.com
 */
!defined('PATH_ADMIN') && exit('Forbidden');

class ctl_securimage
{
    public function index()
    {
        $this->show();
    }
    public function show()
    {
        $s = new mod_securimage();
        $s->image_width = "80";
        $s->image_height = "26";
        $s->text_x_start = 5;
        $s->text_minimum_distance = 18;
        $s->text_maximum_distance = 18;
        $s->gd_font_size = 10;
        $s->font_size = 17;
        $s->line_distance = 4;
        $s->arc_linethrough = false;
        $s->show();
    }
}
?>