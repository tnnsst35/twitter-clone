<?php
$mongo = new Mongo();

$collection = $mongo->twitter->tweets;

// text => 日本語で60文字
//$data = array(
//        "user_id" => 8,
//        "text"    => "こんにちはこんばんわこんにちはこんばんわこんにちはこんばんわこんにちはこんばんわこんにちはこんばんわこんにちはこんばんわこんにちはこんばんわこんにちはこんばんわこんにちはこんばんわこんにちはこんばんわこんにちはこんばんわこんにちはこんばんわ",
//        "created" => date("Y-m-d H:i:s"),
//        "updated" => date("Y-m-d H:i:s"),
//        );

$userNum  = 5000000;
$tweetNum = 10;

$text = "こんにちはこんにちはこんにちはこんにちはこんにちはこんにちはこんにちはこんにちはこんにちはこんにちは";
$now = date("Y-m-d H:i:s");

for ($i = 0;$i < $userNum;$i++) {
    for ($j = 0;$j < $tweetNum;$j++) {
        $collection->insert(array(
                    'user_id' => $i+1,
                    'text' => $text,
                    'created' => $now,
                    'updated' => $now,
                    ));
    }
}

//$dataNum = 50000000;
//
//for ($i = 0;$i = )
//
//$collection->insert($data);

$mongo = null;
