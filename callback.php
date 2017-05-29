<?php

$accessToken = 'ZKn9unlskiyJSHtgke5A8bS1sUxk/mvjGtaj5YIYbHtChPtaQcZ4zKP+TEayMDKSxGFnd6pTv16gxvy+63uKD42P3oiZvmiplfvkcZ7GrVqXMabH/kwFZGYKXl922FTS028W/nXq4nxLQfkkwiArygdB04t89/1O/w1cDnyilFU=';

//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);

//取得データ
$replyToken = $json_object->{"events"}[0]->{"replyToken"};        //返信用トークン
$message_type = $json_object->{"events"}[0]->{"message"}->{"type"};    //メッセージタイプ
$message_text = $json_object->{"events"}[0]->{"message"}->{"text"};    //メッセージ内容

//メッセージタイプが「text」以外のときは何も返さず終了
if($message_type != "text") exit;

//返信メッセージ
$return_message_text = "「" . $message_text . "」じゃねーよｗｗｗ";

//返信実行
sending_messages($accessToken, $replyToken, $message_type, $return_message_text);
?>
<?php
//メッセージの送信
function sending_messages($accessToken, $replyToken, $message_type, $return_message_text){
    //レスポンスフォーマット
    $response_format_text = [
        "type" => $message_type,
        "text" => $return_message_text
    ];

    //ポストデータ
    $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$response_format_text]
    ];

    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}





// $jsonString = file_get_contents('php://input');
// error_log($jsonString);
// $jsonObj = json_decode($jsonString);
//
// $message = $jsonObj->{"events"}[0]->{"message"};
// $replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
//
// // 送られてきたメッセージの中身からレスポンスのタイプを選択
// if ($message->{"text"} == '確認') {
//     // 確認ダイアログタイプ
//     $messageData = [
//         'type' => 'template',
//         'altText' => '確認ダイアログ',
//         'template' => [
//             'type' => 'confirm',
//             'text' => '元気ですかー？',
//             'actions' => [
//                 [
//                     'type' => 'message',
//                     'label' => '元気です',
//                     'text' => '元気です'
//                 ],
//                 [
//                     'type' => 'message',
//                     'label' => 'まあまあです',
//                     'text' => 'まあまあです'
//                 ],
//             ]
//         ]
//     ];
// } elseif ($message->{"text"} == 'ボタン') {
//     // ボタンタイプ
//     $messageData = [
//         'type' => 'template',
//         'altText' => 'ボタン',
//         'template' => [
//             'type' => 'buttons',
//             'title' => 'タイトルです',
//             'text' => '選択してね',
//             'actions' => [
//                 [
//                     'type' => 'postback',
//                     'label' => 'webhookにpost送信',
//                     'data' => 'value'
//                 ],
//                 [
//                     'type' => 'uri',
//                     'label' => 'googleへ移動',
//                     'uri' => 'https://google.com'
//                 ]
//             ]
//         ]
//     ];
// } elseif ($message->{"text"} == 'カルーセル') {
//     // カルーセルタイプ
//     $messageData = [
//         'type' => 'template',
//         'altText' => 'カルーセル',
//         'template' => [
//             'type' => 'carousel',
//             'columns' => [
//                 [
//                     'title' => 'カルーセル1',
//                     'text' => 'カルーセル1です',
//                     'actions' => [
//                         [
//                             'type' => 'postback',
//                             'label' => 'webhookにpost送信',
//                             'data' => 'value'
//                         ],
//                         [
//                             'type' => 'uri',
//                             'label' => '美容の口コミ広場を見る',
//                             'uri' => 'http://clinic.e-kuchikomi.info/'
//                         ]
//                     ]
//                 ],
//                 [
//                     'title' => 'カルーセル2',
//                     'text' => 'カルーセル2です',
//                     'actions' => [
//                         [
//                             'type' => 'postback',
//                             'label' => 'webhookにpost送信',
//                             'data' => 'value'
//                         ],
//                         [
//                             'type' => 'uri',
//                             'label' => '女美会を見る',
//                             'uri' => 'https://jobikai.com/'
//                         ]
//                     ]
//                 ],
//             ]
//         ]
//     ];
// } else {
//     // それ以外は送られてきたテキストをオウム返し
//     $messageData = [
//         'type' => 'text',
//         'text' => $message->{"text"}
//     ];
// }
//
// $response = [
//     'replyToken' => $replyToken,
//     'messages' => [$messageData]
// ];
// error_log(json_encode($response));
//
// $ch = curl_init('https://api.line.me/v2/bot/message/reply');
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json; charser=UTF-8',
//     'Authorization: Bearer ' . $accessToken
// ));
// $result = curl_exec($ch);
// error_log($result);
// curl_close($ch);

?>
