<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb02ba83cc7affbfab4b847441cc62a62
{
    public static $files = array (
        '854728b439c1069d0a370c8d36b0c193' => __DIR__ . '/../..' . '/core/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'src\\' => 4,
        ),
        'c' => 
        array (
            'core\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'src\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb02ba83cc7affbfab4b847441cc62a62::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb02ba83cc7affbfab4b847441cc62a62::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb02ba83cc7affbfab4b847441cc62a62::$classMap;

        }, null, ClassLoader::class);
    }
}
