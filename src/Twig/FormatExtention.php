<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormatExtention extends AbstractExtension
{
    private Environment $twig;

    public function __construct(Environment $twig){
        $this->twig = $twig;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('strtotime', [$this, 'strtotime'], ['is_safe' => ['html']]),
            new TwigFunction('telephone', [$this, 'telephone'], ['is_safe' => ['html']]),
            new TwigFunction('mail', [$this, 'mail'], ['is_safe' => ['html']]),
            new TwigFunction('shortstr', [$this, 'shortstr'], ['is_safe' => ['html']]),
            new TwigFunction('lien', [$this, 'lien'], ['is_safe' => ['html']]),
            new TwigFunction('strtoupper', [$this, 'strtoupper'], ['is_safe' => ['html']]),
            new TwigFunction('randColor', [$this, 'rand_color'], ['is_safe' => ['html']]),
            new TwigFunction('addTime', [$this, 'addTime'], ['is_safe' => ['html']]),
            new TwigFunction('timeMinute', [$this, 'timeMinute'], ['is_safe' => ['html']]),
            new TwigFunction('minuteTime', [$this, 'minuteTime'], ['is_safe' => ['html']]),
            new TwigFunction('tags', [$this, 'tags'], ['is_safe' => ['html']]),
            new TwigFunction('roles', [$this, 'roles'], ['is_safe' => ['html']]),
            new TwigFunction('civil', [$this, 'civil'], ['is_safe' => ['html']]),
            new TwigFunction('etat', [$this, 'etat'], ['is_safe' => ['html']]),
        ];
    }
    function etat($etat)
    {
        if($etat == 10){
            return 'Approuvé';
        }
        elseif($etat == 1){
            return 'En attente d\'approbation';
        }else
        {
            return 'Brouillon ';
        }
    }
    function civil($civil)
    {
        if($civil == 1){
            return 'M. ';
        }else{
            return 'Mme ';
        }
    }
    function roles($roles)
    {
        if($roles){
            $data = '';
            foreach ($roles as $role){
                if($role == 'ROLE_SUPERADMIN'){
                    $data .= '<span class="badge badge-success">Super Admin</span> ';
                }
                if($role == 'ROLE_ADMIN'){
                    $data .= '<span class="badge badge-success">Administration</span> ';
                }
                if($role == 'ROLE_ASSOCIATION'){
                    $data .= '<span class="badge badge-success">Association</span> ';
                }
                if($role == 'ROLE_ETABLISSEMENT'){
                    $data .= '<span class="badge badge-success">Etablissement</span> ';
                }
                if($role == 'ROLE_RESIDENT'){
                    $data .= '<span class="badge badge-success">Résident</span> ';
                }
            }
        }
        return $data;
    }

    function tags($str)
    {
        $newphrase = $str->getContent();
        foreach ($str->getTag() as $tags){
            // dd($tags->getTag());
            $newphrase = str_replace( $tags->getTag(),  '<strong>'.$tags->getTag().'</strong>', $newphrase);
        }
        return $newphrase;
    }

    function minuteTime($Time)
    {
        return gmdate("H:i:s", $Time);
    }

    function timeMinute($temps)
    {
        $temp_string = explode(":", $temps);
        $totalHours = $temp_string[0] * 60;
        $totalMinutes = $temp_string[1];
        $total = $totalHours + $totalMinutes;
        return $total * 60;
    }

    function addTime($temps, $hours=0, $minutes=0, $seconds=0)
    {
// on split le temps
        $temp_string = explode(":", $temps);
        $totalHours = $temp_string[0] + $hours;
        $totalMinutes = $temp_string[1] + $minutes;
        if ( $totalMinutes / 60 > 1) {
            $totalHours = $totalHours + floor($totalMinutes/60);
            $totalMinutes = $totalMinutes % 60;
        }
        $totalSeconds = $temp_string[2] + $seconds;
        if ( $totalSeconds / 60 > 1) {
            $totalMinutes = $totalHours + floor($totalSeconds/60);
            $totalSeconds = $totalSeconds % 60;
        }
        if( $totalHours < 10 ) {
            $totalHours = "0" . $totalHours;
        }
        if( $totalMinutes < 10 ) {
            $totalMinutes = "0" . $totalMinutes;
        }
        if( $totalSeconds < 10 ) {
            $totalSeconds = "0" . $totalSeconds;
        }
        $myTime = $totalHours . ":" . $totalMinutes . ":" . $totalSeconds;
        return $myTime;
    }

    public function strtotime($str) {
        return date("H:i", strtotime($str));
    }

    public function rand_color() {
        $input = ['#063007', '#165418', '#2f7331', '#3d863f', '#4b8e4d', '#a1a734', '#dddd55', '#aaaa55', '#e4d00a', '#fff600'];
        // return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);

        $rand_keys = array_rand($input, 2);
        return $input[$rand_keys[1]];
    }

    public function strtoupper($str){
        if($str){
            $data = strtoupper($str);
        }else{
            $data = null;
        }

        return $data;
    }

    public function lien($str){
        if($str){
            $data = '<a class="text-decoration-none" target="_blank" href="https://'.$str.'">'.$str.'</a>';
        }else{
            $data = null;
        }

        return $data;
    }

    public function telephone($str){
        if($str){
            $link = $this->telFormat($str);
            $num = $this->telFormatTwig($str);
            $data = '<a class="text-decoration-none" href="tel:'.$link.'">'.$num.'</a>';
        }else{
            $data = null;
        }

        return $data;
    }

    public function telFormat($str){
        $data = '+33'.$str;
        return $data;
    }

    public function telFormatTwig($str){
        $new = '0'.$str;
        $data = substr($new, 0,2).' ';
        $data .= substr($new, 2,2).' ';
        $data .= substr($new, 4,2).' ';
        $data .= substr($new, 6,2).' ';
        $data .= substr($new, 8,2).' ';
        $data .= substr($new, 10,2).' ';
        return $data;
    }

    public function mail($str, $etat = null){
        if($str){
            if($etat == 'enveloppe'){
                $data = "<a href='mailto:$str' class='text-decoration-none' data-bs-toggle='tooltip' data-bs-placement='top'  title='$str'><i class='fas fa-envelope'></i> Envoyer email</a>";
            }else{
                $data = "<a href='mailto:$str' class='text-decoration-none'>$str</a>";
            }

        }else{
            $data = null;
        }
        return $data;
    }

    public function shortstr($str, $length){

        // Strip_tag enleve les balise html / Stim supprime les espaces retour ligne, ... / html_entity_decode permet de ne pas afficher les caractères spéciaux du au coupures
        $string = strip_tags(trim(html_entity_decode($str,   ENT_QUOTES, 'UTF-8'), "\xc2\xa0"));
        // Mettre ... si nombre de caractères >= à length
        if( strlen($string) >= $length){
            //mb_strcut Coupe la chaine de caractère en octet
            $string = mb_strcut($string, 0,$length).'...';
        }else{
            $string = mb_strcut($string, 0,$length);
        }
        return $string;
    }
}
