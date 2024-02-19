<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9f42a476995ec1973949a7f5704196db
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'ModuleFactory\\FsCustomHtml\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ModuleFactory\\FsCustomHtml\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'FsCustomHtmlBlockFilterModel' => __DIR__ . '/../..' . '/classes/FsCustomHtmlBlockFilterModel.php',
        'FsCustomHtmlBlockModel' => __DIR__ . '/../..' . '/classes/FsCustomHtmlBlockModel.php',
        'FsCustomHtmlFilterModel' => __DIR__ . '/../..' . '/classes/FsCustomHtmlFilterModel.php',
        'FsCustomHtmlHelper' => __DIR__ . '/../..' . '/classes/FsCustomHtmlHelper.php',
        'FsCustomHtmlHelperConfig' => __DIR__ . '/../..' . '/classes/FsCustomHtmlHelperConfig.php',
        'FsCustomHtmlHelperForm' => __DIR__ . '/../..' . '/classes/FsCustomHtmlHelperForm.php',
        'FsCustomHtmlHelperFormAbstract' => __DIR__ . '/../..' . '/classes/FsCustomHtmlHelperFormAbstract.php',
        'FsCustomHtmlHelperFormFilter' => __DIR__ . '/../..' . '/classes/FsCustomHtmlHelperFormFilter.php',
        'FsCustomHtmlHelperList' => __DIR__ . '/../..' . '/classes/FsCustomHtmlHelperList.php',
        'FsCustomHtmlHookModel' => __DIR__ . '/../..' . '/classes/FsCustomHtmlHookModel.php',
        'FsCustomHtmlTemplateModel' => __DIR__ . '/../..' . '/classes/FsCustomHtmlTemplateModel.php',
        'FsCustomHtmlValidate' => __DIR__ . '/../..' . '/classes/FsCustomHtmlValidate.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9f42a476995ec1973949a7f5704196db::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9f42a476995ec1973949a7f5704196db::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9f42a476995ec1973949a7f5704196db::$classMap;

        }, null, ClassLoader::class);
    }
}
