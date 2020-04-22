<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Muhanz
{
    /**
     * __construct
     *
     * @author Muhanz
     */
    public function __construct()
    {
		$this->ci =& get_instance();
		// Load config file
		$this->ci->load->config('app');


    }

    public function success($message_success, $url = false, $data = false)
    {

        if (empty($message_success)) {
            $message_success = 'n-a';
        }

        $message = array(
            'url'     => base_url($url),
            'status'  => 'success',
            'type'    => 'success',
            'message' => strip_tags($message_success),
			'data'	  => $data
        );

        echo json_encode($message);
    }

	public function success_qrcode($message_success, $data)
	{

		if (empty($message_success)) {
			$message_success = 'n-a';
		}

		$message = array(
			'filename'     => $data,
			'status'  => 'success',
			'type'    => 'success',
			'message' => strip_tags($message_success),
		);

		echo json_encode($message);
	}

    public function error($message_error, $url)
    {

        if (empty($message_error)) {
            $message_error = 'n-a';
        }

        $message = array(
            'url'     => base_url($url),
            'status'  => 'error',
            'type'    => 'danger',
            'message' => strip_tags($message_error),
        );

        echo json_encode($message);
    }

    public function app_title($title)
    {

        if (!empty($title)) {  
            return $title.' | '. $this->ci->config->item('site_name');
        } 
        else 
        { 
            return $this->ci->config->item('site_name');
        }
    }

    public function store_title($title)
    {
        
        if (!empty($title)) {  
            return $title. ' - ' .$this->ci->config->item('site_name');
        } 
        else 
        { 
            return $this->ci->config->item('site_name', 'app');
        }
    }
    
    public function remove_url($string)
    {
        return str_replace(base_url(), "", $string);
    }

    public function terbilang($nilai) {

        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = penyebut($nilai - 10). " Belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
        }     

        if($nilai<0) {
            $hasil = "Minus ". trim($temp);
        } else {
            $hasil = trim($temp);
        }           
        return $hasil.' Rupiah';

    }


    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' lalu' : ' sekarang';
    }

    public function comma_separated_to_array($string, $separator = ',')
    {
        //Explode on comma
        $vals = explode($separator, $string);

        //Trim whitespace
        foreach ($vals as $key => $val) {
            $vals[$key] = trim($val);
        }
        //Return empty array if no items found
        //http://php.net/manual/en/function.explode.php#114273
        return array_diff($vals, array(""));
    }

    public function strip_tags_content($text, $tags = '', $invert = FALSE) 
    { 

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags); 
        $tags = array_unique($tags[1]); 
        
        if(is_array($tags) AND count($tags) > 0) 
        { 
            if($invert == FALSE) 
            { 
                return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text); 
            } 
            else 
            { 
                return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text); 
            } 
        } 
        elseif($invert == FALSE) 
        { 
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text); 
        } 
        return $text; 
    } 


    public function day_id($event_end_date, $type = false)
    {

        if (isset($type) && $type == '1') {
            $hari = date('D', strtotime($event_end_date));
        } else {
            $date_now = date('Y-m-d');
            $beetwen  = date('Y-m-d', strtotime('+4 days', strtotime($date_now)));
            if ($beetwen >= $event_end_date) {
                $hari = date('D', strtotime($event_end_date));
            } else {
                $hari = date('D', strtotime($beetwen));
            }
        }

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }

        return 'Hari ' . $hari_ini;
    }

    public function month_id($event_end_date)
    {

        $nama_bulan = date("m", strtotime($event_end_date));

        switch ((int) $nama_bulan) {
            case 1:
                $nama_bulan = "Januari";
                break;
            case 2:
                $nama_bulan = "Februari";
                break;
            case 3:
                $nama_bulan = "Maret";
                break;
            case 4:
                $nama_bulan = "April";
                break;
            case 5:
                $nama_bulan = "Mei";
                break;
            case 6:
                $nama_bulan = "Juni";
                break;
            case 7:
                $nama_bulan = "Juli";
                break;
            case 8:
                $nama_bulan = "Agustus";
                break;
            case 9:
                $nama_bulan = "September";
                break;
            case 10:
                $nama_bulan = "Oktober";
                break;
            case 11:
                $nama_bulan = "November";
                break;
            case 12:
                $nama_bulan = "Desember";
                break;
            default:
                $nama_bulan = Date('F');
                break;
        }

        return date("d", strtotime($event_end_date)) . ' ' . $nama_bulan . ' ' . date("Y", strtotime($event_end_date));
    }

}
