<?

if($_SESSION['EEMAL']==1){
		
				$dataemail = $i->array_query2("select titulo_admin,admin_email from tbl_setup");
			
				include("../class/email.php");
				$mail = new email(); 
				
				
				$mail->From = $dataemail[1];
				$mail->FromName = $dataemail[0];
				$mail->AddAddress($_POST['email'], $_POST['nombre']);
				//$mail->AddAddress("ellen@example.com");                  // name is optional
				$mail->AddReplyTo($dataemail[1],LANG_ADMIN_admini);
				
				$mail->WordWrap = 90;                                 // set word wrap to 50 characters
				//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
				//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
				$mail->IsHTML(true);                                  // set email format to HTML
				
				$mail->Subject = LANG_email_subj_ins;
				$mail->Body    = '<font size="10px" style="font-family:Verdana, Arial, Helvetica, sans-serif">
							<table width="583" border="0" align="center">
							  <tr>
								<td width="577" height="42" align="center" bgcolor="#C7D8D0"><h5>'.LANG_email_mes1_ins.'</h5></td>
							  </tr>
							  <tr>
								<td height="80" bgcolor="#D1D7BF"><h6>'.LANG_emai2_mes2_ins.'</h6></td>
							  </tr>
							  <tr>
								<td height="39" align="center" bgcolor="#FFFFFF"><h6>'.LANG_email_mes3_ins.'</h6></td>
							  </tr>
							  <tr>
								<td height="94" align="center" bgcolor="#FFFFFF"><table width="335" border="0" cellpadding="5" cellspacing="5">
								  <tr>
									<td width="75"><h5>'.LANG_login.'</h5></td>
									<td bgcolor="#C7D8D0" width="225"><h5>'.$_POST['login1'].'</h5></td>
									</tr>
								  <tr>
									<td><h5>'.LANG_pass.'</h5></td>
									<td bgcolor="#C7D8D0"><h5>'.$_POST['pass1'].'</h5></td>
									</tr>
								  
								</table></td>
							  </tr>
							  <tr>
								<td height="52" bgcolor="#FFFFBF"><h6>'.LANG_email_mes4_ins.' '.$dataemail[1].'</h6></td>
							  </tr>
							</table></font>';
				
				
				
				
				$mail->AltBody = LANG_email_mes1_ins.'\n\r'.LANG_emai2_mes2_ins.'\n\r'.LANG_email_mes3_ins.'\n\r'.LANG_login.' '.$_POST['login1'].'\n\r'.LANG_pass.' '.$_POST['pass1'].'\n\r'.LANG_email_mes4_ins.' '.$dataemail[1];
				
				if(!$mail->Send())
				{
				   echo LANG_email_nosend;
				   echo "Mailer Error: " . $mail->ErrorInfo;
				   exit;
				}

					
		
 }	

?>