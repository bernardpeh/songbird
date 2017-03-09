<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class Page extends Bundle
{
    // use a child bundle
    public function getParent()
    {
        return 'BpehNestablePageBundle';
    }
}
