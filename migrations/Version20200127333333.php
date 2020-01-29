<?php

namespace Sprint\Migration;

use Sprint\Migration\Exceptions\HelperException;
use CIBlockElement;
use Cutil;

class Version20200127333333 extends Version
{
    protected $description = "Заполнение инфоблока \"Список мероприятий\" тестовыми данными";

    protected $moduleVersion = "3.12.17";

    public function up()
    {
	    $helper = $this->getHelperManager();

	    $iblockEventsList = $helper->Iblock()->getIblockIdIfExists('events_list');
	    $iblockFileds = $helper->Iblock()->getIblockFields($iblockEventsList);

	    $elementTranslit = $iblockFileds['CODE']['DEFAULT_VALUE'];
	    $elementTranslitSettings = array(
		    'max_len' => $elementTranslit['TRANS_LEN'],
		    'change_case' => $elementTranslit['TRANS_CASE'],
		    'replace_space' => $elementTranslit['TRANS_SPACE'],
		    'replace_other' => $elementTranslit['TRANS_OTHER'],
		    'delete_repeat_replace' => ($elementTranslit['TRANS_EAT'] == 'Y')
	    );

	    if (!isset($this->params['add'])) {
		    $this->params['add'] = 1;
	    }

	    $cnt = 5;

	    if ($this->params['add'] <= $cnt) {
		    $this->outProgress('Прогресс добавления', $this->params['add'], $cnt);

		    $elementName = 'Мероприятие ' . $this->params['add'];

		    $helper->Iblock()->addElement($iblockEventsList, [
		        'NAME' => $elementName,
		        'CODE' => Cutil::translit($elementName, 'ru', $elementTranslitSettings),
			    'PREVIEW_TEXT' => 'Анонс мероприятия ' . $this->params['add'],
			    'DETAIL_TEXT' => 'Детальное описание мероприятия ' . $this->params['add'],
		    ]);

		    $this->params['add']++;

		    $this->restart();

	    }

    }

    public function down()
    {
	    $helper = $this->getHelperManager();

	    $iblockEventsList = $helper->Iblock()->getIblockIdIfExists('events_list');

	    /** @noinspection PhpDynamicAsStaticMethodCallInspection */
	    $dbRes = CIBlockElement::GetList([], ['IBLOCK_ID' => $iblockEventsList]);

	    while ($aItem = $dbRes->Fetch()) {
		    $helper->Iblock()->deleteElement($aItem['ID']);
		    $this->out('deleted %d', $aItem['ID']);
	    }

    }

}
