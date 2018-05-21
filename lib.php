<?php
/**
 * Youtube Proxy 
 * Simple Youtube PHP Proxy Server
 * @author ZXQ
 * @version V1.2
 * @description 核心操作函数集合
 */

require_once(dirname(__FILE__).'/config.php');

//加载第三方ytb解析库
require_once(dirname(__FILE__).'/YouTubeDownloader.php');
//获取远程数据函数
 function get_data($url){
    if (!function_exists("curl_init")) {
		$f = file_get_contents($url);
	} else {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.youtube.com/');
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.91 Safari/534.30");
		$f = curl_exec($ch);
		curl_close($ch);
	}
   return $f;  
}
//获取类别热门视频
function get_trending($apikey,$max,$pageToken='',$regionCode='vn'){
    $apilink='https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&chart=mostPopular&regionCode='.$regionCode.'&maxResults='.$max.'&key='.$apikey.'&pageToken='.$pageToken;
     return json_decode(get_data($apilink),true);
}

//获取视频数据函数
 function get_video_info($id,$apikey){
    $apilink='https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id='.$id.'&key='.$apikey;
     return json_decode(get_data($apilink),true);
}

//获取用户频道数据
function get_channel_info($cid,$apikey){
   $apilink='https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics&hl=vi&id='.$cid.'&key='.$apikey;
   return json_decode(get_data($apilink),true);
}

//获取相关视频
function get_related_video($vid,$apikey){
   $apilink='https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=24&relatedToVideoId='.$vid.'&key='.$apikey;
   return json_decode(get_data($apilink),true);
}


//获取用户频道视频
function get_channel_video($cid,$pageToken='',$apikey,$regionCode='VN'){
   $apilink='https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&maxResults=50&type=video&regionCode='.$regionCode.'&hl=vi-VN&channelId='.$cid.'&key='.$apikey.'&pageToken='.$pageToken;
   return json_decode(get_data($apilink),true);
}

//获取视频类别内容
function videoCategories($apikey,$regionCode='VN'){
   $apilink='https://www.googleapis.com/youtube/v3/videoCategories?part=snippet&regionCode='.$regionCode.'&hl=vi-VN&key='.$apikey;
   return json_decode(get_data($apilink),true);
}


function categorieslist($id){
   $data=array(
    '1' => 'Phim ảnh và Hoạt hình',
    '2' => 'Xe hơi',
    '10' => 'Âm nhạc',
    '15' => 'Vật nuôi và động vật',
    '17' => 'Thể thao',
    '18' => 'Phim ngắn',
    '19' => 'Du lịch và hoạt động',
    '20' => 'Game',
    '21' => 'Video Blog',
    '22' => 'Người và Blogs',
    '23' => 'Hài kịch',
    '24' => 'Giải trí',
    '25' => 'Tin tức và Chính trị',
    '26' => 'Tự làm và bách khoa toàn thư',
    '27' => 'Giáo dục',
    '28' => 'Khoa học và Công nghệ',
    '30' => 'Phim',
    '31' => 'Anime / Hoạt hình',
    '32' => 'Hành động / Phiêu lưu',
    '33' => 'Cổ điển',
    '34' => 'Hài kịch',
    '35' => 'Tài liệu',
    '36' => 'Bộ phim truyền hình',
    '37' => 'Gia đình mảnh',
    '38' => 'Nước ngoài',
    '39' => 'Phim kinh dị',
    '40' => 'khoa học viễn tưởng / tưởng tượng',
    '41' => 'Kinh dị',
    '42' => 'Phim ngắn',
    '43' => 'Show',
    '44' => 'Trailer'
       );
     if($id=='all'){
     return $data;    
     }else{
      return $data[$id];   
     }
}
//获取视频类别内容
function Categories($id,$apikey,$pageToken='',$order='relevance',$regionCode='VN'){
   $apilink='https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&&regionCode='.$regionCode.'&hl=vi-VN&maxResults=48&videoCategoryId='.$id.'&key='.$apikey.'&order='.$order.'&pageToken='.$pageToken;
   return json_decode(get_data($apilink),true);
}


