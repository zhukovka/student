<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenka
 * Date: 2/7/16
 * Time: 18:15
 */

namespace AppBundle\Twig;


use Doctrine\ORM\EntityManager;

class AppExtension extends \Twig_Extension
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getGlobals()
    {
        return array(
            'menu' => $this->em->getRepository('AppBundle:MenuItem')->findAll()
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'app_extension';
    }
}