<?php

namespace AppBundle\Twig;

use Symfony\Component\Intl\Intl;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('localeName', array($this, 'localeName')),
        );
    }

    public function localeName($locale = 'en')
    {
        $localeName = Intl::getLocaleBundle()->getLocaleName($locale);

        return $localeName;
    }

    public function getName()
    {
        return 'app_extension';
    }
}
