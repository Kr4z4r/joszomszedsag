@extends('layout')
@section('title', 'Cookie használati szabályzat')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h1 class="center-align">{{ __('Cookiek használatának szabályzata') }}</h1>
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">{{ __('Cookiek (sütik) felhasználási politikája és hasonló technológiák') }}</div>
                        <div class="collapsible-body">{{ __('') }}</div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('Mik azok a sütik?') }}</div>
                        <div class="collapsible-body">{{ __('A sütik olyan rövid szöveges, betűkből és számokból álló fájlok, amelyeket a felhasználó által felkeresett honlapok töltenek le a számítógép, mobil készülék vagy más berendezés böngészőjére, amelyről az internetet használják. A süti a felhasználó terminálja által az eMAG szervere vagy egy harmadik fél szervere felé elküldött kérése alapján telepítődik.') }}</div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('Mire használhatók a Sütik?') }}</div>
                        <div class="collapsible-body">
                            <p>{{ __('') }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('Milyen Sütiket használunk?') }}</div>
                        <div class="collapsible-body">
                            <p>{{ __('') }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('Hogyan használja ez a weboldal a sütiket?') }}</div>
                        <div class="collapsible-body">
                            <p>{{ __('') }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('A Sütik vagy a hasonló technológiák tartalmaznak személyes adatokat?') }}</div>
                        <div class="collapsible-body">
                            <p>{{ __('') }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('Sütik blokkolása') }}</div>
                        <p>{{ __('') }}</p><div class="collapsible-body">
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('') }}</div>
                        <div class="collapsible-body">{{ __('') }}</div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('Miért fontosak a Sütik és/vagy hasonló technológiák az Internet számára?') }}</div>
                        <div class="collapsible-body">
                            <p>{{ __('A Sütik és/vagy hasonló technológiák egy központi pontot jelentenek az Internet hatékony működését illetően, egy barátságos böngészési tapasztalat létrehozásában segít, amely mindegyik felhasználó tetszése és érdekei szerint alkalmazkodik. A Sütik letiltása vagy kikapcsolása eredményeként bizonyos weboldalak vagy azok részei használhatatlanná válhatnak.') }}</p>
                            <p>{{ __('A Sütik kikapcsolása nem azt jelenti, hogy a törvény tiszteletben tartásával már nem fog online reklámokat kapni – hanem csak azt, hogy a készüléke már nem tartja számon a kedvelt beállításait és érdekeit, amelyeket a böngészési magatartása által nyilvánított ki. Példák a Sütik fontos felhasználására (amelyek nem szükségeltetik egy felhasználó egy fiók általi bejelentkezését):') }}</p>
                            <ul>
                                <li>{{ __('Jelszavak megjegyzése') }}</li>
                                <li>{{ __('') }}</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('Biztonság és adatvédelemmel kapcsolatos nézőpontok') }}</div>
                        <div class="collapsible-body">
                            <p>{{ __('Általában a böngészőknek be vannak építve adatvédelmi beállításai, amelyek különböző Süti-elfogadási szinteket szolgáltatnak, ezek érvényességi időszakát és automatikus törlést, miután a felhasználó meglátogatott egy bizonyos weboldalt.') }}</p>
                            <p>{{ __('Más biztonsági tényezők a Sütiket illetően:') }}</p>
                            <p>{{ __('A böngésző beállításainak testre szabása ami a sütiket illeti, annak érdekében, hogy Önnek egy kényelmes süti-felhasználási szintet nyújtson.') }}</p>
                            <p>{{ __('Ha Ön az egyedüli személy, aki a számítógépet használja, ha akarja, hosszabb időszakokat is beállíthat a korábbi böngészések és a bejelentkezési személyes adatok tárolására.') }}</p>
                            <p>{{ __('Ha többen hozzáférhetnek a számítógépéhez, beállíthatja a böngészőt úgy, hogy a böngésző mindegyik lezárása után az személyes adatok törlődjenek. Ez a Sütiket küldő weboldalakra való belépés és a böngészési szesszió lezárásánál minden információ törlése egyik változata.') }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('További hasznok linkek és információk') }}</div>
                        <div class="collapsible-body">
                            Ha több információt szeretne megtudni a Sütikkel, illetve azok használatával kapcsolatosan, akkor a következő linkeket ajánljuk figyelmébe:

                            Microsoft Cookies guide

                            All About Cookies

                            http://www.youronlinechoices.com/ro/
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">{{ __('Az oldal által használt cookie-k') }}</div>
                        <div class="collapsible-body">
                            {{ __('Az alábbi táblázat bemutatja a weboldalon használt mindegyik sütit külön-külön, ideértve azok szerepét is. Nem fogjuk ezeket a sütiket a jelen Sütik felhasználási politikájában bemutatott módszerektől eltérő módokon használni:') }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('extra_js')
    <script type="text/javascript" defer>
        $(document).ready(function(){
            $('.collapsible').collapsible();
        });
    </script>
@endsection