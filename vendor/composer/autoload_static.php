<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6085310402447f106555f9be74038a40
{
    public static $prefixesPsr0 = array (
        'G' => 
        array (
            'Gregwar\\Image' => 
            array (
                0 => __DIR__ . '/..' . '/gregwar/image',
            ),
            'Gregwar\\Cache' => 
            array (
                0 => __DIR__ . '/..' . '/gregwar/cache',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit6085310402447f106555f9be74038a40::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit6085310402447f106555f9be74038a40::$classMap;

        }, null, ClassLoader::class);
    }
}
