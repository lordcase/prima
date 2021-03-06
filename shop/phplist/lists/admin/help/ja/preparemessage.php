<p>このページでは、後で送信するためのメッセージを準備できます。
実際に送信するリストを除いて、メッセージの情報をすべて明確に設定、入力することができます。
準備済メッセージを送信する段階で、リストを指定でき、準備済メッセージは送信されます。</p>
<p>
準備済メッセージは固定されていますので、送信した後、消去されませんが、さまざまな時間を選択できます。
ユーザに数回同一のメッセージを送信することになるかもしれませんので、このことには注意してください。
</p>
<p>
この機能は、"複数の管理者"機能を念頭において特別に設計されています。
もし主管理者がメッセージを準備するならば、副管理者は、それらのメッセージを自身のリストに送付できます。
メッセージに追加のプレースホルダーを加えることができます: 管理者の属性
</p>
<p>例えば、もし管理者に対し<b>Name</b>属性をもっていれば、プレースホルダーとして[LISTOWNER.NAME]を加えることができます。
リストのオーナーの<b>Name</b>で置換されて、メッセージは送信されます。これはメッセージを送信した人を問いません。
そのため、他の誰かがオーナーのリストに主管理者がメッセージを送信するならば、[LISTOWNER]プレースホルダーは、リストのオーナーの値で置換されます。主管理者の値ではありません。
</P>
<p>参考までに:
<br/>
[LISTOWNER]プレースホルダーのフォーマットは、 <b>[LISTOWNER.ATTRIBUTE]</b>です。<br/>
<p>現在、下記の管理者属性が定義されています。
<table border=1><tr><td><b>属性</b></td><td><b>プレースホルダー</b></td></tr>
<?php
$req = Sql_query("select name from {$tables["adminattribute"]} order by listorder");
if (!Sql_Affected_Rows())
  print '<tr><td colspan=2>None</td></tr>';

while ($row = Sql_Fetch_Row($req))
  if (strlen($row[0]) < 20)
    printf ('<tr><td>%s</td><td>[LISTOWNER.%s]</td></tr>',$row[0],strtoupper($row[0]));

?>
