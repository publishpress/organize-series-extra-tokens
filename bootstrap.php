<?php

use OrganizeSeries\application\Root;
use OrganizeSeries\domain\model\ClassOrInterfaceFullyQualifiedName;
use OrganizeSeries\ExtraTokensAddon\domain\Meta;
use OrganizeSeries\ExtraTokensAddon\domain\services\Bootstrap;


Root::initializeExtensionMeta(
    __FILE__,
    OS_ET_VERSION,
    new ClassOrInterfaceFullyQualifiedName(
        Meta::class
    )
);
Root::registerAndLoadExtensionBootstrap(
    new ClassOrInterfaceFullyQualifiedName(
        Bootstrap::class
    )
);
