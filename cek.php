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

    // memecah pesan dalam 2 blok array, kita ambil yang array pertama saja
    $command = explode(' ',$textur,2); //
    $isicommand = explode(' ',$textur); //

//==================================================================================================================//
//============================== vvvvvvvvvv [ BAGIAN COMAND BOT] vvvvvvvvvv ========================================//
	
    switch ($command) {
	// getno
        case '/getno':
            $hasil = "wa.me/62$isicommand";
            break;
    }
	
   // identifikasi perintah (yakni kata pertama, atau array pertamanya)
    switch ($command[0]) {

        
		    
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
# /menu (menunjukan list menu yang tersedia)
# /id (cek user id)
# /time (cek waktu)";
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
