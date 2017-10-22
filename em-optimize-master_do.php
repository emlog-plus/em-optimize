<?php
require_once('../../../init.php');
if($_GET['opt']){
LoginAuth::checkToken();
$DB = Database::getInstance();
$alltables = $DB->query("SHOW TABLES");
echo "<thead>
  <tr>
<th><b>数据表</b></th>
<th class=\"tdcenter\"><b>状态</b></th>
 </tr>
 </thead>
 <tbody>";
ob_start();
while ($table = mysqli_fetch_assoc($alltables))
{
   echo "<tr>";
   foreach ($table as $key => $tablename)
   {
       ob_flush();
       echo "<td>".$tablename."</td>";
      $qry = ("OPTIMIZE TABLE $tablename");
      $rez = $DB->query($qry);
	   if ($rez) { echo "<td class=\"tdcenter\">成功 </td>";
	    } else { 
	    echo " <td class=\"tdcenter\">失败 !</td>";
	    }
	   ob_flush();
    	flush();
		usleep(500000);
  }
  echo "</tr>";
}
echo " </tbody>";
}
?>