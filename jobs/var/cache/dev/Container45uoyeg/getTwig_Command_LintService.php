<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'twig.command.lint' shared service.

$this->services['twig.command.lint'] = $instance = new \Symfony\Bundle\TwigBundle\Command\LintCommand(${($_ = isset($this->services['twig']) ? $this->services['twig'] : $this->getTwigService()) && false ?: '_'});

$instance->setName('lint:twig');

return $instance;
