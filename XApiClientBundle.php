<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace XApi\ClientBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use XApi\ClientBundle\DependencyInjection\XApiClientExtension;

/**
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
class XApiClientBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new XApiClientExtension();
        }

        if ($this->extension) {
            return $this->extension;
        }
    }
}