//获取搜索数据
function get_search_video($query,$apikey,$pageToken='',$type='video',$order='relevance',$regionCode='VN'){
   $apilink='https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=48&order='.$order.'&type='.$type.'&q='.$query.'&key='.$apikey.'&pageToken='.$pageToken;
   return json_decode(get_data($apilink),true);
}

//api返回值时间转换函数1
function covtime($youtube_time){
    $start = new DateTime('@0'); 
    $start->add(new DateInterval($youtube_time));
    if(strlen($youtube_time)<=7){
      return $start->format('i:s');  
    }else{
     return $start->format('H:i:s');   
    }
    
}   

//转换时间函数，计算发布时间几天前几年前
function format_date($time){
    $t=strtotime($time);
    $t=time()-$t;
    $f=array(
    '31536000'=>' năm',
    '2592000'=>' tháng',
    '604800'=>' tuần',
    '86400'=>' ngày',
    '3600'=>' giờ',
    '60'=>' phút',
    '1'=>' giây'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.' trước';
        }
    }
}

//api返回值时间转换函数2
function str2time($ts) {
 return date("Y-m-d H:i", strtotime($ts));
}

 //播放量转换
function convertviewCount($value){
    if($value <= 10000){
    $number = $value;   
    }else{
      $number = $value / 1000 ; 
      $number = round($number,1).'K';
      
    }
    
    return $number;
}
//获取banner背景
function get_banner($a,$apikey){
   $apilink='https://www.googleapis.com/youtube/v3/channels?part=brandingSettings&id='.$a.'&key='.$apikey;
   $json=json_decode(get_data($apilink),true);
  if (array_key_exists('bannerTabletImageUrl',$json['items'][0]['brandingSettings']['image'])){
  return $json['items'][0]['brandingSettings']['image']['bannerTabletImageUrl'];    
 }else{
  return 'https://c1.staticflickr.com/5/4546/24706755178_66c375d5ba_h.jpg';   
 }
}
$videotype=array(
    '3GP144P' => array('3GP','144P','3gpp'),
    '360P' => array('MP4','360P','mp4'), 
    '720P' => array('MP4','720P','mp4'), 
    'WebM360P' => array('webM','360P','webm'), 
    'Unknown' => array('N/A','N/A','3gpp'), 
    );
    
//获取相关频道 api不支持，靠采集完成
require_once(dirname(__FILE__).'/inc/phpQuery.php');
require_once(dirname(__FILE__).'/inc/QueryList.php');
use QL\QueryList;
function get_related_channel($id){
    $channel='https://www.youtube.com/channel/'.$id;
    $rules = array(
    'id' => array('.branded-page-related-channels .branded-page-related-channels-list li','data-external-id'),
    'name' => array('.branded-page-related-channels .branded-page-related-channels-list li .yt-lockup .yt-lockup-content .yt-lockup-title a','text'),
);

return $data = QueryList::Query(get_data($channel),$rules)->data;
}

