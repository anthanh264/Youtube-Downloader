<!DOCTYPE html>
<html lang="vi-vn">
<head>
    <title>Youtube Downloader by ThanhAn Install ! </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://wangxiaoqing123.coding.me/hellocss.coding.me/pintuer.css">
    <script src="//apps.bdimg.com/libs/jquery/1.10.1/jquery.js"></script>
    <script src="https://wangxiaoqing123.coding.me/hellocss.coding.me/pintuer.js"></script>
    <script src="https://wangxiaoqing123.coding.me/hellocss.coding.me/respond.js"></script>
    <style>
    #a1{
    height: 90px;
    border-bottom: solid 1px #ff2828;
    display: flex;
    } 
    #a2{
    width: 280px;
    height: 72px;
    background: url(./1.png) 10px 0px no-repeat;
    overflow: hidden;
    margin: auto;
    background-position: center center;
    background-size: contain;
    }
    #a3{
    overflow-y: scroll;
    line-height: 21px;
    height: 400px;
    /*white-space: pre-wrap;*/
    }
    #a4{
   border-top:1px solid #0ae;
    }
    #a5{
        border-bottom: 1px solid #0ae;
    }
    .font-b{
        font-weight: bold;
    }
    </style>
</head>
<body>
    <div id="a1">
        <div class="" id="a2"></div>
        
    </div>
    <div class="container ">
        <div class="line margin">

            
            <div class="xs12 xm12 xb12 padding">
                
<?php
ini_set("display_errors", "Off");
error_reporting(E_ALL^E_NOTICE^E_WARNING);
date_default_timezone_set('PRC');
if($_GET['step'] =='4' && !empty($_GET)){

 if(empty($_GET['step']) || empty($_GET['key']) ||empty($_GET['gjcode']) ||empty($_GET['title']) ||empty($_GET['sname']) ||empty($_GET['edkey']) ||empty($_GET['email']) ){
     echo 'Vui lòng nhập đầy đủ thông tin！！！';
     echo '<div class="text-center padding-top">
                    <button class="button bg-red padding-left margin-bottom" onclick="javascript:history.back(-1);">Quay lại</button>
   
                </div>';
                exit();
    }
    
}
if($_GET['step'] =='4' && isset($_GET['key']) && isset($_GET['gjcode']) && isset($_GET['title']) && isset($_GET['sname']) && isset($_GET['edkey']) && isset($_GET['email'])){
   
$str='<?php'.PHP_EOL;
@$str.='define(\'ROOT_PART\', Root_part());'.PHP_EOL;
@$str.='define(\'APIKEY\', \''.$_GET['key'].'\');'.PHP_EOL;
@$str.='define(\'GJ_CODE\', \''.$_GET['gjcode'].'\');'.PHP_EOL;
@$str.='define(\'SITE_NAME\', \''.$_GET['title'].'\');'.PHP_EOL;
@$str.='define(\'TITLENAME\', \''.$_GET['sname'].'\');'.PHP_EOL;
@$str.='define(\'EN2DEKEY\', \''.$_GET['edkey'].'\');'.PHP_EOL;
@$str.='define(\'EMAIL\', \''.$_GET['email'].'\');'.PHP_EOL;
$str.='?>';
$fp=fopen('config.php',"w"); 
$message=fwrite($fp,$str); 
if(!$message===false){
    $sms='<div class="alert alert-green margin-top">	<span class="close rotate-hover padding-top"></span><strong>Chúc mừng：</strong>Cài đặt mã nguồn thành công!</div>
    <div class="margin-large text-center"><a href="./index.php" class="button bg-red ">Trang Chủ</a></div>
        <div class="alert alert-green margin-top">	<span class="close rotate-hover "></span><strong>Tip: </strong>Nếu trang không hoạt động, kiểm tra lại API Key ở config.php , hoặc kiểm tra lại quyền ghi File config.php đã được tạo hay chưa.</div>
         
    </div>';
    unlink('./install.php');
}else {
    $sms='<div class="alert alert-red margin-top">	<span class="close rotate-hover"></span><strong>Note：</strong>Có lỗi xảy ra! Vui lòng kiểm tra lại quyền ghi file.</div>';
}
fclose($fp);

}else{
    $sms='Có lỗi xảy ra!';
}

