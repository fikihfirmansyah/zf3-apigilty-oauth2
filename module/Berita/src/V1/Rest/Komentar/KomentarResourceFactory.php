<?php

namespace Berita\V1\Rest\Komentar;

class KomentarResourceFactory
{
    public function __invoke($services)
    {
        $komentarMapper = $services->get(\Berita\Mapper\Komentar::class);
        $komentarService = $services->get(\Berita\V1\Service\Komentar::class);


        return new KomentarResource($komentarMapper, $komentarService);
    }
}
