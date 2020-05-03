

<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Muhanz.
 */
class Mustache{
    private $CI;
    private $mustache;

    public function __construct()
    {
        $this->CI =& get_instance();
        
    }
    public function parser_tpl($template, $data)
    {
        $this->mustache = new Mustache_Engine(
            array(
                'cache' => APPPATH . '/cache/mustache',
                'cache_file_mode' => FILE_READ_MODE, 
                'loader' => new Mustache_Loader_FilesystemLoader(VIEWPATH.'/mustache'),
                'partials_loader' => new Mustache_Loader_FilesystemLoader(VIEWPATH . '/mustache/partials'),
                'charset' => 'ISO-8859-1',
            )
        );

        return $this->mustache->render($template, array('setData' => $data ));
    }

    public function parser($inline_tpl, $data)
    {
        $this->mustache = new Mustache_Engine(
            array(
                'cache' => APPPATH . '/cache/mustache',
                'cache_file_mode' => FILE_READ_MODE, 
                'charset' => 'ISO-8859-1',
            )
        );
        
        return $this->mustache->render($inline_tpl, array('setData' => $data ));
    }

}