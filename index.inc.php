<?php

class IndexApp
{

    private $opts = array(
        'local' => true,
        'projName' => false,
        'baseUrl' => false,
        'localBaseUrl' => false,
        'version' => false,
        'versionData' => false,
    );
    private $filenames = array(
        'script' => false,
        'css' => false,
    );

    function __construct($mainOptions = false)
    {
        if ($mainOptions) {
            $this->updateOptions($mainOptions);
        }
        $this->genFileNames();
    }

    function formatImageUrl($urlSource, $imageName, $forceLocal = false, $encode = false)
    {
        $finalSrc = $this->opts['localBaseUrl'][$urlSource] . $imageName;
        if (!is_file($finalSrc)) {
            return 'missing image - ' . $finalSrc;
        }
        if (!$forceLocal) {
            $finalSrc = $this->opts['baseUrl'][$urlSource] . $imageName;
        }

        if ($encode) {
            $finalSrc = $this->image2base64($finalSrc);
        }
        return $finalSrc;
    }

    function image2base64($url)
    {
        $im = file_get_contents($url);
        $ext = explode('.', $url);
        return 'data:image/' . end($ext) . ';base64,' . base64_encode($im);
    }

    function saveSupportFile($dataToSaveFile)
    {
        $formatedContent = str_replace($dataToSaveFile['from'], $dataToSaveFile['to'], $dataToSaveFile['content']);
        $fmin = fopen($dataToSaveFile['file'], 'w');
        fwrite($fmin, $formatedContent);
        fclose($fmin);
    }

    function formatAndSaveCss($content)
    {
        $dataToSaveFile = array(
            'content' => $content,
            'from' => array(
                '<style>',
                '</style>',
                'div#du-body.du-body'
            ),
            'to' => array(
                '',
                '',
                $this->opts['projName']['proj']['css']
            ),
            'file' => $this->opts['baseUrl']['toSave']['files']
                . $this->filenames['css'] . '.css',
        );
        if ($this->opts['local']) {
            $dataToSaveFile['from'][] = $this->opts['baseUrl']['img'];
            $dataToSaveFile['to'][] = '../' . $this->opts['baseUrl']['img'];
            $dataToSaveFile['from'][] = $this->opts['baseUrl']['def_img'];
            $dataToSaveFile['to'][] = '../' . $this->opts['baseUrl']['def_img'];
        }

        $this->saveSupportFile($dataToSaveFile);
        die();
    }

    function formatAndSaveJs($content)
    {
        $dataToSaveFile = array(
            'content' => $content,
            'from' => array(
                '<script>',
                '</script>'
            ),
            'to' => array(
                '',
                ''
            ),
            'file' => $this->opts['baseUrl']['toSave']['files']
                . $this->filenames['script'] . '.js',
        );
        if ($this->opts['local']) {
            $dataToSaveFile['from'][] = '##tempFinalFile##';
            $dataToSaveFile['to'][] = $this->opts['baseUrl']['toSave']['files'];
        } else {
            $dataToSaveFile['from'][] = '##tempFinalFile##';
            $dataToSaveFile['to'][] = $this->opts['baseUrl']['img'];

            $dataToSaveFile['from'][] = $this->filenames['css'] . '.css';
            $dataToSaveFile['to'][] = $this->filenames['css'] . '.min' . '.css';
        }
        $this->saveSupportFile($dataToSaveFile);
        die();
    }

    function generateInnerHtml($content)
    {
        ob_clean();
        $content = explode('<!-- ++++++++ -->', $content);
        $ttemp = preg_replace("/|\r|\n|\t/", '', $content[1]);
        $ttemp = preg_replace("/\s+/", ' ', $ttemp);
        $ttemp = preg_replace("/> </", '><', $ttemp);
        echo trim($ttemp);
        die();
    }

    function formatAndSaveCodeFiles($content)
    {
        $dataToSaveFile = array(
            'content' => $content,
            'from' => array(''),
            'to' => array(''),
            'file' => $this->opts['baseUrl']['toSave']['preview']
                . $this->filenames['html'] . '.html',
        );
        $this->saveSupportFile($dataToSaveFile);

        $content = explode('<!-- #### -->', $content);
        $from = array(
            $this->opts['baseUrl']['toSave']['files'],
            $this->filenames['script'] . '.js',
            $this->filenames['css'] . '.css'
        );
        $to = array(
            $this->opts['baseUrl']['img'],
            $this->filenames['script'] . '.min' . '.js',
            $this->filenames['css'] . '.min' . '.css'
        );
        $dataToSaveFile = array(
            'content' => $content[1],
            'from' => $from,
            'to' => $to,
            'file' => $this->opts['baseUrl']['toSave']['toMin']
                . $this->filenames['html'] . '.html',
        );
        $this->saveSupportFile($dataToSaveFile);
    }

    function generateMainHtml($content, $addLive)
    {
        $this->createSaveFolders();
        $genFiles = array(
            'css',
            'script',
        );
        foreach ($genFiles as $value) {
            $filenameToGen = 'http://localhost/' .
                $this->opts['localBaseUrl']['proj'] . '?gen=' . $value . $addLive;
            file_get_contents($filenameToGen);
        }

        ob_clean();
        $content = explode('<!-- ++++++++ -->', $content);
        unset($content[1]);

        $from = array('##tempFinalFile##');
        $to = array($this->opts['baseUrl']['toSave']['files']);
        $content = str_replace($from, $to, implode('', $content));
        echo $content;
    }

