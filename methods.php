<?php
// TODO: view post button on contact card
// TODO: admin can edit posts

// TODO: essage for incorrect LOGIN
// TODO: functionality to block user from directly accessing HOME if not logged in
// TODO:

//manually sets error reporting on in ini get_included_files
//remove for production!
error_reporting(E_ALL);
ini_set('display_errors','On');
session_name('app_session');
session_start();
$timezone = "America/Vancouver";
date_default_timezone_set($timezone);

//DATA ACCESS -Riley
function PDO(){
  $host = 'localhost';
  $port = 8889;
  $database = 'ShoutOut';
  $charset = 'utf8mb4';

  $DBusername = 'root';
  $DBpass = 'root';

  $dsn = "mysql:host={$host};port={$port};dbname={$database};charset={$charset}";

  $options =
  [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => FALSE
  ];

  $pdo = new PDO($dsn,$DBusername,$DBpass,$options);
  return $pdo;
}


//LOGIN - Riley
function login(){
  $pdo = PDO();
  if(isset($_POST["l_submit"])){

    $employee_id = $_POST['employee_id'];
    $pass = $_POST['password'];
    //to change the login encryption cost
    $P_options = ['cost' => 12];
    $hash = password_hash($pass,PASSWORD_BCRYPT,$P_options);
    $login_statement = $pdo->prepare('SELECT * FROM `users` WHERE `employee_id` = ?');

    if($login_statement->execute([$employee_id])){
    	$row = $login_statement->fetch();

    	if($row){
    		if(password_verify($pass,$row['password'])){
          $username = $row['user_name'];
          $user_id = $row['id'];
          $department = $row['department'];
          $likes = $row['likes'];
          $posts = $row['posts'];
          $comments = $row['comments'];

          $_SESSION['user_id'] = $user_id;
          $_SESSION['employee_id'] = $employee_id;
          $_SESSION['username'] = $username;
          $_SESSION['department'] = $department;
          $_SESSION['likes'] = $likes;
          $_SESSION['posts'] = $posts;
          $_SESSION['comments'] = $comments;
          //checking if password needs rehash
    				if(password_needs_rehash($row['password'], PASSWORD_BCRYPT, $P_options)){
    					$login_statement = $pdo->prepare('UPDATE `users` SET `password` = ? WHERE `username` = ?');
    					$login_statement->execute([$hash,$user]);
    			    }
          // redirect to home if it passes checks
          header('Location: home.php');
          die();
    		}else{
          // tell the user to screw off or try again
          print "Incorrect user or password.";
        }
    	}
    }
  }
}

//CREATING DATE TIME OBJECT - Riley
function db_timestamp(){
  return date('Y-m-d H:i:s', time());
}

//REGISTER - Riley
function register(){
  $pdo = PDO();
  if (isset($_POST["r_submit"])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $e_id = $_POST['employee_id'];

    $P_options = ['cost' => 12];
    $hash = password_hash($pass,PASSWORD_BCRYPT,$P_options);

    $register_statement = $pdo->prepare('INSERT INTO `users` (user_name, password, employee_id, role) VALUES (?, ?, ?, 1)');
    $result = $register_statement->execute([$user, $hash, $e_id]);
    print('user added.');
} else {

}

}

//`employee_id`, `user_name`, `likes`, `comments`, `posts`

//CREATING A CONTACT CARD - Riley
function fetch_user(){
  $pdo = PDO();
  $fetch_user_statement = $pdo->prepare('SELECT * FROM `users`');
  $user_result = $fetch_user_statement->execute();
  $row = $fetch_user_statement->fetchall();
  return $row;
}

//CREATING & FETCHING POSTS - Riley
function create_post(){

  // TODO add a try catch for error handling
  if(isset($_POST['post_submit'])){
    $date_stamp = db_timestamp();

    $body = $_POST['post_input'];
    $author = $_SESSION['user_id'];
    

    $pdo = PDO();

    $create_post_statement = $pdo->prepare('INSERT INTO `posts` (author_id, body, post_time) VALUES (?, ?, ?)');
    $create_post_result = $create_post_statement->execute([$author, $body, $date_stamp]);
  }
}
//query to get lots of posts with info - Riley (thanks marvin for the query)
//select posts.*,users.employee_id from posts left join users on posts.author_id = users.id where SUBSTRING(users.employee_id,1,1) = "M";
function fetch_post(){
  $pdo = PDO();
    $fetch_post_statement = $pdo->prepare('SELECT `posts`.*, `users`.`employee_id`, `users`.`user_name` FROM `posts` LEFT JOIN `users` ON `posts`.`author_id` = `users`.`id` ORDER BY `post_time` DESC;');
  $post_result = $fetch_post_statement->execute();
  $post_row = $fetch_post_statement->fetchall();
  return $post_row;
}

