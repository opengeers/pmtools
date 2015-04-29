<?php
/*
 * @Author Cre8ive labs<info@cre8ivelabs.com>
 * @Version 1.0
 * @Package Database
 */

include("include/config.php");
class Functions extends Database{
	private $con = false; // Check to see if the connection is active
	private $result = array(); // Any results from a query will be stored here
    private $myQuery = "";// used for debugging process with SQL return
    private $numResults = "";// used for returning the number of rows
	
	// Function to make connection to database
	public function connect(){
		if(!$this->con){
			$myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);  // mysql_connect() with variables defined at the start of Database class
            if($myconn){
            	$seldb = @mysql_select_db($this->db_name,$myconn); // Credentials have been pass through mysql_connect() now select the database
                if($seldb){
                	$this->con = true;
                    return true;  // Connection has been made return TRUE
                }else{
                	array_push($this->result,mysql_error()); 
                    return false;  // Problem selecting database return FALSE
                }  
            }else{
            	array_push($this->result,mysql_error());
                return false; // Problem connecting return FALSE
            }  
        }else{  
            return true; // Connection has already been made return TRUE 
        }  	
	}
	
	// Function to disconnect from the database
    public function disconnect(){
    	// If there is a connection to the database
    	if($this->con){
    		// We have found a connection, try to close it
    		if(@mysql_close()){
    			// We have successfully closed the connection, set the connection variable to false
    			$this->con = false;
				// Return true tjat we have closed the connection
				return true;
			}else{
				// We could not close the connection, return false
				return false;
			}
		}
    }
	
	public function sql($sql){
		$query = @mysql_query($sql);
        $this->myQuery = $sql; // Pass back the SQL
		if($query){
			// If the query returns >= 1 assign the number of rows to numResults
			$this->numResults = mysql_num_rows($query);
			// Loop through the query results by the number of rows returned
			for($i = 0; $i < $this->numResults; $i++){
				$r = mysql_fetch_array($query);
               	$key = array_keys($r);
               	for($x = 0; $x < count($key); $x++){
               		// Sanitizes keys so only alphavalues are allowed
                   	if(!is_int($key[$x])){
                   		if(mysql_num_rows($query) >= 1){
                   			$this->result[$i][$key[$x]] = $r[$key[$x]];
						}else{
							$this->result = null;
						}
					}
				}
			}
			return true; // Query was successful
		}else{
			array_push($this->result,mysql_error());
			return false; // No rows where returned
		}
	}
	
	// Function to SELECT from the database
	public function select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null){
		// Create query from the variables passed to the function
		$q = 'SELECT '.$rows.' FROM '.$table;
		if($join != null){
			$q .= ' JOIN '.$join;
		}
        if($where != null){
        	$q .= ' WHERE '.$where;
		}
        if($order != null){
            $q .= ' ORDER BY '.$order;
		}
        if($limit != null){
            $q .= ' LIMIT '.$limit;
        }
        $this->myQuery = $q; // Pass back the SQL
		// Check to see if the table exists
        if($this->tableExists($table)){
        	// The table exists, run the query
        	$query = @mysql_query($q);
			if($query){
				// If the query returns >= 1 assign the number of rows to numResults
				$this->numResults = mysql_num_rows($query);
				// Loop through the query results by the number of rows returned
				for($i = 0; $i < $this->numResults; $i++){
					$r = mysql_fetch_array($query);
                	$key = array_keys($r);
                	for($x = 0; $x < count($key); $x++){
                		// Sanitizes keys so only alphavalues are allowed
                    	if(!is_int($key[$x])){
                    		if(mysql_num_rows($query) >= 1){
                    			$this->result[$i][$key[$x]] = $r[$key[$x]];
							}else{
								$this->result = null;
							}
						}
					}
				}
				return true; // Query was successful
			}else{
				array_push($this->result,mysql_error());
				return false; // No rows where returned
			}
      	}else{
      		return false; // Table does not exist
    	}
    }
	
	// Function to insert into the database
    public function insert($table,$params=array()){
    	// Check to see if the table exists
    	 if($this->tableExists($table)){
    	 	$sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
            $this->myQuery = $sql; // Pass back the SQL
            // Make the query to insert to the database
            if($ins = @mysql_query($sql)){
            	array_push($this->result,mysql_insert_id());
                return true; // The data has been inserted
            }else{
            	array_push($this->result,mysql_error());
                return false; // The data has not been inserted
            }
        }else{
        	return false; // Table does not exist
        }
    }
	
	//Function to delete table or row(s) from database
    public function delete($table,$where = null){
    	// Check to see if table exists
    	 if($this->tableExists($table)){
    	 	// The table exists check to see if we are deleting rows or table
    	 	if($where == null){
                $delete = 'DELETE '.$table; // Create query to delete table
            }else{
                $delete = 'DELETE FROM '.$table.' WHERE '.$where; // Create query to delete rows
            }
            // Submit query to database
            if($del = @mysql_query($delete)){
            	array_push($this->result,mysql_affected_rows());
                $this->myQuery = $delete; // Pass back the SQL
                return true; // The query exectued correctly
            }else{
            	array_push($this->result,mysql_error());
               	return false; // The query did not execute correctly
            }
        }else{
            return false; // The table does not exist
        }
    }
	
	// Function to update row in database
    public function update($table,$params=array(),$where){
    	// Check to see if table exists
    	if($this->tableExists($table)){
    		// Create Array to hold all the columns to update
            $args=array();
			foreach($params as $field=>$value){
				// Seperate each column out with it's corresponding value
				$args[]=$field.'="'.$value.'"';
			}
			// Create the query
			$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
			// Make query to database
            $this->myQuery = $sql; // Pass back the SQL
            if($query = @mysql_query($sql)){
            	array_push($this->result,mysql_affected_rows());
            	return true; // Update has been successful
            }else{
            	array_push($this->result,mysql_error());
                return false; // Update has not been successful
            }
        }else{
            return false; // The table does not exist
        }
    }
	
	// Private function to check if table exists for use with queries
	private function tableExists($table){
		$tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb){
        	if(mysql_num_rows($tablesInDb)==1){
                return true; // The table exists
            }else{
            	array_push($this->result,$table." does not exist in this database");
                return false; // The table does not exist
            }
        }
    }
	
	// Public function to return the data to the user
    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    //Pass the SQL back for debugging
    public function getSql(){
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    //Pass the number of rows back
    public function numRows(){
        $val = $this->numResults;
        $this->numResults = array();
        return $val;
    }

    // Escape your string
    public function escapeString($data){
        return mysql_real_escape_string($data);
    }
	
	public function url(){
		$root="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url=end(explode('/',$root));
		$url=explode('?',$url);
		return $url[0];
	}
	
	public function redirect($url){
		header('Location:'.$url.'');
	}

	public function encoded($str){
		return base64_encode(base64_encode($str));
	}

	public function decoded($str){
		return base64_decode(base64_decode($str));
	}
	
	public function count_rows($table, $rows = '*', $where = null){
		$q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null){
        	$q .= ' WHERE '.$where;
		}
        $this->myQuery = $q; // Pass back the SQL
		// Check to see if the table exists
        if($this->tableExists($table)){
        	// The table exists, run the query
        	$query = @mysql_query($q);
			if($query){
				// If the query returns >= 1 assign the number of rows to numResults
				$this->numResults = mysql_num_rows($query);
				return $this->numResults;
			}
		}		
	}
	
	public function send_email($to,$subject,$email_message,$from,$cc = null, $bcc = null){
			$to = $to;
		    $subject = $subject;
		    $message = $email_message;
		    $header = "From:".$from." \r\n";
			$headers .= "Content-type: text/html\r\n"; 
			//options to send to cc+bcc 
			if($cc != null){
        		$headers .= "Cc: [email]".$cc."[/email]"; 
			}
			if($bcc != null){
        		$headers .= "Bcc: [email]".$bcc."[/email]"; 
			}
			// now lets send the email. 
			if(mail($to, $subject, $message, $headers)){
				$email_set=1;	
			}else{
				$email_set01=error_get_last();	
				$email_set=$email_set01['message'];
			}
			return $email_set;
	}
	
	public function login($table,$rows = '*', $where = null){
		$q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null){
        	$q .= ' WHERE '.$where;
		}
        $this->myQuery = $q; // Pass back the SQL
		// Check to see if the table exists
        //echo $q;
		if($this->tableExists($table)){
        	// The table exists, run the query
        	$query = @mysql_query($q);
			if($query){
				// If the query returns >= 1 assign the number of rows to numResults
				$this->numResults = mysql_num_rows($query);
				if($this->numResults>0){
					$rows=mysql_fetch_array($query);
					if($rows['role']=='admin'){ // admin user
						$_SESSION[SITE_URL_ADMIN]=true;
						$_SESSION['admin_user_id']=$rows['id'];	
						$_SESSION['admin_user_info']=$rows;	
					}else{ // front end user
						$_SESSION[SITE_URL]=true;
						$_SESSION['user_info']=$rows;			
					}
					$result='1';
				}else{
					$result='0';	
				}
				return $result;
			}
		}		
	}
	
	public function facebook_login($table,$rows = '*', $email){
		$q = 'SELECT '.$rows.' FROM '.$table;
       	$q .= ' WHERE (email="'.$email.'" OR username="'.$email.'") ';
        $this->myQuery = $q; // Pass back the SQL
		// Check to see if the table exists
        if($this->tableExists($table)){
        	// The table exists, run the query
        	$query = @mysql_query($q);
			if($query){
				// If the query returns >= 1 assign the number of rows to numResults
				$this->numResults = mysql_num_rows($query);
				if($this->numResults>0){
					$rows=mysql_fetch_array($query);
					$_SESSION[SITE_URL.'_login']=true;	
					$_SESSION['user_details']=$rows;	
					$result='1';
				}else{
					$result='0';
				}
				return $result;
			}
		}		
	}
	
	public function logout($role = null){
		if($role=='admin'){
			unset($_SESSION[SITE_URL_ADMIN]);
			unset($_SESSION['admin_user_id']);
			unset($_SESSION['admin_user_info']);
		}else{
			unset($_SESSION[SITE_URL]);
			unset($_SESSION['user_info']);
			unset($_SESSION['FBID']);
			unset($_SESSION['LOGOUT']);
			unset($_SESSION['FB_INFO']);
			unset($_SESSION['GP_INFO']);
		}
		$result='1';
		return $result;		
	}
	
	public function image_link($link,$folder){
		$mystring = $link;
		$findme   = '://';
		$pos = strpos($mystring, $findme);
		if ($pos === false) {
			$image=SITE_URL.'/'.$folder.'/'.$link;	
		} else {
			$image=$link;
		}
		return $image;
	}
	
	public function full_url(){
		$pageURL= 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		return $pageURL;
	}
	
	public function clean_url($string){
		$string = strtolower(str_replace(' ', '-', $string)); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.	
	}
	
	public function clean_sc($string){
		$string = preg_replace('/[^A-Za-z0-9\- ]/', '', $string); // Removes special chars.	
		return $string;
	}
	
	public function countdata($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null){
		// Create query from the variables passed to the function
		$q = 'SELECT '.$rows.' FROM '.$table;
		if($join != null){
			$q .= ' JOIN '.$join;
		}
        if($where != null){
        	$q .= ' WHERE '.$where;
		}
        if($order != null){
            $q .= ' ORDER BY '.$order;
		}
        if($limit != null){
            $q .= ' LIMIT '.$limit;
        }
        $this->myQuery = $q; // Pass back the SQL
		// Check to see if the table exists
        if($this->tableExists($table)){
        	// The table exists, run the query
        	$query = @mysql_query($q);
			if($query){
				// If the query returns >= 1 assign the number of rows to numResults
				$this->numResults = mysql_num_rows($query);
				// Loop through the query results by the number of rows returned
				return $this->numResults; // Query was successful
			}else{
				array_push($this->result,mysql_error());
				return false; // No rows where returned
			}
      	}else{
      		return false; // Table does not exist
    	}
    }
	
	public function permalink($string,$id){
		$string = strtolower(str_replace(' ', '-', $string)); // Replaces all spaces with hyphens.
		$permalink=preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.	
		$q = 'SELECT permalink FROM blog_post WHERE permalink="'.$permalink.'" AND id!='.$id.' ';
        $this->myQuery = $q;
		$query = @mysql_query($q);
		if($query){
			$this->numResults= mysql_num_rows($query);
			if($this->numResults>0){
				$permalink01=$permalink.rand();
			}
			else{
				$permalink01=$permalink;
			}
		}
		return $permalink01;			
	}
} 
$db = new Functions();
$db->connect();
define('URL',$db->url());
define('URL_FULL',$db->full_url());


