<?php

namespace Berita\V1;

use Berita\Entity\Konten;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class KontenEvent extends Event
{
    public const EVENT_CREATE_KONTEN         = 'create.konten';
    public const EVENT_CREATE_KONTEN_ERROR   = 'create.konten.error';
    public const EVENT_CREATE_KONTEN_SUCCESS = 'create.konten.success';

    public const EVENT_UPDATE_KONTEN        = 'update.konten';
    public const EVENT_UPDATE_KONTEN_ERROR   = 'update.konten.error';
    public const EVENT_UPDATE_KONTEN_SUCCESS = 'update.konten.success';

    public const EVENT_DELETE_KONTEN        = 'delete.konten';
    public const EVENT_DELETE_KONTEN_ERROR   = 'delete.konten.error';
    public const EVENT_DELETE_KONTEN_SUCCESS = 'delete.konten.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \Berita\Entity\Konten
     */
    protected $konten;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @param  \Zend\InputFilter\InputFilter  $input
     * @return void
     */
    public function setInput(InputFilter $input)
    {
        $this->input = $input;
    }

    /**
     * @return \Zend\InputFilter\InputFilter
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param  \Berita\Entity\Konten  $konten
     * @return void
     */
    public function setKonten(Konten $konten)
    {
        $this->konten = $konten;
    }

    /**
     * @return \Berita\Entity\Konten
     */
    public function getKonten()
    {
        return $this->konten;
    }

    /**
     * @param  \Exception  $exception
     * @return void
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}
