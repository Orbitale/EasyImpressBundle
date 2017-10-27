<?php

/**
 * This file is part of the EasyImpress package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orbitale\Bundle\EasyImpressBundle\Controller;

use Orbitale\Bundle\EasyImpressBundle\Impress\EasyImpress;
use Orbitale\Bundle\EasyImpressBundle\Model\Presentation;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PresentationController
{
    /**
     * @var EasyImpress
     */
    private $impress;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $layout;

    public function __construct($layout, EasyImpress $impress, Environment $twig)
    {
        $this->impress = $impress;
        $this->twig = $twig;
        $this->layout = $layout;
    }

    /**
     * @param string $presentationName
     *
     * @return Response
     */
    public function presentation($presentationName)
    {
        /** @var Presentation $presentation */
        $presentation = $this->impress->getPresentation($presentationName);

        if (!$presentation) {
            throw new NotFoundHttpException('Presentation "'.$presentationName.'" not found.');
        }

        return new Response($this->twig->render('@EasyImpress/presentation.html.twig', [
            'layout'       => $this->layout,
            'presentation' => $presentation,
        ]));
    }
}
