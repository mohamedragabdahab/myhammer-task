<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'swiftmailer.mailer.default.transport' shared service.

$this->services['swiftmailer.mailer.default.transport'] = $instance = new \Swift_Transport_SpoolTransport(${($_ = isset($this->services['swiftmailer.mailer.default.transport.eventdispatcher']) ? $this->services['swiftmailer.mailer.default.transport.eventdispatcher'] : $this->services['swiftmailer.mailer.default.transport.eventdispatcher'] = new \Swift_Events_SimpleEventDispatcher()) && false ?: '_'}, ${($_ = isset($this->services['swiftmailer.mailer.default.spool']) ? $this->services['swiftmailer.mailer.default.spool'] : $this->services['swiftmailer.mailer.default.spool'] = new \Swift_MemorySpool()) && false ?: '_'});

$instance->registerPlugin(${($_ = isset($this->services['swiftmailer.mailer.default.plugin.messagelogger']) ? $this->services['swiftmailer.mailer.default.plugin.messagelogger'] : $this->services['swiftmailer.mailer.default.plugin.messagelogger'] = new \Swift_Plugins_MessageLogger()) && false ?: '_'});

return $instance;
