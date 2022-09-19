<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ImagesExtention extends AbstractExtension
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('slider', [ $this, 'slider' ], [ 'is_safe' => [ 'html' ] ]),
        ];
    }

    function slider($images, $path)
    {
        $carouselExampleIndicators = 'carousel'.uniqid();
        $nbImages = count($images);
        if($nbImages > 1) {
            $data = '';
            $data .= '<div id="'. $carouselExampleIndicators.'" class="carousel slide carousel-fade" data-bs-ride="carousel">';
            $data .= '<div class="carousel-indicators">';
            foreach ($images as $key => $image) {
                if ($key == 0) {
                    $data .= '<button type="button" data-bs-target="#'. $carouselExampleIndicators.'" data-bs-slide-to="' . $key . '" class="active" aria-current="true" aria-label="Slide ' . $key . '"></button>';
                } else {
                    $data .= '<button type="button" data-bs-target="#'. $carouselExampleIndicators.'" data-bs-slide-to="' . $key . '" class="" aria-current="true" aria-label="Slide ' . $key . '"></button>';
                }
            }
            $data .= '</div>';
            $data .= '<div class="carousel-inner">';
            foreach ($images as $key => $image) {
                if ($key == 0) {
                    $active = 'carousel-item active';
                } else {
                    $active = 'carousel-item';
                }
                $data .= '<div class="' . $active . '">';
                $data .= '<img src="' . $path . $image->getFile() . '" class="d-block w-100" alt="' . $image->getTitle() . '">';
                $data .= '</div>';
            }
            $data .= '</div>';
            $data .= '<button class="carousel-control-prev" type="button" data-bs-target="#'. $carouselExampleIndicators.'" data-bs-slide="prev">';
            $data .= '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            $data .= '<span class="visually-hidden">Previous</span>';
            $data .= '</button>';
            $data .= '<button class="carousel-control-next" type="button" data-bs-target="#'. $carouselExampleIndicators.'" data-bs-slide="next">';
            $data .= '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            $data .= '<span class="visually-hidden">Next</span>';
            $data .= '</button>';
            $data .= '</div>';
        } else {
            $data = '<img src="' . $path . $images[0]->getFile() . '" class="d-block w-100" alt="' . $images[0]->getTitle() . '">';
        }
        return $data;
    }
}
