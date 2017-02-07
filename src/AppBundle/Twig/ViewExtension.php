<?php
/**
 * Created by PhpStorm.
 * User: xfly3r
 * Date: 25.01.17
 * Time: 12:45
 */

namespace AppBundle\Twig;


class ViewExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('convertToArray', array($this, 'convertToArray')),
        );
    }

    public function convertToArray($object)
    {
        return (array) $object;
    }

    public function getName()
    {
        return 'app_extension';
    }
}