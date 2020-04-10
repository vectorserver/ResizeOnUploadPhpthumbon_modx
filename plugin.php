<?php
//Обработчик
$snippet = "phpthumbon"; //phpthumbof ps: phpthumbof не обрабатывает имена фалов содержащие []
//Настрйка обработки изображения
$width =    isset($scriptProperties['width']) ? $scriptProperties['width'] : 1070;
$height =   isset($scriptProperties['height']) ? $scriptProperties['height'] : 1070;
$crop =     isset($scriptProperties['crop']) ? $scriptProperties['crop'] : 0;
$format =   isset($scriptProperties['format']) ? $scriptProperties['format'] : "jpg";
$quality =  isset($scriptProperties['quality']) ? $scriptProperties['quality'] : "75";

$eventName = $modx->event->name;
switch ($eventName) {

    case 'OnFileManagerUpload':
        // настройки media source
        $directory = $source->properties['basePath'].$directory;

        //Поддерживаемые изображения
        $extensions = explode(',', $modx->getOption('upload_images'));


        //Тип файла
        $extData = explode("/", $files["file"]["type"]);
        $extType = $extData[1];

        //Проверка на совместимост
        if (in_array($extType, $extensions)) {
            $file = $files["file"];

            $imgPath = $directory . $file['name'];

            $tmpImg = $modx->runSnippet($snippet, array('input' => $imgPath, 'options' => "&w=$width&h=$height&zc=$crop&f=$format&q=$quality"));
            $tmpImg = str_ireplace("//", "/", MODX_BASE_PATH . $tmpImg);

            rename($tmpImg, MODX_BASE_PATH . $imgPath);
        };
        break;
}
