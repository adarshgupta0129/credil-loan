<?php
	class crud_model extends CI_Model
	{
		
		public function __construct()
		{
			parent::__construct();     
		//	$this->session->set_userdata('current_url',current_url());
		}	


	/*
			|		SEND EMAIL CODE
		*/
		public function send_email($to=NULL,$subject=NULL,$message=NULL,$mailfor=NULL)
		{
			
			$config = array (
			'protocol' => 'smtp',
			'smtp_host'=> EMAIL_SEND_URL,	
			'smtp_user'=> EMAIL,	
			'smtp_pass'=> EMAIL_PASSWORD,
			'charset'  => 'utf-8',
			'priority' => '1'
			);
			$this->email->initialize($config);
			$this->email
			->set_newline("\r\n")
			->from(EMAIL,$mailfor)			 			
			->to(trim($to))								
			->subject($subject)
			->message($message)
			->set_mailtype('html');
			if(EMAIL_SEND_STATUS==1)
			{
				if($this->email->send())
				return 1;
				else
				return $this->email->print_debugger();
			}
			else
			{
				return 1;
			}
		}
		
		/*
			|		SEND SMS CODE
		*/	
		public function send_sms($mob,$msg)
		{
			$url = SMS_SEND_URL;
			$params = array (
			'AUTH_KEY'=>SMS_AUTH,
			'message'=>$msg,
			'senderId'=>SMS_SENDERID,
			'routeId'=>1,
			'mobileNos'=>$mob,
			'smsContentType'=>'english'
			);
			
			$options = array(
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0
			);
			
			$defaults = array(
			CURLOPT_URL => $url. (strpos($url, '?') 
			=== FALSE ? '?' : ''). http_build_query($params),
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT =>56
			);
			
			$ch = curl_init();
			curl_setopt_array($ch, ($options + $defaults));
			$result = curl_exec($ch);
			if(!$result)
			{
				trigger_error(curl_error($ch));
				$flag=0;
			}
			else
			{	                
				$flag=1;
			}
			curl_close($ch);
			//echo $result;
		}
		
		public function profile_percent()
		{
			$data=array(
			'USER_REG'	=>	$this->session->userdata('profile_id')
			);
			$query = " CALL sp_profiler(?" . str_repeat(",?", count($data)-1) . ") ";
			return $this->db->query($query, $data)->row()->percentage;
		}

		public function menu_limit()
		{
			$data=array(
			'USER_REG'	=>	$this->session->userdata('profile_id')
			);
			$query = " CALL sp_profiler(?" . str_repeat(",?", count($data)-1) . ") ";
			return $this->db->query($query, $data)->row()->MENU_STATUS;
		}
		
    	public function check_permission()
		{
			$bank=$this->db->get_where('m04_user_bank',array('or_m_id'=>$this->session->userdata('profile_id'),'or_m_b_primary'=>1));
			$user=$this->db->get_where('m03_user_detail',array('or_m_reg_id'=>$this->session->userdata('profile_id')));
			if($bank->num_rows>0 && $user->num_rows>0)
			{
			if((($bank->row()->or_m_bid!='' && $bank->row()->or_m_bid!=0 )||($user->row()->or_m_perfect!='' && $user->row()->or_m_perfect!=0)) && $user->row()->or_m_name!='' )
			{
				return 1;	
			}
			else
			{
				return 0;
			}
			}
			else
			{
				return 0;
			}
		}
		
		
		
		public function admin_send_email($to=NULL,$subject=NULL,$message=NULL,$mailfor=NULL)
		{
			
			$config = array (
            'protocol' => 'smtp',
            'smtp_host'=> EMAIL_SEND_URL,	
            'smtp_user'=> EMAIL,	
            'smtp_pass'=> EMAIL_PASSWORD,
            'charset'  => 'utf-8',
            'priority' => '1'
			);
			
			$this->email->initialize($config);
			$this->email
            ->set_newline("\r\n")
            ->from(EMAIL,$mailfor)			 			
            ->to(trim($to))								
            ->subject($subject)
            ->message($message)
            ->set_mailtype('html');
			
			if(EMAIL_SEND_STATUS==1)
			{	
				if($this->email->send())				
               // return 1;
				return $this->email->print_debugger();
				else				
                //return 0;
				return $this->email->print_debugger();
			}
			else
			{
				return 1;
			}
		}
		
		public function topdf($page_path, $data = null, $title = null)
		{
			$this->load->library('m_pdf');		
			$html = $this->load->view($page_path, $data, true);
			$pdfFilePath = $title."-".time()."-download.pdf";
			$pdf = $this->m_pdf->load();
			$pdf->WriteHTML($html,2);
			$pdf->Output($pdfFilePath, "D");
		}
		
		public function toexcel($post_data, $data = null, $title = null)
		{
			require_once APPPATH.'libraries/PHPExcel.php';
			$this->excel = new PHPExcel(); 
			$filename = "DownloadReport.xls";
			$table    = $post_data;

			// save $table inside temporary file that will be deleted later
			$tmpfile = tempnam(sys_get_temp_dir(), 'html');
			file_put_contents($tmpfile, $table);

			// insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
			$objPHPExcel     = new PHPExcel();
			$excelHTMLReader = PHPExcel_IOFactory::createReader('HTML');
			$excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);
			$objPHPExcel->getActiveSheet()->setTitle('any name you want'); // Change sheet's title if you want

			unlink($tmpfile); // delete temporary file because it isn't needed anymore

			header('Content-Type: text/html; charset=utf-8');
			header('Content-type: application/ms-excel');
			header('Content-Disposition: attachment;filename='.$filename); // specify the download file name
			header('Cache-Control: max-age=0');

			// Creates a writer to output the $objPHPExcel's content
			$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$writer->save('php://output');
			exit; 


/*			include(APPPATH."libraries/simple_html_dom.php");
			$html = str_get_html(implode($post_data));
			header('Content-type: application/ms-excel');
			header("Content-Disposition: attachment; filename=".$title.".csv");
			ini_set("max_execution_time", '5000');
			ini_set("post_max_size", '60M');
			$fp = fopen("php://output", "w");
			$csvString="";

			foreach($html->find('tr') as $element)
			{

				$td = array();
				foreach( $element->find('th') as $row)
				{
					$row->plaintext="\"$row->plaintext\"";
					$td [] = $row->plaintext;
				}
				$td=array_filter($td);
				$csvString.=implode(",", $td);

				$td = array();
				foreach( $element->find('td') as $row)
				{
					$row->plaintext="\"$row->plaintext\"";
					$td [] = $row->plaintext;
				}
				$td=array_filter($td);
				$csvString.=implode(",", $td)."\n";
			}

			echo $csvString;
			fclose($fp); 
*/
		}
   //On click of ledger download 
   public function ledger_download()
   {

      $data_tbl = $_POST['tbl_data'];

      //generate the PDF from the given html
      $myhtml = '<table><style>table, th, td {border: 1px solid black;border-collapse: collapse; padding:8px;text-align:center}table th {color:white}</style>
         <tr style="background-color:#213138">
			<th>S No</th>
			<th>Login Id/Name</th>
			<th>Joining Date</th>
			<th>Topup Date</th>
			<th>Sponsor Id/Name</th>
			<th>Mobile No</th>
			<th>Upliner Id/Name</th>
			<th>Position</th>
         </tr>';
      $myhtml .= strip_tags($data_tbl,'<tr> <td> <tbody>');
      $myhtml .='</table>';

      if($_POST['file_type'] == 'excel'){

         $this->ledger_excel($myhtml);
      } 

      if($_POST['file_type'] == 'pdf'){
         $this->ledger_pdf($myhtml);

      }


   }

   //for PDF download of ledger
	public function ledger_pdf($data)
	{
	  $pdfFilePath = "Ledger.pdf";

	  //load mPDF library
	  $this->load->library('m_pdf');
	  $this->m_pdf->pdf->SetTitle('Ledger');
	  $this->m_pdf->pdf->WriteHTML($data);

	  //download it.
	  $this->m_pdf->pdf->Output($pdfFilePath, "I"); 
	  exit;
	}

   //for Excel download of ledger
   public function ledger_excel($data)
	{
		  $filename = "Ledger.xls";
		  $this->load->library('Excel');
		  // save $table inside temporary file that will be deleted later
		  $tmpfile = tempnam(sys_get_temp_dir(), 'html');
		  file_put_contents($tmpfile, $data);

		  // insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
		  $objPHPExcel     = new PHPExcel();
		  $excelHTMLReader = PHPExcel_IOFactory::createReader('HTML');
		  $excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);

		  $objPHPExcel->getActiveSheet()
			 ->getStyle('A1:P1')
			 ->applyFromArray(
			 array(
				'fill' => array(
				   'type' => PHPExcel_Style_Fill::FILL_SOLID,
				   'color' => array('rgb' => '3787E3')
				),

				'font'  => array(
				   'bold'  => true,
				   'color' => array('rgb' => 'FFFFFF'),
				   'size'  => 12,
				)
			 )
		  );

		  $objPHPExcel->getActiveSheet()->setTitle('Ledger'); // Change sheet's title if you want

		  $style = array(
			 'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			 )
		  );

		  $objPHPExcel->getDefaultStyle()->applyFromArray($style);

		  foreach(range('A','Z') as $columnID) {
			 $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		  }

		  unlink($tmpfile); // delete temporary file because it isn't needed anymore

		  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
		  header('Content-Disposition: attachment;filename='.$filename); // specify the download file name
		  header('Cache-Control: max-age=0');

		  // Creates a writer to output the $objPHPExcel's content
		  $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		  $writer->save('php://output');

		  exit;

   }


		
}
		?>		