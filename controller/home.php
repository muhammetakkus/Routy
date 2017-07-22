<?php
class Home
{
    //gönderilmeyen parametreler için hata almak istemiyorsan default değer ver
    function Index($id = "")
    {
        if (empty($id))
            echo "Home@Index argüman kanalından id bekliyor";
        else
            echo "id: ".$id;
    }
}