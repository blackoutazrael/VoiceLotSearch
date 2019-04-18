<?
/* 
    DISCORD API操作に必要な情報や、各種APIアクセス用URIなどはここで一元管理
    Publicリポジトリへアップにあたり、全てマスクを実施
*/
class StringStocker{

    /* 処理年 */
    public $year = "2019";

    /* DICORD で BOTに書き込ませる用のチャンネルID */
    public $channelid_50kotei_goyotei = 'channelid_50kotei_goyotei';

    /* 調整さん作成プログラムに渡すパラメータ作成処理CALL用URI */
    public $URL_TO_GET_INFO_FOR_CHOSEISAN = "URL_TO_GET_INFO_FOR_CHOSEISAN";

    /* 調整さん作成画面のURI */
    public $URL_TO_CREATE_CHOSEISAN = "URL_TO_CREATE_CHOSEISAN";

    /* 作成した調整さんのCDなど登録プログラムURI */
    public $URL_TO_REGISTER_CHOSEISAN = "URL_TO_REGISTER_CHOSEISAN";

    /* 個人所有のスプレッドシートに用意したGAS（API化済み）へのアクセスURI */
    public $URL_TO_SPREAD_SHEET = "URL_TO_SPREAD_SHEET";
    
    /* ご予定チャンネルに投稿する際のDICORD_APIのCALL用URI */
    public $URL_TO_POST_TO_GOYOTEI;

    function __construct()
    {
        $this->URL_TO_POST_TO_GOYOTEI = "https://discordapp.com/api/channels/".$this->channelid_50kotei_goyotei."/messages";        
    }   

}
?>