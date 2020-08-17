<?php


namespace App\Helpers;


use phpDocumentor\Reflection\Types\Boolean;

class Utils
{
    /**
     * @param string $string
     * @return string
     */
    public static function cleanSearchAndMakeSlug(string $string) {
        $string = trim($string);
        $string = str_replace('.',' ', $string);
        $string = preg_replace('/[^\w\s]+/u', '', $string); // Removes special chars.
        $string = preg_replace('!\s+!', ' ', $string);
        $string = str_replace(' ','-', $string);
        return $string;
    }

    /**
     * @param string $string
     * @return string
     */
    public static function slugToText(string $string){
        return trim(str_replace('-',' ', $string));
    }

    /**
     * @param string $haystack
     * @return bool
     */
    public static function is_bad_word(string $haystack){
        $needles = array('ممنوعة', 'فيلم','افلام','step','movie','film','mother',
            'قحاب','خيانة','للكبار','رقص','قضيب','مهبل','مساج','اباحي','ممنوع','مساج','زامل','زوامل',
            'ثدي','لحس', 'سقس', 'بنات', 'ممحونات', 'مغربيات', 'سعوديات', 'شرموطات',
            'صدر','كس','ارداف','قبلات','بوس','شفايف','عاهرة','ساخن','تقبيل','انوثة', 'فيديو', 'تحسيس',
            'سكس','نيك','طيز','جماع','زب','قحبة','شرموطة','ممحونة','ساخنة','جنس','جنسية',
            'اباحية','فضيحة','sex','porn','بورنو','نكاح','لواط','سحاق', 'massage', 'xvideos', 'xnxx',
            'خالد يوسف', 'منى فاروق', 'فصيحه', 'فيلم', 'الاباحي', 'الجنسي', 'شيماء الحاج', 'فيلم', 'لحوا',
            'مسلسل', 'مكالمة', 'شراميط', 'مكالمات', 'فلم');
        foreach($needles as $needle){
            if (strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $string
     * @return bool
     */
    public static function isArabic(string $string){
        if (!preg_match('/[^A-Z a-z 0-9]/', $string)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return string
     */
    public static function getRandomDomSite(){
        return Constants::$sitesArray[rand(0, count(Constants::$sitesArray)-1)];
    }

    /**
     * @param bool $light
     * @return string
     */
    public static function generateSearchFullUrl(bool $light){
        $site = self::getRandomDomSite();
        if ($light == true){
            return $site."search/1/";
        }else{
            return $site."search/0/";
        }
    }

    /**
     * @param bool $light
     * @param bool $related
     * @return string
     */
    public static function generateVideoFullUrl(bool $light, bool $related){
        $site = self::getRandomDomSite();
        if ($light == true){
            $site = $site."video/0/";
        }else{
            $site = $site."video/1/";
        }
        if ($related == true){
            $site = $site."1/";
        }else{
            $site = $site."0/";
        }
        return $site;
    }
}