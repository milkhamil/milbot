<?php

//==================================================================================================================//
//=========================================== [ BAGIAN TOKEN & UNAME BOT] ===========================================//

$TOKEN      = "6291664857:AAEstgKlJclMivUFxypcLtKIo5NFp0MOWPg"; //isikan token dan nama botmu yang di dapat dari bapak bot :
$usernamebot= "@testerbot1937bot"; // sesuaikan besar kecilnya, bermanfaat nanti jika bot dimasukkan grup.

//=========================================== [ BAGIAN TOKEN & UNAME BOT] ===========================================//
//==================================================================================================================//

$debug = true; // aktifkan ini jika perlu debugging
 

// fungsi untuk mengirim/meminta/memerintahkan sesuatu ke bot 
function request_url($method)
{
    global $TOKEN;
    return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
}
 
// fungsi untuk meminta pesan 
// bagian ebook di sesi Meminta Pesan, polling: getUpdates
function get_updates($offset) 
{
    $url = request_url("getUpdates")."?offset=".$offset;
        $resp = file_get_contents($url);
        $result = json_decode($resp, true);
        if ($result["ok"]==1)
            return $result["result"];
        return array();
}


// fungsi untuk mebalas pesan, 
// bagian ebook Mengirim Pesan menggunakan Metode sendMessage
function send_reply($chatid, $msgid, $text)
{
    global $debug;
    $data = array(
        'chat_id' => $chatid,
        'text'  => $text,
        //'reply_to_message_id' => $msgid   // <---- biar ada reply nya balasannya, opsional, bisa dihapus baris ini
    );
    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents(request_url('sendMessage'), false, $context);

    if ($debug) 
        print_r($result);
}
 
// fungsi mengolahan pesan, menyiapkan pesan untuk dikirimkan