/*$veriable = array('VAR_SITE_URL'); 
$value = array(SITE_URL); */

$country_list=array(
'United Kingdom',
'United States',
'United States Minor Outlying Islands',
'Australia',
'Afghanistan',
'Albania',
'Algeria',
'American Samoa',
'Andorra',
'Angola',
'Anguilla',
'Antarctica',
'Antigua and Barbuda',
'Argentina',
'Armenia',
'Aruba',
'Austria',
'Azerbaijan',
'Bahamas, The',
'Bahrain',
'Bangladesh',
'Barbados',
'Belarus',
'Belgium',
'Belize',
'Benin',
'Bermuda',
'Bhutan',
'Bolivia',
'Bosnia and Herzegovina',
'Botswana',
'Bouvet Island',
'Brazil',
'British Indian Ocean Territory',
'British Virgin Islands',
'Brunei',
'Bulgaria',
'Burkina Faso',
'Burma',
'Burundi',
'Cambodia',
'Cameroon',
'Canada',
'Cape Verde',
'Cayman Islands',
'Central African Republic',
'Chad',
'Chile',
'China',
'Christmas Island',
'Cocos (Keeling) Islands',
'Colombia',
'Comoros',
'Congo, Democratic Republic of the',
'Congo, Republic of the',
'Cook Islands',
'Costa Rica',
'Cote d\'Ivoire',
'Croatia',
'Cuba',
'Curacao',
'Cyprus',
'Czech Republic',
'Denmark',
'Djibouti',
'Dominica',
'Dominican Republic',
'Ecuador',
'Egypt',
'El Salvador',
'Equatorial Guinea',
'Eritrea',
'Estonia',
'Ethiopia',
'Falkland Islands (Islas Malvinas)',
'Faroe Islands',
'Fiji',
'Finland',
'France',
'France, Metropolitan',
'French Guiana',
'French Polynesia',
'French Southern and Antarctic Lands',
'Gabon',
'Gambia, The',
'Gaza Strip',
'Georgia',
'Germany',
'Ghana',
'Gibraltar',
'Greece',
'Greenland',
'Grenada',
'Guadeloupe',
'Guam',
'Guatemala',
'Guernsey',
'Guinea',
'Guinea',
'Guyana',
'Haiti',
'Heard Island and McDonald Islands',
'Holy See (Vatican City)',
'Honduras',
'Hong Kong',
'Hungary',
'Iceland',
'India',
'Indonesia',
'Iran',
'Iraq',
'Ireland',
'Isle of Man',
'Israel',
'Italy',
'Jamaica',
'Japan',
'Jersey',
'Jordan',
'Kazakhstan',
'Kenya',
'Kiribati',
'Korea, North',
'Korea, South',
'Kosovo',
'Kuwait',
'Kyrgyzstan',
'Laos',
'Latvia',
'Lebanon',
'Lesotho',
'Liberia',
'Libya',
'Liechtenstein',
'Lithuania',
'Luxembourg',
'Macau',
'Macedonia',
'Madagascar',
'Malawi',
'Malaysia',
'Maldives',
'Mali',
'Malta',
'Marshall Islands',
'Martinique',
'Mauritania',
'Mauritius',
'Mayotte',
'Mexico',
'Micronesia, Federated States of',
'Moldova',
'Monaco',
'Mongolia',
'Montenegro',
'Montserrat',
'Morocco',
'Mozambique',
'Namibia',
'Nauru',
'Nepal',
'Netherlands',
'New Caledonia',
'New Zealand',
'Nicaragua',
'Niger',
'Nigeria',
'Niue',
'Norfolk Island',
'Northern Mariana Islands',
'Norway',
'Oman',
'Pakistan',
'Palau',
'Panama',
'Papua New Guinea',
'Paraguay',
'Peru',
'Philippines',
'Pitcairn Islands',
'Poland',
'Portugal',
'Puerto Rico',
'Qatar',
'Reunion',
'Romania',
'Russia',
'Rwanda',
'Saint Barthelemy',
'Saint Helena, Ascension, and Tristan da Cunha',
'Saint Kitts and Nevis',
'Saint Lucia',
'Saint Martin',
'Saint Pierre and Miquelon',
'Saint Vincent and the Grenadines',
'Samoa',
'San Marino',
'Sao Tome and Principe',
'Saudi Arabia',
'Senegal',
'Serbia',
'Seychelles',
'Sierra Leone',
'Singapore',
'Sint Maarten',
'Slovakia',
'Slovenia',
'Solomon Islands',
'Somalia',
'South Africa',
'South Georgia and the Islands',
'South Sudan',
'Spain',
'Sri Lanka',
'Sudan',
'Suriname',
'Svalbard',
'Swaziland',
'Sweden',
'Switzerland',
'Syria',
'Taiwan',
'Tajikistan',
'Tanzania',
'Thailand',
'Timor',
'Togo',
'Tokelau',
'Tonga',
'Trinidad and Tobago',
'Tunisia',
'Turkey',
'Turkmenistan',
'Turks and Caicos Islands',
'Tuvalu',
'Uganda',
'Ukraine',
'United Arab Emirates',
'United Kingdom',
'United States',
'United States Minor Outlying Islands',
'Uruguay',
'Uzbekistan',
'Vanuatu',
'Venezuela',
'Vietnam',
'Virgin Islands',
'Wallis and Futuna',
'West Bank',
'Western Sahara',
'Yemen',
'Zambia',
'Zimbabwe'
);

