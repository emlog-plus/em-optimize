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
echo '<li><a href="./plugin.php?plugin=em-optimize-master" id="optimizedb">数据库优化</a></li>';
}
addAction('adm_sidebar_ext', 'db_menu');
?>