<?php
  // ここにDBに登録する処理を記述する

?>

<?php
  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
  $user = 'root';
  $password='';
  $dbh = new PDO($dsn, $user, $password);
  $dbh->query('SET NAMES utf8');

if (!empty($_POST)){
    $nickname = $_POST['nickname'];
    $comment = $_POST['comment'];

  $sql = "INSERT INTO `posts`(`id`, `nickname`, `comment`, `created`) VALUES (null,'".$nickname."','".$comment."',now())";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
}

// sql文の作成
$sql = 'SELECT * FROM `posts` ORDER BY `created` DESC';

// SELECT文の実行
$stmt = $dbh->prepare($sql);
$stmt->execute();

//変数にDBから取得したデータを格納する。

//変数の初期化
$posts = array();

//繰り返しwhile→中身が空falseになったらやめbreakる。
while (1) {
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($rec == false) {
    break;
  }


//
$posts[] = $rec;

}

  $dhn = null;
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action="">
      <p><input type="text" name="nickname" placeholder="nickname"></p>
      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p>
    </form>
    <!-- ここにニックネーム、つぶやいた内容、日付を表示する 
    <ul>
      <li><//?php echo $posts[0]['nickname']; ?>
          <//?php echo $posts[0]['comment']; ?> 2016-10-13</li>
      <li>testname 一言呟き 2016-10-13</li>
      <li>テスト太郎 コメント 2016-10-13</li>
    </ul>
-->
<?php  
    foreach ($posts as $post_each){
      echo '<li>';
      echo $post_each['nickname'].'';
      echo $post_each['comment'].'';

      //日付型に変換する。
      $created = strtotime($post_each['created']);

      //
      $created = date('Y/m/d',$created);

      //echo $post_each['created'];

      echo $created;
      echo '</li>';
    }
?>


</body>
</html>