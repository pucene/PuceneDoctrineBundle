<?php

namespace Pucene\Bundle\DoctrineBundle;

use Pucene\Bundle\DoctrineBundle\DependencyInjection\CompilerPass\QueryBuilderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PuceneDoctrineBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new QueryBuilderCompilerPass());
    }
}
