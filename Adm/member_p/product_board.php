													<select name='id' >
													<option value=''>선택하세요&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
													<?
													$query_po="select code,title FROM $shop_goods";  
													
													$result_po= mysql_query($query_po,$DBconn);
											
										   			$total_record_po = mysql_num_rows($result_po);
														for($pi = 0; $pi < $total_record_po; $pi++){ 
															$N_Id = mysql_result($result_po,$pi,0);
															$N_Name = mysql_result($result_po,$pi,1);
													?>				
													<option value="<?=$N_Id?>" <?if($N_Id==$id){?>selected<?}?>><?=$N_Id?>(<?=$N_Name?>)</option>
													<?}?>
													</select>