    public function getOptionsLightsHtml($gen = false)
    {
        $html = '';
        if ($gen == 'widget' && !!$this->opts['local']) {
            $html .= '<li class="genCode"><a href="' .
                'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
                . '&live=1">Generate Code</a></li>';
        }

        if ($this->opts['version']) {
            $html .= '<li class="opt v_' . $this->opts['version'] . '">Version: ' . $this->opts['version'] . '</li>';
        }
        foreach ($this->opts['baseUrl']['php_setup'] as $key => $value) {
            if ($key == 'class') {
                continue;
            }
            $class = '';
            if (!!$value) {
                $class = 'on';
            }
            $html .= '<li class="' . $class . '">' . $key . '</li>';
        }
        $class = '';
        if (!!$this->opts['baseUrl']['analytics']) {
            $class = 'on';
        }
        $html .= '<li class="' . $class . '">analytics</li>';
        return $html;
    }

    function genBodyClass($myInputs)
    {
        $bodyClass = '';
        if (isset($myInputs['gen'])) {
            $bodyClass = 'body-' . $myInputs['gen'];
            if (!$this->opts['local']) {
                $bodyClass .= '-live';
            }
        }
        return $bodyClass;
    }

    private function createSaveFolders()
    {
        if (!$this->opts['localBaseUrl']['toSave']) {
            return false;
        }

        if (is_string($this->opts['localBaseUrl']['toSave'])) {
            $this->opts['localBaseUrl']['toSave'] = array(
                $this->opts['localBaseUrl']['toSave']
            );
        }
        foreach ($this->opts['localBaseUrl']['toSave'] as $key => $value) {
            if (is_dir($value) === false) {
                mkdir($value);
            }
        }
    }

    private function updateOptions($options)
    {
        foreach ($this->opts as $key => $value) {
            if (isset($options[$key])) {
                $this->opts[$key] = $options[$key];
            }
        }
    }

    public function getCssFilename()
    {
        return $this->filenames['css'] . '.css';
    }

    public function getScriptFilename()
    {
        return $this->filenames['script'] . '.js';
    }

    private function genFileNames()
    {
        $this->filenames['script'] = 'du_' . $this->opts['projName']['seo'];
        $this->filenames['css'] = 'du_' . $this->opts['projName']['seo'];

        $this->filenames['html'] = 'code_' . $this->opts['projName']['seo'];

        if ($this->opts['version']) {
            /*  $this->filenames['script'] .= '_' . $this->opts['version']; */
            /*  $this->filenames['css'] .= '_' . $this->opts['version']; */
            /*  $this->filenames['html'] .= '_' . $this->opts['version']; */
        }
    }

    protected function pr($array, $title = false)
    {
        if (!$this->opts['local']) {
            return false;
        }
        echo '<pre>';
        //$finalTitle = '(' . print_r(debug_backtrace(), 1) . ')';
        $finalTitle = '(' . $this->getBacktrace() . ')';
        if ($title) {
            $finalTitle = $title . ' ' . $finalTitle;
        }
        echo '--- ' . $finalTitle . " ---<br>\n";
        if (is_array($array)) {
            print_r($array);
        } else {
            echo $array;
        }
        echo '</pre>';
    }

    protected function prd($array, $title = false)
    {
        $this->pr($array, $title);
        die();
    }

    protected function getBacktrace()
    {
        $temp = debug_backtrace();

        $res = array();
        $first = true;
        $x = count($temp);
        foreach ($temp as $key => $value) {
            $x--;
            if ($first) {
                $first = false;
                continue;
            }
            if (in_array($value['function'], array('pr', 'prd'))) {
                continue;
            }
            $strArray = explode('\\', $value['file']);
            $lastElement = end($strArray);

            array_unshift($res, "\n" . (str_repeat('-', $x)) . '> ' . $value['function'] . ', ' . $lastElement . '');
        }

        return implode('', $res) . "\n";
    }

    public function calculateSprite($spriteBaseName)
    {
        if (!file_exists($this->formatImageUrl('img', $spriteBaseName . '.png', 1))) {
            return false;
        }
        $sprite = array(
            'main' => array(
                'name' => $spriteBaseName . '.png',
            ),
            'ratio2' => false
        );
        $sprite['main']['url'] = $this->formatImageUrl('img', $sprite['main']['name']);
        $sprite['main']['url-local'] = $this->formatImageUrl('img', $sprite['main']['name'], 1);
        $sprite['main']['size'] = getimagesize($sprite['main']['url-local']);
        $sprite['main']['size']['width'] = $sprite['main']['size'][0];
        $sprite['main']['size']['height'] = $sprite['main']['size'][1];

        /*         * *******
         * Higher Definition sprite, pixel-ratio:2 and min-resolution: 192dpi
         *  ********* */
        if (file_exists($this->formatImageUrl('img', $spriteBaseName . '_x2.png', 1))) {
            $sprite['ratio2'] = array(
                'name' => $spriteBaseName . '_x2.png',
            );
            $sprite['ratio2']['url'] = $this->formatImageUrl('img', $sprite['ratio2']['name']);
            $sprite['ratio2']['url-local'] = $this->formatImageUrl('img', $sprite['ratio2']['name'], 1);
            $sprite['ratio2']['size'] = getimagesize($sprite['ratio2']['url-local']);
            $sprite['ratio2']['size']['width'] = $sprite['ratio2']['size'][0];
            $sprite['ratio2']['size']['height'] = $sprite['ratio2']['size'][1];
        }
        return $sprite;
    }
}
