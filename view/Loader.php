<?php namespace View;

use Config\Config;

class Loader
{
    /**
     * @param $file string
     * @param $data array
     */
    public function view(string $file, array $data = [])
    {
        ob_start();

        extract($data, EXTR_SKIP);

        /* view'a gönderilen dosyayı çağır */
        $filePath = trim(Config::get('view.view'), '/') . '/' . $file . '.php';

        if(file_exists($filePath))
            require_once $filePath;
        else
            echo '</b>' . $filePath . '</b> file not found!';

        // ob_get_clean() Geçerli sayfanın içeriğini döndürüp o içeriği siler
        // ob_get_clean() = ob_get_contents() ve ob_end_clean() ?
        $content = ob_get_clean();
        if (ob_get_level() > 0) ob_flush();
        preg_match_all('/@section\((.*?)\)(.*?)@stop/ms', $content, $match);
        array_shift($match);
        $say = count($match);

        /*
         * Buraya kadar sayfa çağrılıp var olan içerik $content değişkenine depolandı
         * preg_match_all ile $match değişkenine içerikteki @section(x)'deki x değerleri ve eşleşen içeriği alındı
         * ve for ile $c değişkenine x ve eşleşen değer ikilisi şeklinde array yapılıyor [content => html içeriği] gibi
         * */
        for ($i = 0; $i < $say-1; $i++)
        {
            $c = array_combine($match[$i], $match[$i + 1]);
        }

        /* boşluksuz olarak ard arda yazılmış {{ varsa $phpstart ile replace */
        /* {{ (.*?) }} -> match varsa 1. 2. değişkene al 1. replace $phpstart 2. replace $phpend
        $phpstart = "<?php";
        $phpend = "?>";
        preg_replace('/({{).*?(}})/ms', $php, $content);
        */

        /*
         * $c değişkenindeki key olan section keyleri ile eşleşen @yield(key) tanımları içerik ile değiştiriliyor
         * */
        foreach ($c as $k => $v)
        {
            $content = preg_replace("/@yield\($k\)/ms", $v, $content);
        }

        // @section ve @stop tanımları içerikten kaldırılıyor
        $content = preg_replace('/[\r\n]*@section.*?@stop[\r\n]*/ms', '', $content);

        // @yield tanımları içerikten kaldırılıp ekrana basılıyor
        echo preg_replace('/[\r\n]*@yield.*?\)[\r\n]*/ms', '', $content);
    }
}