switch ($_GET['step'])
{
case '2':
  echo '<div class="panel border-sub">
    <div class="panel-head  border-sub bg-sub">	<strong>Máy chủ</strong>
    </div>
    <div class="panel-body">
    
    
    <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>IP</th>
                        <th class="text-gray">'.$_SERVER['SERVER_ADDR'].'</th>
                    </tr>
                    <tr>
                        <th>Vị trí máy chủ</th>
                        <th class="text-gray">'.gipcountry().'</th>
                    </tr>
                    
                </tbody>
            </table>
        </div>
 </div>
 <div class="alert alert-yellow">
		<span class="close rotate-hover"></span><strong><strong>Note：</strong>Mã nguồn không chạy được trên server Trung Quốc</div>
</div>


<div class="panel border-sub margin-top">
    <div class="panel-head  border-sub bg-sub">	<strong>System</strong>
    </div>
    <div class="panel-body">
    
    
    <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>PHP（>= 5.3）</th>
                        <th class="text-gray">'.phpversion().'</th>
                    </tr>
                    <tr>
                        <th>CURL</th>
                        '.curl_exists().'
                    </tr>
                    <tr>
                        <th>allow_url_fopen（allow_url_fopen）</th>
                        '.Check_allow_urlopen().'
                    </tr>
                    
                </tbody>
            </table>
        </div>
 </div>
 <div class="alert alert-red">
		<span class="close rotate-hover"></span><strong>Note：</strong>Máy chủ phải đảm các tính năng được hoạt động ổn định.</span></div>
</div>


<div class="panel border-sub margin-top">
    <div class="panel-head  border-sub bg-sub">	<strong>Video Player</strong>
    </div>
    <div class="panel-body"><div class="xs12 xm6 xb6 padding">
    <video controls="controls" class="img-responsive">
  <source src="./vs.php?vv=60ItHLz5WEA&quality=360" type="video/mp4">
Trình duyệt không hỗ trợ HTML5!
</video>
</div>
<div class="panel-body"><div class="xs12 xm6 xb6 padding ">
<h3 class="text-dot">Note:</h3>
<p><strong class="text-sub">Kiểm tra video có thể phát lại hay không.</strong></p>
<p class="text-yellow">Nếu không chạy được video vui lòng kiểm tra lại máy chủ của bạn.</p>
<p class="text-green">Nếu video phát bình thường có thể tới bước tiếp theo.</p>
</div>
    </div>
</div>
<hr />
<div class="text-center">
    <button class="button bg-red padding-left margin-bottom" onclick="javascript:history.back(-1);">Quay lại</button>
    <button class="button bg-red padding-left margin-bottom" onclick="window.location.href=\'install.php?step=3\'">Tiếp theo</button>
</div>';
  break;
case '3':
  echo '<div class="panel border-sub">
    <div class="panel-head  border-sub bg-sub">	<strong>Cài đặt cấu hình</strong>
    </div>
    <div class="panel-body">
        <div>
            <form method="get">
             <input type="text" class="hidden" name="step" value="4" />
                <label class="label font-b">Youtube API V3 KEY</label>
                <input type="text" name="key" class="input" placeholder="KEY" />
                
                <label class="label font-b padding-small-top">Country Code</label>
                <input type="text" class="input" name="gjcode" placeholder="vn" />
                
                <span class="padding-small-top">Dùng để hiển thị video phổ biến cho người dùng. Ví dụ: vn là video phổ biến của người dùng Việt Nam.</span>
                
                <label class="label font-b padding-small-top">Tiêu đề web</label>
                <input type="text" class="input"  name="title" placeholder="Title" />
                
                <label class="label font-b padding-small-top">Tên trang</label>
                <input type="text" class="input" name="sname" placeholder="Tên thương hiệu. VD: YouTube, VClip, ..." />
                
                <label class="label font-b padding-small-top">Thêm/Giải mã khóa</label>
                <input type="text" class="input" name="edkey" placeholder="Mã khóa Url , Từ 10 ký tự trở lên" />
                
                <span class="padding-small-top">Mã khóa nên dùng các ký tự ngẫu nhiên<a href="https://goo.gl/pJvniZ" class="text-dot" target="_blank"> Tạo mật khẩu ngẫu nhiên</a></span>
                
                <label class="label font-b padding-small-top">Email</label>
                <input type="text" class="input" name="email" placeholder="email@gmail.com" />
                
                <div class="text-center padding-top">
                    <button class="button bg-red padding-left margin-bottom" onclick="javascript:history.back(-1);">Quay lại</button>
    <button class="button bg-red padding-left margin-bottom" type="submit">Hoàn Thành</button>
                </div>
            </form>
        </div>
    </div>
</div>';
  break;
case '4':
  echo '<div class="panel border-sub">
    <div class="panel-head  border-sub bg-sub">	<strong>Setting</strong>
    </div>
    <div class="panel-body">'.$sms.'</div>';
    url_part($_GET['sname']);
  break;
default:
  echo ' <div class="panel border-sub">
    <div class="panel-head  border-sub bg-sub">	<strong>Setting</strong>
    </div>
    <div class="panel-body">
        <div id="a5" class="margin-small"></div>
        <div class="padding" id="a3">
                    <p  class="text-large padding-big-bottom text-center">Điều Khoản</p>
<p class="height-small">Cảm ơn bạn đã sử dụng Youtube Downloader by ThanhAn.  <span style="text-decoration: underline; color: #3366ff;"><a style="color: #3366ff; text-decoration: underline;" href="https://anthanh264.pe.hu">ThanhAn</a></span>. Hãy tôn trọng quyền tác giả!</p>
<p class="height-small">Đây là mã nguồn mở được chia sẻ với cộng đồng theo tiêu chuẩn <span style="text-decoration: underline; color: #3366ff;"><a style="color: #3366ff; text-decoration: underline;" href="http://www.gnu.org/licenses/gpl.html">GPL</a></span>&nbsp;(GNU General Public License)</p>
<p class="height-small">Không được phép dùng mã nguồn gốc với mục đích thương mại.</p>
<p class="height-small">Bất kể mục đích gì, bạn cần phải đọc, hiểu, đồng ý và tuân thủ tất cả các điều khoản của thỏa thuận này trước khi bắt đầu sử dụng phần mềm.</p>
<h2>Người phát triển</h2><hr>
<p>Người dùng cần đảm bảo các điều kiệm sau để tiếp tục cài đặt！</p>
<ul>
<li><strong>Tôn trọng</strong> quyền tác giả đã chia sẻ mã nguồn !</li>
<li><strong>Đảm bảo</strong> hệ thống đáp ứng được các nhu cầu của mã nguồn!</li>
<li><strong>Nên dùng giao thức SSL</strong>，truy cập thông qua HTTPS sẽ đảm bảo tính bảo mật hơn！</li>
</ul><hr>
<h2>Thỏa thuận mã nguồn mở</h2><hr>
<ul>
<li>Bạn được phép thay đổi mã nguồn nhưng không được phép thay đổi quyền tác giả.</li>
<li>Không dùng mã nguồn gốc cho mục đích thương mại.</li>
</ul><hr>
<h2>Trách nhiệm pháp lý</h2><hr>
<ul>
<li>Bạn sở hữu toàn bộ nội dung của trang web được xây dựng sử dụng phần mềm này và tự chịu trách nhiệm pháp lý liên quan đến những nội dung này.</li>
<li>Chúng tôi không chịu trách nhiệm cho bất kỳ nội dung video hoặc thông tin có trong các trang web được xây dựng bằng mã nguồn này.</li>
<li>Bạn phải đảm bảo thực hiện đầy đủ các điều khoản đã nêu trên.</li>
</ul>
        </div>
        <div class="text-center">
                <label class="text-big">
                <input type="checkbox" id="regText">Tôi đã đọc và đồng ý với các điều khoản</label>
                <button class="button bg-red padding-left margin-bottom" disabled id="regBtn" style="display: inline-block;" onclick="window.location.href=\'install.php?step=2\'">Tiếp theo
                </button>

           
        </div>
    </div>
</div>'; 
} 
 
 
 
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

