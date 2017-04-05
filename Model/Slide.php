<?php

/**
 * This file is part of the EasyImpress package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orbitale\Bundle\EasyImpressBundle\Model;

class Slide
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var SlideData
     */
    protected $data;

    /**
     * @var array
     */
    protected $attr;

    /**
     * @var SlideReset
     */
    protected $reset;

    /**
     * @var Presentation
     */
    protected $presentation;

    /**
     * @param array        $config
     * @param Presentation $presentation
     */
    public function __construct(array $config, Presentation $presentation)
    {
        $this->presentation = $presentation;
        $this->id           = $config['id'];
        $this->attr         = $config['attr'];
        $this->data         = $config['data'];
        $this->content      = $config['content'];
        $this->data         = new SlideData($config['data']);
        $this->reset        = new SlideReset($config['reset']);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return SlideData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * @return SlideReset
     */
    public function getReset()
    {
        return $this->reset;
    }

    /**
     * @return Presentation
     */
    public function getPresentation()
    {
        return $this->presentation;
    }
}
