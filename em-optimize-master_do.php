<?php
require_once('../../../init.php');
if($_GET['opt']){
/*Load the language*/
require_once(EMLOG_ROOT . "/content/plugins/em-optimize-master/lang/".Option::get('language').".php");
/*end*/
LoginAuth::checkToken();
$DB = Database::getInstance();
$alltables = $DB->query("SHOW TABLES");
echo "<thead>
  <tr>
<th><b>".$_lang['name']."</b></th>
<th class=\"tdcenter\"><b>".$_lang['state']."</b></th>
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
	   if ($rez) { echo "<td class=\"tdcenter\"> ".$_lang['succ']."  </td>";
	    } else { 
	    echo " <td class=\"tdcenter\">".$_lang['fail']."  !</td>";
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