//采集抓取随机推荐内容
function random_recommend(){
   $dat=get_data('https://www.youtube.com/?gl=VN&hl=vi-VN'); 
   $rules = array(
    't' => array('#feed .individual-feed .section-list li .item-section li .feed-item-container .feed-item-dismissable .shelf-title-table .shelf-title-row h2 .branded-page-module-title-text','text'),
    'html' => array('#feed .individual-feed .section-list li .item-section li .feed-item-container .feed-item-dismissable .compact-shelf .yt-viewport .yt-uix-shelfslider-list','html'),
        );

    $rules1 = array(
    'id' => array('li .yt-lockup ','data-context-item-id'),
    'title' => array('li .yt-lockup .yt-lockup-dismissable .yt-lockup-content .yt-lockup-title a','text'),
        );

    $data = QueryList::Query($dat,$rules)->data;
    
    $ldata=array();
    foreach ($data as $v) {
       $d = QueryList::Query($v['html'],$rules1)->data;
       $ldata[]=array(
           't'=> $v['t'],
           'dat' => $d
           );
    }
    array_shift($ldata);
    return $ldata;
}
//视频下载
function video_down($v,$name){
$yt = new YouTubeDownloader();
$links = $yt->getDownloadLinks("https://www.youtube.com/watch?v=$v");
echo '<table class="table table-hover"><thead><tr>
      <th>Định dạng</th>
      <th>Loại</th>
      <th>Tải về</th>
    </tr>
  </thead>';
foreach ($links as $value) {
    global $videotype;
echo ' <tbody>
    <tr>
      
      <td>'.$videotype[$value['format']][0].'</td>
      <td>'.$videotype[$value['format']][1].'</td>
      <td><a href="./downvideo.php?v='.$v.'&quality='.$value['format'].'&name='.$name.'&format='.$videotype[$value['format']][2].'" target="_blank" class="btn btn-outline-success btn-sm"><i class="fa fa-download"></i> Download</a></td>
    </tr></tbody>';
    } 
    echo '</table>';
}

//判断高清微缩图是否存在
function get_thumbnail_code($vid){
$thumblink='https://img.youtube.com/vi/'.$vid.'/maxresdefault.jpg';    
$oCurl = curl_init();
$header[] = "Content-type: application/x-www-form-urlencoded";
$user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
curl_setopt($oCurl, CURLOPT_URL, $thumblink);
curl_setopt($oCurl, CURLOPT_HTTPHEADER,$header);
curl_setopt($oCurl, CURLOPT_HEADER, true);
curl_setopt($oCurl, CURLOPT_NOBODY, true);
curl_setopt($oCurl, CURLOPT_USERAGENT,$user_agent);
curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($oCurl, CURLOPT_POST, false);
$sContent = curl_exec($oCurl);
$headerSize = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
curl_close($oCurl);
if($headerSize == '404'){
  return 'https://img.youtube.com/vi/'.$vid.'/hqdefault.jpg';  
}else{
  return 'https://img.youtube.com/vi/'.$vid.'/maxresdefault.jpg';   
}
}


//解析历史记录
function Hislist($str,$apikey){
    $str=str_replace('@',',',$str);
    $apilink='https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id='.$str.'&key='.$apikey;
   return json_decode(get_data($apilink),true);   
}

