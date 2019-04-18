<?
/* 用途：
    Google Homeから取得するパラメータを、処理用のパラメータに置き換える
    日本語、英語、両言語への対応に必要な処理のまとめ
*/

class MultiLangUtil{
    private static $jobstatusEn;
    private static $jobstatusJan;
    private static $body;
    private static $accessory;
    private static $token;

    function __construct() {
                
        $this->jobstatusEn = array(
                            "paladin" => "V"
                            , "warrior" => "V"
                            , "dark knight" => "V"
                            , "tank" => "V"
                            , "dragoon" => "Sl"
                            , "ninja" => "Dn"
                            , "monk" => "St"
                            , "samurai" => "St"
                            , "bard" => "Dr"
                            , "mechanic" => "Dr"
                            , "range" => "Dr"
                            , "black mage" => "I"
                            , "summoner" => "I"
                            , "red mage" => "I"
                            , "caster" => "I"
                            , "white mage" => "M"
                            , "scholar" => "M"
                            , "astrologian" => "M"
                            , "healer" => "M"
                            , "token" => "F"
                        );

        $this->jobstatusJan = array(
                            "ナイト" => "V"
                            , "戦士" => "V"
                            , "暗黒" => "V"
                            , "タンク" => "V"
                            , "竜騎士" => "Sl"
                            , "忍者" => "Dn"
                            , "モンク" => "St"
                            , "侍" => "St"
                            , "詩人" => "Dr"
                            , "機工士" => "Dr"
                            , "レンジ" => "Dr"
                            , "黒魔道士" => "I"
                            , "召喚" => "I"
                            , "赤魔道士" => "I"
                            , "キャスター" => "I"
                            , "白魔道士" => "M"
                            , "学者" => "M"
                            , "占星術師" => "M"
                            , "ヒーラー" => "M"
                            , "トークン" => "F"
                        );
        
        $this->body = array(
                            "head"      => "頭"
                            , "armor"   => "胴"
                            , "arm"     => "手"
                            , "waist"   => "帯"
                            , "bottoms" => "脚"
                            , "bottom"  => "脚"
                            , "shoes"   => "足"
                        );

        $this->accessory = array(
                            "ear"       => "耳"
                            , "neck"    => "首"
                            , "wrist"   => "腕"
                            , "ring"    => "指"
                        );

        $this->token = array(
                            "Shellac"   => "薬"
                            , "Twine"   => "繊維"
                            , "enhance" => "強化"
                            , "strone"  => "石"
                            , "box"     => "箱"
                        );
    }

    // ジョブ名から、ステータスへ変換する
    public function ConvertJobToStatus($jobstring){
        $res = $this->jobstatusEn[$jobstring];

        if($res == "" || is_null($res)){
            $res = $this->jobstatusJan[$jobstring];
        }

        return $res;
    }

    // 装備の部位名称を英語から日本語に変換
    public function TranslateEquip($equipstring){
        $res = $this->body[$equipstring];

        if($res =="" || is_null($res)){
            $res = $this->accessory[$equipstring];
        }

        if($res =="" || is_null($res)){
            $res = $this->token[$equipstring];
        }

        return $res;
    }

    public function isEng($str){
        return preg_match('/[a-zA-Z]/', $str);
    }
}
?>