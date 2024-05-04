<?php 
 include('_config.php'); 
 $error = ''; 
 $good = false; 
 if( !empty($_POST) ) 
 { 
  if( empty($_POST['full_name']) ) $error[] = 'Вы забыли указать Ф.И.О.'; 
  if( !isset($_POST['sex']) || intval($_POST['sex'])>1 ) $error[] = 'Вы что, какого-то неопределенного пола?'; 
  if( empty($_POST['birthday']) || $_POST['birthday']<1970 || $_POST['birthday']>1992 ) $error[] = 'Ваш возраст не приемлим'; 
  if( !isset($_POST['status']) || intval($_POST['status'])>count($_m_status)-1 ) $error[] = 'Определитесь, пожалуста, с вашим симейным положением'; 
  if( !isset($_POST['education']) || intval($_POST['education'])>count($_education)-1 ) $error[] = 'Вы хоть где-то учились?'; 
  if( !isset($_POST['experience']) || intval($_POST['experience'])>count($_experience)-1 ) $error[] = 'Лентяйство - это плохо!'; 
  if( !isset($_POST['salary']) || intval($_POST['salary'])>count($_salary) ) $error[] = 'Вам что, деньги не нужны?'; 
  if( empty($error) ) 
  { 
   $mlink = mysql_connect($sql_host, $sql_user, $sql_pass); 
   mysql_query('SET NAMES cp1251'); 
   mysql_select_db($sql_dbnm); 
   $sql = 'INSERT INTO candidats VALUES (0, '; 
  $sql .= "'".mysql_real_escape_string($_POST['full_name'])."', "; 
   $sql .= intval($_POST['sex']).', '; 
   $sql .= intval($_POST['birthday']).', '; 
   $sql .= intval($_POST['status']).', '; 
   $sql .= intval($_POST['education']).', '; 
   $sql .= intval($_POST['experience']).', '; 
   $sql .= intval($_POST['salary']).', '; 
   $sql .= isset($_POST['lang'])?'1, ':'0, '; 
   $sql .= isset($_POST['conviction'])?'1':'0'; 
   $sql .= ','.intval($_POST['vac']).','; 
   $sql.= "'".mysql_real_escape_string($_POST['contact'])."')"; 
   #echo $sql; 
   mysql_query($sql); 
   #echo mysql_error(); 
   mysql_close($mlink); 
   $good = true; 
  } 
 } 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd"> 
<html> 
<head> 
 <title>Подача анкеты для приема на работу в <?php echo htmlspecialchars($_orgname); ?></title> 
 <style type="text/css"> 
  html{ background:#dddddd; margin:0; padding:0;} 
  body{ margin:0px auto; margin-bottom:10px; padding:0px; width:902px; background:#b0b0ff; border-left:4px solid #bbbbbb; border-right:4px solid #bbbbbb; border-bottom:4px solid #bbbbbb; } 
  h1{ margin-bottom:25px; color:#2f2f2f; font:bold 22px Times; text-align:center; } 
  table{ border:2px solid #555555; background:#eeeeee; } 
  th{ text-align:left; } 
  input{ padding:2px 5px; } 
  select{ width:100%; } 
  .md{ padding-bottom:40px; border-left:1px solid #888888; border-bottom:1px solid #888888; border-right:1px solid #888888; } 
 </style> 
</head> 
<body> 
<div class="md"> 
<img src="head.jpg"/> 
<h1>Подача анкеты для приема на работу в <?php echo htmlspecialchars($_orgname); ?></h1> 
<?php 
 if( $good ) 
  echo '<center><b>Спасибо, ваша анкета принята на рассмотрение.</b></center>'; 
 else 
 { 
  if( !empty($error) ) 
  { 
?> 
   <table align="center" border="0" cellpadding="10" style="margin-bottom:25px; border:1px solid red;"> 
   <tr><th>Во время заполнения анкеты были допущены ошибки :</th></tr> 
   <tr><td><?php echo implode('<br/>', $error); ?></td></tr> 
   </table> 
<?php 
  } 
?> 
<form action="" method="post"> 
<table align="center" border="0" cellspacing="20px" > 
<tr><th>Ф.И.О. :</th><td><input type="text" name="full_name"/></td></tr> 
<tr> 
 <th>Ваш пол :</th> 
 <td><select name="sex"> 
   <option value="1">мужской</option> 
   <option value="0">женский</option> 
  </select></td> 
</tr> 
<tr><th>Год рождения (гггг) :</th><td><input type="text" maxlength="4" name="birthday"/></td></tr> 
<tr> 
 <th>Семейное положение :</th> 
 <td><select name="status"> 
<?php 
 foreach($_m_status as $key=>$value) 
  echo '  <option value="'.$key.'">'.$value.'</option>',"\r\n"; 
?> 
 </select></td> 
</tr> 
<tr> 
 <th>Образование :</th> 
 <td><select name="education"> 
<?php 
 foreach($_education as $key=>$value) 
  echo '  <option value="'.$key.'">'.$value.'</option>',"\r\n"; 
?> 
 </select></td> 
</tr> 
<tr> 
 <th>Должность :</th> 
 <td><select name="vac"> 
<?php 
 foreach($_vacancy as $gr=>$ar) 
 { 
  echo '  <optgroup label="'.htmlspecialchars($gr).'">',"\r\n"; 
  foreach( $ar as $key=>$val ) 
   echo '   <option value="'.$key.'">'.htmlspecialchars($val).'</option>',"\r\n"; 
  echo '  </optgroup>',"\r\n"; 
 } 
?> 
 </select></td> 
</tr> 
<tr> 
 <th>Стаж работы :</th> 
 <td><select name="experience"> 
<?php 
 foreach($_experience as $key=>$value) 
  echo '  <option value="'.$key.'">'.$value.'</option>',"\r\n"; 
?> 
 </select></td> 
</tr> 
<tr> 
 <th>Желаемый месячный оклад :</th> 
 <td><select name="salary"> 
<?php 
 foreach($_salary as $key=>$value) 
  echo '  <option value="'.$key.'">'.$value.'</option>',"\r\n"; 
?> 
 </select></td> 
</tr> 
<tr><th>Знание иностранных языков :</th><td><input type="checkbox" name="lang"/></td></tr> 
<tr><th>Наличие судимости :</th><td><input type="checkbox" name="conviction"/></td></tr> 
<tr><th>Контактные данные :</th><td><textarea rows="3" style="width:100%" name="contact"></textarea></td></tr> 
<tr><td colspan="2" align="center"><input type="submit" value="Подать анкету на рассмотрение"/></td></tr> 
</table> 
</form> 
<?php 
 } 
?> 
<div></body> 
</html> 
