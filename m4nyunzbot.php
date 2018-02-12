$tokenbot     = $Hook['env']['tokenbot'];
$usernamebot  = "@m4nyunzBOT";
$teleurl      = "https://api.telegram.org/bot";
$endpoint     = "$teleurl$tokenbot/";
$usertokenbot = "530564868:AAH-kHukt2LvsrmpQbrhsNJGBmPyCKhftXg";
$userendpoint = "$teleurl$usertokenbot/";
$messages     = $Hook["params"];

if (isset($messages['message'])) {
   $messages = $messages['message'];} else {
   echo 'URL hook.io: https://'.$Hook['input']['host'].$Hook['input']['path'];}

// memberikan informasi ID
if (isset($messages['messages'])) {
   $sumber   = $message['message'];
   $idpesan  = $sumber['message_id'];
   $idchat   = $sumber['chat']['id'];
   $namamu   = $sumber['from']['first_name'];
   if (isset($sumber['text'])) {
      $pesan  =  $sumber['text'];
      $pecah  = explode(' ', $pesan);
      $katapertama = strtolower($pecah[0]);
      switch ($katapertama) {
         case '/id':
         case '/id'.$usernamebot:
            $pesan = "Your ID is $idchat";
            break;
         case '/time':
            $pesan  = "Waktu Sekarang :\n";
            $pesan .= date("d-m-Y H:i:s");
            break;
         default:
            $pesan = "Pesan sudah diterima, terimakasih ya!";
            break;}}
   kirimPesan($idpesan, $idchat, $text);}

// ngucapin selamat datang member baru
if (isset($messages['new_chat_member'])) {
   $pesan = "Hai ".$messages['new_chat_member']['first_name']."!\n";
   $pesan.= "Selamat datang di Grup ".$messages['chat']['title'];
   kirimPesan($messages['chat']['id'], $pesan);}

// ngucapin selamat tinggal buat user yang pergi
// HANYA jika telegram mengirimkan signal left member
if (isset($messages['left_chat_member'])) {
   $pesan = "Sampai jumpa lagi ".$messages['left_chat_member']['first_name'] ;
   kirimPesan($messages['chat']['id'], $pesan);}

// fungsi Kirim Pesan
function kirimPesan($chat_id, $text){
   global $endpoint;
   $data = array(
      'chat_id' => $chat_id,
      'text'  => $text);
      // Buat parameter pengiriman
      $options = array(
         'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),),);
   $context  = stream_context_create($options);
   $result = file_get_contents($endpoint.'sendMessage', false, $context);
   return $result;}
