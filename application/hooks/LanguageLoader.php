
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LanguageLoader
{
    public function initialize()
    {
        $ci = &get_instance();
        $ci->load->helper('language');
        $ci->lang->load('mz', 'english');
    }

}
