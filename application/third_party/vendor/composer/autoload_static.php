<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit180039b10e1b2515b0859d4ac17af78f
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Rakit\\Validation\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Rakit\\Validation\\' => 
        array (
            0 => __DIR__ . '/..' . '/rakit/validation/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit180039b10e1b2515b0859d4ac17af78f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit180039b10e1b2515b0859d4ac17af78f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
