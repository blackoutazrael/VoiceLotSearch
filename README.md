# VoiceLotSearch
### 【概要】
FF14（オンラインゲーム）のプレイ環境改善を目的に作成しているBOTの一部です。<br>
コンテンツクリアすると、週１回制限のレアアイテムが入手できます。それをチームメンバー内で公平に配分する必要があるのですが、<br>
「次は誰が何を優先取得できるのか」が度々課題になります。<br>
そこで、音声認識で取得権利者の検索を行えるツールを簡易に作りました。

### 【流れ】
1. Google Spreadsheet上に、アイテム取得希望順と取得状況を表で管理
![LotManageSheetImage.png](https://raw.githubusercontent.com/blackoutazrael/VoiceLotSearch/images/WS000003.BMP "LotManageSheetImage")

2. Google Home から、分配したいアイテム情報を入力
3. GASでSheetから、各メンバーのアイテム取得状況を取得
4. PHPで3.と4.で取得したデータをぶつけて、アイテム取得優先権保持者を取得
5. 結果をGoogle Homeで返答

### 【環境】
GCPのApp Engineを使用

### 【動作の様子】
[実演(youtube)](https://youtu.be/EX3qJbQnVzk)
