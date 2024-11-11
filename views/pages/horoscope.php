<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-3 d-flex justify-content-between">

            <?php
            $aquarius = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/aquarius/'));
            $scorpio = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/scorpio/'));
            $libra = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/libra/'));
            $taurus = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/taurus/'));
            $sagittarius = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/sagittarius/'));
            $capricorn = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/capricorn/'));
            $aries = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/aries/'));
            $virgo = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/virgo/'));
            $pisces = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/pisces/'));
            $gemini = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/gemini/'));
            $leo = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/leo/'));
            $cancer = json_decode(file_get_contents('https://ohmanda.com/api/horoscope/cancer/'));

            $aquarius->vreme = "Jan 20th - Feb 18th";
            $scorpio->vreme = "October 23rd - November 21st";
            $libra->vreme = "September 23rd - October 22nd";
            $taurus->vreme = "April 20th - May 20th";
            $sagittarius->vreme = "November 22nd - December 21st";
            $capricorn->vreme = "December 22nd - January 19th";
            $aries->vreme = "Mar 21 - April 19th";
            $virgo->vreme = "August 23rd - September 22nd";
            $pisces->vreme = "Feb 19th - March 20nd";
            $gemini->vreme = "May 21st - June 20th";
            $leo->vreme = "July 23rd - August 22nd";
            $cancer->vreme = "June 21st - July 22nd";


            $signs = [$aquarius, $scorpio, $libra, $taurus, $sagittarius, $capricorn, $aries, $virgo, $pisces, $gemini, $leo, $cancer];

            foreach ($signs as $sign) {
                echo ("<div class='card' style='width: 25rem;'>
                    <div class='card-body'>
                        <h5 class='card-title'>") . strtoupper($sign->sign) . ("</h5>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item'><strong>$sign->vreme</strong></li>
                    </ul>
                        <p class='card-text'>$sign->horoscope</p>
                    </div>
                    </div>");
            }

            ?>
        </div>
    </div>
</div>