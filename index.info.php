<?php
$widgetData = array(
    'widget' => array(),
    'other' => array(
        array(
            'high' => true,
            'name' => 'What',
            'text' => 'Description',
        ),
        array(
            'name' => 'Journalist',
            'text' => array(
                'sdfsdfsdf',
                'sdfsdfsdf',
            ),
        ),
        array(
            'name' => 'Designer',
            'text' => 'sdfsdfsdf',
        ),
        array(
            'name' => 'Data Source',
            'text' => array(
                'sdfsdfsdf',
                'sdfsdfsdf',
            ),
        ),
        array(
            'name' => 'Obs',
            'text' => array(
                'Helpful info',
            ),
        ),
    )
);
if (!isset($versions) || !$versions) {
    $widgetData['widget'][] = array(
        'name' => 'Widget',
        'link' => array(
            'title' => 'The widget',
            'url' => '?gen=widget',
        )
    );
} else {
    foreach ($versions as $versionsKey => $versionsValue) {
        $widgetData['widget'][] = array(
            'name' => $versionsValue['name'],
            'link' => array(
                'title' => $versionsKey,
                'url' => '?gen=widget&version=' . $versionsKey
            )
        );
    }
}
$pageData = array(
    'sep' => '<tr><th colspan="2"><hr/></th></tr>',
    'title' => '<tr class="title"><th colspan="2">##key##</th></tr>',
    'text' => '<tr><th>##name##</th><td>##text##</td></tr>',
    'textArray' => '<tr><td>##text##</td></tr>',
    'url' => '<tr ##style##><th>##name##</th><td><a ##style## title="##title##" href="##url##">##title##</a></td></tr>'
);

?><div class="men_article">
    <table border="1">
        <thead>
            <tr class="title">
                <th colspan="2">
                    <h1><?php echo $projName["long"]; ?></h1>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($widgetData as $groupKey => $groupValue) {
                echo $pageData['sep'];
                echo str_replace("##key##", strtoupper($groupKey), $pageData['title']);
                foreach ($groupValue as $rowKey => $rowValue) {
                    $useRow = $rowValue;
                    if (isset($rowValue['background'])) {
                        $useRow = 'bg';
                    } else if (isset($rowValue['link'])) {
                        $useRow = 'link';
                    } else if (isset($rowValue['text'])) {
                        $useRow = 'text';
                    }
                    $str_from = false;
                    switch ($useRow) {
                        case 'sep':
                            echo $pageData['sep'];
                            break;
                        case 'link':
                            $str_from = array(
                                '##name##',
                                '##url##',
                                '##title##',
                                '##style##'
                            );
                            $str_to = array(
                                $rowValue['name'],
                                $rowValue['link']['url'],
                                $rowValue['link']['title'],
                                ''
                            );
                            $mainString = $pageData['url'];
                            break;
                        case 'bg':
                            $str_from = array(
                                '##name##',
                                '##url##',
                                '##title##',
                                '##style##',
                            );
                            $str_to = array(
                                $rowValue['name'],
                                $rowValue['link']['url'],
                                $rowValue['link']['title'],
                                $rowValue['background'],
                            );
                            $mainString = $pageData['url'];
                            break;
                        case 'text' && !is_array($rowValue['text']):
                            $str_from = array(
                                '##name##',
                                '##text##',
                            );
                            $str_to = array(
                                $rowValue['name'],
                                $rowValue['text'],
                            );
                            if (isset($rowValue['high'])) {
                                $str_from[] = 'td>';
                                $str_to[] = 'th>';
                            }
                            $mainString = $pageData['text'];
                            break;
                    }
                    if ($str_from) {
                        echo str_replace($str_from, $str_to, $mainString);
                    }
                    if ($useRow == 'text' && is_array($rowValue['text'])) {
                        $mainString = $pageData['text'];
                        $first = true;
                        $finalText = "";

                        foreach ($rowValue['text'] as $rowText) {
                            $newRow = "";
                            if ($first) {
                                $str_from = array(
                                    '<tr><th>',
                                    '##name##',
                                    '##text##',
                                );
                                $str_to = array(
                                    '<tr><th rowspan="' . count($rowValue['text']) . '">',
                                    $rowValue['name'],
                                    $rowText,
                                );
                                $newRow = str_replace($str_from, $str_to, $mainString);
                                $first = false;
                            } else {
                                $mainString = $pageData['textArray'];
                                $str_from = array(
                                    '##text##',
                                );
                                $str_to = array(
                                    $rowText,
                                );
                                $newRow = str_replace($str_from, $str_to, $mainString);
                            }
                            $finalText .= $newRow;
                        }

                        echo $finalText;
                    }
                }
            }

            ?></tbody>
    </table>
</div>
<style>
    html,
    body,
    h1,
    a {
        text-align: center
    }

    .men_article {
        max-width: 1050px;
        margin: 0 auto
    }

    table {
        margin: 20px auto 0;
        min-width: 400px;
        text-align: left
    }

    table table {
        margin-top: 0
    }

    .title {
        text-align: center;
        background: #000;
        color: #fff
    }

    .example td {
        padding: 5px
    }
</style>