function profile_picture($link,$noimage){
		
		if($link==''){
  			$picture=SITE_URL.'/upload/'.$noimage;
		}else{
			if(!filter_var($link, FILTER_VALIDATE_URL))
  			{
	  			if (file_exists('upload/'.$link)) {
					$picture=SITE_URL.'/upload/'.$link;
				}else{
					$picture=SITE_URL.'/upload/'.$noimage;	
				}
			}else{				
				$picture=$link;
			}	
		}		
		return $picture;
	}	

function pagination($per_page = 10, $page = 1, $url = '', $total){    
 
        $adjacents = "2";
 
        $page = ($page == 0 ? 1 : $page); 
        $start = ($page - 1) * $per_page;                              
         
        $prev = $page - 1;                         
        $next = $page + 1;
        $lastpage = ceil($total/$per_page);
        $lpm1 = $lastpage - 1;
         
        $pagination = "";
        if($lastpage > 1)
        {  
            $pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details'>Page $page of $lastpage</li>";
            if ($lastpage < 7 + ($adjacents * 2))
            {  
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>$counter</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2))
            {
                if($page < 1 + ($adjacents * 2))    
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
                    }
                    $pagination.= "<li class='dot'>...</li>";
                    $pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";     
                }
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $pagination.= "<li><a href='{$url}1'>1</a></li>";
                    $pagination.= "<li><a href='{$url}2'>2</a></li>";
                    $pagination.= "<li class='dot'>...</li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
                    }
                    $pagination.= "<li class='dot'>..</li>";
                    $pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>";     
                }
                else
                {
                    $pagination.= "<li><a href='{$url}1'>1</a></li>";
                    $pagination.= "<li><a href='{$url}2'>2</a></li>";
                    $pagination.= "<li class='dot'>..</li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='{$url}$counter'>$counter</a></li>";                   
                    }
                }
            }
             
            if ($page < $counter - 1){
                $pagination.= "<li><a href='{$url}$next'>Next</a></li>";
               // $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
            }else{
                //$pagination.= "<li><a class='current'>Next</a></li>";
               // $pagination.= "<li><a class='current'>Last</a></li>";
            }
            $pagination.= "</ul>\n";     
        }          
        return $pagination;
    } 
?>
