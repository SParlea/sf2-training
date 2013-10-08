<?php
namespace Main\MainBundle\Twig\Extensions;

class MainMainBundleExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'ceil' => new \Twig_Filter_Method($this, 'ceil'),
        );
    }

    public function ceil($number)
    {
        return ceil($number);
    }

    public function getName()
    {
        return 'main_main_extension';
    }
}