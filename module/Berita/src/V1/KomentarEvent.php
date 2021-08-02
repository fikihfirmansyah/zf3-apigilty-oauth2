<?php

namespace Berita\V1;

use Berita\Entity\Komentar;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class KomentarEvent extends Event
{
    public const EVENT_CREATE_KOMENTAR         = 'create.komentar';
    public const EVENT_CREATE_KOMENTAR_ERROR   = 'create.komentar.error';
    public const EVENT_CREATE_KOMENTAR_SUCCESS = 'create.komentar.success';

    public const EVENT_UPDATE_KOMENTAR        = 'update.komentar';
    public const EVENT_UPDATE_KOMENTAR_ERROR   = 'update.komentar.error';
    public const EVENT_UPDATE_KOMENTAR_SUCCESS = 'update.komentar.success';

    public const EVENT_DELETE_KOMENTAR        = 'delete.komentar';
    public const EVENT_DELETE_KOMENTAR_ERROR   = 'delete.komentar.error';
    public const EVENT_DELETE_KOMENTAR_SUCCESS = 'delete.komentar.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \Berita\Entity\Komentar
     */
    protected $komentar;

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
     * @param  \Berita\Entity\Komentar  $komentar
     * @return void
     */
    public function setKomentar(Komentar $komentar)
    {
        $this->komentar = $komentar;
    }

    /**
     * @return \Berita\Entity\Komentar
     */
    public function getKomentar()
    {
        return $this->komentar;
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