//获取频道所属国家
$CountryID=array(
    'DZ' => 'Algeria',
    'AR' => 'Argentina',
    'AE' => 'United Arab Emirates',
    'OM' => 'Oman',
    'AZ' => 'Azerbaijan',
    'EG' => 'Ai Cập',
    'IE' => 'Ireland',
    'EE' => 'Estonia',
    'AT' => 'Áo',
    'AU' => 'Úc',
    'PK' => 'Pakistan',
    'BH' => 'Bahrain',
    'BR' => 'Brazil',
    'BY' => 'Belarus',
    'BG' => 'Bulgaria',
    'BE' => 'Bỉ',
    'IS' => 'Iceland',
    'PR' => 'Puerto Rico',
    'PL' => 'Ba Lan',
    'BA' => 'Bosnia và Herzegovina',
    'DK' => 'Đan Mạch',
    'DE' => 'Đức',
    'RU' => 'Nga',
    'FR' => 'Pháp',
    'PH' => 'Philippines',
    'FI' => 'Phần Lan',
    'CO' => 'Colombia',
    'GE' => 'Cộng hòa Georgia',
    'KZ' => 'Kazakhstan',
    'KR' => 'Hàn Quốc',
    'NL' => 'Hà Lan',
    'ME' => 'Cộng hòa Montenegro',
    'CA' => 'Canada',
    'CN' => 'Trung Quốc',
    'GH' => 'Ghana',
    'CZ' => 'Cộng hòa Séc',
    'ZW' => 'Zimbabwe',
    'QA' => 'Qatar ',
    'KW' => 'Kuwait',
    'HR' => 'Croatia',
    'KE' => 'Kenya',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LT' => 'Lithuania',
    'LY' => 'Libya',
    'LU' => 'Duchy of Luxembourg',
    'RO' => 'Romania',
    'MY' => 'Malaysia',
    'MK' => 'Macedonia',
    'Mỹ' => 'Mỹ',
    'PE' => 'Peru',
    'MA' => 'Morocco',
    'MX' => 'Mexico',
    'ZA' => 'Nam Phi',
    'NP' => 'Nepal',
    'NG' => 'Nigeria',
    'NO' => 'Na Uy',
    'PT' => 'Bồ Đào Nha',
    'JP' => 'Nhật Bản',
    'SE' => 'Thụy Điển',
    'CH' => 'Thụy Sĩ',
    'RS' => 'Serbia',
    'SN' => 'Senegal',
    'SA' => 'Saudi Arabia',
    'LK' => 'Sri Lanka',
    'SK' => 'Slovakia',
    'SI' => 'Slovenia',
    'TW' => 'Đài Loan',
    'TH' => 'Thái Lan',
    'TZ' => 'Tanzania',
    'TN' => 'Tunisia',
    'TR' => 'Thổ Nhĩ Kỳ',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'ES' => 'Tây Ban Nha',
    'GR' => 'Hy Lạp',
    'HK' => 'Hồng Kông',
    'SG' => 'Singapore',
    'NZ' => 'New Zealand',
    'HU' => 'Hungary',
    'JM' => 'Jamaica',
    'YE' => 'Yemen',
    'IQ' => 'Iraq',
    'IL' => 'Israel',
    'IT' => 'Ý',
    'IN' => 'Ấn Độ',
    'ID' => 'Indonesia',
    'GB' => 'Anh',
    'JO' => 'Jordan',
    'VN' => 'Việt Nam',
    'CL' => 'Chile',
    );
function get_country($c){
    global $CountryID;
    return  $CountryID[$c];
}

