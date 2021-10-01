<html>
<body>

Welcome <?php echo $_POST["name"]; ?><br>
Image chosen: <?php echo $_POST["avatar"];

//Make Unique DIrectory
$id = 'ClientBooks/'.uniqid();
mkdir($id);

//LOGFILE
$logfile = fopen($id . '/' . "log.txt","w");
fwrite($logfile, $_POST["avatar"]);
fclose($logfile);
include $id . '/log.txt';



//CSVFILE


$list = array(array('name','image'),array($_POST["name"],$_POST["avatar"]));
$csv = fopen($id.'/data.csv', 'w');
foreach($list as $fields) {
fputcsv($csv, $fields);
}
fclose($csv);
include $id . '/data.csv';



//Template
$source = 'example_template.tex'; 
$destination = $id.'/template.tex'; 
  
if( !copy($source, $destination) ) { 
    echo "File can't be copied! \n"; 
} 
else { 
    echo "File has been copied! \n"; 
} 



//Remove DIR after time T

$T = 60;

$dir = 'ClientBooks/';

// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
            
            if(time() - filectime($file) > 60){
    				rmdir($file);
    		}
        }
        closedir($dh);
    }
}
// unlink($id . '/log.txt');
// unlink($id .'/data.csv');
// unlink($id . '/template.tex');
//rmdir($id);

?>
</body>
</html>