function create_response($text, $message)
{
    global $usernamebot;
    // inisiasi variable hasil yang mana merupakan hasil olahan pesan
    $hasil = '';  

    $fromid = $message["from"]["id"]; // variable penampung id user
    $chatid = $message["chat"]["id"]; // variable penampung id chat
    $pesanid= $message['message_id']; // variable penampung id message


    // variable penampung username nya user
    isset($message["from"]["username"])
        ? $chatuser = $message["from"]["username"]
        : $chatuser = '';

    // ini saya pergunakan untuk menghapus kelebihan pesan spasi yang dikirim ke bot.
    $textur = preg_replace('/\s\s+/', ' ', $text); 

	// memecah pesan dalam beberapa  blok array, kita ambil yang array pertama saja
    $command = explode(' ',$textur); //
    $isinya1 = $command[1]; //
    $isinya2 = $command[2]; //
    $isinya3 = $command[3]; //
    $isinya4 = $command[4]; //
    $isinya5 = $command[5]; //

//==================================================================================================================//
//================================================== [ INFOGA] ===================================================//
    $input = $isinya1 ;
    $caknomer = str_split($input);
// INISIALISASI NOMER PER FORMAT
    $lokalformat = $input;
    $interformat = "+".$input;
    $rawformat = "0".$caknomer[2].$caknomer[3].$caknomer[4].$caknomer[5].$caknomer[6].$caknomer[7].$caknomer[8].$caknomer[9].$caknomer[10].$caknomer[11].$caknomer[12].$caknomer[13];
    $raw8format = $caknomer[2].$caknomer[3].$caknomer[4].$caknomer[5].$caknomer[6].$caknomer[7].$caknomer[8].$caknomer[9].$caknomer[10].$caknomer[11].$caknomer[12].$caknomer[13];
    $spasiformat = "0".$caknomer[2].$caknomer[3].$caknomer[4]."+".$caknomer[5].$caknomer[6].$caknomer[7].$caknomer[8]."+".$caknomer[9].$caknomer[10].$caknomer[11].$caknomer[12].$caknomer[13];
    $garisformat = "0".$caknomer[2].$caknomer[3].$caknomer[4]."-".$caknomer[5].$caknomer[6].$caknomer[7].$caknomer[8]."-".$caknomer[9].$caknomer[10].$caknomer[11].$caknomer[12].$caknomer[13];
    $basicphoga = ("intext%3A%22".$lokalformat."%22+OR+intext%3A%22%2B".$lokalformat."%22+OR+intext%3A%22".$rawformat."%22+OR+intext%3A%22".$spasiformat."%22+OR+intext%3A%22".$garisformat."%22");
    $phogageneral1 = ("https://www.google.com/search?q=".$basicphoga);
    $phogageneral2 = ("https://www.google.com/search?q=%28ext%3Adoc+OR+ext%3Adocx+OR+ext%3Aodt+OR+ext%3Apdf+OR+ext%3Artf+OR+ext%3Asxw+OR+ext%3Apsw+OR+ext%3Appt+OR+ext%3Apptx+OR+ext%3Apps+OR+ext%3Acsv+OR+ext%3Atxt+OR+ext%3Axls%29+".$basicphoga);
    $phogasites = ("https://www.google.com/search?q=site%3A");
//================================================== [ INFOGA] ===================================================//
//==================================================================================================================//
	
//==================================================================================================================//
//============================== vvvvvvvvvv [ BAGIAN COMAND BOT] vvvvvvvvvv ========================================//
	
	
   // identifikasi perintah (yakni kata pertama, atau array pertamanya)
    switch ($command[0]) {
       // get link nomer telpon
		    
	case '/tester':
            $hasil .= "===== GENERAL INFO =====\n\n";
            $hasil .= ("<a href='$phogageneral1'>General 1</a>", parse_mode = ParseMode.HTML) ;
            $hasil .= ("General 1 = ".$phogageneral1."\n\n") ;
            $hasil .= ("General 2 = ".$phogageneral2."\n\n") ;
            break;
		    
	case '/scanall':
            $hasil = "===== GET INFO NO TELP =====\n\n";
            $hasil .= "WHASTAPP = wa.me/$isinya1\n";
            $hasil .= "TELEGRAM = t.me/+$isinya1\n";
            $hasil .= "KREDIBLE = kredibel.com/phone/id/$raw8format\n\n";
            $hasil .= "===== SOSIAL MEDIA SEARCH =====\n\n";
            $hasil .= ("Facebook = ".$phogasites."facebook.com+".$basicphoga."\n\n") ;
            $hasil .= ("Instagram = ".$phogasites."instagram.com+".$basicphoga."\n\n") ;
            $hasil .= ("Linkedin = ".$phogasites."linkedin.com+".$basicphoga."\n\n") ;
            $hasil .= ("Twitter = ".$phogasites."twitter.com+".$basicphoga."\n\n") ;
            $hasil .= ("Tiktok = ".$phogasites."tiktok.com+".$basicphoga."\n\n") ;
            $hasil .= "===== GENERAL INFO =====\n\n";
            $hasil .= ("General 1 = ".$phogageneral1."\n\n") ;
            $hasil .= ("General 2 = ".$phogageneral2."\n\n") ;
            break;
		  
        case '/getinfo':
            $hasil = "===== GET INFO NO TELP =====\n\n";
            $hasil .= "===== SOSIAL MEDIA SEARCH =====\n\n";
            $hasil .= ("Facebook = ".$phogasites."facebook.com+".$basicphoga."\n\n") ;
            $hasil .= ("Instagram = ".$phogasites."instagram.com+".$basicphoga."\n\n") ;
            $hasil .= ("Linkedin = ".$phogasites."linkedin.com+".$basicphoga."\n\n") ;
            $hasil .= ("Twitter = ".$phogasites."twitter.com+".$basicphoga."\n\n") ;
            $hasil .= ("Tiktok = ".$phogasites."tiktok.com+".$basicphoga."\n\n") ;
            $hasil .= "===== GENERAL INFO =====\n\n";
            $hasil .= ("General 1 = ".$phogageneral1."\n\n") ;
            $hasil .= ("General 2 = ".$phogageneral2."\n\n") ;
            break;
		  
		    
        case '/getno':
            $hasil .= "===== GET LINK NO TELP =====\n";
            $hasil .= "wa.me/$isinya1\n";
            $hasil .= "t.me/+$isinya1\n\n";
            $hasil .= "wa.me/$isinya2\n";
            $hasil .= "t.me/+$isinya2\n\n";
            $hasil .= "wa.me/$isinya3\n";
            $hasil .= "t.me/+$isinya3\n\n";
            $hasil .= "wa.me/$isinya4\n";
            $hasil .= "t.me/+$isinya4\n\n";
            $hasil .= "wa.me/$isinya5\n";
            $hasil .= "t.me/+$isinya5\n\n";
            break;
		    
	// jika ada pesan /id, bot akan membalas dengan menyebutkan idnya user
        case '/id':
            $hasil = "ID kamu adalah $fromid";
            break;
        
        // jika ada permintaan waktu
     	case '/time':
            $hasil  = "$namauser, waktu lokal bot sekarang adalah :\n";
            $hasil .= date("d M Y")."\nPukul ".date("H:i:s");
            break;
		// menu
        case '/menu':
            $hasil = "=======[ MENU LIST ]=======
# /scanall 628xxxxx (scann nomer yang di input)

# /getno 628xxxxx (buat link dari nomer yang di input maksimal 5)

# /getinfo 628xxxxx (buat link google dork dari nomer yang di input)";
            break;

        // balasan default jika pesan tidak di definisikan
        default:
            $hasil = 'Maaf saya tidak mengerti, coba command
/menu';
            break;
    }

    return $hasil;
}


