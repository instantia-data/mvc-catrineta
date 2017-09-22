<?php

/*
 * Copyright (C) 2017 Luis Pinto <luis.nestesitio@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Catrineta\tools;


/**
 * Description of TinTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 25, 2015
 */
class TinTools
{
    //http://www.webdados.pt/2014/08/validacao-de-nif-portugues-em-php/

    /**
     * @param $nif
     * @return bool
     */
    public static function checkDigitPT($nif)
    {
        //Limpamos eventuais espaços a mais
        $nif = trim($nif);
        $nif = self::cleanTIN($nif);
        //Verificamos se é numérico e tem comprimento 9
        if (!is_numeric($nif) || strlen($nif)!=9) {
            return FALSE;
        }else{
            $nifSplit=str_split($nif);
            if(in_array($nifSplit[0], [1, 2, 5, 6, 8, 9])){
                $checkDigit=0;
                for($i=0; $i<8; $i++) {
                    $checkDigit += $nifSplit[$i]*(10-$i-1);
                }
                $checkDigit = 11-($checkDigit % 11);
                //Se der 10 então o dígito de controlo tem de ser 0 -
                if ($checkDigit >= 10) {
                    $checkDigit = 0;
                }
                //Comparamos com o último dígito
                if ($checkDigit==$nifSplit[8]) {
                    return $nif;
                }
            }
        }
        return false;
    }

    /**
     * @param $txt
     * @return mixed
     */
    public static function cleanTIN($txt)
    {
        return substr(preg_replace("/[^0-9]/", "", $txt), 0, 9);
    }

}
