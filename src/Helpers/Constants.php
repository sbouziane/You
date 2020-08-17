<?php


namespace App\Helpers;


class Constants
{
 public static $siteConfig = [
        'site_ar_name' => 'ميوزيكن',
        'site_domain' => 'muziken.org',
        'site_title' => 'ميوزيكن للأغاني العربية',
        'site_base_color' => '#c23616',
        'site_tags' => [
            'aghani mp3',
            'aghani',
            'sm3ha',
            'اغاني ام بي ثري',
            'اغاني جديدة',
            'تحميل الاغاني'
        ],
        'list_group_header' => 'محرك بحث الاغاني العربية',
        'list_group_desc' => 'أخر الاغاني المضافة الى موقعنا',
        'site_description' => 'يمكنك الموقع من تحميل جميع أغانيك المفضلة بصيغة ام بي تري, يمكنك البحث عن أي أغنية باستعمال محرك
                    البحث أعلاه وتحميلها بطريقة مباشرة',
        'site_dmca' => 'جميع حقوق الاغاني مملوكة لاصحابها ادا كان لديك أي سؤال المرجو الأتصال بإدارة الموقع',

        'top_search_title' => 'الأكثر بحثا',
        'new_search_title' => 'جديد البحث',
        'see_all_title' => 'تصفح الكل',
        'js_start' => 'مشاهدة',
        'js_stop' => 'إيقاف',
        'search_title' => 'بحث',
        'search_input_placeholder' => 'إبحث عن أي أغنية, مطرب, ألبوم...'
    ];
    public static $loadMoreVideoData = false;
    //new siteMap stat row
    public static $newSiteMapStartRow = 1;
    public static $maxLinesBySiteMap = 8000;
    public static $stopSiteMapAt = 465000;

    //my dom websites:
    public static $sitesArray = ['https://video-api.top/'];

    //my dom configuration
    public static $lightSearchResult = true;
    public static $lightVideoResult = true;
    public static $showRelatedVideos = false;
    public static $relatedVideosSize = 10;

    //paginator size
    public static $paginatorSize = 30;
    /* no-light version with 14 related video
     * http://localhost/domapi/api.php?video=1wBvuZVE7FI&related=1&light=0&size=14
     * light version without related
     * http://localhost/domapi/api.php?video=1wBvuZVE7FI&related=0&light=1
     * */

}