// search function for posts related to username - Riley
//function search(){
//  if(isset($_POST['search_posts'])){
//    $author = htmlspecialchars(mysql_real_escape_string($_POST['search_input']));
//
//    $pdo = PDO();
//    $search_post_statement = $pdo->prepare('SELECT `posts`.*, `users`.`employee_id`, `users`.`user_name` FROM `posts` LEFT JOIN `users` ON `posts`.`author_id` = `users`.`id` WHERE `user_name` = ? ORDER BY `post_time` DESC;');
//    $search_post_statement->execute([$author]);
//    $search_result = $fetch_post_statement->fetchall();
//    return $search_result;
//  }
//}

//function to add a like based on button click - Riley
function like(){
  if(isset($_POST['like_submit'])){
    $author = $_SESSION['user_id'];
    $upost_id = $_POST['postId'];

    $pdo = PDO();
    $add_like_statement = $pdo->prepare('INSERT INTO `likes` (post, employee) VALUES (?,?)');
    $add_like_statement->execute([$upost_id, $author]);

  }
}

//function to add comment based on form - Riley
function comment(){
  if(isset($_POST['comment_send'])){  //this line checks if the comment was sent then does the thing
    $date_stamp = db_timestamp();
    $body = $_POST['comment_input']; //saves the comment to a var
    $author = $_SESSION['user_id']; //saves logged in user as comment creator
    $ass_post = $_POST['postId'];

    $pdo = PDO();  //start PDO object for data transactioning

    $create_comment_statement = $pdo->prepare('INSERT INTO `comments` (author, associated_post, body, time) VALUES (?, ?, ?, ?)');
    $create_comment_statement->execute([$author,$ass_post, $body,$date_stamp]);

  }
}





/**profanity filtering---Santana
 * filter class to replace profanity with safe characters
 */
class filter_profanity
{
	// these characters will be looked for as joining characters between letters in attempt to bypass the filter l-i-k-e t_h_i_s...
	private $joining_chars = ' _\-\+\.';
	
	// these words should be the plain ascii version
	// the code will generate regular expression replacements based on the character arrays below
	// mis-spellings (like 'fck' instead of 'fuck') will need to be manually added, the code will then generate
	// corresponding equivalents (like ⓕⓒⓚ)
	private $profanity = array(
		'anal','anus','arse','ass','assface','asshole','asslick','asswipe',
		'ballsack','bastard','biatch','bitch','blowjob','bollock','bollok','boob','bugger','bum','butt','butthole','buttcam','buttplug','buttwipe','buttfucking','buttfuck','barely legal','bdsm','bbw','bimbo','bukkake',
		'clit','clitoris','cock','cockhead','cocksucker','coon','crap','cunt','cum','cumshot','cumming',
		'damn','dick','dickhead','dildo','dyke','deepthroat','defloration','doggystyle','dp',
		'ejaculation',
		'fag','fatass','fck','fellate','fellatio','felching','fuck','fucker','fuckface','fudgepacker','fucked','fisting','fingering','foreplay','foursome',
		'gayboy','gaygirl','goddamn','gagged','gloryhole','golden shower','gilf',
		'homo','handjob','hymen','huge toy','hooter',
		'jackoff','jap','jizz',
		'knob','knobend','knobjockey','knocker',
		'labia','lactating','ladyboy',
		'masterbate','masturbate','mofo','muff','milf','muff dive','muff diving',
		'nigga','nigger','nipple',
		'orgy',
		'paki','penis','piss','pisstake','poop','porn','prick','pube','pussy','pornstar','porn star','porno','pornographic','pissing',
		'rectum','retard',
		'schlong','scrotum','sex','shit','shithead','shyte','slut','spunk','shitting','sperm','strap on','stripper','speculum','sybian',
		'tit','tosser','turd','twat','threesome','topless','titty',
		'vagina',
		'whore','wank','wanker','whoar',
	);
	
