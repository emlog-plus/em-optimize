<?php 
/**
 * 数据库优化
 * @copyright (c) crazyus.us All Rights Reserved
 */
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view() {
 $DB = Database::getInstance();
   function format_size($size) {
	$measure = "Byte";
	    if ($size >= 1024) {
				$size = $size / 1024;
				$measure = "KiB";
			}
           if ($size >= 1024) {
				$size = $size / 1024;
				$measure = "MB";
			}
               $return = sprintf('%0.4s',$size);
           if (substr($return, -1) == "." ) $return = substr($return, 0, -1);
                return $return . " ". $measure;
		}
?>
<script type="text/javascript">
$("#menu_mg").addClass('active');
$("#optimizedb").addClass('active-page');
setTimeout(hideActived,2600);
</script>
<div class="heading-bg  card-views">
<ul class="breadcrumbs">
 <li><a href="./"><i class="fa fa-home"></i> 首页</a></li>
<li class="active">数据库优化</li>
 </ul>
</div>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default card-view">
<div class="panel-body"> 
<span style="color: #ff0000;">友情提示:</span> 如果数据多的话,会有点慢,请耐心等待哦
</div>
<div id="cache">
<div class="form-group text-center">
  <a  id="opt" class="btn btn-info button"/>开始优化</a>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default card-view">	
<div class="table-wrap ">
<div class="table-responsive">	
<table class="table table-striped table-bordered mb-0" id="optimized">
<thead>
  <tr>
<th><b>数据表</b></th>
<th class="tdcenter"><b>大小</b></th>
<th class="tdcenter"><b>记录</b></th>
<th class="tdcenter"><b>多余</b></th>
 </tr>
 </thead>
 <tbody>
 <?php
 $tables = array();
 $result = $DB->query("SHOW TABLE STATUS");
 $tot =0; 
 $rs =0;
 $nrs=0;
while($row = $DB->fetch_array($result)) {
 $total_size = $row[ "Data_length" ] +  $row[ "Index_length" ];$gain= $row['Data_free'];
$total_gain += $gain;
$gain = round ($gain,2);$tbl = $row['Name'];
$rs++;
$tot = $tot + $total_size;?><tr>
<td> <?php echo $tbl?></td>
<td class="tdcenter"> <?php echo format_size($total_size);?></td>
<td class="tdcenter">
<?php
      $q=("select * from $tbl");
      $rez= $DB-> query($q);
      echo $rowss= $DB-> num_rows($rez);
      $nrs =$nrs +$rowss;?> 条
</td>
<?php 
if ($gain == 0){
?>
<td class="tdcenter">
 0 KiB
</td>
<?php }else{ ?>
<td class="tdcenter" style=\"color: #ff0000;\">
<?php echo format_size($gain) ?>
</td>
<?php } ?>
</tr>
<?php }?>
 <tr>
 <td>统计<sup><?php echo $rs ?>个数据表</sup></td>
  <td> <?php echo format_size($tot);?> </td>
   <td> <?php echo $nrs ?> 条</td>
  <td> <?php echo format_size($total_gain);?> </td>
  </tr>
</tbody>
</table>
 </div> 
 </div> 
 </div> 
 </div>
 </div>
 <script>
$(document).on("click","#opt",function(){
$("#optimized").html('<img src="<?php echo BLOG_URL ?>content/plugins/em-optimize-master/loading.gif" style="width:12px;height:12px"/> <a style="color:#666;" rel="external nofollow" title="优化中" id="checkbaidu" > 优化中....</a>');	
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
document.getElementById("optimized").innerHTML=xmlhttp.responseText;
    }
  }
var url="";
url="<?php echo BLOG_URL ?>content/plugins/em-optimize-master/em-optimize-master_do.php?opt=suc&token=<?php echo LoginAuth::genToken(); ?>";
xmlhttp.open("GET",url,true);
xmlhttp.send();	
})
</script>
<?php
}
?>