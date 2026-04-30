													<select name='Title' >
													<option value=''>선택하세요&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
													<?
													include "../common/dbconn.php";
													$query="select code,title FROM $shop_goods";  
													//echo "$query";
													$result= mysql_query($query,$DB);
											
										   			$total_record = $rn;
														for($i = 0; $i < $total_record; $i++){ 
															$N_Id =$rs[$i][0];
															$N_Name =$rs[$i][1];
													?>				
													<option value="<?=$N_Id?>" <?if($N_Id==$Title){?>selected<?}?>><?=$N_Id?>(<?=$N_Name?>)</option>
													<?}?>
													</select>