//url字符串加解密
function strencode($string,$key='09KxDsIIe|+]8Fo{YP<l+3!y#>a$;^PzFpsxS9&d;!l;~M>2?N7G}`@?UJ@{FDI') {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string,$i,1));
        if (@$j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        @$j++;
    @$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
    }
    return 'Urls://'.$hash;
}
function strdecode($string,$key='09KxDsIIe|+]8Fo{YP<l+3!y#>a$;^PzFpsxS9&d;!l;~M>2?N7G}`@?UJ@{FDI') {
    $string= ltrim($string, 'Urls://');
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
        if (@$j == $keyLen) { @$j = 0; }
        $ordKey = ord(substr($key,@$j,1));
        @$j++;
        @$hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

//分享功能
function shareit($id,$title='Mã nhúng video Youtube'){
    $pic=ROOT_PART.'/thumbnail.php?vid='.$id;
    $url=ROOT_PART.'watch-'.$id.'.html';
    $title=str_replace('&','||',$title);
    $title=str_replace('"',' ',$title);
     $title=str_replace("'",' ',$title);
    $des='【Mã nhúng Videi】 Cho phép nhúng《'.$title.'》 Có thể xem trên trang của bạn！';
    return "<div id='share'>
  <a class='icoqz' href='https://plus.google.com/share?url=".$url."' target='blank' title='Chia sẻ lên Google+'><i class='fa fa-google-plus'></i></a>

  <a class='icotb' href='https://www.facebook.com/sharer/sharer.php?u=".$url."' target='blank' title='Chia sẻ lên Facebook'><i class='fa fa-facebook'></i></a>

  <a class='icowb' href='https://twitter.com/home?status=".$url."' target='blank' title='Chia sẻ lên Twitter'><i class='fa fa-twitter'></i></a>
</div>
 <div class='form-group'><div class='d-inline-block h6 pt-3 col-12'>
    Mã nhúng：
 </div>
    <textarea style='resize:none;height: auto' class='form-control d-inline align-middle col-12 icoys icontext' id='inputs' type='text' rows='5' placeholder='Default input'><iframe height=498 width=510 src=&quot;".ROOT_PART."embed/?v=".$id.";&quot; frameborder=0 &quot;allowfullscreen&quot;></iframe></textarea>
    
    <button type='submit' class='btn btn-primary align-middle col-12 mt-2' onclick='copytext1()'>Coppy</button></div>";
    
}
//
function html5_player($id){
    $yt = new YouTubeDownloader();
    $links = $yt->getDownloadLinks('https://www.youtube.com/watch?v='.$id);
    if(count($links)!=1){
        echo'<video id="h5player"  class="video-js vjs-fluid mh-100 mw-100" loop="loop" width="100%" preload="auto" autoplay webkit-playsinline="true" playsinline="true" x-webkit-airplay="true" controls="controls" controls preload="auto" width="100%" poster="./thumbnail.php?type=maxresdefault&vid='.$id.'" data-setup=\'\'>';
        
        //获取视频分辨率
        if(array_key_exists('22',$links)){
        echo '<source src="./vs.php?vv='.$id.'&quality=720" type=\'video/mp4\' res="720" label=\'720P\'/>';   
            };
        echo '<source src="./vs.php?vv='.$id.'&quality=360" type=\'video/mp4\' res="360" label=\'360P\'/>';
        
        
    //提取字幕
     $slink='https://www.youtube.com/api/timedtext?type=list&v='.$id;
     $vdata=get_data($slink);
     @$xml = simplexml_load_string($vdata);
     $array1=json_decode(json_encode($xml), true);
     $arr=array();
     //分离出几种常用字幕
     if(array_key_exists('track',$array1) && array_key_exists('0',$array1['track'])){
         if (array_key_exists('track', $array1) && array_key_exists('0', $array1['track'
    									   ])) {
    	foreach ($array1['track'] as $val) {if ($val['@attributes']['lang_code'] == 'en' || $val['@attributes']['lang_code'] == 'zh' || $val['@attributes']['lang_code'] =='zh-CN' || $val['@attributes']['lang_code'] =='zh-TW' || $val['@attributes']['lang_code'] =='zh-HK') {
    			$arr[$val['@attributes']['lang_code']] = "
    <track kind='captions' src='./tracks.php?vtt={$id}&lang=" . $val['@attributes']
    ['lang_code'] . "' srclang='" . $val['@attributes']['lang_code'] . "' label='" .
    				   $val['@attributes']['lang_original'] . "'/>";
    		}
    	}
    	foreach ($arr as $k => $v) {
    	    switch ($k) {
    		    case 'zh-CN':
    		        $arr[$k] = substr_replace($v, ' default ', -2,0);
    				break;
    			case 'zh':
    		        $arr[$k] = substr_replace($v, ' default ', -2,0);
    				break;
    			case 'zh-HK':
    		        $arr[$k] = substr_replace($v, ' default ', -2,0);
    				break;
    			case 'zh-TW':
    				$arr[$k] = substr_replace($v, ' default ', -2,0);
    				break;
    			case 'en':
    				$arr[$k] = substr_replace($v, ' default ', -2,0);
    				break;
    		}
    		break;
    	}
    	foreach($arr as $vl ){
          echo $vl.PHP_EOL;
      }
    }
     }elseif(array_key_exists('track',$array1)){
     echo "<track kind='captions' src='./tracks.php?vtt={$id}&lang=".$array1['track']['@attributes']['lang_code']."' srclang='".$array1['code']."' label='".$array1['track']['@attributes']['lang_original']."' default />";   
     }

    echo '</video>';
    }else{
        echo '<img src="./inc/2.svg" class="w-100" onerror="this.onerror=null; this.src="./inc/2.gif"">';       
        }   
}
//获取安装目录
function Root_part(){
$http=isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$part=rtrim($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME']));
$domain=$_SERVER['SERVER_NAME'];
 return "$http"."$domain"."$part";
}
?>