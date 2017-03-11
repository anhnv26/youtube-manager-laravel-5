<?php

namespace App\Http\Controllers;

use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function video(Request $request)
    {
        $video = Youtube::getVideoInfo('rie-hPVJ7Sw');
        dd($video);
    }

    public function download(Request $request)
    {
        $data = file_get_contents("https://youtube.com/get_video_info?video_id=3k-cTvUwioc&el=vevo&fmt=18&asv=2&hd=1");

        parse_str($data , $details);
        $title = $details['title'];
        $my_formats_array = explode(',' , $details['adaptive_fmts']);
        $avail_formats[] = '';
        $i = 0;
        $ipbits = $ip = $itag = $sig = $quality_label = $type = $url = '';
        $expire = time();

        foreach ($my_formats_array as $format) {
            parse_str($format);
            $avail_formats[$i]['itag'] = $itag;
            $avail_formats[$i]['quality'] = $quality_label;
            $type = explode(';', $type);
            $avail_formats[$i]['type'] = $type[0];
            $avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
            parse_str(urldecode($url));
            $avail_formats[$i]['expires'] = date("G:i:s T", $expire);
            $avail_formats[$i]['ipbits'] = $ipbits;
            $avail_formats[$i]['ip'] = $ip;

            echo "<a href='$url?title=$title'>$quality_label></a><br>/";
        }
    }
}
