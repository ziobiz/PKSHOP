<?
		function getFromUrl($url, $method = 'GET')
		{
					
					$ch = curl_init();
					$agent = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)';
					
					
					switch(strtoupper($method))
					{
						case 'GET':     
							curl_setopt($ch, CURLOPT_URL, $url);
							break;
				 
						case 'POST':
							$info = parse_url($url);
							$url = $info['scheme'] . '://' . $info['host'] . $info['path'];
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $info['query']);
							break;
				 
						default:
							return false;
					}
					
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
					curl_setopt($ch, CURLOPT_TIMEOUT, 5);
					curl_setopt($ch, CURLOPT_REFERER, $url);
					curl_setopt($ch, CURLOPT_USERAGENT, $agent);
					

					$res = curl_exec($ch);

					curl_close($ch);
					
					return $res;
		}

?>