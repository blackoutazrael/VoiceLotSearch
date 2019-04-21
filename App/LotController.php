<?
require_once(dirname(__FILE__) . "/LotSearcher.php");
require_once(dirname(__FILE__) . "/../Util/ExcelParamGetter.php");
require_once(dirname(__FILE__) . "/../Util/MultiLangUtil.php");

class LotController extends MultiLangUtil{

    protected $searcher;
    protected $multiUtil;
    protected $excelParam;
    protected $errmsg;

    function __construct() {
        parent::__construct();
        $this->searcher = new LotSearcher();

        $eParamGetter = new ExcelParamGetter();
        $json = $eParamGetter->Get();
        $this->excelParam = json_decode($json, true);

        // $this->multiUtil = new MultiLangmultiUtil();
    }

    // 英語 : $param = ["job" => "dragoon", "equip" => "head"]
    // 日本語 : $param = ["job" => "竜", "equip" => "頭"]
    function LotSearch($param){
        $discordParam = array(
            "job" =>  $this->ConvertJobToStatus(strtolower($param["job"]))
            , "equip" => $this->TranslateEquip(strtolower($param["equip"]))
        );

        // パラメータチェック
        $errmsg = $this->isInvalid($discordParam);
        if($errmsg != ""){
            throw new Exception($errmsg);
        }else{
            // 
            $searchResult = $this->Search($discordParam);
        }


        return $this->BuildText($searchResult, $param);
    }

    //override
    function TranslateEquip($equipstring){
        $res = $this->body[$equipstring];

        if($res =="" || is_null($res)){
            $res = $this->accessory[$equipstring];
        }

        if($res =="" || is_null($res)){
            $res = $this->token[$equipstring];
        }

        return $res =="" || is_null($res) ? $equipstring : $res;
    }

    function isInvalid($discordParam){
        if(is_null($discordParam["job"])){
            return 'エラーです。ジョブ名を見直してください。'; 
           
        }

        if(is_null($discordParam["equip"])){
            return 'エラーです。装備名を見直してください。';
        }

        return "";
    }

    // 第一優先者、第二優先者を取得
    function Search($discordParam){
        $namesArray = array();
        // 優先権１ ロットできる人を取得
        $first = $this->excelParam['F'];
        $namesArray = $this->GetName($first, $discordParam, "F");

        // 第一希望がいなければ第二希望
        if (is_null($namesArray) || count($namesArray) == 0) {
            $second = $this->excelParam['S'];
            $namesArray = $this->GetName($second, $discordParam, "S");
        }

        return $namesArray;
    }

    // ロット権利者の検索処理
    function GetName($eParam, $dParam, $order){

        if(in_array($dParam["equip"], $this->body) || array_key_exists($dParam["equip"], $this->body)){
            // 左装備
            $res = $this->searcher -> GetArmorName($eParam, $dParam, $order);
        }
        elseif (in_array($dParam["equip"], $this->accessory) || array_key_exists($dParam["equip"], $this->accessory)) {
            // アクセ
            $res = $this->searcher -> GetAccessoryName($eParam, $dParam, $order);
        }
        elseif ($dParam["job"] == "F") {
            // トークン
            $res = $this->searcher -> GetTokenName($eParam, $dParam);
        }

        return $res;
    }

    // Google Homeに喋らせる内容の作成
    function BuildText($searchResult, $param){        
        $returnText = "";
        if(is_null($searchResult) || count($searchResult) == 0){
            $searchResult = $this->isEng($param["job"]) ? "anyone in the party. It's free to lot!!": "フリーな予感です！！！全員" ;
        }else{
            $searchResult = implode(', ', $searchResult);
        }

        if ($this->isEng($param["job"])) {
            $returnText = "{$param['job']}'s {$param['equip']} is available for {$searchResult}";
        } else {
            $returnText = "{$param['job']} の {$param['equip']} は {$searchResult} がロットできます";
        }

        return $returnText;
    }
}
?>
