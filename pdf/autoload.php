<?php
    function GetNewMPDF() {
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
		$mpdf = new \Mpdf\Mpdf(array(
			// 'tempDir' => '/tmp',
            'fontDir' => array_merge($fontDirs, [
                '../php/font-for-mpdf',
            ]),
            'fontdata' => $fontData + [
                'thsarabunnew' => [
                    'R' => "THSarabunNew.ttf",
					'B' => "THSarabunNew Bold.ttf",
					'I' => "THSarabunNew Italic.ttf",
					'BI' => "THSarabunNew BoldItalic.ttf",
                ]
            ],
            'default_font' => 'thsarabunnew',
            'default_font_size' => 15,
            'margin_top' => 18,
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_bootom' => 18,
            // 'format' => [100, 236]
		));
		return $mpdf;
	}
?>