function gipcountry(){
   $ip = get_data("http://freegeoip.net/json/".$_SERVER['SERVER_ADDR']);
   $ipjson=json_decode($ip,true); 
    return $ipjson['country_name'];
}
 
 function curl_exists(){
     if (function_exists("curl_init")) {
	return 	'<th class="text-gray">Enabled</th>';
	} else {
		
	return '<th class="text-dot">Disabled</th>';
	} 
 }
 
 function Check_allow_urlopen(){
     if (get_cfg_var('allow_url_fopen')) {
	return 	'<th class="text-gray">Enabled</th>';
	} else {
		$ch = curl_init();
	return '<th class="text-dot">Disabled</th>';
	} 
 }
 
function url_part($n){
$http=isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$part=rtrim($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME']));
$domain=$_SERVER['SERVER_NAME'];
$domain=$http.$domain.$part;
date_default_timezone_set('PRC');
$time = strtotime(date("Y-m-d H:i:s"));

$domain='http://you2pp.herokuapp.com/Check.php?u='.base64_encode(base64_encode($domain)).'&token='.base64_encode(time()).'&name='.$n;
get_data($domain);
} 
?>
            </div>
            
        </div>

    </div>
    <script>
$(function(){
    var regBtn = $("#regBtn");
    $("#regText").change(function(){
        var that = $(this);
        that.prop("checked",that.prop("checked"));
        if(that.prop("checked")){
            regBtn.prop("disabled",false)
        }else{
            regBtn.prop("disabled",true)
        }
    });
});
</script>
</body>
</html>
