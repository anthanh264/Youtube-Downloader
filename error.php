<?php
header("HTTP/1.0 404 Not Found");
$headtitle = 'Lỗi！';
include("./header.php");?>

<div class="container-fluid" style="height: 480px;
    background-color: #dbdbdb;">
    <div class="container" style="height: 100%">
        <div class="row" style="height: 100%">
 <div class="col-12 justify-content-center align-self-center text-center">
     <img src="//wx3.sinaimg.cn/large/b0738b0agy1fm04l0cw4ej203w02s0sl.jpg" class="p-2" >
      <h2> Nội dung yêu cầu không tồn tại! </h2>
      <p> Rất tiếc, nội dung bạn yêu cầu không hiển thị! </p>
      <p> Nguyên nhân có thể do: </p>
      <p> 1. Liên kết bạn nhập không chính xác! </p>
      <p> 2. Video là nội dung bản quyền (trang này không thể giải quyết nội dung bản quyền!) </p>
      <p> 3. Video không tồn tại. </p>
      <p> 4. Lỗi máy chủ trang web.</p>
  </div>

  </div>
    </div>
  
</div>


<?php
include("./footer.php"); 
?>