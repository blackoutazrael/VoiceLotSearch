<?php
/* 
    GASで取得したパラメータとGoogle Homeから取得したパラメータをぶつけて
    ロット権利所持者を取得する                   
*/

class LotSearcher
{
    function GetOrderString($_order){
        $prefix = "";
        if($_order == "F"){
            $prefix = "第一希望で";
        }else if ($_order == "S"){
            $prefix = "第二希望で";
        }

        return $prefix;
    }

    public function GetArmorName($ExcelParam, $discordParam, $order)
    {

        $array = array();
        foreach ($ExcelParam as $key => $excel) {
            if ($excel["ステ"] == $discordParam['job']) {
                if (array_key_exists($discordParam['equip'], $excel) && $excel[$discordParam['equip']] == "") {
                    //ロット権のある人
                    if(count($array) == 0){
                        $array[] = $this->GetOrderString($order);
                    }

                    $array[] = $excel["名前"]."さん";
                }
            }
        }

        return $array;
    }

    public function GetAccessoryName($ExcelParam, $discordParam, $order)
    {
        $array = array();
        foreach ($ExcelParam as $key => $excel) {
            // モ侍と竜は、アクセは同じものを装備するので、モ侍の[St] と 竜の[Sl] は同じステ[S]で判定する
            // 詩機と忍は、アクセは同じものを装備するので、詩機の[Dr] と 忍の[Dn] は同じステ[D]で判定する
            if (mb_substr($excel["ステ"], 0, 1) == mb_substr($discordParam['job'], 0, 1)) {
                if (array_key_exists($discordParam['equip'], $excel) && $excel[$discordParam['equip']] == "") {
                    //ロット権のある人
                    if(count($array) == 0){
                        $array[] = $this->GetOrderString($order);
                    }
                    $array[] = $excel["名前"]."さん";
                }
            }
        }

        return $array;
    }

    public function GetTokenName($ExcelParam, $discordParam)
    {
        $array = array();
        foreach ($ExcelParam as $key => $excel) {
            // ジョブ名=強化のとき
            if ($discordParam['job'] == "F") {
                if ($excel[$discordParam['equip']] == "次回") {
                    //ロット権のある人
                    $array[] = $excel["名前"]."さん";
                }
            }
        }

        return $array;
    }
}
?>