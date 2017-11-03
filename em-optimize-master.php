<?php
/*
Plugin Name: 优化数据库
Version: 1.0
Plugin URL: https://crazyus.us
Description: 后台直接优化 MySQL 数据表, 使用OPTIMIZE TABLE 优化表空间,回收空间,减少碎片
ForEmlog:6.0
Author:Flyer
Author Email: gao.eison@gmail.con
Author URL: https://crazyus.us
*/
!defined('EMLOG_ROOT') && exit('access deined!');

function db_menu()
{
/*Load the language*/
require_once(EMLOG_ROOT . "/content/plugins/em-optimize-master/lang/".Option::get('language').".php");
/*end*/
echo '<li><a href="./plugin.php?plugin=em-optimize-master" id="optimizedb">'.$_lang['optimize'].'</a></li>';
}
addAction('adm_sidebar_ext', 'db_menu');
?>