//============================== ^^^^^^^^^^ [ BAGIAN COMAND BOT] ^^^^^^^^^^ =========================================//
//==================================================================================================================//

// fungsi pesan yang sekaligus mengupdate offset 
// biar tidak berulang-ulang pesan yang di dapat 
function process_message($message)
{
    $updateid = $message["update_id"];
    $message_data = $message["message"];
    if (isset($message_data["text"])) {
    $chatid = $message_data["chat"]["id"];
        $message_id = $message_data["message_id"];
        $text = $message_data["text"];
        $response = create_response($text, $message_data);
        if (!empty($response))
          send_reply($chatid, $message_id, $response);
    }
    return $updateid;
}

// hanya untuk metode poll
// fungsi untuk meminta pesan
function process_one()
{
    global $debug;
    $update_id  = 0;
    echo "-";
 
    if (file_exists("last_update_id")) 
        $update_id = (int)file_get_contents("last_update_id");
 
    $updates = get_updates($update_id);

    // jika debug=0 atau debug=false, pesan ini tidak akan dimunculkan
    if ((!empty($updates)) and ($debug) )  {
        echo "\r\n===== isi diterima \r\n";
        print_r($updates);
    }
 
    foreach ($updates as $message)
    {
        echo '+';
        $update_id = process_message($message);
    }
    
    // update file id, biar pesan yang diterima tidak berulang
    file_put_contents("last_update_id", $update_id + 1);
}

// metode poll
// proses berulang-ulang
// sampai di break secara paksa
// tekan CTRL+C jika ingin berhenti 
while (true) {
    process_one();
    sleep(1);
}

// metode webhook
// secara normal, hanya bisa digunakan secara bergantian dengan polling
// aktifkan ini jika menggunakan metode webhook
/*
$entityBody = file_get_contents('php://input');
$pesanditerima = json_decode($entityBody, true);
process_message($pesanditerima);
*/
/* 
// jebakan token, klo ga diisi akan mati
// boleh dihapus jika sudah mengerti
if (strlen($TOKEN)<20) 
    die("Token mohon diisi dengan benar!\n");
// hapus baris dibawah ini, jika tidak dihapus berarti kamu kurang teliti!
die("Mohon diteliti ulang codingnya..\nERROR: Hapus baris atau beri komen line ini yak!\n");
 
*/
    
?>