	// these characters will replace each letter in a profanity word above in a regex character class
	private $replacement = array(
		'a' => 'aªàáâãäåāăąǎȁȃȧᵃḁẚạảₐ⒜ⓐａ4⍺4⁴₄④⑷⒋４₳@',
		'b' => 'bᵇḃḅḇ⒝ⓑｂɞßℬ฿',
		'c' => 'cçćĉċčᶜⅽ⒞ⓒｃ©¢℃￠€\<',
		'd' => 'dďᵈḋḍḏḑḓⅆⅾ⒟ⓓｄ',
		'e' => 'eèéêëēĕėęěȅȇȩᵉḙḛẹẻẽₑ℮ℯⅇ⒠ⓔｅ⅀∑⨊⨋€℮',
		'f' => 'fᶠḟ⒡ⓕﬀｆƒ⨐ƒ៛',
		'g' => 'gĝğġģǧǵɡᵍᵹḡℊ⒢ⓖｇ',
		'h' => 'hĥȟʰһḣḥḧḩḫẖₕℎ⒣ⓗｈ44⁴₄④⑷⒋４',
		'i' => 'iìíîïĩīĭįİıǐȉȋᵢḭỉịⁱℹⅈⅰⅱ⒤ⓘｉlĺļľŀˡḷḻḽₗℓⅼ⒧ⓛｌ|׀∣❘｜1¹₁⅟①⑴⒈１',
		'j' => 'jĵǰʲⅉ⒥ⓙⱼｊ',
		'k' => 'kķǩᵏḱḳḵₖ⒦ⓚｋ',
		'l' => 'iìíîïĩīĭįİıǐȉȋᵢḭỉịⁱℹⅈⅰⅱ⒤ⓘｉlĺļľŀˡḷḻḽₗℓⅼ⒧ⓛｌ|׀∣❘｜1¹₁⅟①⑴⒈１',
		'm' => 'mᵐḿṁṃₘⅿ⒨ⓜ㎜ｍℳ',
		'n' => 'nñńņňŉƞǹṅṇṉṋⁿₙ⒩ⓝｎ',
		'o' => 'oºòóôõöōŏőơǒǫȍȏȯᵒọỏₒℴ⒪ⓞｏ°⃝⃠⊕⊖⊗⊘⊙⊚⊛⊜⊝⌼⌽⌾⍉⍜⍟⍥⎉⎊⎋⏀⏁⏂⏣○◌●◯⚆⚇⚪⚬❍⦲⦵⦶⦷⦸⦹⦾⧂⧃⧲⧬⨀㊀0⁰₀⓪０',
		'p' => 'pᵖṕṗₚ⒫ⓟｐ',
		'q' => 'q⒬ⓠｑ',
		'r' => 'rŕŗřȑȓɼʳᵣṙṛṟ⒭ⓡｒſẛɼẛ',
		's' => 'sśŝşšșˢṡṣₛ⒮ⓢｓ$﹩＄5⁵₅⑤⑸⒌５§',
		't' => 'tţťƫțᵗƾṫṭṯṱẗₜ⒯ⓣｔ☨☩♰♱⛨✙✚✛✜✝✞✟⧧†\+',
		'u' => 'uùúûüũūŭůűųưǔȕȗᵘᵤṳṵṷụủ⒰ⓤｕvᵛᵥṽṿⅴ⒱ⓥｖ',
		'v' => 'uùúûüũūŭůűųưǔȕȗᵘᵤṳṵṷụủ⒰ⓤｕvᵛᵥṽṿⅴ⒱ⓥｖ',
		'w' => 'wŵʷẁẃẅẇẉẘ⒲ⓦｗ',
		'x' => 'xˣẋẍₓⅹ⒳ⓧｘ˟╳❌❎⤫⤬⤭⤮⤯⤰⤱⤲⨯×✕✖⨰⨱⨴⨵⨶⨷',
		'y' => 'yýÿŷȳʸẏẙỳỵỷỹ⒴ⓨｙ¥￥',
		'z' => 'zźżžƶᶻẑẓẕ⒵ⓩｚ2²₂②⑵⒉２',
		' ' => ' _\-\+\.',
	);
	
	/**
	* return a filtered string
	* @param string $filter_line the string to be filtered
	* @param string $replace_char optional character to use as the replacement - defaults to *
	* @return string
	*/
	public function filter_string($filter_line, $replace_char='*')
	{
		/*
		* loop through the words in the $profanity array, and for each character swap in the replacement characters
		* within the regex character match brackets
		* the regex also matches against word boundaries, so clbuttic mistakes don't occur
		*/
		foreach($this->profanity as $word)
		{
			$regex = '/(\b|[ \t])';
			$regex_parts = array();
			
			// it's ok to use strlen & substr here as the input string should only ever be ascii, never multibyte
			for($i=0; $i<strlen($word); $i++)
			{
				$letter = substr($word, $i, 1);
				$regex_parts[] = "[{$this->replacement[$letter]}]+";
			}
			$regex_parts[] = "[{$this->replacement['e']}]*[{$this->replacement['s']}{$this->replacement['d']}]*";
			
			$regex .= join("[{$this->joining_chars}]*", $regex_parts);
			$regex .= '(\b|[ \t])/ui';
			$replacement = (mb_strlen($replace_char))?' '.str_pad('', strlen($word), $replace_char).' ':'';
			$filter_line = preg_replace($regex, $replacement, $filter_line );
		}
		return $filter_line;
	}
}