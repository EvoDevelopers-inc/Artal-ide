<?php

use php\io\File;
use php\lib\fs;
use php\lib\str;




function task_copySourcesToBuild($e)
{
    foreach ($e->package()->getAny('sources', []) as $src) {
        if (str::startsWith($src, '..')) continue;

        if (str::startsWith($src, "platforms/")) {
            $to = $src;

            if (str::endsWith($src, '/src')) {
                $to = fs::parent($src);
            }

            Tasks::copy("./$src", "./build/sources/$to");
        } else {
            Tasks::copy("./$src", "./build/sources/$src");
        }
    }

    Tasks::copy("../dn-app-framework/src", "./build/sources/dn-app-framework");
    Tasks::copy("./src-release", "./build/sources/src");
}


function copySourcePlatformToSrc() {
    $currentPath = fs::abs('./');
    $platformsDir = "$currentPath/platforms";
    $targetDir = "$currentPath/src/ide/project";

    // Создаем целевую директорию, если не существует
    if (!fs::isDir($targetDir)) {
        fs::makeDir($targetDir, 0777, true);
    }

    // Копируем все содержимое из platforms в src/ide/project
    fs::scan($platformsDir, function($path) use ($platformsDir, $targetDir) {
        $relative = fs::relativize($path, $platformsDir);
        $targetPath = fs::path($targetDir, $relative);

        if (fs::isFile($path)) {
            fs::copy($path, $targetPath);
        } else if (fs::isDir($path)) {
            fs::makeDir($targetPath);
        }
    });

    echo "Platforms copied to: $targetDir\n";



    // Удаляем скопированные данные
    fs::scan($targetDir, function($path) {
        if (fs::isFile($path)) {
            fs::delete($path);
        } else if (fs::isDir($path)) {
            fs::clean($path);
            fs::delete($path);
        }
    });

    echo "Copied files have been removed from: $targetDir\n";
}

/**
 * @jppm-task ext-platform-build
 */
function task_compiler_build() {

    echo "Начало";
    Tasks::run("build");
    echo "КОнец";

}

