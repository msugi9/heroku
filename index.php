<?php
    
    // ---------------------------------------------------------------
    // 楽天商品検索API の利用サンプルコード (PHP)
    // Sample code for using Ichiba Item Search API
    // ---------------------------------------------------------------
    // 以下を変更してPHP5が動作する公開領域におくだけでOK
    // 詳細な仕様は以下を参照
    // - 楽天ウェブサービス- http://webservice.rakuten.co.jp/
    //
    // UTF-8で保存すること
    /* ---------------- 以下、変更部分 ------------------------------ */
    
    // 自分のアプリID
    $APP_ID      = "自分のアプリID";
    
    // 自分のアフィリエイトID
    $AFFILIATE_ID = "自分のアフィリエイトID";
    
    /* ---------------- 以上、変更部分 ------------------------------ */
    
    // --------- API毎の固定値
    // API名
    $API_NAME    = "楽天商品検索API";
    
    // APIのURL
    $API_BASE_URL = "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222";
    
    // --------- リクエストパラメタの取得とAPIへのリクエストURL生成
    
    // リクエストURL生成
    $query = array(
                       'format'        => "json",
                       'keyword'      => $_REQUEST['keyword'],
                       'applicationId' => $APP_ID
                   );
    $api_url = $API_BASE_URL . "?" . http_build_query($query);
    
    // --------- API取得処理
    
    // 商品検索ボタンを押された時、APIにリクエストを投げる
    if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == "商品検索") {
            $contents = file_get_contents($api_url);
            $data = json_decode($contents, true);
        
            // 連想配列から値を取得
            if ($data) {
                    // 検索数
                    $count = $data['count'];
                    // 商品情報
                    $item_list = $data['Items'];
                }
    }
    
    // ここからHTML表示部分
    header("Content-type:text/html;charset=UTF-8");
    ?>
<html lang="ja">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php echo $API_NAME; ?>／楽天ウェブサービス</title>
</head>
<body bgcolor="#ffffff  " TEXT="#333333  " LINK="#3333cc  ">

  <!-- タイトル -->
  <h1 style="font-size: 16px; font-weight: bold;">楽天ウェブサービス</h1>
  <hr size="1" noshade><?php echo $API_NAME; ?><hr size="1" noshade>
  <!--/タイトル -->

  <!-- HTMLフォーム表示 -->
  <form action="./index.php" method="post">
    <table width="60%" border="0" cellspacing="0" cellpadding="0" style="margin: 5px 0pt 0pt 0px;">
      <tr>
        <td bgcolor="#afafaf  ">
          <table width="100%" border=0 cellspacing=1 cellpadding=5 style="font-size: 12px;">
            <tr>
              <td style="background-color: #eeeeee  ;">検索キーワード</td>
              <td style="background-color: #ffffff  ;">
                <!-- キーワード入力テキストボックス --> <input type="text" name="keyword" value="<?php echo htmlspecialchars($_REQUEST['keyword']); ?>" size="30">
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <br> <input type="submit" name="submit" value="商品検索">
  </form>
  <!-- HTMLフォーム表示 -->

  <!-- API検索結果表示 -->
  <font style="font-size: 14px;">
<?php if ($count > 0) : ?>
取得件数: <?php echo number_format($count); ?>件<br>
    <table width="60%" border="0" cellspacing="0" cellpadding="0" style="margin: 5px 0pt 0pt 0px;">
      <tr>
        <td bgcolor="#afafaf  ">
          <table width="100%" border=0 cellspacing=1 cellpadding=5 style="font-size: 12px;">
            <tr align="center" style="background-color: #eeeeee  ;">
              <td width="8%">写真</td>
              <td width="47%">商品名</td>
              <td width="15%">価格</td>
              <td width="30%">ショップ名</td>
            </tr>
<?php foreach ($item_list as $data) : ?>
<?php $item = $data['Item']; ?>
            <tr style="background-color: #ffffff  ;">
              <td width="8%" align="center"><a href="<?php echo $item['itemUrl']; ?>" target="_top"><img src="<?php echo $item['smallImageUrls'][0]['imageUrl']; ?>" border=0></a></td>
              <td width="47%" align="left"><a href="<?php echo $item['itemUrl']; ?>" target="_top"><font size="-1"><?php echo $item['itemName']; ?></a></td>
              <td width="15%" align="right" nowrap> <?php echo number_format($item['itemPrice']); ?> 円</td>
              <td width="47%" align="left"><a href="<?php echo $item['shopUrl']; ?>" target="_top"><font size="-1"><?php echo $item['shopName']; ?></a></td>
            </tr>
<?php endforeach; ?>
          </table>
        </td>
      </tr>
    </table>
<?php endif; ?>
</font>
  <!-- /API検索結果表示 -->

</body>
</html>