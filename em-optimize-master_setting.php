<?php 
/**
 * 数据库优化
 * @copyright (c) crazyus.us All Rights Reserved
 */
!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view() {
/*Load the language*/
include(EMLOG_ROOT."/content/plugins/em-optimize-master/lang/".Option::get('language').".php");
/*end*/
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
 <li><a href="./"><i class="fa fa-home"></i> <?php echo $_lang['home'] ?></a></li>
<li class="active"> <?php echo $_lang['optimize'] ?> </li>
 </ul>
</div>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default card-view">
<div class="panel-body"> 
<?php echo $_lang['tips'] ?>
</div>
<div id="cache">
<div class="form-group text-center">
  <a  id="opt" class="btn btn-info button"/><?php echo $_lang['button'] ?></a>
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
<th><b> <?php echo $_lang['name'] ?> </b></th>
<th class="tdcenter"><b> <?php echo $_lang['size'] ?> </b></th>
<th class="tdcenter"><b> <?php echo $_lang['record'] ?> </b></th>
<th class="tdcenter"><b> <?php echo $_lang['overhead'] ?> </b></th>
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
      $nrs =$nrs +$rowss;?> <?php echo $_lang['format'] ?>
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
 <td><?php echo $_lang['total'] ?><sup><?php echo $rs ?> <?php echo $_lang['formats'] ?> </sup></td>
  <td> <?php echo format_size($tot);?> </td>
   <td> <?php echo $nrs ?> <?php echo $_lang['format'] ?></td>
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
$("#optimized").html('<img src="<?php echo BLOG_URL ?>content/plugins/em-optimize-master/loading.gif" style="width:12px;height:12px"/> <a style="color:#666;" rel="external nofollow" title="<?php echo $_lang['doing'] ?>" id="opt" > <?php echo $_lang['doing'] ?>....</a>');	
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