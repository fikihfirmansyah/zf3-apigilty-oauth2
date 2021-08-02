<?php

namespace Berita\V1\Rest\Konten;

class KontenResourceFactory
{
    public function __invoke($services)
    {
        $kontenMapper = $services->get(\Berita\Mapper\Konten::class);
        $kontenService = $services->get(\Berita\V1\Service\Konten::class);

        return new KontenResource($kontenMapper, $kontenService);
    }
}
